<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\PolicyUserDataUpdate;
use App\Models\City;
use App\Models\FamilyHistory;
use App\Models\Provinces;
use App\Models\UserPolicyData;
use App\Models\UserPolicyStatusHistory;
use App\Services\CnicMobileLinkService;
use App\Support\LifeProposedDocument;
use App\Support\LifeProposedProfile;
use Barryvdh\DomPDF\Facade\Pdf;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class PolicyController extends Controller
{
    private const ALLOWED_UPLOAD_EXTENSIONS = ['jpg', 'jpeg', 'png', 'pdf'];

    private const ALLOWED_UPLOAD_MIMES = [
        'image/jpeg',
        'image/png',
        'application/pdf',
    ];

    public function self_policy()
    {
        $policies = UserPolicyData::with([
            'policyPlan:id,name,class_id,logo',
            'policyPlan.mainClass:id,name'
        ])
            ->select(
                'id',
                'policy_id',
                'user_id',
                'mobile_number',
                'cnic_number',
                'plan',
                'status',
                'created_at'
            )->ownedBy(Auth::id())->latest()->get();

        return view('frontend.self-policy.self-policy-listing', compact('policies'));
    }

    public function policy_detail($id)
    {
        $data = $this->ownedPolicyOrFail($id);

        return view('frontend.self-policy.policy_detail', compact('data'));
    }

    public function policyDetailEdit($id)
    {
        $data = $this->ownedPolicyOrFail($id);
        $encryptedId = $id;
        $provinces = Provinces::get();
        $cities = City::query()->orderBy('name')->get(['id', 'name']);

        return view('frontend.self-policy.edit', compact('data', 'provinces', 'cities', 'encryptedId'));
    }

    public function downloadPdf($id)
    {
        $data = $this->ownedPolicyOrFail($id);

        $pdf = Pdf::loadView('backend.userPolicy.policy-detail-pdf', compact('data'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('policy-' . $data->policy_id . '.pdf');
    }

    private function ownedPolicyOrFail($encryptedId): UserPolicyData
    {
        try {
            $id = decrypt($encryptedId);
        } catch (\Throwable) {
            abort(404);
        }

        return UserPolicyData::with('voucher', 'family_history', 'lifeProposedDetail')
            ->ownedBy(Auth::id())
            ->where('id', $id)
            ->firstOrFail();
    }

    private function uploadFile(Request $request, string $field, string $folder = 'uploads/policy_documents')
    {
        if (!$request->hasFile($field)) {
            return null;
        }
        $file = $request->file($field);
        if (is_array($file)) {
            $file = $file[0] ?? null;
        }
        if (!$file instanceof UploadedFile || !$file->isValid()) {
            return null;
        }

        $extension = strtolower((string) $file->getClientOriginalExtension());
        $mime = strtolower((string) $file->getMimeType());
        if (
            !in_array($extension, self::ALLOWED_UPLOAD_EXTENSIONS, true)
            || !in_array($mime, self::ALLOWED_UPLOAD_MIMES, true)
        ) {
            return null;
        }

        $fileName = uniqid() . '_' . time() . '.' . $extension;
        if (!is_dir(public_path($folder))) {
            mkdir(public_path($folder), 0755, true);
        }
        $file->move(public_path($folder), $fileName);
        return $fileName;
    }

    public function policyupdate(PolicyUserDataUpdate $request, $id)
    {
        try {
            DB::beginTransaction();
            $policy = $this->ownedPolicyOrFail($id);

            $data = UserPolicyData::withoutProtected($request->validated());

            $documents = [
                'proposer_cnic_front',
                'proposer_cnic_back',
                'nominee_document',
                'proposer_photo',
                'income_proof',
            ];

            foreach ($documents as $document) {
                unset($data[$document]);
                $imageName = $this->uploadFile($request, $document);

                if ($imageName) {
                    $data[$document] = $imageName;
                }
            }

            unset($data['life_proposed_document']);
            if (($request->input('is_same_person') ?? '') !== 'No') {
                $data['other_documents'] = LifeProposedDocument::put($policy->other_documents, null);
            } else {
                $lifeProposedFile = $this->uploadFile($request, 'life_proposed_document');
                if ($lifeProposedFile) {
                    $data['other_documents'] = LifeProposedDocument::put($policy->other_documents, $lifeProposedFile);
                }
            }

            if (!empty($data['birth_place_city_id'])) {
                $city = City::query()->find($data['birth_place_city_id']);
                if ($city) {
                    $data['birth_placed'] = $city->name;
                }
            }

            if (!empty($data['cnic_number']) && !empty($data['mobile_number'])) {
                app(CnicMobileLinkService::class)->ensureLink(
                    $data['cnic_number'],
                    $data['mobile_number'],
                    'policy_update',
                    $policy->user_id
                );
            }

            $data['status'] = 'Pending';
            $lpExtras = LifeProposedProfile::pullFrom($data);
            if (($data['is_same_person'] ?? '') === 'No'
                && !empty($data['life_proposed_cnic'])
                && !empty($lpExtras['mobile'])
                && (int) ($lpExtras['age'] ?? 0) >= 18
            ) {
                app(CnicMobileLinkService::class)->ensureLink(
                    $data['life_proposed_cnic'],
                    $lpExtras['mobile'],
                    'life_proposed_update',
                    $policy->user_id
                );
            }
            $policy->update($data);
            LifeProposedProfile::syncForPolicy($policy, $data['is_same_person'] ?? 'Yes', $lpExtras);

            $history = new UserPolicyStatusHistory;
            $history->policy_id = $policy->id;
            $history->status = 'Pending';
            $history->user_id = Auth::user()->id;
            $history->save();

            FamilyHistory::where('user_personal_policy_data_id', $policy->id)->delete();

            $this->saveFamilyMember($request, $policy, 'father');
            $this->saveFamilyMember($request, $policy, 'mother');
            $this->saveFamilyMember($request, $policy, 'spouse');

            $dynamicTypes = ['brother', 'sister', 'son', 'daughter'];

            foreach ($dynamicTypes as $type) {
                if ($request->has($type . '_age') && is_array($request->input($type . '_age'))) {
                    $ages = $request->input($type . '_age');
                    $healths = $request->input($type . '_health');
                    $isAliveList = $request->input($type . '_is_alive');
                    $yearsOfDeath = $request->input($type . '_year_of_death');
                    $agesOfDeath = $request->input($type . '_age_of_death');
                    $causesOfDeath = $request->input($type . '_cause_of_death');

                    foreach ($ages as $index => $ageValue) {
                        if (empty($ageValue)) {
                            continue;
                        }

                        $memberAlive = $isAliveList[$index] ?? null;
                        if ($memberAlive === null) {
                            $memberAlive = !empty($yearsOfDeath[$index]) || !empty($agesOfDeath[$index]) || !empty($causesOfDeath[$index])
                                ? 'No'
                                : 'Yes';
                        }

                        FamilyHistory::create([
                            'user_personal_policy_data_id' => $policy->id,
                            'policy_id'                    => $policy->policy_id,
                            'memner_flag'                  => $type,
                            'age'                          => $ageValue,
                            'state_of_health'              => $healths[$index] ?? null,
                            'year_of_death'                => $memberAlive === 'No' ? ($yearsOfDeath[$index] ?? null) : null,
                            'age_of_death'                 => $memberAlive === 'No' ? ($agesOfDeath[$index] ?? null) : null,
                            'cause_of_death'               => $memberAlive === 'No' ? ($causesOfDeath[$index] ?? null) : null,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('frontend.policyDetail', encrypt($policy->id))
                ->with('success', 'Policy updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\App\Exceptions\CnicMobileConflictException $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['mobile_number' => $e->getMessage()]);
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    private function saveFamilyMember(Request $request, UserPolicyData $policy, string $type): void
    {
        if (!$request->filled($type . '_age')) {
            return;
        }

        $alive = $request->input($type . '_is_alive');
        if ($alive === null) {
            $alive = $request->filled($type . '_year_of_death')
                || $request->filled($type . '_age_of_death')
                || $request->filled($type . '_cause_of_death')
                ? 'No'
                : 'Yes';
        }

        FamilyHistory::create([
            'user_personal_policy_data_id' => $policy->id,
            'policy_id'                    => $policy->policy_id,
            'memner_flag'                  => $type,
            'age'                          => $request->input($type . '_age'),
            'state_of_health'              => $request->input($type . '_health'),
            'year_of_death'                => $alive === 'No' ? $request->input($type . '_year_of_death') : null,
            'age_of_death'                 => $alive === 'No' ? $request->input($type . '_age_of_death') : null,
            'cause_of_death'               => $alive === 'No' ? $request->input($type . '_cause_of_death') : null,
        ]);
    }
}

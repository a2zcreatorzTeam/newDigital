<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\PolicyUserDataUpdate;
use App\Models\FamilyHistory;
use App\Models\Provinces;
use App\Models\UserPolicyData;
use App\Models\UserPolicyStatusHistory;
use App\Services\CnicMobileLinkService;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PolicyController extends Controller
{
    public function self_policy()
    {


        if (!Auth::check()) {
            return redirect()->back()->with('info', 'You must log in first before proceeding');
        }

        $policies =  UserPolicyData::with([
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
            )->where('user_id', Auth::user()->id)->latest()->get();
 
        return view('frontend.self-policy.self-policy-listing', compact('policies'));
    }
    public function policy_detail($id)
    {
        $id = decrypt($id);
        $data = UserPolicyData::with('voucher', 'family_history')->where('id', $id)->first();
        return view('frontend.self-policy.policy_detail', compact('data'));
    }

    public function policyDetailEdit($id)
    {
        $id = decrypt($id);
        $data = UserPolicyData::with('voucher', 'family_history')->where('id', $id)->first();
        $provinces = Provinces::get();
        return view('frontend.self-policy.edit', compact('data', 'provinces', 'id'));
    }

    private  function uploadFile(Request $request, string $field, string $folder = 'uploads/policy_documents')
    {
        if (!$request->hasFile($field)) {
            return null;
        }
        $file = $request->file($field);
        $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
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
            $policy = UserPolicyData::where('id', $id)->firstOrFail();

            // Family history / document fields ko normal $data se exclude karo,
            // in ko alag se handle karenge
            $data = $request->except([
                '_token',
                '_method',
                // documents (alag se handle honge)
                'proposer_cnic_front',
                'proposer_cnic_back',
                'nominee_document',
                'proposer_photo',
                'income_proof',

                // father / mother
                'father_id',
                'father_flag',
                'father_age',
                'father_health',
                'father_year_of_death',
                'father_age_of_death',
                'father_cause_of_death',

                'mother_id',
                'mother_flag',
                'mother_age',
                'mother_health',
                'mother_year_of_death',
                'mother_age_of_death',
                'mother_cause_of_death',

                // dynamic members
                'brother_id',
                'brother_age',
                'brother_health',
                'brother_year_of_death',
                'brother_age_of_death',
                'brother_cause_of_death',
                'memner_flag_brother',

                'sister_id',
                'sister_age',
                'sister_health',
                'sister_year_of_death',
                'sister_age_of_death',
                'sister_cause_of_death',
                'memner_flag_sister',

                'son_id',
                'son_age',
                'son_health',
                'son_year_of_death',
                'son_age_of_death',
                'son_cause_of_death',
                'memner_flag_son',

                'daughter_id',
                'daughter_age',
                'daughter_health',
                'daughter_year_of_death',
                'daughter_age_of_death',
                'daughter_cause_of_death',
                'memner_flag_daughter',
            ]);

            // ==========================================
            // 1. Documents — sirf tab replace ho jab naya file diya ho
            // ==========================================
            $documents = [
                'proposer_cnic_front',
                'proposer_cnic_back',
                'nominee_document',
                'proposer_photo',
                'income_proof',
            ];

            foreach ($documents as $document) {
                $imageName = $this->uploadFile($request, $document);

                if ($imageName) {
                    $data[$document] = $imageName; // naya upload mila to replace karo
                }
                // agar naya file nahi mila to $data me is field ka key hi nahi hoga,
                // is liye purani value column me as-is rahegi (overwrite nahi hoga)
            }

            // ==========================================
            // 2. Update Main Policy Record (Insert nahi, sirf Update)
            // ==========================================
            if (!empty($data['cnic_number']) && !empty($data['mobile_number'])) {
                app(CnicMobileLinkService::class)->ensureLink(
                    $data['cnic_number'],
                    $data['mobile_number'],
                    'policy_update',
                    $policy->user_id
                );
            }

            $data['status'] = 'Pending';
            $policy->update($data);




            $history = new UserPolicyStatusHistory;
            $history->policy_id = $id;
            $history->status = 'Pending';
            // $history->comment = $request->comment ?? '';
            $history->user_id = Auth::user()->id;
            $history->save();

            // ==========================================
            // 3. Family History — Clean Rewrite (purana delete, naya insert)
            // ==========================================
            FamilyHistory::where('user_personal_policy_data_id', $policy->id)->delete();

            // --- Father ---
            if ($request->filled('father_age')) {
                FamilyHistory::create([
                    'user_personal_policy_data_id' => $policy->id,
                    'policy_id'                    => $policy->policy_id,
                    'memner_flag'                  => 'father',
                    'age'                          => $request->input('father_age'),
                    'state_of_health'              => $request->input('father_health'),
                    'year_of_death'                => $request->input('father_year_of_death'),
                    'age_of_death'                 => $request->input('father_age_of_death'),
                    'cause_of_death'               => $request->input('father_cause_of_death'),
                ]);
            }

            // --- Mother ---
            if ($request->filled('mother_age')) {
                FamilyHistory::create([
                    'user_personal_policy_data_id' => $policy->id,
                    'policy_id'                    => $policy->policy_id,
                    'memner_flag'                  => 'mother',
                    'age'                          => $request->input('mother_age'),
                    'state_of_health'              => $request->input('mother_health'),
                    'year_of_death'                => $request->input('mother_year_of_death'),
                    'age_of_death'                 => $request->input('mother_age_of_death'),
                    'cause_of_death'               => $request->input('mother_cause_of_death'),
                ]);
            }

            // --- Brother / Sister / Son / Daughter (dynamic arrays) ---
            $dynamicTypes = ['brother', 'sister', 'son', 'daughter'];

            foreach ($dynamicTypes as $type) {
                if ($request->has($type . '_age') && is_array($request->input($type . '_age'))) {

                    $ages          = $request->input($type . '_age');
                    $healths       = $request->input($type . '_health');
                    $yearsOfDeath  = $request->input($type . '_year_of_death');
                    $agesOfDeath   = $request->input($type . '_age_of_death');
                    $causesOfDeath = $request->input($type . '_cause_of_death');

                    foreach ($ages as $index => $ageValue) {
                        if (empty($ageValue)) continue;

                        FamilyHistory::create([
                            'user_personal_policy_data_id' => $policy->id,
                            'policy_id'                    => $policy->policy_id,
                            'memner_flag'                  => $type,
                            'age'                          => $ageValue,
                            'state_of_health'              => $healths[$index] ?? null,
                            'year_of_death'                => $yearsOfDeath[$index] ?? null,
                            'age_of_death'                 => $agesOfDeath[$index] ?? null,
                            'cause_of_death'               => $causesOfDeath[$index] ?? null,
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
}

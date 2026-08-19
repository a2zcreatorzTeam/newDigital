<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressInfoRequest;
use App\Http\Requests\BasicDetailRequest;
use App\Http\Requests\PolicyUserDataRequest;
use App\Http\Requests\UserHealthRequest;
use App\Http\Requests\UserOccupationRequest;
use App\Mail\SendOtpMail;
use App\Models\AddressInfo;
use App\Models\BasicDetail;
use App\Models\FamilyHistory;
use App\Models\City;
use Carbon\Carbon;
use App\Models\Voucher;
use App\Models\District;
use App\Models\MainClass;
use App\Models\Otp;
use App\Models\PlanAgeMaturity;
use App\Models\Provinces;
use App\Models\SubClass;
use App\Models\User;
use App\Models\UserHealth;
use App\Models\UserOccupation;
use App\Models\UserPolicyData;
use App\Rules\MobileLinkedToCnic;
use App\Services\CnicMobileLinkService;
use App\Services\PolicyFormDraftService;
use App\Support\LifeProposedDocument;
use App\Support\LifeProposedProfile;
use App\Support\PremiumCalculator;
use App\Models\PolicyFormDraft;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class FrontendController extends Controller
{
    public function home()
    {
        if (session()->has('policy_id')) {
            session()->forget('policy_id');
        }
        $category = MainClass::where('status', 1)->get();

        return view('frontend.index')->with(['category' => $category]);
    }


    public function profile()
    {
        return view('frontend.my-profile');
    }


    public function cart()
    {
        return view('frontend.cart');
    }

    public function forget_password()
    {
        return view('frontend.forgot-password');
    }

    public function contact()
    {
        return view('frontend.contact-us');
    }

    public function signup(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_no' => ['required', 'regex:/^03[0-9]{2}-[0-9]{7}$/', new MobileLinkedToCnic('cnic')],
            'cnic' => 'required|regex:/^[0-9]{5}-[0-9]{7}-[0-9]$/',
            'password' => 'required|min:8|confirmed',
        ], [
            'phone_no.regex' => 'Enter a valid mobile number (e.g. 0300-1234567).',
            'cnic.regex' => 'CNIC format must be like 42101-1234567-1.',
        ]);

        try {
            $data = $request->all();

            // ✅ Create User (observer also enforces CNIC↔mobile uniqueness)
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone_no' => $validated['phone_no'],
                'cnic' => $validated['cnic'],
                'password' => Hash::make($validated['password']),
            ]);

            app(CnicMobileLinkService::class)->ensureLink(
                $validated['cnic'],
                $validated['phone_no'],
                'signup',
                $user->id
            );
            // ✅ Generate OTP
            $otpCode = rand(100000, 999999);

            // ✅ Save OTP
            Otp::create([
                'user_id' => $user->id,
                'otp' => $otpCode,
                'type' => 'email',
                'expires_at' => now()->addMinutes(5),
            ]);

            // ✅ Send OTP Email
            Mail::to($user->email)->send(new SendOtpMail($otpCode, $user));

            // ✅ Login User
            // Auth::login($user);

            // ✅ Success Response (for AJAX)
            return response()->json([
                'status' => true,
                'message' => 'OTP sent successfully to your email.',
                'user_id' => $user->id
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\App\Exceptions\CnicMobileConflictException $e) {
            throw $e->toValidationException('phone_no');
        } catch (\Exception $e) {
            Log::warning('Password reset exception for:: ' . $request->email . ', reason:' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function signin(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {

            // ✅ Check user exists
            $user = User::where('email', $validated['email'])->first();


            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // ✅ Check password
            if (!Hash::check($validated['password'], $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }
            // ✅ EMAIL NOT VERIFIED
            if (!$user->email_verified_at) {

                // delete old otp
                Otp::where('user_id', $user->id)->delete();

                // generate new otp
                $otpCode = rand(100000, 999999);

                // save otp
                Otp::create([
                    'user_id' => $user->id,
                    'otp' => $otpCode,
                    'type' => 'email',
                    'expires_at' => now()->addMinutes(5),
                ]);

                // resend email
                Mail::to($user->email)
                    ->send(new SendOtpMail($otpCode, $user));

                return response()->json([
                    'status' => false,
                    'message' => 'Email not verified. New OTP sent.',
                    'user_id' => $user->id,
                    'verification_required' => true
                ], 403);
            }

            // ✅ VERIFIED USER LOGIN
            Auth::login($user);

            $redirect = route('frontend.index');
            $referer = $request->headers->get('referer');
            if ($referer) {
                $refererHost = parse_url($referer, PHP_URL_HOST);
                $appHost = parse_url((string) config('app.url'), PHP_URL_HOST);
                if ($refererHost && $appHost && strcasecmp($refererHost, $appHost) === 0) {
                    $redirect = $referer;
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'redirect_url' => $redirect,
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('frontend.index')->with('success', 'Logout Successfully!');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status === Password::RESET_LINK_SENT) {
                return response()->json([
                    'status' => true,
                    'message' => 'If your email exists, we have sent a reset link',
                ]);
            }

            Log::warning('Password reset failed for: ' . $request->email);
            return response()->json([
                'status' => false,
                'message' => __($status),
            ], 429);
        } catch (\Exception $e) {
            Log::warning('Password reset exception for:: ' . $request->email . ', reason:' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function product(Request $request)
    {
        return view('frontend.products');
    }
    public function getPolicies(Request $request)
    {
        $policies = SubClass::where('class_id', $request->category_id)->get();
        $main_category = MainClass::where('id', $request->category_id)->select('name')->first();
        return view('frontend.get-policies', ['policies' => $policies, 'main_category' => $main_category]);
    }

    public function policyForm()
    {
        return view('frontend.policy-form');
    }
    public function dashboard(Request $request, $id)
    {

        if (session()->has('policy_id')) {
            session()->forget('policy_id');
        }

        if (!Auth::check()) {
            return redirect()->back()->with('info', 'You must log in first before proceeding');
        }
        $user = User::with('basicDetail.lifeProposedDetail', 'AddressInfo', 'occupation', 'health')->where('id', Auth::user()->id)->first();
        if (
            !$user->basicDetail ||
            !$user->AddressInfo ||
            !$user->occupation ||
            !$user->health
        ) {
            return redirect()
                ->route('frontend.profileForm')
                ->with('info', 'Please complete your profile before proceeding!');
        }
        $product = SubClass::with('product')->where('id', $id)->first();
        if (!$product) {
            return redirect()
                ->route('frontend.index')
                ->with('info', 'The selected product was not found.');
        }

        $policy_data = $product->product->where('age', $user->basicDetail->age_nearest_date)->first();
        if (!$policy_data) {
            return redirect()
                ->route('frontend.index')
                ->with('info', 'No premium rate is available for your age on this product.');
        }

        $provinces = Provinces::get();
        $cities = City::query()->orderBy('name')->get(['id', 'name']);

        $draft = null;
        $draftId = $request->query('draft');
        if ($draftId) {
            $draft = PolicyFormDraft::query()
                ->where('user_id', Auth::id())
                ->where('id', $draftId)
                ->where('product_id', $id)
                ->first();
        }

        return view('frontend.dashboard', [
            'user' => $user,
            'provinces' => $provinces,
            'cities' => $cities,
            'policy_data' => $policy_data,
            'product' => $product,
            'id' => $id,
            'draft' => $draft,
        ]);
    }

    public function profileForm()
    {
        if (!Auth::check()) {
            return redirect()->route('frontend.index')->with('info', 'Please sign in to complete your profile.');
        }

        $user = User::with('basicDetail.lifeProposedDetail', 'AddressInfo', 'occupation', 'health')->where('id', Auth::user()->id)->first();
        $provinces = Provinces::get();
        $cities = City::query()->orderBy('name')->get(['id', 'name']);
        return view('frontend.profile-form', ['user' => $user, 'provinces' => $provinces, 'cities' => $cities]);
    }

    public function updateBasicDetails(BasicDetailRequest $request)
    {
        try {
            DB::beginTransaction();

            $userId = auth()->id();
            $data = $request->validated();
            $data = $this->syncBirthPlaceFromCity($data);
            $lpExtras = LifeProposedProfile::pullFrom($data);

            $basicDetail = BasicDetail::updateOrCreate(
                ['user_id' => $userId],
                $data + ['user_id' => $userId]
            );

            LifeProposedProfile::syncForProfile($basicDetail, $data['is_same_person'] ?? 'Yes', $lpExtras);

            if (!empty($data['cnic_number']) && !empty($data['mobile_number'])) {
                app(CnicMobileLinkService::class)->ensureLink(
                    $data['cnic_number'],
                    $data['mobile_number'],
                    'basic_details',
                    $userId
                );
            }
            if (($data['is_same_person'] ?? '') === 'No'
                && !empty($data['life_proposed_cnic'])
                && !empty($lpExtras['mobile'])
                && (int) ($lpExtras['age'] ?? 0) >= 18
            ) {
                app(CnicMobileLinkService::class)->ensureLink(
                    $data['life_proposed_cnic'],
                    $lpExtras['mobile'],
                    'life_proposed_profile',
                    $userId
                );
            }

            DB::commit();

            // AJAX ke liye success JSON return karein
            return response()->json([
                'success' => true,
                'message' => 'Basic details saved successfully'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\App\Exceptions\CnicMobileConflictException $e) {
            DB::rollBack();
            throw $e->toValidationException();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }
    public function updateAddressInfo(AddressInfoRequest $request)
    {
        try {
            DB::beginTransaction();

            $userId = auth()->id();
            $data = $request->validated();

            $address_info = AddressInfo::updateOrCreate(
                ['user_id' => $userId],
                $data + ['user_id' => $userId]
            );

            DB::commit();

            // AJAX ke liye success JSON return karein
            return response()->json([
                'success' => true,
                'message' => 'Basic details saved successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }
    public function updateOccupation(UserOccupationRequest $request)
    {
        try {
            DB::beginTransaction();

            $userId = auth()->id();
            $data = $request->validated();

            $address_info = UserOccupation::updateOrCreate(
                ['user_id' => $userId],
                $data + ['user_id' => $userId]
            );

            DB::commit();

            // AJAX ke liye success JSON return karein
            return response()->json([
                'success' => true,
                'message' => 'Basic details saved successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }
    public function updateHealth(UserHealthRequest $request)
    {
        try {
            DB::beginTransaction();

            $userId = auth()->id();
            $data = $request->validated();

            $address_info = UserHealth::updateOrCreate(
                ['user_id' => $userId],
                $data + ['user_id' => $userId]
            );

            DB::commit();

            // AJAX ke liye success JSON return karein
            return response()->json([
                'success' => true,
                'message' => 'Basic details saved successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getcityData(Request $request)
    {
        $province_id = $request->province_id;
        $cities = City::where('province_id', $province_id)->get();
        return $cities;
    }
    public function getDistrictData(Request $request)
    {
        $city_id = $request->city_id;
        $district = District::where('city_id', $city_id)->get();
        return $district;
    }

    public function policyDataSave_old_11_06_2026(PolicyUserDataRequest $request)
    {

        try {
            DB::beginTransaction();

            $userId = auth()->id();
            $data   = $request->validated();
            $policy_id = session('policy_id');

            $policy = null;

            if ($policy_id) {
                $policy = UserPolicyData::where('user_id', $userId)
                    ->where('policy_id', $policy_id)
                    ->first();
            }

            // ✅ If found → UPDATE
            if ($policy) {
                $policy->update($data);
            } else {
                do {
                    $policy_id = 'POL-' . date('Y') . '-' . random_int(100000, 999999);
                    session(['policy_id' => $policy_id]);
                } while (UserPolicyData::where('policy_id', $policy_id)->exists());
                $data['status'] = 'Pending';

                $policy = UserPolicyData::create([
                    'user_id'   => $userId,
                    'policy_id' => $policy_id,
                ] + $data);



                $this->generateCustomerVoucher($policy);
            }

            DB::commit();

            return response()->json([
                'success'   => true,
                'message'   => 'Policy saved successfully',
                'policy_id' => $policy->policy_id,
                'redirect_url' => route('voucher.voucher', [encrypt($policy->id)])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }


    /**
     * Persist birth_place_city_id and denormalized birth_placed city name.
     */
    private function syncBirthPlaceFromCity(array $data): array
    {
        if (empty($data['birth_place_city_id'])) {
            return $data;
        }

        $city = City::query()->find($data['birth_place_city_id']);
        if ($city) {
            $data['birth_placed'] = $city->name;
        }

        return $data;
    }

    private const ALLOWED_UPLOAD_EXTENSIONS = ['jpg', 'jpeg', 'png', 'pdf'];

    private const ALLOWED_UPLOAD_MIMES = [
        'image/jpeg',
        'image/png',
        'application/pdf',
    ];

    private  function uploadFile(Request $request, string $field, string $folder = 'uploads/policy_documents')
    {
        if (!$request->hasFile($field)) {
            return null;
        }
        $file = $request->file($field);
        // Support accidental multi-file inputs by taking the first file
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

    private function storeValidatedUpload($file, string $folder = 'uploads/policy_documents'): ?string
    {
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



    public function policyDataSave(PolicyUserDataRequest $request)
    {

        try {
            DB::beginTransaction();
            $userId = auth()->id();
            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }
            $data   = $request->validated();
            $data   = UserPolicyData::withoutProtected($data);
            $data   = $this->syncBirthPlaceFromCity($data);
            $lpExtras = LifeProposedProfile::pullFrom($data);

            $calculatedPremium = PremiumCalculator::calculate(
                $data['sum_assured'] ?? $request->input('sum_assured'),
                $data['payment_mode'] ?? $request->input('payment_mode'),
                $data['term'] ?? $request->input('term'),
                $data['plan'] ?? $request->input('plan', $request->input('policy_product_id')),
                $data['age_nearest_date'] ?? $request->input('age_nearest_date'),
                $data['adb_rider'] ?? $request->input('adb_rider'),
                $data['tir_rider'] ?? $request->input('tir_rider')
            );
            if ($calculatedPremium === null) {
                throw ValidationException::withMessages([
                    'premium_paid' => 'Kindly First Calculate the Premium Amount.',
                ]);
            }
            $data['premium_paid'] = $calculatedPremium['premium_paid'];

            $documents = [
                'proposer_cnic_front',
                'proposer_cnic_back',
                'nominee_document',
                'proposer_photo',
                'income_proof',
            ];

            $lifeProposedFile = null;
            if (($data['is_same_person'] ?? '') === 'No') {
                $lifeProposedFile = $this->uploadFile($request, 'life_proposed_document');
            }
            unset($data['life_proposed_document']);

            foreach ($documents as $document) {
                // Never mass-assign UploadedFile objects
                unset($data[$document]);

                $imageName = $this->uploadFile($request, $document);

                if ($imageName) {
                    $data[$document] = $imageName;
                }
            }

            // Medical documents JSON payload
            $medicalDocs = [];
            $fixedMedical = [
                'medical_doc_referred_opd' => 'Referred / OPD Letter / Slip / Card',
                'medical_doc_previous_opd' => 'Previous OPD Card / Slip / Document',
                'medical_doc_summary_reports' => 'Summary / Discharge / Operation / Lab Reports / Any others',
                'medical_doc_present_history' => 'Present / Brief History / Investigations / Picture (If any)',
                'medical_doc_death_mlc' => 'Death / MLC / Postmortem / Police / Medico Legal',
                'medical_doc_medicolegal' => 'Medicolegal / Legal / FIR / Panchanama / Inquest / Others',
            ];
            foreach ($fixedMedical as $field => $label) {
                $fileName = $this->uploadFile($request, $field);
                if ($fileName) {
                    $medicalDocs[] = [
                        'key' => $field,
                        'label' => $label,
                        'file' => $fileName,
                    ];
                }
                unset($data[$field]);
            }
            if ($request->hasFile('medical_extra_docs')) {
                $extraLabels = $request->input('medical_extra_labels', []);
                foreach ($request->file('medical_extra_docs') as $index => $file) {
                    $fileName = $this->storeValidatedUpload($file);
                    if (!$fileName) {
                        continue;
                    }
                    $medicalDocs[] = [
                        'key' => 'medical_extra_' . $index,
                        'label' => $extraLabels[$index] ?? ('Additional Medical Document ' . ($index + 1)),
                        'file' => $fileName,
                    ];
                }
            }
            $data['medical_documents'] = !empty($medicalDocs) ? json_encode($medicalDocs) : null;

            // Other documents JSON payload
            $otherDocs = [];
            if ($request->hasFile('other_docs')) {
                $otherLabels = $request->input('other_doc_labels', []);
                foreach ($request->file('other_docs') as $index => $file) {
                    $fileName = $this->storeValidatedUpload($file);
                    if (!$fileName) {
                        continue;
                    }
                    $otherDocs[] = [
                        'key' => 'other_doc_' . $index,
                        'label' => $otherLabels[$index] ?? ('Other Document ' . ($index + 1)),
                        'file' => $fileName,
                    ];
                }
            }
            $data['other_documents'] = LifeProposedDocument::put(
                !empty($otherDocs) ? json_encode($otherDocs) : null,
                $lifeProposedFile
            );

            // Remove non-column array inputs from mass assignment
            unset($data['medical_extra_docs'], $data['medical_extra_labels'], $data['other_docs'], $data['other_doc_labels']);

            // Family history is stored in a related table — strip from policy mass-assignment
            $familyKeys = [
                'father_age', 'father_health', 'father_is_alive', 'father_year_of_death', 'father_age_of_death', 'father_cause_of_death',
                'mother_age', 'mother_health', 'mother_is_alive', 'mother_year_of_death', 'mother_age_of_death', 'mother_cause_of_death',
                'spouse_age', 'spouse_health', 'spouse_is_alive', 'spouse_year_of_death', 'spouse_age_of_death', 'spouse_cause_of_death',
                'brother_age', 'brother_health', 'brother_is_alive', 'brother_year_of_death', 'brother_age_of_death', 'brother_cause_of_death',
                'sister_age', 'sister_health', 'sister_is_alive', 'sister_year_of_death', 'sister_age_of_death', 'sister_cause_of_death',
                'son_age', 'son_health', 'son_is_alive', 'son_year_of_death', 'son_age_of_death', 'son_cause_of_death',
                'daughter_age', 'daughter_health', 'daughter_is_alive', 'daughter_year_of_death', 'daughter_age_of_death', 'daughter_cause_of_death',
                'memner_flag', 'memner_flag_brother', 'memner_flag_sister', 'memner_flag_son', 'memner_flag_daughter',
                'policy_product_id',
            ];
            foreach ($familyKeys as $key) {
                unset($data[$key]);
            }

            // Global CNIC ↔ mobile uniqueness (one mobile → one CNIC)
            if (!empty($data['cnic_number']) && !empty($data['mobile_number'])) {
                app(CnicMobileLinkService::class)->ensureLink(
                    $data['cnic_number'],
                    $data['mobile_number'],
                    'policy_form',
                    $userId
                );
            }
            if (($data['is_same_person'] ?? '') === 'No'
                && !empty($data['life_proposed_cnic'])
                && !empty($lpExtras['mobile'])
                && (int) ($lpExtras['age'] ?? 0) >= 18
            ) {
                app(CnicMobileLinkService::class)->ensureLink(
                    $data['life_proposed_cnic'],
                    $lpExtras['mobile'],
                    'life_proposed_policy',
                    $userId
                );
            }

            $policy_id = session('policy_id');
            $policy = null;
            if ($policy_id) {
                $policy = UserPolicyData::where('user_id', $userId)
                    ->where('policy_id', $policy_id)
                    ->first();
            }

            // 1. Save or Update User Policy Data
            if ($policy) {
                $policy->update($data);
                // Optional: Delete previous history if you want a clean rewrite on updates
                FamilyHistory::where('user_personal_policy_data_id', $policy->id)->delete();
            } else {
                do {
                    $policy_id = 'POL-' . date('Y') . '-' . random_int(100000, 999999);
                    session(['policy_id' => $policy_id]);
                } while (UserPolicyData::where('policy_id', $policy_id)->exists());

                $data['status'] = 'Pending';

                $policy = new UserPolicyData();
                $policy->user_id = $userId;
                $policy->fill(['policy_id' => $policy_id] + $data);
                $policy->save();
                $this->generateCustomerVoucher($policy);
            }

            LifeProposedProfile::syncForPolicy($policy, $data['is_same_person'] ?? 'Yes', $lpExtras);

            // ==========================================
            // 2. SAVE FAMILY HISTORY DATA HERE
            // ==========================================

            // --- Process Father Data ---
            if ($request->filled('father_age')) {
                $fatherAlive = $request->input('father_is_alive');
                FamilyHistory::create([
                    'user_personal_policy_data_id' => $policy->id,
                    'policy_id'                    => $policy->policy_id,
                    'memner_flag'                  => 'father',
                    'age'                          => $request->input('father_age'),
                    'state_of_health'              => $request->input('father_health'),
                    'year_of_death'                => $fatherAlive === 'No' ? $request->input('father_year_of_death') : null,
                    'age_of_death'                 => $fatherAlive === 'No' ? $request->input('father_age_of_death') : null,
                    'cause_of_death'               => $fatherAlive === 'No' ? $request->input('father_cause_of_death') : null,
                ]);
            }

            // --- Process Mother Data ---
            if ($request->filled('mother_age')) {
                $motherAlive = $request->input('mother_is_alive');
                FamilyHistory::create([
                    'user_personal_policy_data_id' => $policy->id,
                    'policy_id'                    => $policy->policy_id,
                    'memner_flag'                  => 'mother',
                    'age'                          => $request->input('mother_age'),
                    'state_of_health'              => $request->input('mother_health'),
                    'year_of_death'                => $motherAlive === 'No' ? $request->input('mother_year_of_death') : null,
                    'age_of_death'                 => $motherAlive === 'No' ? $request->input('mother_age_of_death') : null,
                    'cause_of_death'               => $motherAlive === 'No' ? $request->input('mother_cause_of_death') : null,
                ]);
            }

            // --- Process Spouse Data ---
            if ($request->filled('spouse_age')) {
                $spouseAlive = $request->input('spouse_is_alive');
                FamilyHistory::create([
                    'user_personal_policy_data_id' => $policy->id,
                    'policy_id'                    => $policy->policy_id,
                    'memner_flag'                  => 'spouse',
                    'age'                          => $request->input('spouse_age'),
                    'state_of_health'              => $request->input('spouse_health'),
                    'year_of_death'                => $spouseAlive === 'No' ? $request->input('spouse_year_of_death') : null,
                    'age_of_death'                 => $spouseAlive === 'No' ? $request->input('spouse_age_of_death') : null,
                    'cause_of_death'               => $spouseAlive === 'No' ? $request->input('spouse_cause_of_death') : null,
                ]);
            }


            $dynamicTypes = ['brother', 'sister', 'son', 'daughter'];

            foreach ($dynamicTypes as $type) {
                if ($request->has($type . '_age') && is_array($request->input($type . '_age'))) {

                    $ages           = $request->input($type . '_age');
                    $healths        = $request->input($type . '_health');
                    $isAliveList    = $request->input($type . '_is_alive');
                    $yearsOfDeath   = $request->input($type . '_year_of_death');
                    $agesOfDeath    = $request->input($type . '_age_of_death');
                    $causesOfDeath  = $request->input($type . '_cause_of_death');
                    foreach ($ages as $index => $ageValue) {
                        if (empty($ageValue)) continue;

                        $memberAlive = $isAliveList[$index] ?? null;

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

            // Clear matching queue draft after successful submission
            app(PolicyFormDraftService::class)->deleteForProduct(
                (int) $userId,
                (int) ($policy->plan ?? $request->input('plan') ?? $request->input('policy_product_id') ?? 0)
            );

            return response()->json([
                'success'   => true,
                'message'   => 'Policy Data saved Successfully',
                'policy_id' => $policy->policy_id,
                'redirect_url' => route('voucher.voucher', [encrypt($policy->id)])
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\App\Exceptions\CnicMobileConflictException $e) {
            DB::rollBack();
            throw $e->toValidationException();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }


    public function ip_address()
    {
        return request()->ip();
    }



    protected   function generateCustomerVoucher($order)
    {


        // $prefix = "01520";
        $prefix = "13051";
        $currentDate = Carbon::now();
        $billingMonth = $currentDate->format('ym');

        $sequence = str_pad($order->id, 7, '0', STR_PAD_LEFT);

        $consumerNumber = $prefix . $billingMonth . $sequence;

        // DB me insert karna
        return Voucher::create([
            'consumer_number' => $consumerNumber,
            'customer_name' => $order->life_proposed_full_name,
            // 'amount_within_due_date' => $order->total_amount,
            'amount_within_due_date' => $order->premium_paid,
            // 'amount_after_due_date' => $order->total_amount + 150, // Late fee agar applicable ho
            'amount_after_due_date' => $order->premium_paid + 150, // Late fee agar applicable ho
            'due_date' => Carbon::now()->addDays(10)->format('Y-m-d'),
            'billing_month' => $billingMonth,
            'email' => $order->user_email,
            'contact_number' => $order->mobile_number,
            'status' => 'U',
            'order_id' => $order->id,
            'policy_id' => $order->policy_id,
            'user_ip_address' => $this->ip_address()
        ]);
    }

    public function getPlanData(Request $request)
    {
        $plan = PlanAgeMaturity::with('surrendervalues')
            ->where('plan_id', $request->product_id)
            ->where('age', $request->age)
            ->first();

        return [
            'plan' => $plan,
            'surrender_values' => $plan?->surrendervalues ?? []
        ];
    }

    public function getSumAssured(Request $request)
    {
        $plan = PlanAgeMaturity::with('surrendervalues')
            ->where('plan_id', $request->product_id)
            ->where('age', $request->age)
            ->first();

        if (!$plan) {
            return 0;
        }

        $surrender = $plan->surrendervalues
            ->where('duration', $request->term_value)
            ->first();

        return $surrender?->amount ?? 0;
    }






    public function successPayment(Request $request)
    {
        $policy_id = session('policy_id');
        $policy = null;

        if ($policy_id) {
            $policy = UserPolicyData::with('product')
                ->where('policy_id', $policy_id)
                ->where('user_id', Auth::id())
                ->first();
        }

        if (!$policy) {
            return redirect()
                ->route('frontend.index')
                ->with('info', 'Payment session expired. Please sign in to view your policies.');
        }

        return view('frontend.payment.success', ['policy' => $policy]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'otp' => 'required'
        ]);

        $failKey = 'otp-fail:' . $request->ip() . ':' . $request->input('user_id');
        if (RateLimiter::tooManyAttempts($failKey, 5)) {
            return response()->json([
                'status' => false,
                'message' => 'Too many OTP attempts. Please try again later.'
            ], 429);
        }

        $otp = Otp::where('user_id', $request->user_id)
            ->where('otp', $request->otp)
            ->where('is_used', false)
            ->latest()
            ->first();

        if (!$otp) {
            RateLimiter::hit($failKey, 900);

            return response()->json([
                'status' => false,
                'message' => 'Invalid OTP'
            ], 422);
        }

        if ($otp->expires_at < now()) {
            RateLimiter::hit($failKey, 900);

            return response()->json([
                'status' => false,
                'message' => 'OTP expired'
            ], 422);
        }

        RateLimiter::clear($failKey);

        $otp->update([
            'is_used' => true
        ]);

        $user = $otp->user;

        $user->email_verified_at = now();
        $user->save();

        Auth::login($user);
        return response()->json([
            'status' => true,
            'message' => 'Email verified successfully'
        ]);
    }
    public function resendOtp(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $resendKey = 'otp-resend:' . $request->ip() . ':' . $request->input('user_id');
        if (RateLimiter::tooManyAttempts($resendKey, 3)) {
            return response()->json([
                'status' => false,
                'message' => 'Too many OTP resend requests. Please try again later.'
            ], 429);
        }
        RateLimiter::hit($resendKey, 300);

        $user = User::find($request->user_id);

        Otp::where('user_id', $user->id)->delete();

        $otpCode = rand(100000, 999999);

        Otp::create([
            'user_id' => $user->id,
            'otp' => $otpCode,
            'type' => 'email',
            'expires_at' => now()->addMinutes(5),
        ]);

        Mail::to($user->email)
            ->send(new SendOtpMail($otpCode, $user));

        return response()->json([
            'status' => true,
            'message' => 'New OTP sent successfully'
        ]);
    }
}

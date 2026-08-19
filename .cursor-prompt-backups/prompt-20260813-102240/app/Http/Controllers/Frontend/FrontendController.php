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
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
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
            'phone_no' => 'required|regex:/^03[0-9]{2}-[0-9]{7}$/',
            'cnic' => 'required|regex:/^[0-9]{5}-[0-9]{7}-[0-9]$/',
            'password' => 'required|min:8|confirmed',
        ]);

        try {
            $data = $request->all();

            // ✅ Create User
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone_no' => $validated['phone_no'],
                'cnic' => $validated['cnic'],
                'password' => Hash::make($validated['password']),
            ]);

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
                'data' => $user,
                'user_id' => $user->id
            ]);
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

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'data' => $user
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
        $user = User::with('basicDetail', 'AddressInfo', 'occupation', 'health')->where('id', Auth::user()->id)->first();
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
        $policy_data = $product->product->where('age', $user->basicDetail->age_nearest_date)->first();

        $provinces = Provinces::get();
        return view('frontend.dashboard', ['user' => $user, 'provinces' => $provinces, 'policy_data' => $policy_data, 'product' => $product, 'id' => $id]);
    }

    public function profileForm()
    {
        $user = User::with('basicDetail', 'AddressInfo', 'occupation', 'health')->where('id', Auth::user()->id)->first();
        $provinces = Provinces::get();
        return view('frontend.profile-form', ['user' => $user, 'provinces' => $provinces]);
    }

    public function updateBasicDetails(BasicDetailRequest $request)
    {
        try {
            DB::beginTransaction();

            $userId = auth()->id();
            $data = $request->validated();

            $basicDetail = BasicDetail::updateOrCreate(
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
                'redirect_url' => route('voucher.voucher', [$policy->id])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }


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
        if (!$file) {
            return null;
        }
        $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
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
            $data   = $request->validated();

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
                    if (!$file) {
                        continue;
                    }
                    $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $folder = 'uploads/policy_documents';
                    if (!is_dir(public_path($folder))) {
                        mkdir(public_path($folder), 0755, true);
                    }
                    $file->move(public_path($folder), $fileName);
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
                    if (!$file) {
                        continue;
                    }
                    $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $folder = 'uploads/policy_documents';
                    if (!is_dir(public_path($folder))) {
                        mkdir(public_path($folder), 0755, true);
                    }
                    $file->move(public_path($folder), $fileName);
                    $otherDocs[] = [
                        'key' => 'other_doc_' . $index,
                        'label' => $otherLabels[$index] ?? ('Other Document ' . ($index + 1)),
                        'file' => $fileName,
                    ];
                }
            }
            $data['other_documents'] = !empty($otherDocs) ? json_encode($otherDocs) : null;

            // Remove non-column array inputs from mass assignment
            unset($data['medical_extra_docs'], $data['medical_extra_labels'], $data['other_docs'], $data['other_doc_labels']);
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

                $policy = UserPolicyData::create([
                    'user_id'   => $userId,
                    'policy_id' => $policy_id,
                ] + $data);
                $this->generateCustomerVoucher($policy);
            }

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

            return response()->json([
                'success'   => true,
                'message'   => 'Policy Data saved Successfully',
                'policy_id' => $policy->policy_id,
                'redirect_url' => route('voucher.voucher', [$policy->id])
            ]);
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

        if ($policy_id) {
            $policy = UserPolicyData::with('product')->where('policy_id', $policy_id)
                ->first();
        }
        return view('frontend.payment.success', ['policy' => $policy]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'otp' => 'required'
        ]);

        $otp = Otp::where('user_id', $request->user_id)
            ->where('otp', $request->otp)
            ->where('is_used', false)
            ->latest()
            ->first();

        if (!$otp) {

            return response()->json([
                'status' => false,
                'message' => 'Invalid OTP'
            ], 422);
        }

        if ($otp->expires_at < now()) {

            return response()->json([
                'status' => false,
                'message' => 'OTP expired'
            ], 422);
        }

        $otp->update([
            'is_used' => true
        ]);

        $user = $otp->user;

        $user->email_verified_at = now();
        $user->save();

        // 🔥 LOGIN ONLY AFTER OTP SUCCESS
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

        $user = User::find($request->user_id);

        // remove old otp
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

        // send mail
        Mail::to($user->email)
            ->send(new SendOtpMail($otpCode, $user));

        return response()->json([
            'status' => true,
            'message' => 'New OTP sent successfully'
        ]);
    }
}

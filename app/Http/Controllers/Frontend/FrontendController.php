<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressInfoRequest;
use App\Http\Requests\BasicDetailRequest;
use App\Http\Requests\PolicyUserDataRequest;
use App\Http\Requests\UserHealthRequest;
use App\Http\Requests\UserOccupationRequest;
use App\Models\AddressInfo;
use App\Models\BasicDetail;
use App\Models\City;
use App\Models\District;
use App\Models\MainClass;
use App\Models\PlanAgeMaturity;
use App\Models\Provinces;
use App\Models\SubClass;
use App\Models\User;
use App\Models\UserHealth;
use App\Models\UserOccupation;
use App\Models\UserPolicyData;
use Hash;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Mail;

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
            $encrypted = Crypt::encryptString($user->id);

            Auth::login($user);
            event(new Registered($user));


            // ✅ Success Response (for AJAX)
            return response()->json([
                'status' => true,
                'message' => 'User registered successfully. We have sent a verification email—please verify your email address.',
                'data' => $user
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

        $provinces = Provinces::get();
        return view('frontend.dashboard', ['user' => $user, 'provinces' => $provinces, 'product' => $product, 'id' => $id]);
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

    public function policyDataSave(PolicyUserDataRequest $request)
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
                $data['status'] = 'Incart';
                $policy = UserPolicyData::create([
                    'user_id'   => $userId,
                    'policy_id' => $policy_id,
                ] + $data);
            }

            DB::commit();

            return response()->json([
                'success'   => true,
                'message'   => 'Policy saved successfully',
                'policy_id' => $policy->policy_id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
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
}

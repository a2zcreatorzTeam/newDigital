<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\SignupEmail;
use App\Models\MainClass;
use App\Models\SubClass;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Mail;

class FrontendController extends Controller
{
    public function home()
    {
        $category=MainClass::where('status',1)->get();
        return view('frontend.index')->with(['category'=>$category]);
    }


    public function profile()
    {
        return view('frontend.my-profile');
    }


    public function cart(){
        return view('frontend.cart');
    }
    
    public function forget_password(){
        return view('frontend.forgot-password');
    }

    public function contact(){
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
            $data=$request->all();
          
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
            Log::warning('Password reset exception for:: '.$request->email.', reason:'.$e->getMessage());
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
        try{
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status === Password::RESET_LINK_SENT) {
                return response()->json([
                    'status' => true,
                    'message' => 'If your email exists, we have sent a reset link',
                ]);
            }

            Log::warning('Password reset failed for: '.$request->email);
            return response()->json([
                'status' => false,
                'message' => __($status),
            ], 429);

        } catch (\Exception $e) {
            Log::warning('Password reset exception for:: '.$request->email.', reason:'.$e->getMessage());
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
    public function getPolicies(Request $request){
          $policies=SubClass::where('class_id',$request->category_id)->get();
          $main_category=MainClass::where('id',$request->category_id)->select('name')->first();
          return view('frontend.get-policies',['policies'=>$policies,'main_category'=>$main_category]);
    }

    public function policyForm(){
        return view('frontend.policy-form');
    }
    public function dashboard(){
        return view('frontend.dashboard');
    }


    
}

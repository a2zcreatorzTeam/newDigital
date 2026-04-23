<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Auth;
use Mail;
use App\Mail\SignupEmail;
use Illuminate\Support\Facades\Crypt;
class FrontendController extends Controller
{
    public function home()
    {
        return view('frontend.index');
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
            'password' => 'required|min:6|confirmed',
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
            
        

            Mail::to($validated['email'])->send(new SignupEmail($data));

            // ✅ Success Response (for AJAX)
            return response()->json([
                'status' => true,
                'message' => 'User registered successfully',
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
        return redirect()->back()->with('success', 'Logout Successfully!');
    }
}

<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;


class AuthController extends Controller
{
    public function loginPage()
    {
        return view('backend.auth.login');
    }

    public function login(Request $request)
    {


        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            if ((int) $user->user_type !== 2) {
                return back()->with('error', 'Invalid credentials');
            }
            Auth::login($user);
            return redirect()->route('admin.dashboard')->with('success', 'Login successful');
        }
        return back()->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login')->with('success', 'Logged out');
    }
}

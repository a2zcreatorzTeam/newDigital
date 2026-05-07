<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserPolicyController extends Controller
{
    public function allUserPolicyList(Request $request)
    {
        $data = User::latest()->get();

        return view('backend.userPolicy.list', compact('data'));
    }
    public function policy_detail($id)
    {
        $data = User::latest()->get();

        return view('backend.userPolicy.policy_detail', compact('data'));
    }
    

}
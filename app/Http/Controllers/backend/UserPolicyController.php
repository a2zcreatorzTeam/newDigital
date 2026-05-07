<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserPolicyData;
use Illuminate\Http\Request;

class UserPolicyController extends Controller
{
    public function allUserPolicyList(Request $request)
    {
        $data = User::latest()->get();

        return view('backend.userPolicy.list', compact('data'));
    }
    public function policy_detail($id)
    {
        $data = UserPolicyData::where('id',$id)->first();

        return view('backend.userPolicy.policy_detail', compact('data'));
    }
    

}
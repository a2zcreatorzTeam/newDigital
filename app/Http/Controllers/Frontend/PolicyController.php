<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\UserPolicyData;
use Illuminate\Support\Facades\Auth;

class PolicyController extends Controller
{
    public function self_policy()
    {
        
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
            'status','created_at'
        )->where('user_id',Auth::user()->id)->paginate(1);
        return view('frontend.self-policy.self-policy-listing',compact('policies'));

    }
    public function policy_detail($id)
    {
        $data = UserPolicyData::where('id',$id)->first();

        return view('frontend.self-policy.policy_detail', compact('data'));
    }

}
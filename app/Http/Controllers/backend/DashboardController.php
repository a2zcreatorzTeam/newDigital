<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\MainClass;
use App\Models\UserPolicyData;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $total_policies = MainClass::count();
        $active_policies = MainClass::where('status', 1)->count();
        $total_user_policies = UserPolicyData::count();
        $total_approved_user_policies = UserPolicyData::where('status','Approved')->count();
        return view('home', ['total_policies' => $total_policies, 'active_policies' => $active_policies,'total_user_policies'=>$total_user_policies,'total_approved_user_policies'=>$total_approved_user_policies]);
    }
}

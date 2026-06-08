<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\MainClass;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $total_policies=MainClass::count();
        $active_policies=MainClass::where('status',1)->count();
        return view('home',['total_policies'=>$total_policies,'active_policies'=>$active_policies]);
    }
}

<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\SubClass;
use App\Models\User;
use App\Models\UserPolicyData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPolicyController extends Controller
{  
    function __construct()
    {
         $this->middleware('permission:userPolicy-status-update', ['only' => ['mark_status']]);
    }
    public function allUserPolicyList(Request $request)
    {
        $Classes = SubClass::latest()->get();
        $query =  UserPolicyData::with([
                                    'user:id,name,email',
                                    'policyPlan:id,name,class_id',
                                    'policyPlan.mainClass:id,name'
                                ])
                                ->select(
                                    'id',
                                    'policy_id',
                                    'user_id',
                                    'mobile_number',
                                    'cnic_number',
                                    'plan',
                                    'status',
                                    'status_updated_by'
                                );

        //Policy Category filter
        if ($request->plan) {
            $query->where('plan', $request->plan);
        }

        //Policy Number filter
        if ($request->policy_number) {
            $query->where('policy_id', 'like', '%' . $request->policy_number . '%');
        }

        // ✔️ User detail search (name, email, mobile, cnic)
        if ($request->user_detail_search) {

            $search = $request->user_detail_search;

            $query->where(function ($q) use ($search) {

                $q->where('mobile_number', 'like', "%$search%")
                ->orWhere('cnic_number', 'like', "%$search%")
                ->orWhereHas('user', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                });

            });
        }

        // ✔️ Sorting
        $sortBy = $request->sorting ?? 'id';
        $direction = $request->direction ?? 'desc';

        $query->orderBy($sortBy, $direction);

        $data = $query->latest()->paginate($request->qty ?? 10);
        
        //AJAX RESPONSE (ONLY ROWS)
        if ($request->ajax()) {
            return view('backend.userPolicy.table', compact('data'))->render();
        }
        return view('backend.userPolicy.list', compact('data','Classes'));
    }
    public function policy_detail($id)
    {
        $data = UserPolicyData::where('id',$id)->first();

        return view('backend.userPolicy.policy_detail', compact('data'));
    }
    
    public function mark_status(Request $request,$id)
    {
        $request->validate([
                'status' => 'required|in:Approved,Rejected',
                'admin_comment' => 'nullable|string|max:1000',
            ]);
        
            $policy = UserPolicyData::findOrFail($id);
        
            $policy->status = $request->status;
            $policy->admin_comment = $request->admin_comment;
            $policy->status_updated_by =  Auth::user()->id;
            $policy->save();
        
            return redirect()->back()->with('success', 'Policy status updated successfully.');
    }

}
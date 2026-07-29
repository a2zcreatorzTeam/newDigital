<?php

namespace App\Http\Controllers\backend;

use App\Exports\UserPolicyExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStatusRequest;
use App\Models\SubClass;
use App\Models\UserPolicyData;
use App\Models\UserPolicyStatusHistory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;


class UserPolicyController extends Controller
{
    // public function allUserPolicyList(Request $request)
    // {

    //     $Classes = SubClass::latest()->get();
    //     $query =  UserPolicyData::with([
    //         'user:id,name,email',
    //         'policyPlan:id,name,class_id',
    //         'policyPlan.mainClass:id,name'
    //     ])
    //         ->select(
    //             'id',
    //             'policy_id',
    //             'user_id',
    //             'mobile_number',
    //             'cnic_number',
    //             'plan',
    //             'status'
    //         );
    //     //Policy Category filter
    //     if ($request->plan) {
    //         $query->where('plan', $request->plan);
    //     }
    //     //Policy status filter
    //     if ($request->status) {
    //         $query->where('status', $request->status);
    //     }

    //     //Policy Number filter
    //     if ($request->policy_number) {
    //         $query->where('policy_id', 'like', '%' . $request->policy_number . '%');
    //     }

    //     // ✔️ User detail search (name, email, mobile, cnic)
    //     if ($request->user_detail_search) {
    //         $search = $request->user_detail_search;
    //         $query->where(function ($q) use ($search) {

    //             $q->where('mobile_number', 'like', "%$search%")
    //                 ->orWhere('cnic_number', 'like', "%$search%")
    //                 ->orWhereHas('user', function ($q2) use ($search) {
    //                     $q2->where('name', 'like', "%$search%")
    //                         ->orWhere('email', 'like', "%$search%");
    //                 });
    //         });
    //     }
    //     // ✔️ Sorting
    //     $sortBy = $request->sorting ?? 'id';
    //     $direction = $request->direction ?? 'desc';
    //     $query->orderBy($sortBy, $direction);
    //     $data = $query->latest()->paginate($request->qty ?? 10)->withQueryString();
    //     $dataCount = $query->count();


    //     return view('backend.userPolicy.list', compact('data', 'Classes', 'dataCount'));
    // }

    public function policy_detail($id)
    {
        $id = Crypt::decryptString($id);
        $data = UserPolicyData::with('voucher', 'family_history')->where('id', $id)->first();
        return view('backend.userPolicy.policy_detail', compact('data'));
    }

  
    public function downloadPolicyUserPdf($id)
    {
        $data = UserPolicyData::with('voucher', 'family_history')
            ->where('id', $id)
            ->first();

        $pdf = Pdf::loadView('backend.userPolicy.policy-detail-pdf', compact('data'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('policy-' . $data->policy_id . '.pdf');
    }





    public function filter()
    {
        $Classes = SubClass::latest()->get();
        return view('backend.userPolicy.filter', compact('Classes'));
    }




    public function list(Request $request)
    {
        $page = $request->page ?? 1;
        $qty = $request->qty ?? 10;

        $query = $this->filterPolicies($request);

        $export_filters = json_encode($request->only([
            'plan',
            'status',
            'policy_number',
            'user_detail_search',
            'sorting',
            'direction',
            'qty',
            'start_date',
            'end_date'
        ]));

        $data = $query->paginate($qty, ['*'], 'page', $page);

        return view('backend.userPolicy.list', compact('data', 'export_filters'));
    }
    public function export(Request $request)
    {
        $filters = json_decode($request->data, true);

        $request->merge($filters);

        $query = $this->filterPolicies($request);

        $final_data = $query->get();

        return Excel::download(
            new UserPolicyExport($final_data),
            'User-Policy-' . now()->format('Y-m-d_H-i-s') . '.xlsx'
        );
    }


    private function filterPolicies(Request $request)
    {
        $query = UserPolicyData::query();

        if ($request->plan) {
            $query->where('plan', $request->plan);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->policy_number) {
            $query->where('policy_id', 'like', '%' . $request->policy_number . '%');
        }

        if ($request->user_detail_search) {

            $search = $request->user_detail_search;

            $query->where(function ($q) use ($search) {

                $q->where('mobile_number', 'like', "%{$search}%")
                    ->orWhere('cnic_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {

                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->start_date && $request->end_date) {

            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        } elseif ($request->start_date) {

            $query->where('created_at', '>=', $request->start_date . ' 00:00:00');
        } elseif ($request->end_date) {

            $query->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }

        return $query;
    }

    public function updateStatus(UpdateStatusRequest $request){
          $history=new UserPolicyStatusHistory;
          $history->policy_id=$request->id;
          $history->status=$request->status;
          $history->comment=$request->comment;
          $history->user_id=Auth::user()->id;
          $history->save();

          UserPolicyData::where('id',$request->id)->update([
             'comment'=>$request->comment,
             'status'=>$request->status
          ]);
          return redirect()->back()->with(['success'=>'Data Update Successfully!']);
    }
}

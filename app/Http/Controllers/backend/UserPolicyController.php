<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\SubClass;
use App\Models\UserPolicyData;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class UserPolicyController extends Controller
{
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
                                    'status'
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
            return view('backend.userPolicy.rows', compact('data'))->render();
        }
        return view('backend.userPolicy.list', compact('data','Classes'));
    }
    public function policy_detail($id)
    {
        $data = UserPolicyData::where('id',$id)->first();

        return view('backend.userPolicy.policy_detail', compact('data'));
    }

    public function downloadPolicyUserPdf($id)
    {
        $data = UserPolicyData::where('id',$id)->first();
        // run this command   ->    composer require barryvdh/laravel-dompdf
        $pdf = Pdf::loadView('backend.userPolicy.policy-detail-pdf', compact('data'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('policy-'.$data->policy_id.'.pdf');
    }
    public function export(Request $request)
    {
        $fileName = 'user-policies.csv';
    
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];
    
        $callback = function () use ($request) {
    
            $file = fopen('php://output', 'w');
    
            // HEADINGS
            fputcsv($file, [
                'Policy Number',
                'Policy Plan',
                'Category',
                'User Name',
                'User Email',
                'Mobile',
                'CNIC',
                'Status',
            ]);
    
            $query = UserPolicyData::with([
                'user:id,name,email',
                'policyPlan:id,name,class_id',
                'policyPlan.mainClass:id,name'
            ]);
    
            // Policy Category
            if ($request->main_class) {
                $query->whereHas('policyPlan', function ($q) use ($request) {
                    $q->where('class_id', $request->main_class);
                });
            }
    
            // Policy Number
            if ($request->policy_number) {
                $query->where('policy_id', 'like', '%' . $request->policy_number . '%');
            }
    
            // User search
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
    
            // IMPORTANT: chunk for large data (avoid memory crash)
            $query->chunk(1000, function ($rows) use ($file) {
    
                foreach ($rows as $row) {
                    fputcsv($file, [
                        $row->policy_id,
                        optional($row->policyPlan)->name,
                        optional(optional($row->policyPlan)->mainClass)->name,
                        optional($row->user)->name,
                        optional($row->user)->email,
                        $row->mobile_number,
                        $row->cnic_number,
                        ucfirst($row->status),
                    ]);
                }
            });
    
            fclose($file);
        };
    
        return response()->stream($callback, 200, $headers);
    }
    
}
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

        //Policy status filter
        if ($request->status) {
            $query->where('status', $request->status);
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

        $data = $query->latest()->paginate($request->qty ?? 10)->withQueryString();
        $dataCount = $query->count();

        //AJAX RESPONSE (ONLY ROWS)
        if ($request->ajax()) {
            return view('backend.userPolicy.rows', compact('data','dataCount'))->render();
        }
        return view('backend.userPolicy.list', compact('data','Classes','dataCount'));
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
                'Status',
                'Policy Plan',
                'Category',
                'User Name',
                'User Email',
                'Mobile',
                'CNIC',
                'CNIC Issue Date',
                'CNIC Expiry Date',
                'Date Of Birth',
                'Age Nearest Date',
                'Gender',
                'Mother Maiden Name',
                'Father Name',
                'Husband Name',
                'Religion',
                'User Email',
                'Age Proof',
                'Phone Office',
                'Phone Residence',
                'Fax Number',
                'Dual National',
                'Primary Nationality',
                'Dual Nationality',
                'Birth Place',
                'Same Person',
                'Permanent Province',
                'Permanent District',
                'Permanent City',
                'Permanent Address',
                'Correspondence Province',
                'Correspondence District',
                'Correspondence City',
                'Correspondence Address',
                'Temporary Province',
                'Temporary District',
                'Temporary City',
                'Temporary Address',
                'Employment',
                'Business',
                'Holding Land',
                'Average Monthly Income',
                'Ex Defence Personal',
                'Discharged On Medical',
                'Hazardous Occupation',
                'Comment',
                'Height CM',
                'Height FT',
                'Weight KG',
                'Chest Insp CM',
                'Chest Insp Inches',
                'Chest Exp CM',
                'Chest Exp Inches',
                'Abdomen CM',
                'Abdomen Inches',
                'Weight Loss KG',
                'Weight Gain KG',
                'Weight Increase Reason',
                'Plan',
                'Table No',
                'Term',
                'Sum Assured',
                'ND Applied',
                'Payment Mode',
                'Automatic Paid Up',
                'Automatic Premium Loan',
                'AIB Rider',
                'ADB Rider',
                'TIR Rider',
                'FIB Rider',
                'Admin Comment',
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
            //Policy status filter
            if ($request->status) {
                $query->where('status', $request->status);
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
                        ucfirst($row->status),
                        optional($row->policyPlan)->name,
                        optional(optional($row->policyPlan)->mainClass)->name,
                        optional($row->user)->name,
                        optional($row->user)->email,
                        $row->mobile_number,
                        $row->cnic_number,
                        $row->cnic_issue_date,
                        $row->cnic_expiry_date,
                        $row->date_of_birth,
                        $row->age_nearest_date,
                        $row->gender,
                        $row->mother_maiden_name,
                        $row->father_name,
                        $row->husband_name,
                        $row->religion,
                        $row->user_email,
                        $row->age_proof,
                        $row->phone_number_office,
                        $row->phone_number_residente,
                        $row->fax_number,
                        $row->is_client_dual_national,
                        $row->primary_nationality,
                        $row->dual_nationality,
                        $row->birth_placed,
                        $row->is_same_person,
                        $row->permanent_province_id,
                        $row->permanent_district_id,
                        $row->permanent_city_id,
                        $row->permanent_address,
                        $row->corres_province_id,
                        $row->corres_district_id,
                        $row->corres_city_id,
                        $row->corres_address,
                        $row->temp_province_id,
                        $row->temp_district_id,
                        $row->temp_city_id,
                        $row->temp_address,
                        $row->is_emaployemnt,
                        $row->is_business,
                        $row->is_holding_land,
                        $row->avaerage_monthly_income,
                        $row->ex_defence_personal,
                        $row->discharged_on_medical,
                        $row->hazardous_occupation,
                        $row->comment,
                        $row->height_cm,
                        $row->height_ft,
                        $row->weight_kg,
                        $row->chest_insp_cm,
                        $row->chest_insp_inches,
                        $row->chest_exp_cm,
                        $row->chest_exp_inches,
                        $row->abdomen_cm,
                        $row->abdomen_inches,
                        $row->weight_loss_kg,
                        $row->weight_gain_kg,
                        $row->weight_increase_reason,
                        $row->plan,
                        $row->table_no,
                        $row->term,
                        $row->sum_assured,
                        $row->is_nd_applied,
                        $row->payment_mode,
                        $row->automatic_paid_up,
                        $row->automatic_premium_loan,
                        $row->aib_rider,
                        $row->adb_rider,
                        $row->tir_rider,
                        $row->fib_rider,
                        $row->admin_comment,

                    ]);
                }
            });
    
            fclose($file);
        };
    
        return response()->stream($callback, 200, $headers);
    }
    
}
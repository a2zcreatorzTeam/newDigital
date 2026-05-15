<?php

namespace App\Exports;

use App\Models\UserPolicyData;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserPolicyExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = UserPolicyData::with([
            'user:id,name,email',
            'policyPlan:id,name,class_id',
            'policyPlan.mainClass:id,name'
        ]);

        // Policy Category
        if ($this->request->main_class) {
            $query->whereHas('policyPlan', function ($q) {
                $q->where('class_id', $this->request->main_class);
            });
        }

        // Policy Number
        if ($this->request->policy_number) {
            $query->where('policy_id', 'like', '%' . $this->request->policy_number . '%');
        }

        // User Search
        if ($this->request->user_detail_search) {

            $search = $this->request->user_detail_search;

            $query->where(function ($q) use ($search) {

                $q->where('mobile_number', 'like', "%$search%")
                  ->orWhere('cnic_number', 'like', "%$search%")
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%$search%")
                         ->orWhere('email', 'like', "%$search%");
                  });

            });
        }

        return $query->get()->map(function ($row) {

            return [
                'Policy Number' => $row->policy_id,
                'Policy Plan'   => optional($row->policyPlan)->name,
                'Category'      => optional(optional($row->policyPlan)->mainClass)->name,
                'User Name'     => optional($row->user)->name,
                'User Email'    => optional($row->user)->email,
                'Mobile'        => $row->mobile_number,
                'CNIC'          => $row->cnic_number,
                'Status'        => ucfirst($row->status),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Policy Number',
            'Policy Plan',
            'Category',
            'User Name',
            'User Email',
            'Mobile',
            'CNIC',
            'Status',
        ];
    }
}
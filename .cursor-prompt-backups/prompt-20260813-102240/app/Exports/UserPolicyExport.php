<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserPolicyExport implements FromArray, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return collect($this->data)->map(function ($row) {

            return [

                // Account (not on the page, kept for reference)
                optional($row->user)->name,
                optional($row->user)->email,

                // Policy Summary
                $row->policy_id,
                optional($row->product)->name,
                $row->sum_assured,
                $row->term,

                // Personal Information
                $row->life_proposed_full_name,
                $row->mobile_number,
                $row->cnic_number,
                $row->cnic_issue_date,
                $row->cnic_expiry_date,
                $row->date_of_birth,
                $row->age_nearest_date,
                $row->gender,
                $row->marital_status,
                $row->mother_maiden_name,
                $row->father_name,
                $row->husband_name,
                $row->wife_name,
                $row->religion,
                $row->user_email,
                $row->age_proof,
                $row->phone_number_office,
                $row->phone_number_residente,
                $row->is_client_dual_national,
                $row->primary_nationality,
                $row->dual_nationality,
                $row->dual_nationality_country,
                $row->dual_passport_number,
                $row->birth_placed,
                $row->is_same_person,
                $row->life_proposed_name,
                $row->life_proposed_cnic,
                $row->life_proposed_dob,
                $row->life_proposed_relationship,

                // Policy Information
                $row->status,
                $row->table_no,
                $row->term,
                $row->sum_assured,
                $row->is_nd_applied,
                $row->payment_mode,
                $row->adb_rider,
                $row->tir_rider,
                $row->fib_rider,

                // Address Information — Permanent
                optional($row->get_permanent_province)->name,
                optional($row->get_permanent_city)->name,
                optional($row->get_permanent_district)->name,
                $row->permanent_address,

                // Address Information — Correspondence
                optional($row->get_corres_province)->name,
                optional($row->get_corres_city)->name,
                optional($row->get_corres_district)->name,
                $row->corres_address,

                // Address Information — Temporary
                optional($row->get_temp_province)->name,
                optional($row->get_temp_city)->name,
                optional($row->get_temp_district)->name,
                $row->temp_address,

                // Occupation & Income
                $row->is_emaployemnt,
                $row->is_business,
                $row->is_holding_land,
                $row->avaerage_monthly_income,
                $row->ex_defence_personal,
                $row->discharged_on_medical,
                $row->hazardous_occupation,
                $row->comment,

                // Payment Information
                optional($row->voucher)->consumer_number,
                optional($row->voucher)->amount_within_due_date,
                optional($row->voucher)->amount_after_due_date,
                optional($row->voucher)->due_date,

                // Family History (flattened, see note below)
                // $this->formatFamilyHistory($row->family_history),

                // Female Section
                // $row->date_of_last_delivery,
                // $row->miscarriage_dates,
                // $row->is_pregnant,
                // $row->caesarean_details,
                // $row->lmp_date,
                // $row->female_disease_history,
                // $row->self_monthly_income,
                // $row->husband_monthly_income,
                // $row->qualification,
                // $row->pays_tax_land_revenue,
                // $row->husband_policy_no,
                // $row->husband_zone_company,
                // $row->husband_sum_assured,

                // Nominee Information
                $row->nominee_name,
                $row->nominee_cnic,
                $row->nominee_age,
                $row->nominee_relationship,
                $row->appointee_name,
                $row->appointee_relationship,
                $row->appointee_cnic,

                // Documents (filenames)
                $row->proposer_cnic_front,
                $row->proposer_cnic_back,
                $row->nominee_document,
                $row->proposer_photo,
                $row->income_proof,

                // Health Information
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
                $row->daily_consumption,
                $row->physical_impairments,
                $row->last_illness_injury,
                $row->medical_investigations,
                $row->medical_history,
                $row->weight_increase_reason,

                $row->created_at?->format('d-m-Y H:i:s'),

            ];

        })->toArray();
    }

    public function headings(): array
    {
        return [
            // Account
            'User Name',
            'User Login Email',

            // Policy Summary
            'Policy Number',
            'Plan Name',
            'Sum Assured',
            'Policy Term',

            // Personal Information
            'Life Proposed Full Name',
            'Mobile Number Personal',
            'CNIC / B-FORM NO',
            'CNIC Issue Date',
            'CNIC Expiry Date',
            'Date Of Birth',
            'Age Nearest Birth-date',
            'Gender/Sex',
            'Marital Status',
            'Mother Maiden Name',
            "Father's Name of Life Proposed",
            'Husband Name of Life Proposed',
            'Wife Name of Life Proposed',
            'Religion',
            'Email Address',
            'Age Proof',
            'Phone Number Office',
            'Phone Number Residential',
            'Is Client Dual National?',
            'Primary Nationality',
            'Dual Nationality',
            'Dual Nationality Country',
            'Dual Nationality Passport Number',
            'Birth Place',
            'Proposer & Life Proposed are same',
            'Life Proposed Name',
            'Life Proposed CNIC',
            'Life Proposed DOB',
            'Life Proposed RelationShip',

            // Policy Information
            'Policy Status',
            'Table',
            'Term',
            'Sum Assured',
            'IS ND APPLIED',
            'Payment Mode',
            'Accidental Death Benefit (ADB)',
            'Term Insurance Rider (TIR)',
            'Family Income Benefit (FIB)',

            // Address — Permanent
            'Permanent Province',
            'Permanent City',
            'Permanent District',
            'Permanent Address',

            // Address — Correspondence
            'Correspondence Province',
            'Correspondence City',
            'Correspondence District',
            'Correspondence Address',

            // Address — Temporary
            'Temporary Province',
            'Temporary City',
            'Temporary District',
            'Temporary Address',

            // Occupation & Income
            'Is Employment?',
            'Is Businessman',
            'If holding Land?',
            'Average monthly income',
            'Defence/Ex-Defence/Flight Crew/Pilot',
            'Discharged on Medical Grounds',
            'Hazardous Occupation',
            'Comments',

            // Payment Information
            'Consumer No',
            'Amount With In Due Date',
            'Amount After Date',
            'Due Date',

            // Family History
            // 'Family History',

            // Female Section
            // 'Date of Last Delivery',
            // 'Miscarriage Dates',
            // 'Is Pregnant',
            // 'Caesarean Details',
            // 'LMP Date',
            // 'Female Disease History',
            // 'Self Monthly Income',
            // 'Husband Monthly Income',
            // 'Qualification',
            // 'Pays Tax / Land Revenue',
            // 'Husband Policy No.',
            // 'Husband Zone / Company',
            // 'Husband Sum Assured',

            // Nominee Information
            'Nominee Name',
            'Nominee CNIC',
            'Nominee Age',
            'Nominee Relationship',
            'Appointee Name',
            'Appointee Relationship',
            'Appointee CNIC',

            // Documents
            'Proposer CNIC Front',
            'Proposer CNIC Back',
            'Nominee Document',
            'Proposer Photo',
            'Income Proof',

            // Health Information
            'Height In cm',
            'Height In ft',
            'Weight In Kg',
            'Chest Insp (cm)',
            'Chest Insp (Inches)',
            'Chest Exp (cm)',
            'Chest Exp (Inches)',
            'Abdomen (cm)',
            'Abdomen (Inches)',
            'Weight Loss (Kg)',
            'Weight Gain (Kg)',
            'Daily Consumption',
            'Physical Impairments',
            'Last Illness / Injury',
            'Medical Investigations',
            'Medical History',
            'Reason for Weight Gain or Weight Loss',

            'Created At',
        ];
    }

    /**
     * Family history is a hasMany relation — flatten each member into
     * one readable string, joined with "|", since it can't map to fixed columns.
     */
    private function formatFamilyHistory($familyHistory): string
    {
        if (!$familyHistory || $familyHistory->count() === 0) {
            return '---';
        }

        return $familyHistory->map(function ($member) {
            return sprintf(
                '%s: Age %s, Health: %s, Death Year: %s, Death Age: %s, Cause: %s',
                $member->memner_flag ?? '---',
                $member->age ?? '---',
                $member->state_of_health ?? '---',
                $member->year_of_death ?? '---',
                $member->age_of_death ?? '---',
                $member->cause_of_death ?? '---'
            );
        })->implode(' | ');
    }
}
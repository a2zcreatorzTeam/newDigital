<?php

namespace App\Exports;

use App\Support\MiscarriageDates;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class UserPolicyExport extends DefaultValueBinder implements FromArray, WithHeadings, WithCustomValueBinder
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function bindValue(Cell $cell, $value)
    {
        if (is_string($value) && preg_match('/^\d+$/', $value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        return parent::bindValue($cell, $value);
    }

    public function array(): array
    {
        return collect($this->data)->map(function ($row) {
            $lp = \App\Support\LifeProposedProfile::values($row);

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
                $this->withoutDashes($row->mobile_number),
                $this->withoutDashes($row->cnic_number),
                $row->cnic_issue_date,
                $row->cnic_expiry_date,
                $row->date_of_birth,
                $row->birth_placed,
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
                $this->withoutDashes($row->phone_number_office),
                $this->withoutDashes($row->phone_number_residente),
                optional($row->countryOfResidence)->name,
                $row->current_address,
                $row->is_client_dual_national,
                $row->primary_nationality,
                $row->dual_nationality,
                optional($row->dualNationalityCountry)->name ?? $row->dual_nationality_country,
                $row->dual_tax_tin_number,
                $this->withoutDashes($row->dual_mobile_number),
                $row->dual_address,
                $row->dual_passport_number,
                $row->is_same_person,
                $row->life_proposed_name,
                $this->withoutDashes($row->life_proposed_cnic),
                $row->life_proposed_dob,
                $lp['birth_placed'] ?? null,
                $row->life_proposed_relationship,
                $this->withoutDashes($lp['mobile'] ?? null),
                $lp['cnic_issue_date'] ?? null,
                $lp['cnic_expiry_date'] ?? null,
                $lp['age'] ?? null,
                $lp['gender'] ?? null,
                $lp['marital_status'] ?? null,
                $lp['wife_name'] ?? null,
                $lp['husband_name'] ?? null,
                $lp['mother_maiden_name'] ?? null,
                $lp['father_name'] ?? null,
                $lp['religion'] ?? null,
                $lp['email'] ?? null,
                $this->withoutDashes($lp['phone_office'] ?? null),
                $this->withoutDashes($lp['phone_residential'] ?? null),
                $lp['country_of_residence'] ?? null,
                $lp['current_address'] ?? null,
                $lp['is_client_dual_national'] ?? null,
                $lp['primary_nationality'] ?? null,
                $lp['dual_nationality_country'] ?? null,
                $lp['dual_tax_tin_number'] ?? null,
                $this->withoutDashes($lp['dual_mobile_number'] ?? null),
                $lp['dual_address'] ?? null,
                $lp['dual_passport_number'] ?? null,

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

                // Address Details — Permanent
                optional($row->get_permanent_province)->name,
                optional($row->get_permanent_city)->name,
                optional($row->get_permanent_district)->name,
                $row->permanent_address,

                // Address Details — Correspondence
                optional($row->get_corres_province)->name,
                optional($row->get_corres_city)->name,
                optional($row->get_corres_district)->name,
                $row->corres_address,

                // Address Details — Temporary
                optional($row->get_temp_province)->name,
                optional($row->get_temp_city)->name,
                optional($row->get_temp_district)->name,
                $row->temp_address,

                // Occupation & Income
                $row->is_emaployemnt,
                $row->employment_designation,
                $row->employment_company_name,
                $row->is_business,
                $row->business_name,
                $row->nature_of_business,
                $row->filer_status,
                $row->ntn_number,
                $row->is_holding_land,
                $row->land_unit,
                $row->total_acreage,
                $row->land_location,
                $row->land_type,
                $row->estimated_land_value,
                $row->avaerage_monthly_income,
                $row->ex_defence_personal,
                $row->discharged_on_medical,
                $row->hazardous_occupation,
                $row->comment,
                $row->premium_paid,

                // Payment Information
                optional($row->voucher)->consumer_number,
                optional($row->voucher)->amount_within_due_date,
                optional($row->voucher)->amount_after_due_date,
                optional($row->voucher)->due_date,

                // Family History
                $this->formatFamilyHistory($row->family_history),

                // Female Section
                $row->date_of_last_delivery,
                MiscarriageDates::join($row->miscarriage_dates),
                $row->is_pregnant,
                $row->caesarean_details,
                $row->lmp_date,
                $row->female_disease_history,
                \App\Support\FemaleDiseases::name($row->female_disease_name),
                \App\Support\FemaleDiseases::details($row->female_disease_name),
                $row->self_monthly_income,
                $row->husband_monthly_income,
                $row->qualification,
                $row->pays_tax_land_revenue,
                $row->husband_policy_no,
                $row->husband_zone_company,
                $row->husband_sum_assured,

                // Nominee Information
                $row->nominee_name,
                $this->withoutDashes($row->nominee_cnic),
                $row->nominee_age,
                $row->nominee_relationship,
                $row->appointee_name,
                $row->appointee_relationship,
                $this->withoutDashes($row->appointee_cnic),
                $this->withoutDashes($row->appointee_mobile),

                // Documents (filenames)
                $row->proposer_cnic_front,
                $row->proposer_cnic_back,
                $row->life_proposed_document,
                $row->nominee_document,
                $row->proposer_photo,
                $row->income_proof,
                $row->cnic_image,
                \App\Support\PolicyStoredDocuments::formatForExport(\App\Support\PolicyStoredDocuments::medical($row->medical_documents ?? null)),
                \App\Support\PolicyStoredDocuments::formatForExport(\App\Support\PolicyStoredDocuments::others($row->other_documents ?? null)),

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

                $row->created_at?->timezone('Asia/Karachi')?->format('d-m-Y H:i:s'),

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
            'Place of Birth',
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
            'Country of Residence',
            'Current Address',
            'Is Client Dual National?',
            'Primary Nationality',
            'Dual Nationality',
            'Dual Nationality Country',
            'Tax/TIN Number',
            'Dual Nationality Mobile Number',
            'Dual Nationality Address',
            'Dual Nationality Passport Number',
            'Proposer & Life Proposed are same',
            'Life Proposed Name',
            'Life Proposed CNIC',
            'Life Proposed DOB',
            'Life Proposed Place of Birth',
            'Life Proposed RelationShip',
            'Life Proposed Mobile',
            'Life Proposed CNIC Issue Date',
            'Life Proposed CNIC Expiry Date',
            'Life Proposed Age',
            'Life Proposed Gender',
            'Life Proposed Marital Status',
            'Life Proposed Wife Name',
            'Life Proposed Husband Name',
            'Life Proposed Mother Maiden Name',
            'Life Proposed Father Name',
            'Life Proposed Religion',
            'Life Proposed Email',
            'Life Proposed Office Phone',
            'Life Proposed Residential Phone',
            'Life Proposed Country of Residence',
            'Life Proposed Current Address',
            'Life Proposed Dual National?',
            'Life Proposed Primary Nationality',
            'Life Proposed Dual Nationality Country',
            'Life Proposed Tax/TIN',
            'Life Proposed Dual Mobile',
            'Life Proposed Dual Address',
            'Life Proposed Passport Number',

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
            'Employment Designation',
            'Company Name',
            'Is Businessman',
            'Business Name',
            'Nature Of Business',
            'Filer Status',
            'NTN Number',
            'If holding Land?',
            'Land Unit',
            'Total Area',
            'Land Location',
            'Land Type',
            'Estimated Land Value',
            'Average monthly income',
            'Defence/Ex-Defence/Flight Crew/Pilot',
            'Discharged on Medical Grounds',
            'Hazardous Occupation',
            'Comments',
            'Premium Paid',

            // Payment Information
            'Consumer No',
            'Amount With In Due Date',
            'Amount After Date',
            'Due Date',

            // Family History
            'Family History',

            // Female Section
            'Date of Last Delivery',
            'Miscarriage Dates',
            'Is Pregnant',
            'Caesarean Details',
            'LMP Date',
            'Female Disease History',
            'Female Disease',
            'Female Disease Description',
            'Self Monthly Income',
            'Husband Monthly Income',
            'Qualification',
            'Pays Tax / Land Revenue',
            'Husband Policy No.',
            'Husband Zone / Company',
            'Husband Sum Assured',

            // Nominee Information
            'Nominee Name',
            'Nominee CNIC',
            'Nominee Age',
            'Nominee Relationship',
            'Appointee Name',
            'Appointee Relationship',
            'Appointee CNIC',
            'Appointee Mobile',

            // Documents
            'Proposer CNIC Front',
            'Proposer CNIC Back',
            'Life Proposed CNIC / B-Form',
            'Nominee Document',
            'Proposer Photo',
            'Income Proof',
            'CNIC Image',
            'Medical Documents',
            'Other Documents',

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

            'Submitted Date',
        ];
    }

    /**
     * Strip dashes from CNIC / phone values for the spreadsheet only.
     */
    private function withoutDashes($value): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }

        return str_replace('-', '', (string) $value);
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
                '%s: Alive %s, Age %s, Health: %s, Death Year: %s, Death Age: %s, Cause: %s',
                $member->memner_flag ?? '---',
                filled($member->year_of_death) ? 'No' : 'Yes',
                $member->age ?? '---',
                $member->state_of_health ?? '---',
                $member->year_of_death ?? '---',
                $member->age_of_death ?? '---',
                $member->cause_of_death ?? '---'
            );
        })->implode(' | ');
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PolicyUserDataRequest extends FormRequest
{
    /**
     * Authorize user
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation Rules
     */
    public function rules(): array
    {
        return [
            // ===== Address =====
            'permanent_province_id' => 'required|integer',
            'permanent_city_id' => 'required|integer',
            'permanent_district_id' => 'required|integer',
            'permanent_address' => 'required|string|max:255',

            'corres_province_id' => 'required|integer',
            'corres_city_id' => 'required|integer',
            'corres_district_id' => 'required|integer',
            'corres_address' => 'required|string|max:255',

            'temp_province_id' => 'required|integer',
            'temp_city_id' => 'required|integer',
            'temp_district_id' => 'required|integer',
            'temp_address' => 'required|string|max:255',

            // ===== Personal Info =====
            'life_proposed_full_name' => 'required|string|max:100',
            'mobile_number' => 'required|string|max:20',
            'cnic_number' => 'required|string|max:20',
            'cnic_issue_date' => 'nullable|date',
            'cnic_expiry_date' => 'nullable|date|after:cnic_issue_date',
            'date_of_birth' => 'required',

            'age_nearest_date' => 'required|integer|min:0|max:120',
            'gender' => 'required|integer',

            'mother_maiden_name' => 'required|string|max:100',
            'father_name' => 'required|string|max:100',
            'husband_name' => 'nullable|string|max:100',

            'religion' => 'required|string|max:50',
            'user_email' => 'required|email',

            // ===== Contact =====
            'phone_number_office' => 'nullable|string|max:20',
            'phone_number_residente' => 'nullable|string|max:20',
            'fax_number' => 'nullable|string|max:20',

            // ===== Nationality =====
            'is_client_dual_national' => 'required|in:Yes,No',
            'primary_nationality' => 'required|string|max:100',
            'dual_nationality' => 'nullable|string|max:100',
            'birth_placed' => 'required|string|max:100',

            // ===== Employment =====
            'is_same_person' => 'required|in:Yes,No',
            'is_emaployemnt' => 'required|in:Yes,No',
            'is_business' => 'required|in:Yes,No',
            'is_holding_land' => 'required|in:Yes,No',
            'avaerage_monthly_income' => 'required|numeric|min:0',

            'ex_defence_personal' => 'required|in:Yes,No',
            'discharged_on_medical' => 'required|in:Yes,No',
            'hazardous_occupation' => 'required|in:Yes,No',

            'comment' => 'nullable|string|max:500',

            // ===== Physical Info =====
            'height_cm' => 'required|numeric|min:0',
            'height_ft' => 'nullable|numeric|min:0',

            'weight_kg' => 'required|numeric|min:0',
            'chest_insp_cm' => 'nullable|numeric',
            'chest_exp_cm' => 'nullable|numeric',
            'chest_exp_inches' => 'nullable|numeric',
            'abdomen_inches' => 'nullable|numeric',
            'chest_insp_inches' => 'nullable|numeric',

            'abdomen_cm' => 'nullable|numeric',

            'weight_loss_kg' => 'nullable|numeric|min:0',
            'weight_gain_kg' => 'nullable|numeric|min:0',

            'weight_increase_reason' => 'nullable|string|max:255',

            // ===== Others =====
            'profession' => 'required|integer',
            'marital_status' => 'required|integer',
            'city' => 'required|integer',


            // ===== Product Details =====

            'plan' => 'required',
            'table_no' => 'required',
            'term' => 'required',
            'sum_assured' => 'required',
            'is_nd_applied' => 'required',
            'payment_mode' => 'required',
            'automatic_paid_up' => 'required',
            'automatic_premium_loan' => 'required',
            'aib_rider' => 'required',
            'adb_rider' => 'required',
            'tir_rider' => 'required',
            'fib_rider' => 'required',

        ];
    }

    /**
     * Custom Messages
     */
    public function messages(): array
    {
        return [
            // Address
            'permanent_province_id.required' => 'Permanent province is required.',
            'permanent_city_id.required' => 'Permanent city is required.',
            'permanent_district_id.required' => 'Permanent district is required.',
            'permanent_address.required' => 'Permanent address cannot be empty.',

            'corres_province_id.required' => 'Correspondence province is required.',
            'corres_city_id.required' => 'Correspondence city is required.',
            'corres_district_id.required' => 'Correspondence district is required.',
            'corres_address.required' => 'Correspondence address is required.',

            'temp_province_id.required' => 'Temporary province is required.',
            'temp_city_id.required' => 'Temporary city is required.',
            'temp_district_id.required' => 'Temporary district is required.',
            'temp_address.required' => 'Temporary address is required.',

            // Personal Info
            'life_proposed_full_name.required' => 'Full name is required.',
            'mobile_number.required' => 'Mobile number is required.',

            'cnic_expiry_date.after' => 'CNIC expiry date must be after issue date.',

            'age_nearest_date.required' => 'Age is required and must be valid.',

            // Gender
            'gender.required' => 'Please select gender.',

            // Income
            'avaerage_monthly_income.required' => 'Monthly income is required.',
            'avaerage_monthly_income.numeric' => 'Monthly income must be a number.',

            // Yes/No fields
            'is_client_dual_national.required' => 'Please select dual nationality option.',
            'is_emaployemnt.required' => 'Employment status is required.',
            'is_business.required' => 'Business status is required.',

            // Physical
            'height_cm.required' => 'Height (cm) is required.',
            'weight_kg.required' => 'Weight is required.',

            // Email
            'email.email' => 'Please enter a valid email address.',


            'plan.required' => 'Please select a plan to continue.',
            'table_no.required' => 'Please select table number.',
            'term.required' => 'Policy term is required.',
            'sum_assured.required' => 'Please enter sum assured amount.',

            'is_nd_applied.required' => 'Select ND applied option.',
            'payment_mode.required' => 'Please choose payment mode.',

            'automatic_paid_up.required' => 'Select automatic paid up option.',
            'automatic_premium_loan.required' => 'Select premium loan option.',
            'aib_rider.required' => 'Please select Accidental Death & Indemnity Benefit Option.',
            'adb_rider.required' => 'Please select Accidental Death Benefit (ADB) Option.',
            'tir_rider.required' => 'Please select Term Insurance Rider (TIR) Option.',
            'fib_rider.required' => 'Please select Family Income Benefit (FIB) Option.'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'gender' => 'required|in:Male,Female',
            'marital_status' => 'required|in:Married,Unmarried',

            'mother_maiden_name' => 'required|string|max:100',
            'father_name' => 'required|string|max:100',
            'husband_name' => [
                Rule::requiredIf(fn () => $this->input('gender') === 'Female' && $this->input('marital_status') === 'Married'),
                'nullable',
                'string',
                'max:100',
            ],
            'wife_name' => [
                Rule::requiredIf(fn () => $this->input('gender') === 'Male' && $this->input('marital_status') === 'Married'),
                'nullable',
                'string',
                'max:100',
            ],

            'religion' => 'required|string|max:50',
            'user_email' => 'required|email',
            

            // 'cnic_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',

            // ===== Contact =====
            'phone_number_office' => 'nullable|string|max:20',
            'phone_number_residente' => 'nullable|string|max:20',

            // ===== Nationality =====
            'is_client_dual_national' => 'required|in:Yes,No',
            'primary_nationality' => 'required_if:is_client_dual_national,Yes|nullable|string|max:100',
            'dual_nationality' => 'required_if:is_client_dual_national,Yes|nullable|string|max:100',
            'dual_nationality_country' => 'required_if:is_client_dual_national,Yes|nullable|string|max:100',
            'dual_passport_number' => 'required_if:is_client_dual_national,Yes|nullable|string|max:100',

            'birth_placed' => 'required|string|max:100',

            // ===== is_same_person =====
            'is_same_person' => 'required|in:Yes,No',
            'life_proposed_name' => 'required_if:is_same_person,No|string|max:255',
            'life_proposed_cnic' => 'required_if:is_same_person,No|string|max:25',
            'life_proposed_dob' => 'required_if:is_same_person,No|date',
            'life_proposed_relationship' => 'required_if:is_same_person,No|string|max:100',

           
           
           
           
           
            // Occupation start

            'is_emaployemnt' => 'required|in:Yes,No',
            'employment_designation' => 'required_if:is_emaployemnt,Yes|string|max:255',
            'employment_company_name' => 'required_if:is_emaployemnt,Yes|string|max:255',



            'is_business' => 'required|in:Yes,No',
            'business_name' => 'required_if:is_business,Yes|string|max:255',
            'nature_of_business' => 'required_if:is_business,Yes|string|max:255',


            // ===== Holding Land =====
            'is_holding_land' => 'required|in:Yes,No',
            'total_acreage' => 'required_if:is_holding_land,Yes|nullable|numeric',
            'land_location' => 'required_if:is_holding_land,Yes|nullable|string|max:255',
            'land_type' => 'required_if:is_holding_land,Yes|nullable|in:Agricultural,Commercial,Residential',
            'estimated_land_value' => 'required_if:is_holding_land,Yes|nullable|numeric',


            'avaerage_monthly_income' => 'required|numeric|min:0',

            'ex_defence_personal' => 'required|in:Yes,No',
            'discharged_on_medical' => 'required|in:Yes,No',
            'hazardous_occupation' => 'required|in:Yes,No',

            'comment' => 'nullable|string|max:500',

            // Occupation end


            // ===== Health Info start =====
            'height_cm' => 'required|numeric|min:0',
            'height_ft' => 'required|numeric|min:0',

            'weight_kg' => 'required|numeric|min:0',
            'chest_insp_cm' => 'required|numeric',
            'chest_exp_cm' => 'required|numeric',
            'chest_exp_inches' => 'required|numeric',
            'abdomen_inches' => 'required|numeric',
            'chest_insp_inches' => 'required|numeric',

            'abdomen_cm' => 'required|numeric',

            'weight_loss_kg' => 'nullable|numeric|min:0',
            'weight_gain_kg' => 'nullable|numeric|min:0',

            'weight_increase_reason' => 'nullable|string|max:255',
            
            'daily_consumption' => 'required|string|max:255',
            'physical_impairments' => 'nullable|string|max:255',
            'last_illness_injury' => 'required|string|max:255',
            'medical_investigations' => 'required|string|max:255',
            'medical_history' => 'required|string|max:255',

          // ===== Health Info end =====

            // ===== Others =====
            // 'profession' => 'required|integer',
            // 'marital_status' => 'required|integer',
            // 'city' => 'required|integer',


            // ===== Product Details =====

            'plan' => 'required',
            'table_no' => 'required',
            'term' => 'required',
            'sum_assured' => 'required',
            'is_nd_applied' => 'required',
            'payment_mode' => 'required',
            // remove fields by statelife 
            // 'automatic_paid_up' => 'required',
            // 'automatic_premium_loan' => 'required',
            // 'aib_rider' => 'required',
            'adb_rider' => 'required',
            'tir_rider' => 'required',
            // 'fib_rider' => 'required',

            // ===== Family History =====
            'father_age' => 'required',
            'mother_age' => 'required',
            'mother_health' => 'required',
            'father_health' => 'required',
            'premium_paid' => 'required',




            //    female section


            'date_of_last_delivery' => 'nullable|string|max:255',
            'miscarriage_dates' => 'nullable|string|max:255',
            'is_pregnant' => 'nullable|string|max:255',
            'caesarean_details' => 'nullable|string|max:255',
            'lmp_date' => 'nullable|string|max:255',
            'female_disease_history' => 'nullable|string|max:255',
            'self_monthly_income' => 'nullable|string|max:255',
            'husband_monthly_income' => 'nullable|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'pays_tax_land_revenue' => 'nullable|string|max:255',
            'husband_policy_no' => 'nullable|string|max:255',
            'husband_zone_company' => 'nullable|string|max:255',
            'husband_sum_assured' => 'nullable|string|max:255',



            // nominee section
           'nominee_name' => 'required|string|max:255',
           'nominee_cnic' => 'required|string|max:255',
           'nominee_age' => 'required|string|max:255',
           'nominee_relationship' => 'required|string|max:255',
           'appointee_name' => 'required|string|max:255',
           'appointee_relationship' => 'required|string|max:255',
           'appointee_cnic' => 'required|string|max:255',



        //    documents

        'proposer_cnic_front' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'proposer_cnic_back' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'nominee_document' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'proposer_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'income_proof' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'medical_reports' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',



            
            
            
            
            
            
            













        ];
    }

    /**
     * Custom Messages
     */
    public function messages(): array
    {
        return [
            // Address
            'premium_paid.required' => 'Kindly First Calculate the Premium Amount.',
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
            'fib_rider.required' => 'Please select Family Income Benefit (FIB) Option.',


            // 'cnic_image.required' => 'Please upload your CNIC copy.',
            // 'cnic_image.image'    => 'The uploaded file must be an image.',
            // 'cnic_image.mimes'    => 'Only JPG, JPEG and PNG images are allowed.',
            // 'cnic_image.max'      => 'The CNIC image size must not exceed 2 MB.',

        ];
    }
}

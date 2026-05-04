<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressInfoRequest extends FormRequest
{
    /**
     * Authorize user
     */
    public function authorize(): bool
    {
        return true; // agar auth check chahiye ho to yahan laga sakte ho
    }

    /**
     * Validation Rules
     */
    public function rules(): array
    {
        return [
            'permanent_province_id' => 'required|int',
            'permanent_district_id' => 'required|int',
            'permanent_city_id' => 'required|int',
            'corres_province_id' => 'required|int',
            'corres_district_id' => 'required|int',
            'corres_city_id' => 'required|int',
            'temp_province_id' => 'required|int',
            'temp_district_id' => 'required|int',
            'temp_city_id' => 'required|int',
            'permanent_address' => 'required|string',
            'corres_address' => 'required|string',
            'temp_address' => 'required|string'
          
           
        ];

    }

    /**
     * Custom Messages
     */
    public function messages(): array
    {
        return [
            'life_proposed_full_name.required' => 'Full name is required',

            'mobile_number.required' => 'Mobile number is required',
            'mobile_number.digits_between' => 'Enter valid mobile number',

            'cnic_number.required' => 'CNIC is required',
            'cnic_number.regex' => 'CNIC format must be like 42101-1234567-1',

            'cnic_issue_date.required' => 'CNIC issue date is required',
            'cnic_expiry_date.after' => 'Expiry date must be after issue date',

            'date_of_birth.required' => 'Date of birth is required',

            'age_nearest_date.required' => 'Age is required',
            'age_nearest_date.integer' => 'Age must be a number',

            'gender.required' => 'Gender is required',

            'email.required' => 'Email is required',
            'email.email' => 'Enter valid email',

            'is_client_dual_national.required' => 'Select dual nationality option',

            'primary_nationality.required' => 'Primary nationality is required',

            'is_same_person.required' => 'Please select this option',
        ];
    }
}

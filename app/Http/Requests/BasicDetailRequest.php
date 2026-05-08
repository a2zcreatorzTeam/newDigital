<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BasicDetailRequest extends FormRequest
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
            'life_proposed_full_name' => 'required|string|max:255',
            'mobile_number' => [
                'nullable',
                'regex:/^[0-9]{3,4}-[0-9]{7,8}$/'
            ],
            'cnic_number' => [
                'required',
                'regex:/^[0-9]{5}-[0-9]{7}-[0-9]{1}$/'
            ],

            'cnic_issue_date' => 'required|date',
            'cnic_expiry_date' => 'required|date|after:cnic_issue_date',
            'date_of_birth' => 'required|date|before:today',
            'age_nearest_date' => 'required|integer|min:20|max:120',
            'gender' => 'required|in:Male,Female',
            'mother_maiden_name' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'husband_name' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:100',
            'email' => 'required|email|max:255',
            'age_proof' => 'nullable|string|max:255',
            'phone_number_office' => 'nullable|digits_between:7,15',
            'phone_number_residente' => 'nullable|digits_between:7,15',
            'fax_number' => 'nullable|digits_between:7,15',
            'is_client_dual_national' => 'required',
            'primary_nationality' => 'required|string|max:100',
            'dual_nationality' => 'nullable|string|max:100',
            'birth_placed' => 'nullable|string|max:255',
            'is_same_person' => 'required',
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

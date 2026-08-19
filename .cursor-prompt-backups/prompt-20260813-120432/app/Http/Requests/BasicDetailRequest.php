<?php

namespace App\Http\Requests;

use App\Rules\MobileLinkedToCnic;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
                'regex:/^[0-9]{3,4}-[0-9]{7,8}$/',
                new MobileLinkedToCnic('cnic_number'),
            ],
            'cnic_number' => [
                'required',
                'regex:/^[0-9]{5}-[0-9]{7}-[0-9]{1}$/',
            ],

            'cnic_issue_date' => 'required|date',
            'cnic_expiry_date' => 'required|date|after:cnic_issue_date',
            'date_of_birth' => 'required|date|before:today',
            'age_nearest_date' => 'required|integer|min:0|max:120',
            'gender' => 'required|in:Male,Female,Other',
            'marital_status' => 'required|in:Married,Unmarried',
            'mother_maiden_name' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'husband_name' => [
                Rule::requiredIf(fn () => $this->input('gender') === 'Female' && $this->input('marital_status') === 'Married'),
                'nullable',
                'string',
                'max:255',
            ],
            'wife_name' => [
                Rule::requiredIf(fn () => $this->input('gender') === 'Male' && $this->input('marital_status') === 'Married'),
                'nullable',
                'string',
                'max:255',
            ],
            'religion' => 'nullable|string|max:100',
            'email' => 'required|email|max:255',
            // 'age_proof' => 'nullable|string|max:255',
            'phone_number_office' => 'nullable|digits_between:7,15',
            'phone_number_residente' => 'nullable|digits_between:7,15',



            'is_client_dual_national' => 'required|in:Yes,No',
            'primary_nationality' => 'required_if:is_client_dual_national,Yes|nullable|string|max:100',
            'dual_nationality' => 'required_if:is_client_dual_national,Yes|nullable|string|max:100',
            'dual_nationality_country' => 'required_if:is_client_dual_national,Yes|nullable|string|max:100',
            'dual_passport_number' => 'required_if:is_client_dual_national,Yes|nullable|string|max:100',



            'birth_place_city_id' => 'required|integer|exists:cities,id',
            'birth_placed' => 'nullable|string|max:255',
            'is_same_person' => 'required|in:Yes,No',
            'life_proposed_name' => 'required_if:is_same_person,No|string|max:255',
            'life_proposed_cnic' => 'required_if:is_same_person,No|string|max:25',
            'life_proposed_dob' => 'required_if:is_same_person,No|date',
            'life_proposed_relationship' => 'required_if:is_same_person,No|string|max:100',
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
            'birth_place_city_id.required' => 'Birth place is required',
            'birth_place_city_id.exists' => 'Please select a valid city from the list',

            'cnic_number.required' => 'CNIC is required',
            'cnic_number.regex' => 'CNIC format must be like 42101-1234567-1',

            'cnic_issue_date.required' => 'CNIC issue date is required',
            'cnic_expiry_date.after' => 'Expiry date must be after issue date',

            'date_of_birth.required' => 'Date of birth is required',

            'age_nearest_date.required' => 'Age is required',
            'age_nearest_date.integer' => 'Age must be a number',

            'gender.required' => 'Gender is required',
            'marital_status.required' => 'Marital status is required',
            'husband_name.required' => 'Husband name is required for married female applicants',
            'wife_name.required' => 'Wife name is required for married male applicants',

            'email.required' => 'Email is required',
            'email.email' => 'Enter valid email',

            'is_client_dual_national.required' => 'Select dual nationality option',

            'primary_nationality.required' => 'Primary nationality is required',

            'is_same_person.required' => 'Please select this option',
        ];
    }
}

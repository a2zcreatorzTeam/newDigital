<?php

namespace App\Http\Requests;

use App\Rules\MobileLinkedToCnic;
use App\Support\Concerns\PreparesAgeNearestBirthday;
use App\Support\Concerns\PreparesDualNationality;
use App\Support\Concerns\PreparesLifeProposed;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BasicDetailRequest extends FormRequest
{
    use PreparesAgeNearestBirthday;
    use PreparesDualNationality;
    use PreparesLifeProposed;

    /**
     * Authorize user
     */
    public function authorize(): bool
    {
        return Auth::check() && (int) Auth::user()->user_type === 1;
    }

    protected function prepareForValidation(): void
    {
        // Professional profile is about the logged-in user only.
        // Proposer vs Life Proposed is asked later during policy purchase.
        $this->merge([
            'is_same_person' => 'Yes',
        ]);

        $this->mergeAgeNearestBirthday();
        $this->mergeDualNationalityDefaults();
        $this->mergeLifeProposedDefaults(false);
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
            'date_of_birth' => [
                'required',
                'date',
                'before:today',
                'before_or_equal:' . now('Asia/Karachi')->subYears(18)->toDateString(),
            ],
            'age_nearest_date' => 'required|integer|min:18|max:120',
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
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(Auth::id()),
            ],
            // 'age_proof' => 'nullable|string|max:255',
            'phone_number_office' => 'nullable|digits_between:7,15',
            'phone_number_residente' => 'nullable|digits_between:7,15',

            'country_of_residence_id' => [
                'required',
                'integer',
                Rule::exists('countries', 'id')->where(fn ($query) => $query->where('status', true)),
            ],
            'current_address' => 'required|string|min:5|max:1000',

            ...$this->dualNationalityRules(),

            'birth_place_city_id' => 'required|integer|exists:cities,id',
            'birth_placed' => 'nullable|string|max:255',
            ...$this->lifeProposedRules(),
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
            'date_of_birth.before_or_equal' => 'Proposer must be 18 years or older.',

            'age_nearest_date.required' => 'Age is required',
            'age_nearest_date.integer' => 'Age must be a number',
            'age_nearest_date.min' => 'Proposer must be 18 years or older.',

            'gender.required' => 'Gender is required',
            'marital_status.required' => 'Marital status is required',
            'husband_name.required' => 'Husband name is required for married female applicants',
            'wife_name.required' => 'Wife name is required for married male applicants',

            'email.required' => 'Email is required',
            'email.email' => 'Enter valid email',

            'country_of_residence_id.required' => 'Country of Residence is required',
            'country_of_residence_id.exists' => 'Please select a valid Country of Residence',
            'current_address.required' => 'Current Address is required',
            'current_address.min' => 'Please enter a valid Current Address',

            'is_client_dual_national.required' => 'Select dual nationality option',
            'primary_nationality.required' => 'Primary nationality is required',
            'primary_nationality.in' => 'Primary nationality must be Pakistani when dual nationality is No.',

            'is_same_person.required' => 'Please select this option',
            ...$this->lifeProposedMessages(),

            ...$this->dualNationalityMessages(),
        ];
    }
}

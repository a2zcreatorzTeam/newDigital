<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserOccupationRequest extends FormRequest
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
            'is_emaployemnt' => 'required|in:Yes,No',
            'employment_designation' => 'required_if:is_emaployemnt,Yes|nullable|string|max:255',
            'employment_company_name' => 'required_if:is_emaployemnt,Yes|nullable|string|max:255',

            'is_business' => 'required|in:Yes,No',
            'business_name' => 'required_if:is_business,Yes|nullable|string|max:255',
            'nature_of_business' => 'required_if:is_business,Yes|nullable|string|max:255',

            'is_holding_land' => 'required|in:Yes,No',
            'total_acreage' => 'required_if:is_holding_land,Yes|nullable|numeric',
            'land_location' => 'required_if:is_holding_land,Yes|nullable|string|max:255',
            'land_type' => 'required_if:is_holding_land,Yes|nullable|in:Agricultural,Commercial,Residential',
            'estimated_land_value' => 'required_if:is_holding_land,Yes|nullable|numeric',

            'ex_defence_personal' => 'required|in:Yes,No',
            'discharged_on_medical' => 'required|in:Yes,No',
            'hazardous_occupation' => 'required|in:Yes,No',
            'avaerage_monthly_income' => 'required|string',
            'comment' => 'required|string',

        ];
    }

    /**
     * Custom Messages
     */
    public function messages(): array
    {
        return [];
    }
}

<?php

namespace App\Http\Requests;

use App\Support\Concerns\PreparesFilerStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserOccupationRequest extends FormRequest
{
    use PreparesFilerStatus;

    /**
     * Authorize user
     */
    public function authorize(): bool
    {
        return Auth::check() && (int) Auth::user()->user_type === 1;
    }

    protected function prepareForValidation(): void
    {
        $this->mergeFilerStatusDefaults();
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

            ...$this->filerStatusRules(),

            'is_holding_land' => 'required|in:Yes,No',
            'land_unit' => 'required_if:is_holding_land,Yes|nullable|in:Marla,Kanal,Acre,Square Yard,Square Feet,Hectare',
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
        return $this->filerStatusMessages();
    }
}

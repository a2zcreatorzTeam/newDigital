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
            'is_business' => 'required|in:Yes,No',
            'is_holding_land' => 'required|in:Yes,No',
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

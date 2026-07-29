<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserHealthRequest extends FormRequest
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
            'height_cm'                => 'required|numeric|max:300',
            'height_ft'                => 'required|numeric', // e.g., 5'11"
            'weight_kg'                => 'required|numeric|min:2|max:500',
            'chest_insp_cm'            => 'required|numeric',
            'chest_insp_inches'        => 'required|numeric',
            'chest_exp_cm'             => 'required|numeric',
            'chest_exp_inches'         => 'required|numeric',
            'abdomen_cm'               => 'required|numeric',
            'abdomen_inches'           => 'required|numeric',
            'weight_loss_kg'           => 'nullable|numeric|min:0',
            'weight_gain_kg'           => 'nullable|numeric|min:0',
            'weight_increase_reason'   => 'nullable|string|max:1000',
            'daily_consumption' => 'required|string|max:255',
            'physical_impairments' => 'nullable|string|max:255',
            'last_illness_injury' => 'required|string|max:255',
            'medical_investigations' => 'required|string|max:255',
            'medical_history' => 'required|string|max:255',

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

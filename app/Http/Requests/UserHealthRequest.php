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
            'chest_insp_cm'            => 'nullable|numeric',
            'chest_insp_inches'        => 'nullable|numeric',
            'chest_exp_cm'             => 'nullable|numeric',
            'chest_exp_inches'         => 'nullable|numeric',
            'abdomen_cm'               => 'nullable|numeric',
            'abdomen_inches'           => 'nullable|numeric',
            'weight_loss_kg'           => 'nullable|numeric|min:0',
            'weight_gain_kg'           => 'nullable|numeric|min:0',
            'weight_increase_reason'   => 'nullable|string|max:1000',

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

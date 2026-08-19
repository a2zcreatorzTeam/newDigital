<?php

namespace App\Http\Requests;

use App\Support\Concerns\PreparesHealthMeasurements;
use Illuminate\Foundation\Http\FormRequest;

class UserHealthRequest extends FormRequest
{
    use PreparesHealthMeasurements;

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->mergeConvertedHealthMeasurements();
    }

    public function rules(): array
    {
        return array_merge(
            $this->healthMeasurementUiRules(),
            $this->healthMeasurementDbRules(),
            [
                'daily_consumption' => 'required|string|max:255',
                'physical_impairments' => 'nullable|string|max:255',
                'last_illness_injury' => 'required|string|max:255',
                'medical_investigations' => 'required|string|max:255',
                'medical_history' => 'required|string|max:255',
            ]
        );
    }

    public function messages(): array
    {
        return [
            'height_value.required' => 'Height is required.',
            'height_unit.required' => 'Height unit is required.',
            'weight_value.required' => 'Weight is required.',
            'weight_unit.required' => 'Weight unit is required.',
            'weight_change_type.required' => 'Please select Weight Gain or Weight Loss.',
            'weight_change_value.required' => 'Weight change value is required.',
            'weight_increase_reason.required' => 'Reason for weight change is required.',
        ];
    }
}

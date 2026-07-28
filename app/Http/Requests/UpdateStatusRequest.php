<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStatusRequest extends FormRequest
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
            'status' => 'required',
            'comment' => 'required',
        ];

    }

    /**
     * Custom Messages
     */
    public function messages(): array
    {
        return [
            'status.required' => 'Status Field is required',
            'comment.required' => 'Comment Field is required',
        ];
    }
}

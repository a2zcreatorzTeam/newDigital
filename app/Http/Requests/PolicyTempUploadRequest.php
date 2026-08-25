<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PolicyTempUploadRequest extends FormRequest
{
    /** Allowed field keys for single-file temp uploads. */
    public const ALLOWED_FIELDS = [
        'proposer_cnic_front',
        'proposer_cnic_back',
        'life_proposed_document',
        'nominee_document',
        'proposer_photo',
        'income_proof',
        'medical_doc_referred_opd',
        'medical_doc_previous_opd',
        'medical_doc_summary_reports',
        'medical_doc_present_history',
        'medical_doc_death_mlc',
        'medical_doc_medicolegal',
        'medical_extra_doc',
        'other_doc',
    ];

    public function authorize(): bool
    {
        return Auth::check() && (int) Auth::user()->user_type === 1;
    }

    protected function prepareForValidation(): void
    {
        // Prefer multipart file; otherwise accept ModSecurity-friendly base64.
        if (!$this->hasFile('file') && $this->filled('file_base64') && !$this->filled('original_name')) {
            $this->merge([
                'original_name' => 'upload.bin',
            ]);
        }
    }

    public function rules(): array
    {
        $field = (string) $this->input('field', '');
        $mimes = $field === 'proposer_photo'
            ? 'jpg,jpeg,png'
            : 'jpg,jpeg,png,pdf';

        return [
            'field' => 'required|string|in:' . implode(',', self::ALLOWED_FIELDS),
            'file' => [
                Rule::requiredIf(fn () => !$this->filled('file_base64')),
                'nullable',
                'file',
                "mimes:{$mimes}",
                'max:4096',
            ],
            'file_base64' => [
                Rule::requiredIf(fn () => !$this->hasFile('file')),
                'nullable',
                'string',
            ],
            'original_name' => [
                Rule::requiredIf(fn () => $this->filled('file_base64') && !$this->hasFile('file')),
                'nullable',
                'string',
                'max:255',
            ],
            'label' => 'nullable|string|max:255',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $validator->errors()->first() ?: 'Upload validation failed.',
            'errors' => $validator->errors(),
        ], 422));
    }

    protected function failedAuthorization(): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Unauthorized',
        ], 401));
    }
}

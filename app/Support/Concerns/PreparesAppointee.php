<?php

namespace App\Support\Concerns;

use App\Rules\MobileLinkedToCnic;
use Illuminate\Validation\Rule;

trait PreparesAppointee
{
    protected function isNomineeMinor(): bool
    {
        $age = $this->input('nominee_age');
        if ($age === null || $age === '') {
            return false;
        }

        return (int) $age < 18;
    }

    protected function mergeAppointeeDefaults(): void
    {
        if ($this->isNomineeMinor()) {
            return;
        }

        $this->merge([
            'appointee_name' => null,
            'appointee_relationship' => null,
            'appointee_cnic' => null,
            'appointee_mobile' => null,
        ]);
    }

    protected function appointeeRules(): array
    {
        $requiredIfMinor = Rule::requiredIf(fn () => $this->isNomineeMinor());

        return [
            'nominee_name' => 'required|string|max:255',
            'nominee_cnic' => 'required|string|max:20',
            'nominee_age' => 'required|integer|min:0|max:120',
            'nominee_relationship' => 'required|string|max:255',
            'appointee_name' => [$requiredIfMinor, 'nullable', 'string', 'max:255'],
            'appointee_relationship' => [$requiredIfMinor, 'nullable', 'string', 'max:255'],
            'appointee_cnic' => [
                $requiredIfMinor,
                'nullable',
                'string',
                'max:20',
                'regex:/^[0-9]{5}-[0-9]{7}-[0-9]{1}$/',
            ],
            'appointee_mobile' => array_values(array_filter([
                $requiredIfMinor,
                'nullable',
                'string',
                'max:20',
                'regex:/^[0-9]{3,4}-[0-9]{7,8}$/',
                $this->isNomineeMinor() ? new MobileLinkedToCnic('appointee_cnic') : null,
            ])),
        ];
    }

    protected function appointeeMessages(): array
    {
        return [
            'nominee_name.required' => 'Nominee name is required.',
            'nominee_cnic.required' => 'Nominee CNIC or B-Form is required.',
            'nominee_age.required' => 'Nominee age is required.',
            'nominee_age.integer' => 'Nominee age must be a number.',
            'nominee_relationship.required' => 'Nominee relationship is required.',
            'appointee_name.required' => 'Appointee name is required when the nominee is a minor.',
            'appointee_relationship.required' => 'Appointee relationship is required when the nominee is a minor.',
            'appointee_cnic.required' => 'Appointee CNIC is required when the nominee is a minor.',
            'appointee_cnic.regex' => 'Appointee CNIC format must be like 42101-1234567-1.',
            'appointee_mobile.required' => 'Appointee mobile number is required when the nominee is a minor.',
            'appointee_mobile.regex' => 'Appointee mobile format must be like 0300-1234567.',
        ];
    }
}

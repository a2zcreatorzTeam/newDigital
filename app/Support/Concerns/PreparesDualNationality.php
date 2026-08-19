<?php

namespace App\Support\Concerns;

use App\Models\Country;
use Illuminate\Validation\Rule;

trait PreparesDualNationality
{
    protected function mergeDualNationalityDefaults(): void
    {
        if ($this->input('is_client_dual_national') === 'No') {
            $pakistan = Country::query()->active()->where('code', 'PK')->first();

            $this->merge([
                'primary_nationality' => 'Pakistani',
                'primary_nationality_country_id' => $pakistan?->id,
                'dual_nationality' => null,
                'dual_nationality_country' => null,
                'dual_nationality_country_id' => null,
                'dual_passport_number' => null,
                'dual_tax_tin_number' => null,
                'dual_mobile_number' => null,
                'dual_address' => null,
            ]);

            return;
        }

        $primaryId = $this->nullableId('primary_nationality_country_id');
        $dualCountryId = $this->nullableId('dual_nationality_country_id');

        $primary = $primaryId
            ? Country::query()->active()->find($primaryId)
            : null;
        $dualCountry = $dualCountryId
            ? Country::query()->active()->find($dualCountryId)
            : null;

        $this->merge([
            'primary_nationality_country_id' => $primaryId,
            'primary_nationality' => $primary?->name,
            'dual_nationality' => null,
            'dual_nationality_country_id' => $dualCountryId,
            'dual_nationality_country' => $dualCountry?->name,
        ]);
    }

    protected function nullableId(string $key): ?int
    {
        $value = $this->input($key);
        if ($value === '' || $value === null) {
            return null;
        }

        return (int) $value;
    }

    protected function dualNationalityMessages(): array
    {
        return [
            'primary_nationality_country_id.required_if' => 'Please select Primary Nationality.',
            'primary_nationality_country_id.exists' => 'Please select a valid country from the list.',
            'primary_nationality_country_id.integer' => 'Please select a valid country from the list.',
            'dual_nationality_country_id.required_if' => 'Please select a Dual Nationality Country.',
            'dual_nationality_country_id.exists' => 'Please select a valid country from the list.',
            'dual_nationality_country_id.integer' => 'Please select a valid country from the list.',
            'dual_tax_tin_number.required_if' => 'Please enter Tax/TIN Number.',
            'dual_mobile_number.required_if' => 'Please enter Mobile Number.',
            'dual_address.required_if' => 'Please enter Address.',
        ];
    }

    protected function dualNationalityRules(): array
    {
        $isNo = $this->input('is_client_dual_national') === 'No';
        $activeCountry = fn () => Rule::exists('countries', 'id')->where(fn ($query) => $query->where('status', true));

        return [
            'is_client_dual_national' => 'required|in:Yes,No',
            'primary_nationality_country_id' => array_values(array_filter([
                $isNo ? 'nullable' : 'required_if:is_client_dual_national,Yes',
                'nullable',
                'integer',
                $activeCountry(),
            ])),
            'primary_nationality' => $isNo
                ? ['required', 'string', 'max:100', Rule::in(['Pakistani'])]
                : ['nullable', 'string', 'max:100'],
            'dual_nationality' => 'nullable|string|max:100',
            'dual_nationality_country_id' => [
                'required_if:is_client_dual_national,Yes',
                'nullable',
                'integer',
                $activeCountry(),
            ],
            'dual_nationality_country' => 'nullable|string|max:100',
            'dual_passport_number' => 'required_if:is_client_dual_national,Yes|nullable|string|max:100',
            'dual_tax_tin_number' => 'required_if:is_client_dual_national,Yes|nullable|string|max:50',
            'dual_mobile_number' => 'required_if:is_client_dual_national,Yes|nullable|string|max:30',
            'dual_address' => 'required_if:is_client_dual_national,Yes|nullable|string|max:500',
        ];
    }
}

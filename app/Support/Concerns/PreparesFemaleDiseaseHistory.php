<?php

namespace App\Support\Concerns;

use App\Support\FemaleDiseases;
use Illuminate\Validation\Rule;

trait PreparesFemaleDiseaseHistory
{
    protected function hasFemaleDiseaseHistory(): bool
    {
        return $this->input('female_disease_history') === 'Yes';
    }

    protected function mergeFemaleDiseaseDefaults(): void
    {
        if ($this->hasFemaleDiseaseHistory()) {
            return;
        }

        $this->merge([
            'female_disease_name' => null,
            'female_disease_details' => null,
        ]);
    }

    protected function passedValidation(): void
    {
        $this->packFemaleDiseaseForPersist();
    }

    protected function packFemaleDiseaseForPersist(): void
    {
        if ($this->hasFemaleDiseaseHistory()) {
            $this->merge([
                'female_disease_name' => FemaleDiseases::pack(
                    $this->input('female_disease_name'),
                    $this->input('female_disease_details')
                ),
            ]);
        }

        $this->offsetUnset('female_disease_details');
    }

    /**
     * Pack female-disease fields on a validated payload.
     * Named helper so this trait can be combined with PreparesHealthMeasurements.
     */
    protected function applyFemaleDiseaseValidated(mixed $data, mixed $key = null): mixed
    {
        if ($key !== null || !is_array($data)) {
            return $data;
        }

        if (($data['female_disease_history'] ?? null) !== 'Yes') {
            $data['female_disease_name'] = null;
            unset($data['female_disease_details']);

            return $data;
        }

        $unpacked = FemaleDiseases::unpack($data['female_disease_name'] ?? null);
        $data['female_disease_name'] = FemaleDiseases::pack(
            $unpacked['name'] ?? null,
            $data['female_disease_details'] ?? $unpacked['details'] ?? null
        );
        unset($data['female_disease_details']);

        return $data;
    }

    protected function femaleDiseaseRules(): array
    {
        $requiredIfYes = Rule::requiredIf(fn () => $this->hasFemaleDiseaseHistory());
        $requiredIfOther = Rule::requiredIf(fn () =>
            $this->hasFemaleDiseaseHistory()
            && $this->input('female_disease_name') === FemaleDiseases::OTHER
        );

        return [
            'female_disease_history' => 'nullable|in:Yes,No',
            'female_disease_name' => [
                $requiredIfYes,
                'nullable',
                'string',
                Rule::in(FemaleDiseases::values()),
            ],
            'female_disease_details' => [
                $requiredIfOther,
                'nullable',
                'string',
                'max:500',
            ],
        ];
    }

    protected function femaleDiseaseMessages(): array
    {
        return [
            'female_disease_history.in' => 'Please select Yes or No for female disease history.',
            'female_disease_name.required' => 'Please select a female disease.',
            'female_disease_name.in' => 'Please select a valid female disease.',
            'female_disease_details.required' => 'Please enter the disease name or description.',
            'female_disease_details.max' => 'Disease description must not exceed 500 characters.',
        ];
    }
}

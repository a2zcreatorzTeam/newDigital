<?php

namespace App\Support\Concerns;

use App\Models\Country;
use App\Models\UserPolicyData;
use App\Rules\MobileLinkedToCnic;
use App\Support\AgeNearestBirthday;
use App\Support\LifeProposedProfile;
use Illuminate\Validation\Rule;

trait PreparesLifeProposed
{
    protected function isLifeProposedSeparate(): bool
    {
        return $this->input('is_same_person') === 'No';
    }

    protected function isLifeProposedMinor(): bool
    {
        if (!$this->isLifeProposedSeparate()) {
            return false;
        }

        $age = AgeNearestBirthday::calculate($this->input('life_proposed_dob'));

        return $age !== null && $age < 18;
    }

    protected function isLifeProposedDualNational(): bool
    {
        return $this->isLifeProposedSeparate()
            && $this->input('life_proposed_is_client_dual_national') === 'Yes';
    }

    protected function mergeLifeProposedDefaults(bool $includeDocument = true): void
    {
        if ($this->isLifeProposedSeparate()) {
            $age = AgeNearestBirthday::calculate($this->input('life_proposed_dob'));
            if ($age !== null) {
                $this->merge(['life_proposed_age' => $age]);
            }

            $this->mergeLifeProposedDualDefaults();

            if ($this->isLifeProposedMinor()) {
                $this->merge([
                    'life_proposed_cnic_issue_date' => null,
                    'life_proposed_cnic_expiry_date' => null,
                ]);
            }

            $gender = $this->input('life_proposed_gender');
            $marital = $this->input('life_proposed_marital_status');
            if ($marital !== 'Married' || $gender !== 'Male') {
                $this->merge(['life_proposed_wife_name' => null]);
            }
            if ($marital !== 'Married' || $gender !== 'Female') {
                $this->merge(['life_proposed_husband_name' => null]);
            }

            return;
        }

        $payload = [
            'life_proposed_name' => null,
            'life_proposed_cnic' => null,
            'life_proposed_dob' => null,
            'life_proposed_relationship' => null,
        ];

        foreach (LifeProposedProfile::EXTRA_KEYS as $key) {
            $payload[LifeProposedProfile::field($key)] = null;
        }

        if ($includeDocument) {
            $payload['life_proposed_document'] = null;
        }

        $this->merge($payload);
    }

    protected function mergeLifeProposedDualDefaults(): void
    {
        if (!$this->isLifeProposedSeparate()) {
            return;
        }

        if ($this->input('life_proposed_is_client_dual_national') === 'No') {
            $pakistan = Country::query()->active()->where('code', 'PK')->first();
            $this->merge([
                'life_proposed_primary_nationality' => 'Pakistani',
                'life_proposed_primary_nationality_country_id' => $pakistan?->id,
                'life_proposed_dual_nationality_country' => null,
                'life_proposed_dual_nationality_country_id' => null,
                'life_proposed_dual_passport_number' => null,
                'life_proposed_dual_tax_tin_number' => null,
                'life_proposed_dual_mobile_number' => null,
                'life_proposed_dual_address' => null,
            ]);

            return;
        }

        $primaryId = $this->nullableLifeProposedId('life_proposed_primary_nationality_country_id');
        $dualCountryId = $this->nullableLifeProposedId('life_proposed_dual_nationality_country_id');
        $primary = $primaryId ? Country::query()->active()->find($primaryId) : null;
        $dualCountry = $dualCountryId ? Country::query()->active()->find($dualCountryId) : null;

        $this->merge([
            'life_proposed_primary_nationality_country_id' => $primaryId,
            'life_proposed_primary_nationality' => $primary?->name,
            'life_proposed_dual_nationality_country_id' => $dualCountryId,
            'life_proposed_dual_nationality_country' => $dualCountry?->name,
        ]);
    }

    protected function nullableLifeProposedId(string $key): ?int
    {
        $value = $this->input($key);
        if ($value === '' || $value === null) {
            return null;
        }

        return (int) $value;
    }

    protected function lifeProposedRules(): array
    {
        $requiredIfSeparate = Rule::requiredIf(fn () => $this->isLifeProposedSeparate());
        $requiredIfAdult = Rule::requiredIf(fn () => $this->isLifeProposedSeparate() && !$this->isLifeProposedMinor());
        $requiredIfDual = Rule::requiredIf(fn () => $this->isLifeProposedDualNational());
        $requiredIfWife = Rule::requiredIf(fn () =>
            $this->isLifeProposedSeparate()
            && $this->input('life_proposed_gender') === 'Male'
            && $this->input('life_proposed_marital_status') === 'Married'
        );
        $requiredIfHusband = Rule::requiredIf(fn () =>
            $this->isLifeProposedSeparate()
            && $this->input('life_proposed_gender') === 'Female'
            && $this->input('life_proposed_marital_status') === 'Married'
        );
        $activeCountry = fn () => Rule::exists('countries', 'id')->where(fn ($query) => $query->where('status', true));

        $cnicRules = [
            $requiredIfSeparate,
            'nullable',
            'string',
            'max:25',
        ];
        if ($this->isLifeProposedSeparate() && !$this->isLifeProposedMinor()) {
            $cnicRules[] = 'regex:/^[0-9]{5}-[0-9]{7}-[0-9]{1}$/';
        }

        $mobileRules = [
            $requiredIfSeparate,
            'nullable',
            'string',
            'max:20',
        ];
        if ($this->isLifeProposedSeparate() && !$this->isLifeProposedMinor()) {
            $mobileRules[] = new MobileLinkedToCnic('life_proposed_cnic');
        }

        $isDualNo = $this->input('life_proposed_is_client_dual_national') === 'No';

        return [
            'is_same_person' => 'required|in:Yes,No',
            'life_proposed_name' => [$requiredIfSeparate, 'nullable', 'string', 'max:255'],
            'life_proposed_cnic' => $cnicRules,
            'life_proposed_dob' => [$requiredIfSeparate, 'nullable', 'date', 'before:today'],
            'life_proposed_relationship' => [$requiredIfSeparate, 'nullable', 'string', 'max:100'],
            'life_proposed_mobile' => $mobileRules,
            'life_proposed_cnic_issue_date' => [$requiredIfAdult, 'nullable', 'date'],
            'life_proposed_cnic_expiry_date' => [$requiredIfAdult, 'nullable', 'date', 'after:life_proposed_cnic_issue_date'],
            'life_proposed_age' => [$requiredIfSeparate, 'nullable', 'integer', 'min:0', 'max:120'],
            'life_proposed_gender' => [$requiredIfSeparate, 'nullable', 'in:Male,Female,Other'],
            'life_proposed_marital_status' => [$requiredIfSeparate, 'nullable', 'in:Married,Unmarried'],
            'life_proposed_wife_name' => [$requiredIfWife, 'nullable', 'string', 'max:255'],
            'life_proposed_husband_name' => [$requiredIfHusband, 'nullable', 'string', 'max:255'],
            'life_proposed_mother_maiden_name' => [$requiredIfSeparate, 'nullable', 'string', 'max:255'],
            'life_proposed_father_name' => [$requiredIfSeparate, 'nullable', 'string', 'max:255'],
            'life_proposed_religion' => [$requiredIfSeparate, 'nullable', 'string', 'max:100'],
            'life_proposed_email' => [$requiredIfSeparate, 'nullable', 'email', 'max:255'],
            'life_proposed_phone_office' => ['nullable', 'string', 'max:20'],
            'life_proposed_phone_residential' => ['nullable', 'string', 'max:20'],
            'life_proposed_country_of_residence_id' => array_values(array_filter([
                $requiredIfSeparate,
                'nullable',
                'integer',
                $activeCountry(),
            ])),
            'life_proposed_current_address' => [$requiredIfSeparate, 'nullable', 'string', 'min:5', 'max:1000'],
            'life_proposed_is_client_dual_national' => [$requiredIfSeparate, 'nullable', 'in:Yes,No'],
            'life_proposed_primary_nationality_country_id' => array_values(array_filter([
                $isDualNo ? 'nullable' : $requiredIfDual,
                'nullable',
                'integer',
                $activeCountry(),
            ])),
            'life_proposed_primary_nationality' => $isDualNo
                ? ['nullable', 'string', 'max:100', Rule::in(['Pakistani'])]
                : ['nullable', 'string', 'max:100'],
            'life_proposed_dual_nationality_country_id' => [
                $requiredIfDual,
                'nullable',
                'integer',
                $activeCountry(),
            ],
            'life_proposed_dual_nationality_country' => 'nullable|string|max:100',
            'life_proposed_dual_tax_tin_number' => [$requiredIfDual, 'nullable', 'string', 'max:50'],
            'life_proposed_dual_mobile_number' => [$requiredIfDual, 'nullable', 'string', 'max:30'],
            'life_proposed_dual_address' => [$requiredIfDual, 'nullable', 'string', 'max:500'],
            'life_proposed_dual_passport_number' => [$requiredIfDual, 'nullable', 'string', 'max:100'],
            'life_proposed_birth_place_city_id' => [$requiredIfSeparate, 'nullable', 'integer', 'exists:cities,id'],
            'life_proposed_birth_placed' => 'nullable|string|max:255',
        ];
    }

    protected function hasExistingLifeProposedDocument(): bool
    {
        $id = $this->route('id');
        if (!$id) {
            return false;
        }

        $policy = UserPolicyData::query()->find($id);

        return $policy !== null && filled($policy->life_proposed_document);
    }

    protected function lifeProposedDocumentRules(bool $requiredWhenSeparate = true): array
    {
        return [
            'life_proposed_document' => [
                Rule::requiredIf(function () use ($requiredWhenSeparate) {
                    if (!$this->isLifeProposedSeparate()) {
                        return false;
                    }
                    if ($this->filled('life_proposed_document_temp_token')) {
                        return false;
                    }
                    $needsDoc = $requiredWhenSeparate || !$this->hasExistingLifeProposedDocument();

                    return $needsDoc && !$this->hasFile('life_proposed_document');
                }),
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:4096',
            ],
            'life_proposed_document_temp_token' => [
                Rule::requiredIf(function () use ($requiredWhenSeparate) {
                    if (!$this->isLifeProposedSeparate()) {
                        return false;
                    }
                    if ($this->hasFile('life_proposed_document')) {
                        return false;
                    }
                    $needsDoc = $requiredWhenSeparate || !$this->hasExistingLifeProposedDocument();

                    return $needsDoc && !$this->filled('life_proposed_document_temp_token');
                }),
                'nullable',
                'string',
                'uuid',
            ],
        ];
    }

    protected function lifeProposedMessages(): array
    {
        return [
            'is_same_person.required' => 'Please select whether Proposer and Life Proposed are the same.',
            'life_proposed_name.required' => 'Life Proposed name is required.',
            'life_proposed_cnic.required' => 'Life Proposed CNIC or B-Form is required.',
            'life_proposed_cnic.regex' => 'Life Proposed CNIC format must be like 42101-1234567-1.',
            'life_proposed_dob.required' => 'Life Proposed date of birth is required.',
            'life_proposed_relationship.required' => 'Relationship with proposer is required.',
            'life_proposed_mobile.required' => 'Life Proposed mobile number is required.',
            'life_proposed_cnic_issue_date.required' => 'Life Proposed CNIC issue date is required.',
            'life_proposed_cnic_expiry_date.required' => 'Life Proposed CNIC expiry date is required.',
            'life_proposed_cnic_expiry_date.after' => 'Life Proposed CNIC expiry date must be after issue date.',
            'life_proposed_age.required' => 'Life Proposed age is required.',
            'life_proposed_gender.required' => 'Life Proposed gender is required.',
            'life_proposed_marital_status.required' => 'Life Proposed marital status is required.',
            'life_proposed_wife_name.required' => 'Wife name is required for a married male Life Proposed.',
            'life_proposed_husband_name.required' => 'Husband name is required for a married female Life Proposed.',
            'life_proposed_mother_maiden_name.required' => 'Life Proposed mother maiden name is required.',
            'life_proposed_father_name.required' => 'Life Proposed father name is required.',
            'life_proposed_religion.required' => 'Life Proposed religion is required.',
            'life_proposed_email.required' => 'Life Proposed email is required.',
            'life_proposed_email.email' => 'Enter a valid Life Proposed email.',
            'life_proposed_country_of_residence_id.required' => 'Life Proposed Country of Residence is required.',
            'life_proposed_country_of_residence_id.exists' => 'Please select a valid Life Proposed Country of Residence.',
            'life_proposed_current_address.required' => 'Life Proposed Current Address is required.',
            'life_proposed_current_address.min' => 'Please enter a valid Life Proposed Current Address.',
            'life_proposed_is_client_dual_national.required' => 'Select dual nationality for Life Proposed.',
            'life_proposed_primary_nationality_country_id.required' => 'Please select Life Proposed primary nationality.',
            'life_proposed_dual_nationality_country_id.required' => 'Please select Life Proposed dual nationality country.',
            'life_proposed_dual_tax_tin_number.required' => 'Please enter Life Proposed Tax/TIN number.',
            'life_proposed_dual_mobile_number.required' => 'Please enter Life Proposed dual-nationality mobile.',
            'life_proposed_dual_address.required' => 'Please enter Life Proposed dual-nationality address.',
            'life_proposed_dual_passport_number.required' => 'Please enter Life Proposed passport number.',
            'life_proposed_birth_place_city_id.required' => 'Life Proposed birth place is required.',
            'life_proposed_document.required' => 'Please upload Life Proposed CNIC or B-Form copy.',
            'life_proposed_document.mimes' => 'Life Proposed document must be a JPG, PNG, or PDF.',
            'life_proposed_document.max' => 'Life Proposed document must not exceed 4MB.',
        ];
    }
}

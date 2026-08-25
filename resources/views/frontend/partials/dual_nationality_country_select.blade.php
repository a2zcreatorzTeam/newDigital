{{-- Backward-compatible wrapper around the shared country dropdown. --}}
@include('frontend.partials.country_select', [
    'fieldName' => $fieldName ?? 'dual_nationality_country_id',
    'countrySelectId' => $countrySelectId ?? 'dual_nationality_country_id',
    'selectedCountryId' => $selectedCountryId ?? null,
    'selectedCountryName' => $selectedCountryName ?? null,
    'selectedNameField' => $selectedNameField ?? 'dual_nationality_country',
    'countryRequired' => $countryRequired ?? false,
    'countryShowAsterisk' => $countryShowAsterisk ?? true,
    'countrySelectClass' => $countrySelectClass ?? 'form-control account',
    'countryLabel' => $countryLabel ?? policy_label('dual_nationality_country'),
    'countryLabelClass' => $countryLabelClass ?? '',
    'countries' => $countries ?? collect(),
])

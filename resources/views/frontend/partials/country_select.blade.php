{{--
  Database-driven country dropdown (Select2).
  Expects: $countries
  Optional: $fieldName, $selectedCountryId, $selectedCountryName, $countryRequired,
            $countrySelectClass, $countryLabel, $countryLabelClass, $countrySelectId,
            $selectedNameField
--}}
@php
    $countriesList = $countries ?? collect();
    $fieldName = $fieldName ?? 'dual_nationality_country_id';
    $countrySelectId = $countrySelectId ?? $fieldName;
    $selectedCountryId = old($fieldName, $selectedCountryId ?? null);
    if (!empty($selectedNameField)) {
        $selectedCountryName = old($selectedNameField, $selectedCountryName ?? null);
    } else {
        $selectedCountryName = $selectedCountryName ?? null;
    }

    $normalizeCountryName = static function (?string $value): string {
        $value = str_replace(['’', '`'], "'", (string) $value);

        return mb_strtolower(trim($value));
    };

    if (!$selectedCountryId && $selectedCountryName) {
        $lookup = $normalizeCountryName($selectedCountryName);
        $aliases = [
            'pakistani' => 'pakistan',
            'usa' => 'united states',
            'u.s.a' => 'united states',
            'u.s.a.' => 'united states',
            'uk' => 'united kingdom',
            'u.k.' => 'united kingdom',
            'great britain' => 'united kingdom',
            'uae' => 'united arab emirates',
        ];
        $lookup = $aliases[$lookup] ?? $lookup;
        $matched = $countriesList->first(function ($country) use ($lookup, $normalizeCountryName) {
            return $normalizeCountryName($country->name) === $lookup
                || strcasecmp((string) $country->code, $lookup) === 0;
        });
        $selectedCountryId = $matched->id ?? null;
    }

    $countryRequired = $countryRequired ?? false;
    $countryShowAsterisk = $countryShowAsterisk ?? true;
    $countrySelectClass = $countrySelectClass ?? 'form-control account';
    $countryLabel = $countryLabel ?? 'Select Country';
    $countryLabelClass = $countryLabelClass ?? '';
@endphp

<label @if($countryLabelClass) class="{{ $countryLabelClass }}" @endif>
    {{ $countryLabel }}
    @if($countryShowAsterisk)
        <span class="requi text-danger required-asterisk">*</span>
    @endif
</label>
<select
    name="{{ $fieldName }}"
    id="{{ $countrySelectId }}"
    class="{{ $countrySelectClass }} js-country-select"
    @if($countryRequired) required @endif
    data-placeholder="Select Country"
>
    <option value="">Select Country</option>
    @foreach($countriesList as $country)
        <option
            value="{{ $country->id }}"
            data-code="{{ $country->code }}"
            @selected((string) $selectedCountryId === (string) $country->id)
        >
            {{ $country->name }}
        </option>
    @endforeach
</select>

@once
    @push('css')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
        <style>
            .select2-container { width: 100% !important; }
            .select2-container--default .select2-selection--single {
                height: 42px;
                border: 1px solid #dce1e7;
                border-radius: 8px;
                padding: 6px 8px;
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 28px;
                color: #333;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 40px;
            }
            .select2-container--default.select2-container--disabled .select2-selection--single {
                background-color: #e9ecef !important;
                cursor: not-allowed;
            }
            /* Hide Select2 clear chip that can render under the field */
            .js-country-select + .select2-container .select2-selection__clear {
                display: none !important;
            }
        </style>
    @endpush

    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <script>
            $(function () {
                function initCountrySelect() {
                    $('.js-country-select').each(function () {
                        var $el = $(this);
                        if ($el.hasClass('select2-hidden-accessible')) {
                            return;
                        }
                        $el.select2({
                            placeholder: $el.data('placeholder') || 'Select Country',
                            allowClear: !$el.prop('required'),
                            width: '100%'
                        });
                    });
                }
                initCountrySelect();
                window.initCountrySelect = initCountrySelect;
                window.initDualNationalityCountrySelect = initCountrySelect;
            });
        </script>
    @endpush
@endonce

{{--
  Birth Place city dropdown (Select2).
  Expects: $cities (collection of City)
  Optional: $selectedBirthCityId, $birthPlaceRequired (bool), $birthPlaceClass
--}}
@php
    $citiesList = $cities ?? collect();
    $birthPlaceFieldName = $birthPlaceFieldName ?? 'birth_place_city_id';
    $birthPlaceSelectId = $birthPlaceSelectId ?? $birthPlaceFieldName;
    $selectedBirthCityId = old($birthPlaceFieldName, $selectedBirthCityId ?? null);
    $birthPlaceRequired = $birthPlaceRequired ?? true;
    $birthPlaceClass = $birthPlaceClass ?? 'form-control account';
    $birthPlaceLabel = $birthPlaceLabel ?? 'Birth Place (مقامِ پیدائش)';
    $birthPlaceLabelClass = $birthPlaceLabelClass ?? '';
@endphp

<label @if($birthPlaceLabelClass) class="{{ $birthPlaceLabelClass }}" @endif>
    {{ $birthPlaceLabel }}
    @if($birthPlaceRequired)
        <span class="requi text-danger required-asterisk">*</span>
    @endif
</label>
<select
    name="{{ $birthPlaceFieldName }}"
    id="{{ $birthPlaceSelectId }}"
    class="{{ $birthPlaceClass }} birth-place-city-select"
    @if($birthPlaceRequired) required @endif
    data-placeholder="Select Birth Place"
>
    <option value="">Select Birth Place</option>
    @foreach($citiesList as $city)
        <option value="{{ $city->id }}" @selected((string) $selectedBirthCityId === (string) $city->id)>
            {{ $city->name }}
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
        </style>
    @endpush

    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <script>
            $(function () {
                function initBirthPlaceSelect() {
                    $('.birth-place-city-select').each(function () {
                        var $el = $(this);
                        if ($el.hasClass('select2-hidden-accessible')) {
                            return;
                        }
                        $el.select2({
                            placeholder: $el.data('placeholder') || 'Select Birth Place',
                            allowClear: !$el.prop('required'),
                            width: '100%'
                        });
                    });
                }
                initBirthPlaceSelect();
            });
        </script>
    @endpush
@endonce

@php
    $variant = $variant ?? 'form';
    $lp = $lp ?? [];
    $val = function (string $key) use ($lp) {
        return old('life_proposed_'.$key, $lp[$key] ?? '');
    };
    $isEdit = $variant === 'edit';
    $isProfile = $variant === 'profile';
    $col = $isEdit ? 'col-md-6 mb-3' : ($isProfile ? 'col-6' : 'col-md-6 px-0 px-sm-3 mt-3');
    $labelClass = $isEdit ? 'detail-label' : '';
    $inputClass = $isEdit ? 'form-control' : 'form-control account';
    $selectClass = $isEdit ? 'form-select' : 'form-control';
    $open = function (string $extra = '') use ($col, $isEdit, $isProfile) {
        echo '<div class="'.trim($col.' '.$extra).'">';
        if ($isEdit) {
            echo '<div class="detail-box">';
        }
        if ($isProfile) {
            echo '<div class="form-group">';
        }
    };
    $close = function () use ($isEdit, $isProfile) {
        if ($isEdit || $isProfile) {
            echo '</div>';
        }
        echo '</div>';
    };
    $star = $isEdit ? '<span class="required-asterisk">*</span>' : '<span class="requi">*</span>';
@endphp

<div class="js-life-proposed-section row w-100 m-0">
    @php $open(); @endphp
        <label @if($labelClass) class="{{ $labelClass }}" @endif>Life Proposed Full Name {!! $star !!}</label>
        <input type="text" name="life_proposed_name" value="{{ $val('name') }}" class="{{ $inputClass }}">
    @php $close(); @endphp

    @php $open(); @endphp
        <label @if($labelClass) class="{{ $labelClass }}" @endif>Mobile Number Personal {!! $star !!}</label>
        <input type="text" name="life_proposed_mobile" value="{{ $val('mobile') }}" class="{{ $inputClass }} jbl-mobile-format" placeholder="0321-6905568">
    @php $close(); @endphp

    @php $open(); @endphp
        <label @if($labelClass) class="{{ $labelClass }}" @endif>
            <span class="js-life-proposed-id-label">CNIC / B-Form No</span> {!! $star !!}
        </label>
        <input type="text" name="life_proposed_cnic" id="life_proposed_cnic" value="{{ $val('cnic') }}" class="{{ $inputClass }}">
    @php $close(); @endphp

    @php $open('js-life-proposed-cnic-date'); @endphp
        <label @if($labelClass) class="{{ $labelClass }}" @endif>CNIC Issue Date {!! $star !!}</label>
        <input type="date" name="life_proposed_cnic_issue_date" value="{{ $val('cnic_issue_date') }}" class="{{ $inputClass }}">
    @php $close(); @endphp

    @php $open('js-life-proposed-cnic-date'); @endphp
        <label @if($labelClass) class="{{ $labelClass }}" @endif>CNIC Expiry Date {!! $star !!}</label>
        <input type="date" name="life_proposed_cnic_expiry_date" value="{{ $val('cnic_expiry_date') }}" class="{{ $inputClass }}">
    @php $close(); @endphp

    @php $open(); @endphp
        <label @if($labelClass) class="{{ $labelClass }}" @endif>Date Of Birth {!! $star !!}</label>
        <input type="date" name="life_proposed_dob" value="{{ $val('dob') }}" class="{{ $inputClass }}">
    @php $close(); @endphp

    @php $open(); @endphp
        <label @if($labelClass) class="{{ $labelClass }}" @endif>Age Nearest Birth-date {!! $star !!}</label>
        <input type="text" name="life_proposed_age" value="{{ $val('age') }}" class="{{ $inputClass }}" readonly>
    @php $close(); @endphp

    @php $open(); @endphp
        <label @if($labelClass) class="{{ $labelClass }}" @endif>Gender/Sex {!! $star !!}</label>
        <select name="life_proposed_gender" class="{{ $selectClass }} js-lp-gender">
            <option value="">Select Gender</option>
            @foreach(['Male','Female','Other'] as $g)
                <option value="{{ $g }}" @selected($val('gender') == $g)>{{ $g }}</option>
            @endforeach
        </select>
    @php $close(); @endphp

    @php $open(); @endphp
        <label @if($labelClass) class="{{ $labelClass }}" @endif>Marital Status {!! $star !!}</label>
        <select name="life_proposed_marital_status" class="{{ $selectClass }} js-lp-marital">
            <option value="">Select Marital Status</option>
            @foreach(['Married','Unmarried'] as $ms)
                <option value="{{ $ms }}" @selected($val('marital_status') == $ms)>{{ $ms }}</option>
            @endforeach
        </select>
    @php $close(); @endphp

    @php $open('js-lp-wife-wrap'); @endphp
        <label @if($labelClass) class="{{ $labelClass }}" @endif>Wife Name {!! $star !!}</label>
        <input type="text" name="life_proposed_wife_name" value="{{ $val('wife_name') }}" class="{{ $inputClass }}">
    @php $close(); @endphp

    @php $open('js-lp-husband-wrap'); @endphp
        <label @if($labelClass) class="{{ $labelClass }}" @endif>Husband Name {!! $star !!}</label>
        <input type="text" name="life_proposed_husband_name" value="{{ $val('husband_name') }}" class="{{ $inputClass }}">
    @php $close(); @endphp

    @php $open(); @endphp
        <label @if($labelClass) class="{{ $labelClass }}" @endif>Mother Maiden Name {!! $star !!}</label>
        <input type="text" name="life_proposed_mother_maiden_name" value="{{ $val('mother_maiden_name') }}" class="{{ $inputClass }}">
    @php $close(); @endphp

    @php $open(); @endphp
        <label @if($labelClass) class="{{ $labelClass }}" @endif>Father’s Name {!! $star !!}</label>
        <input type="text" name="life_proposed_father_name" value="{{ $val('father_name') }}" class="{{ $inputClass }}">
    @php $close(); @endphp

    @php $open(); @endphp
        <label @if($labelClass) class="{{ $labelClass }}" @endif>Religion {!! $star !!}</label>
        <input type="text" name="life_proposed_religion" value="{{ $val('religion') }}" class="{{ $inputClass }}">
    @php $close(); @endphp

    @php $open(); @endphp
        <label @if($labelClass) class="{{ $labelClass }}" @endif>Email Address {!! $star !!}</label>
        <input type="email" name="life_proposed_email" value="{{ $val('email') }}" class="{{ $inputClass }}">
    @php $close(); @endphp

    @php $open(); @endphp
        <label @if($labelClass) class="{{ $labelClass }}" @endif>Phone Number Office</label>
        <input type="text" name="life_proposed_phone_office" value="{{ $val('phone_office') }}" class="{{ $inputClass }}">
    @php $close(); @endphp

    @php $open(); @endphp
        <label @if($labelClass) class="{{ $labelClass }}" @endif>Phone Number Residential</label>
        <input type="text" name="life_proposed_phone_residential" value="{{ $val('phone_residential') }}" class="{{ $inputClass }}">
    @php $close(); @endphp

    @php $open(); @endphp
        <label @if($labelClass) class="{{ $labelClass }}" @endif>Is Client Dual National? {!! $star !!}</label>
        <select name="life_proposed_is_client_dual_national" class="{{ $selectClass }}">
            <option value="">Select Option</option>
            <option value="Yes" @selected($val('is_client_dual_national') == 'Yes')>Yes</option>
            <option value="No" @selected($val('is_client_dual_national') == 'No')>No</option>
        </select>
    @php $close(); @endphp

    @php $open(); @endphp
        @include('frontend.partials.country_select', [
            'countries' => $countries ?? collect(),
            'fieldName' => 'life_proposed_primary_nationality_country_id',
            'countrySelectId' => 'life_proposed_primary_nationality_country_id',
            'selectedCountryId' => $val('primary_nationality_country_id'),
            'selectedCountryName' => $val('primary_nationality'),
            'selectedNameField' => 'life_proposed_primary_nationality',
            'countryRequired' => false,
            'countrySelectClass' => $inputClass,
            'countryLabel' => 'Primary Nationality (قومیت)',
            'countryLabelClass' => $labelClass,
        ])
    @php $close(); @endphp

    @php $open(); @endphp
        @include('frontend.partials.country_select', [
            'countries' => $countries ?? collect(),
            'fieldName' => 'life_proposed_dual_nationality_country_id',
            'countrySelectId' => 'life_proposed_dual_nationality_country_id',
            'selectedCountryId' => $val('dual_nationality_country_id'),
            'selectedCountryName' => $val('dual_nationality_country'),
            'selectedNameField' => 'life_proposed_dual_nationality_country',
            'countryRequired' => false,
            'countrySelectClass' => $inputClass,
            'countryLabel' => 'Dual Nationality Country',
            'countryLabelClass' => $labelClass,
        ])
    @php $close(); @endphp

    @php $open(); @endphp
        <label @if($labelClass) class="{{ $labelClass }}" @endif>Tax/TIN Number {!! $star !!}</label>
        <input type="text" name="life_proposed_dual_tax_tin_number" value="{{ $val('dual_tax_tin_number') }}" class="{{ $inputClass }}">
    @php $close(); @endphp

    @php $open(); @endphp
        <label @if($labelClass) class="{{ $labelClass }}" @endif>Mobile Number {!! $star !!}</label>
        <input type="text" name="life_proposed_dual_mobile_number" value="{{ $val('dual_mobile_number') }}" class="{{ $inputClass }}">
    @php $close(); @endphp

    @php $open(); @endphp
        <label @if($labelClass) class="{{ $labelClass }}" @endif>Address {!! $star !!}</label>
        <textarea name="life_proposed_dual_address" class="{{ $inputClass }}" rows="2">{{ $val('dual_address') }}</textarea>
    @php $close(); @endphp

    @php $open(); @endphp
        <label @if($labelClass) class="{{ $labelClass }}" @endif>Passport Number {!! $star !!}</label>
        <input type="text" name="life_proposed_dual_passport_number" value="{{ $val('dual_passport_number') }}" class="{{ $inputClass }}">
    @php $close(); @endphp

    @php $open(); @endphp
        @include('frontend.partials.birth_place_select', [
            'cities' => $cities ?? collect(),
            'birthPlaceFieldName' => 'life_proposed_birth_place_city_id',
            'birthPlaceSelectId' => 'life_proposed_birth_place_city_id',
            'selectedBirthCityId' => $val('birth_place_city_id'),
            'birthPlaceRequired' => true,
            'birthPlaceClass' => $isEdit ? 'form-select birth-place-city-select' : $inputClass.' birth-place-city-select',
            'birthPlaceLabel' => 'Birth Place (مقامِ پیدائش)',
            'birthPlaceLabelClass' => $labelClass,
        ])
    @php $close(); @endphp

    @php $open(); @endphp
        <label @if($labelClass) class="{{ $labelClass }}" @endif>Relationship with Proposer {!! $star !!}</label>
        <input type="text" name="life_proposed_relationship" value="{{ $val('relationship') }}" class="{{ $inputClass }}">
    @php $close(); @endphp
</div>

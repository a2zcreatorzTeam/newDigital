<div id="nav-Personal_Details" role="tabpanel" aria-labelledby="nav-Personal_Details-tab" class="tab-pane fade active show">
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-center flex-wrap">
                <h3 class="ib-form-subheading mb-0">Address Details (پتے کی تفصیلات)</h3>
            </div>

            <!-- Permanent Address -->
            <div class="col-12">
                <div class="address-section-card">
                    <div class="address-section-card__header">
                        <h5 class="ib-form-subheading-second address-section-card__title">Permanent Address (مستقل پتہ)</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-4 px-0 px-sm-3">
                            <label>{{ policy_label('province') }}<span class="requi">*</span></label>
                            <select name="permanent_province_id" id="permanent_province_id" required class="form-control jbl-dynamic-input permanent-address-field">
                                <option value="">Select Province</option>
                                @foreach ($provinces as $item)
                                <option value="{{ $item->id }}" {{ ($user->AddressInfo->permanent_province_id ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 px-0 px-sm-3">
                            <label>{{ policy_label('city') }}<span class="requi">*</span></label>
                            <select name="permanent_city_id" id="permanent_city_id" required class="form-control jbl-dynamic-input permanent-address-field">
                                <option value="">Select City</option>
                            </select>
                        </div>

                        <div class="col-md-4 px-0 px-sm-3">
                            <label>{{ policy_label('district') }}<span class="requi">*</span></label>
                            <select name="permanent_district_id" id="permanent_district_id" required class="form-control jbl-dynamic-input permanent-address-field">
                                <option value="">Select District</option>
                            </select>
                        </div>

                        <div class="col-md-12 px-0 px-sm-3">
                            <label>{{ policy_label('address_line') }}<span class="requi">*</span></label>
                            <input type="text" name="permanent_address" id="permanent_address" required class="form-control jbl-dynamic-input permanent-address-field"
                                value="{{$user->AddressInfo->permanent_address ?? ''}}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Correspondence Address -->
            <div class="col-12">
                <div class="address-section-card">
                    <div class="address-section-card__header">
                        <h5 class="ib-form-subheading-second address-section-card__title">Correspondence Address (رابطے کا پتہ)</h5>
                        <button type="button" id="copyPermanentToCorresBtn" class="btn btn-primary btn-sm copy-permanent-address-btn" disabled>
                            Use Permanent Address
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-4 px-0 px-sm-3">
                            <label>{{ policy_label('province') }}<span class="requi">*</span></label>
                            <select name="corres_province_id" required id="corres_province_id" class="form-control jbl-dynamic-input dependent-address-field">
                                <option value="">Select Province</option>
                                @foreach ($provinces as $item)
                                <option value="{{ $item->id }}" {{ ($user->AddressInfo->corres_province_id ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 px-0 px-sm-3">
                            <label>{{ policy_label('city') }}<span class="requi">*</span></label>
                            <select name="corres_city_id" id="corres_city_id" required class="form-control jbl-dynamic-input dependent-address-field">
                                <option value="">Select City</option>
                            </select>
                        </div>

                        <div class="col-md-4 px-0 px-sm-3">
                            <label>{{ policy_label('district') }}<span class="requi">*</span></label>
                            <select name="corres_district_id" id="corres_district_id" required class="form-control jbl-dynamic-input dependent-address-field">
                                <option value="">Select District</option>
                            </select>
                        </div>

                        <div class="col-md-12 px-0 px-sm-3">
                            <label>{{ policy_label('address_line') }}<span class="requi">*</span></label>
                            <input type="text" name="corres_address" id="corres_address" required class="form-control jbl-dynamic-input dependent-address-field"
                                value="{{$user->AddressInfo->corres_address ?? ''}}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Temporary Address -->
            <div class="col-12">
                <div class="address-section-card">
                    <div class="address-section-card__header">
                        <h5 class="ib-form-subheading-second address-section-card__title">Temporary Address (عارضی پتہ)</h5>
                        <button type="button" id="copyPermanentToTempBtn" class="btn btn-primary btn-sm copy-permanent-address-btn" disabled>
                            Use Permanent Address
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-4 px-0 px-sm-3">
                            <label>{{ policy_label('province') }}<span class="requi">*</span></label>
                            <select name="temp_province_id" id="temp_province_id" required class="form-control jbl-dynamic-input dependent-address-field">
                                <option value="">Select Province</option>
                                @foreach ($provinces as $item)
                                <option value="{{ $item->id }}" {{ ($user->AddressInfo->temp_province_id ?? '') == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 px-0 px-sm-3">
                            <label>{{ policy_label('city') }}<span class="requi">*</span></label>
                            <select name="temp_city_id" id="temp_city_id" required class="form-control jbl-dynamic-input dependent-address-field">
                                <option value="">Select City</option>
                            </select>
                        </div>

                        <div class="col-md-4 px-0 px-sm-3">
                            <label>{{ policy_label('district') }}<span class="requi">*</span></label>
                            <select name="temp_district_id" id="temp_district_id" required class="form-control jbl-dynamic-input dependent-address-field">
                                <option value="">Select District</option>
                            </select>
                        </div>

                        <div class="col-md-12 px-0 px-sm-3">
                            <label>{{ policy_label('address_line') }}<span class="requi">*</span></label>
                            <input type="text" name="temp_address" id="temp_address" required class="form-control jbl-dynamic-input dependent-address-field"
                                value="{{$user->AddressInfo->temp_address ?? ''}}">
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-12 d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-primary ib-next-btn">Next</button>
        </div>
    </div>
</div>



<style>
    .copy-permanent-address-btn {
        white-space: nowrap;
        margin: 0;
        flex-shrink: 0;
    }

    .dependent-address-field:disabled {
        background-color: #e9ecef;
        cursor: not-allowed;
        opacity: 0.75;
    }

    .address-section-card {
        border: 2px solid #cfd6e1;
        border-radius: 8px;
        background: #fff;
        padding: 1rem 1rem 0.5rem;
        margin: 0.85rem 0 1.15rem;
        box-shadow: 0 1px 2px rgba(31, 45, 61, 0.03);
    }

    .address-section-card__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-bottom: 0.85rem;
        padding-bottom: 0.55rem;
        border-bottom: 1px solid #eef1f5;
    }

    .address-section-card__title {
        margin: 0 !important;
        padding-bottom: 0;
        border-bottom: 0;
        font-weight: 600;
        font-size: 1.05rem !important;
        color: #363232;
        line-height: 1.4;
    }

    @media (max-width: 575.98px) {
        .address-section-card {
            padding: 0.85rem 0.75rem 0.35rem;
            margin: 0.7rem 0 1rem;
        }

        .address-section-card__header {
            align-items: flex-start;
        }
    }
</style>

@push('js')
<script>
    let permanentProvince = "{{ $user->AddressInfo->permanent_province_id ?? '' }}";
    let permanentCity = "{{ $user->AddressInfo->permanent_city_id ?? '' }}";
    let permanentDistrict = "{{ $user->AddressInfo->permanent_district_id ?? '' }}";

    let corresProvince = "{{ $user->AddressInfo->corres_province_id ?? '' }}";
    let corresCity = "{{ $user->AddressInfo->corres_city_id ?? '' }}";
    let corresDistrict = "{{ $user->AddressInfo->corres_district_id ?? '' }}";

    let tempProvince = "{{ $user->AddressInfo->temp_province_id ?? '' }}";
    let tempCity = "{{ $user->AddressInfo->temp_city_id ?? '' }}";
    let tempDistrict = "{{ $user->AddressInfo->temp_district_id ?? '' }}";

    function isPermanentAddressComplete() {
        let province = $('#permanent_province_id').val();
        let city = $('#permanent_city_id').val();
        let district = $('#permanent_district_id').val();
        let address = ($('#permanent_address').val() || '').trim();

        return !!(province && city && district && address);
    }

    // Enable/disable per-section copy buttons when permanent address is complete
    function updateCopyPermanentAddressButton() {
        let ready = isPermanentAddressComplete();
        $('#copyPermanentToCorresBtn, #copyPermanentToTempBtn').prop('disabled', !ready);
    }

    // Task 2: lock correspondence & temporary until permanent is complete
    function updateDependentAddressLock() {
        let unlocked = isPermanentAddressComplete();
        $('.dependent-address-field').prop('disabled', !unlocked);
    }

    function refreshAddressUiState() {
        updateCopyPermanentAddressButton();
        updateDependentAddressLock();
    }

    function copyAddressToTarget(targetPrefix, addressFieldId) {
        let province = $('#permanent_province_id').val();
        let city = $('#permanent_city_id').val();
        let district = $('#permanent_district_id').val();
        let address = $('#permanent_address').val();

        $('#' + targetPrefix + '_province_id').val(province);
        $('#' + addressFieldId).val(address);

        loadCities(province, '#' + targetPrefix + '_city_id', city, function() {
            loadDistricts(city, '#' + targetPrefix + '_district_id', district);
        });
    }

    function applyPermanentAddressTo(targetPrefix, addressFieldId, successText) {
        if (!isPermanentAddressComplete()) {
            Swal.fire('Info', 'Please complete all Permanent Address fields first.', 'info');
            return;
        }

        // Ensure targets are editable before writing values
        $('.dependent-address-field').prop('disabled', false);
        copyAddressToTarget(targetPrefix, addressFieldId);
        refreshAddressUiState();

        Swal.fire({
            title: 'Copied!',
            text: successText,
            icon: 'success',
            timer: 1800,
            showConfirmButton: false
        });
    }

    function loadCities(provinceId, citySelector, selectedCity = null, callback = null) {
        if (!provinceId) return;

        $.ajax({
            method: 'POST',
            url: '{{ route("frontend.getcityData") }}',
            data: {
                province_id: provinceId,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                let cityDropdown = $(citySelector);
                cityDropdown.html('<option value="">Select City</option>');

                $.each(res, function(i, city) {
                    let selected = (selectedCity == city.id) ? 'selected' : '';
                    cityDropdown.append(`<option value="${city.id}" ${selected}>${city.name}</option>`);
                });

                if (callback) callback();
            }
        });
    }

    function loadDistricts(cityId, districtSelector, selectedDistrict = null, callback = null) {
        if (!cityId) return;

        $.ajax({
            method: 'POST',
            url: '{{ route("frontend.getDistrictData") }}',
            data: {
                city_id: cityId,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                let districtDropdown = $(districtSelector);
                districtDropdown.html('<option value="">Select District</option>');

                $.each(res, function(i, d) {
                    let selected = (selectedDistrict == d.id) ? 'selected' : '';
                    districtDropdown.append(`<option value="${d.id}" ${selected}>${d.name}</option>`);
                });

                if (callback) callback();
            }
        });
    }
    // Permanent
    $('#permanent_province_id').change(function() {
        loadCities(this.value, '#permanent_city_id');
        $('#permanent_district_id').html('<option value="">Select District</option>');
        refreshAddressUiState();
    });

    $('#permanent_city_id').change(function() {
        loadDistricts(this.value, '#permanent_district_id', null, refreshAddressUiState);
        refreshAddressUiState();
    });

    $('#permanent_district_id').change(function() {
        refreshAddressUiState();
    });

    $('#permanent_address').on('input change', function() {
        refreshAddressUiState();
    });


    // Correspondence
    $('#corres_province_id').change(function() {
        loadCities(this.value, '#corres_city_id');
    });

    $('#corres_city_id').change(function() {
        loadDistricts(this.value, '#corres_district_id');
    });


    // Temporary
    $('#temp_province_id').change(function() {
        loadCities(this.value, '#temp_city_id');
    });

    $('#temp_city_id').change(function() {
        loadDistricts(this.value, '#temp_district_id');
    });

    // Copy permanent -> correspondence only
    $('#copyPermanentToCorresBtn').on('click', function() {
        applyPermanentAddressTo('corres', 'corres_address', 'Permanent address copied to Correspondence address.');
    });

    // Copy permanent -> temporary only
    $('#copyPermanentToTempBtn').on('click', function() {
        applyPermanentAddressTo('temp', 'temp_address', 'Permanent address copied to Temporary address.');
    });

    // Disabled fields are skipped by FormData — re-enable right before submit
    $(document).on('click', '#user_details_submited', function() {
        $('.dependent-address-field').prop('disabled', false);
    });

    $(document).ready(function() {
        // Lock dependent fields immediately on load (Task 2)
        refreshAddressUiState();

        // PERMANENT
        if (permanentProvince) {
            $('#permanent_province_id').val(permanentProvince);

            loadCities(permanentProvince, '#permanent_city_id', permanentCity, function() {
                loadDistricts(permanentCity, '#permanent_district_id', permanentDistrict, function() {
                    refreshAddressUiState();
                });
            });
        }

        // CORRESPONDENCE
        if (corresProvince) {
            $('#corres_province_id').val(corresProvince);

            loadCities(corresProvince, '#corres_city_id', corresCity, function() {
                loadDistricts(corresCity, '#corres_district_id', corresDistrict, function() {
                    refreshAddressUiState();
                });
            });
        }

        // TEMPORARY
        if (tempProvince) {
            $('#temp_province_id').val(tempProvince);

            loadCities(tempProvince, '#temp_city_id', tempCity, function() {
                loadDistricts(tempCity, '#temp_district_id', tempDistrict, function() {
                    refreshAddressUiState();
                });
            });
        }

    });








    $(document).ready(function() {
        $('#addressForm').on('submit', function(e) {
            e.preventDefault();

            let formData = $(this).serialize();
            let isValid = true;

            // Simple Validation: Check if required fields are empty
            $(this).find('.form-control').each(function() {
                let fieldName = $(this).attr('name');
                let fieldValue = $(this).val().trim();

                // In fields ko skip karna hai (Optional fields)
                let optionalFields = [];

                // Agar field khali hai AUR wo optional list mein NAHI hai
                if (fieldValue === "" && !optionalFields.includes(fieldName)) {
                    $(this).css('border-color', 'red');
                    isValid = false;
                } else {
                    $(this).css('border-color', ''); // Error khatam hone par border normal kar dein
                }
            });

            if (!isValid) {
                Swal.fire('Error', 'Please fill all required fields.', 'error');
                return false;
            }

            // AJAX Call
            $.ajax({
                method: 'POST',
                url: '{{ route("frontend.updateAddressInfo") }}', // Apna sahi route yahan likhein
                data: formData,
                beforeSend: function() {
                    Swal.fire({
                        title: 'Updating...',
                        text: 'Please wait while we save your details',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    Swal.close();

                    if (response.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Profile updated successfully.',
                            icon: 'success',
                            timer: 2000
                        });
                    } else {
                        Swal.fire('Error', response.message || 'Something went wrong', 'error');
                    }
                },
                error: function(xhr) {
                    Swal.close();

                    if (xhr.status === 422) {
                        // Laravel validation errors yahan hote hain: xhr.responseJSON.errors
                        let errors = xhr.responseJSON.errors;
                        let errorString = '';

                        // Saare errors ko ek string mein jama karein
                        $.each(errors, function(key, value) {
                            errorString += value[0] + '<br>'; // value[0] mein actual message hota hai

                            // Optional: Field ka border red karne ke liye
                            $('[name="' + key + '"]').css('border-color', 'red');
                        });

                        Swal.fire({
                            title: 'Validation Error',
                            html: errorString, // html property use karein taake <br> kaam kare
                            icon: 'error'
                        });
                    } else {
                        Swal.fire('Error', 'Something went wrong on the server.', 'error');
                    }
                }
            });
        });

        $('input[name="cnic_number"]').on('input', function() {
            let val = $(this).val().replace(/\D/g, ''); // Sirf digits rakho
            let newVal = '';

            if (val.length > 0) {
                newVal += val.substr(0, 5);
            }
            if (val.length > 5) {
                newVal += '-' + val.substr(5, 7);
            }
            if (val.length > 12) {
                newVal += '-' + val.substr(12, 1);
            }

            $(this).val(newVal.substring(0, 15)); // Max length 15 characters
        });


        $('input[name="mobile_number"]').on('input', function() {
            // Sirf digits allow karein
            let val = $(this).val().replace(/\D/g, '');
            let newVal = '';

            if (val.length > 0) {
                // Pehle 4 digits (e.g., 0321)
                newVal += val.substr(0, 4);
            }
            if (val.length > 4) {
                // Phir dash aur baki ke 7 digits
                newVal += '-' + val.substr(4, 7);
            }

            // Final value set karein (Total length 12: 4 digits + 1 dash + 7 digits)
            $(this).val(newVal.substring(0, 12));
        });

        //   for permannet

        $('#permanent_province_id').change(function() {
            var province_id = $(this).val();
            if (!province_id) return;
            let cityDropdown = $('#permanent_city_id');
            $.ajax({
                method: 'POST',
                url: '{{ route("frontend.getcityData") }}',
                data: {
                    province_id: province_id,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    cityDropdown.empty();
                    cityDropdown.append('<option value="">Loading .....</option>');
                },
                success: function(response) {

                    cityDropdown.empty(); // clear loading

                    cityDropdown.append('<option value="">Select City</option>');

                    $.each(response, function(index, city) {
                        cityDropdown.append(
                            `<option value="${city.id}">${city.name}</option>`
                        );
                    });
                    refreshAddressUiState();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorString = '';

                        $.each(errors, function(key, value) {
                            errorString += value[0] + '<br>';
                            $('[name="' + key + '"]').css('border-color', 'red');
                        });

                        Swal.fire({
                            title: 'Validation Error',
                            html: errorString,
                            icon: 'error'
                        });
                    } else {
                        Swal.fire('Error', 'Something went wrong on the server.', 'error');
                    }
                }
            });
        });
        $('#permanent_city_id').change(function() {
            var city_id = $(this).val();
            if (!city_id) return;
            let DistrictDropdown = $('#permanent_district_id');
            $.ajax({
                method: 'POST',
                url: '{{ route("frontend.getDistrictData") }}',
                data: {
                    city_id: city_id,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    DistrictDropdown.empty();
                    DistrictDropdown.append('<option value="">Loading .....</option>');
                },
                success: function(response) {
                    DistrictDropdown.empty(); // clear loading
                    DistrictDropdown.append('<option value="">Select District</option>');
                    $.each(response, function(index, city) {
                        DistrictDropdown.append(
                            `<option value="${city.id}">${city.name}</option>`
                        );
                    });
                    refreshAddressUiState();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorString = '';

                        $.each(errors, function(key, value) {
                            errorString += value[0] + '<br>';
                            $('[name="' + key + '"]').css('border-color', 'red');
                        });

                        Swal.fire({
                            title: 'Validation Error',
                            html: errorString,
                            icon: 'error'
                        });
                    } else {
                        Swal.fire('Error', 'Something went wrong on the server.', 'error');
                    }
                }
            });
        });

        // for corres

        $('#corres_province_id').change(function() {
            var province_id = $(this).val();
            if (!province_id) return;
            let cityDropdown = $('#corres_city_id');
            $.ajax({
                method: 'POST',
                url: '{{ route("frontend.getcityData") }}',
                data: {
                    province_id: province_id,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    cityDropdown.empty();
                    cityDropdown.append('<option value="">Loading .....</option>');
                },
                success: function(response) {

                    cityDropdown.empty(); // clear loading

                    cityDropdown.append('<option value="">Select City</option>');

                    $.each(response, function(index, city) {
                        cityDropdown.append(
                            `<option value="${city.id}">${city.name}</option>`
                        );
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorString = '';

                        $.each(errors, function(key, value) {
                            errorString += value[0] + '<br>';
                            $('[name="' + key + '"]').css('border-color', 'red');
                        });

                        Swal.fire({
                            title: 'Validation Error',
                            html: errorString,
                            icon: 'error'
                        });
                    } else {
                        Swal.fire('Error', 'Something went wrong on the server.', 'error');
                    }
                }
            });
        });
        $('#corres_city_id').change(function() {
            var city_id = $(this).val();
            if (!city_id) return;
            let DistrictDropdown = $('#corres_district_id');
            $.ajax({
                method: 'POST',
                url: '{{ route("frontend.getDistrictData") }}',
                data: {
                    city_id: city_id,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    DistrictDropdown.empty();
                    DistrictDropdown.append('<option value="">Loading .....</option>');
                },
                success: function(response) {
                    DistrictDropdown.empty(); // clear loading
                    DistrictDropdown.append('<option value="">Select City</option>');
                    $.each(response, function(index, city) {
                        DistrictDropdown.append(
                            `<option value="${city.id}">${city.name}</option>`
                        );
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorString = '';

                        $.each(errors, function(key, value) {
                            errorString += value[0] + '<br>';
                            $('[name="' + key + '"]').css('border-color', 'red');
                        });

                        Swal.fire({
                            title: 'Validation Error',
                            html: errorString,
                            icon: 'error'
                        });
                    } else {
                        Swal.fire('Error', 'Something went wrong on the server.', 'error');
                    }
                }
            });
        });

        // for temp

        $('#temp_province_id').change(function() {
            var province_id = $(this).val();
            if (!province_id) return;
            let cityDropdown = $('#temp_city_id');
            $.ajax({
                method: 'POST',
                url: '{{ route("frontend.getcityData") }}',
                data: {
                    province_id: province_id,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    cityDropdown.empty();
                    cityDropdown.append('<option value="">Loading .....</option>');
                },
                success: function(response) {

                    cityDropdown.empty(); // clear loading

                    cityDropdown.append('<option value="">Select City</option>');

                    $.each(response, function(index, city) {
                        cityDropdown.append(
                            `<option value="${city.id}">${city.name}</option>`
                        );
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorString = '';

                        $.each(errors, function(key, value) {
                            errorString += value[0] + '<br>';
                            $('[name="' + key + '"]').css('border-color', 'red');
                        });

                        Swal.fire({
                            title: 'Validation Error',
                            html: errorString,
                            icon: 'error'
                        });
                    } else {
                        Swal.fire('Error', 'Something went wrong on the server.', 'error');
                    }
                }
            });
        });
        $('#temp_city_id').change(function() {
            var city_id = $(this).val();
            if (!city_id) return;
            let DistrictDropdown = $('#temp_district_id');
            $.ajax({
                method: 'POST',
                url: '{{ route("frontend.getDistrictData") }}',
                data: {
                    city_id: city_id,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    DistrictDropdown.empty();
                    DistrictDropdown.append('<option value="">Loading .....</option>');
                },
                success: function(response) {
                    DistrictDropdown.empty(); // clear loading
                    DistrictDropdown.append('<option value="">Select City</option>');
                    $.each(response, function(index, city) {
                        DistrictDropdown.append(
                            `<option value="${city.id}">${city.name}</option>`
                        );
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorString = '';

                        $.each(errors, function(key, value) {
                            errorString += value[0] + '<br>';
                            $('[name="' + key + '"]').css('border-color', 'red');
                        });

                        Swal.fire({
                            title: 'Validation Error',
                            html: errorString,
                            icon: 'error'
                        });
                    } else {
                        Swal.fire('Error', 'Something went wrong on the server.', 'error');
                    }
                }
            });
        });


    });
</script>
@endpush
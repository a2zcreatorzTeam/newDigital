    <form action="#" method="POST" id='addressForm'>
        @csrf
        <h2 class="profile-section-title">Address Information</h2>
        <div class="box-form-login">
            <h5 class="mb-4 text-primary"><i class="fas fa-map-marker-alt"></i> Permanent Address (مستقل پتہ)</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label>Province (صوبہ)<span class="text-danger"> *</span></label>
                        <select name="permanent_province_id" id="permanent_province_id" class="form-control">
                            <option>Select Provinces</option>
                            @foreach ($provinces as $item)
                            <option value="{{ $item->id }}" {{ ($user->AddressInfo->permanent_province_id ?? '') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label>City (شہر)<span class="text-danger"> *</span></label>
                        <select name="permanent_city_id" id="permanent_city_id" class="form-control">
                            <option>Select City</option>
                        </select>

                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label>District (ضلع)<span class="text-danger"> *</span></label>
                        <select name="permanent_district_id" id="permanent_district_id" class="form-control">
                            <option>Select District</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="form-group">
                        <label>Address Line (مکمل پتہ)<span class="text-danger"> *</span></label>
                        <input type="text" value="{{$user->AddressInfo->permanent_address ?? ''}}" class="form-control" name="permanent_address">
                    </div>
                </div>
            </div>
            <h5 class="mb-4 text-primary"><i class="fas fa-map-marker-alt"></i> Correspondence Address (رابطے کا پتہ)</h5>
            <div class="row">

                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label>Province (صوبہ)<span class="text-danger"> *</span></label>
                        <select name="corres_province_id" id="corres_province_id" class="form-control">
                            <option>Select Provinces</option>
                            @foreach ($provinces as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label>City (شہر)<span class="text-danger"> *</span></label>
                        <select name="corres_city_id" id="corres_city_id" class="form-control">
                            <option>Select City</option>
                        </select>

                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label>District (ضلع)<span class="text-danger"> *</span></label>
                        <select name="corres_district_id" id="corres_district_id" class="form-control">
                            <option>Select District</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="form-group">
                        <label>Address Line (مکمل پتہ)<span class="text-danger"> *</span></label>
                        <input type="text" value="{{$user->AddressInfo->corres_address ?? ''}}" class="form-control" name="corres_address">
                    </div>
                </div>



            </div>
            <h5 class="mb-4 text-primary"><i class="fas fa-map-marker-alt"></i> Temporary Address (عارضی پتہ)</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label>Province (صوبہ)<span class="text-danger"> *</span></label>
                        <select name="temp_province_id" id="temp_province_id" class="form-control">
                            <option>Select Provinces</option>
                            @foreach ($provinces as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label>City (شہر)<span class="text-danger"> *</span></label>
                        <select name="temp_city_id" id="temp_city_id" class="form-control">
                            <option>Select City</option>
                        </select>

                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label>District (ضلع)<span class="text-danger"> *</span></label>
                        <select name="temp_district_id" id="temp_district_id" class="form-control">
                            <option>Select District</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="form-group">
                        <label>Address Line (مکمل پتہ)<span class="text-danger"> *</span></label>
                        <input type="text" class="form-control" value="{{$user->AddressInfo->temp_address ?? ''}}" name="temp_address">
                    </div>
                </div>
            </div>

            <div class="update-btn-container">
                <button type="submit" class="btn-update">Update Addresses</button>
            </div>
        </div>
    </form>

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

        function loadDistricts(cityId, districtSelector, selectedDistrict = null) {
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
                }
            });
        }
        // Permanent
        $('#permanent_province_id').change(function() {
            loadCities(this.value, '#permanent_city_id');
        });

        $('#permanent_city_id').change(function() {
            loadDistricts(this.value, '#permanent_district_id');
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



        $(document).ready(function() {

            // PERMANENT
            if (permanentProvince) {
                $('#permanent_province_id').val(permanentProvince);

                loadCities(permanentProvince, '#permanent_city_id', permanentCity, function() {
                    loadDistricts(permanentCity, '#permanent_district_id', permanentDistrict);
                });
            }

            // CORRESPONDENCE
            if (corresProvince) {
                $('#corres_province_id').val(corresProvince);

                loadCities(corresProvince, '#corres_city_id', corresCity, function() {
                    loadDistricts(corresCity, '#corres_district_id', corresDistrict);
                });
            }

            // TEMPORARY
            if (tempProvince) {
                $('#temp_province_id').val(tempProvince);

                loadCities(tempProvince, '#temp_city_id', tempCity, function() {
                    loadDistricts(tempCity, '#temp_district_id', tempDistrict);
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
                        console.log(response);

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


            // Jab Date of Birth change ho
            $('input[name="date_of_birth"]').on('change', function() {
                let dobValue = $(this).val();

                if (dobValue) {
                    let dob = new Date(dobValue);
                    let today = new Date();

                    // Age calculate karein
                    let age = today.getFullYear() - dob.getFullYear();
                    let monthDiff = today.getMonth() - dob.getMonth();
                    let dayDiff = today.getDate() - dob.getDate();

                    // Agar birthday is saal abhi tak nahi aaya, to ek saal kam karein
                    if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
                        age--;
                    }

                    // "Nearest Birthday" ka logic (Pakistan Insurance standard):
                    // Agar agle birthday mein 6 mahine se kam rehte hain, to age + 1 kar dete hain
                    let nextBirthday = new Date(dob);
                    nextBirthday.setFullYear(today.getFullYear());

                    // Agar birthday guzar gaya hai to agle saal ka set karein
                    if (today > nextBirthday) {
                        nextBirthday.setFullYear(today.getFullYear() + 1);
                    }

                    let diffTime = Math.abs(nextBirthday - today);
                    let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                    // Insurance rules ke mutabiq: agar 6 mahine (182 days) se kam rehte hain agle bday mein
                    if (diffDays <= 182) {
                        age++;
                    }

                    // Age field mein value set karein
                    $('input[name="age_nearest_date"]').val(age);
                }
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
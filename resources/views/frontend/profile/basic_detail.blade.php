<form action="#" method="POST" id="basicDetailsForm">
    @csrf

    <h2 class="profile-section-title">Basic Details</h2>
    <div class="box-form-login">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="">Life Proposed Full Name (بیمہ زندگی کے لئے مجوزہ کا پورا نام)<span class="text-danger"> *</span></label>
                    <input type="text" value="{{ old('life_proposed_full_name', $user->basicDetail?->life_proposed_full_name ?: ($user->name ?? '')) }}" name="life_proposed_full_name" class="form-control account" required>
                    @error('life_proposed_full_name')
                    <div class="invalid-feedback" style="display: block;">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Mobile Number Personal (ذاتی موبائل نمبر)<span class="text-danger"> *</span></label>
                    <input type="text" value="{{ old('mobile_number', $user->basicDetail?->mobile_number ?: ($user->phone_no ?? '')) }}" name="mobile_number" class="form-control account" placeholder="0322-9847785" required>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="">CNIC / B-FORM NO (قومی شناختی کارڈ نمبر)<span class="text-danger"> *</span></label>
                    <input type="text" required name="cnic_number" value="{{ old('cnic_number', $user->basicDetail?->cnic_number ?: ($user->cnic ?? '')) }}" class="form-control account">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Cnic Issue Date (شناختی کارڈ جاری کرنے کی تاریخ)<span class="text-danger"> *</span></label>
                    <input type="date"
                        value="{{$user->basicDetail->cnic_issue_date ?? ''}}"
                        name="cnic_issue_date" required
                        class="form-control account">
                </div>

            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Cnic Expiry Date (شناختی کارڈ کی میعاد ختم ہونے کی تاریخ)<span class="text-danger"> *</span></label>
                    <input type="date" required name="cnic_expiry_date" value="{{$user->basicDetail->cnic_expiry_date ?? ''}}" class="form-control account">
                </div>

            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="">Date Of Birth (تاریخِ پیدائش)<span class="text-danger"> *</span></label>
                    <input type="date" name="date_of_birth" class="form-control account" value="{{$user->basicDetail->date_of_birth ?? ''}}" required max="{{ now('Asia/Karachi')->subYears(18)->toDateString() }}">
                </div>

            </div>

            <div class="col-6">
                <div class="form-group">
                    @php
                        $selectedBirthCityId = old(
                            'birth_place_city_id',
                            $user->basicDetail->birth_place_city_id
                                ?? optional(($cities ?? collect())->first(
                                    fn ($c) => strcasecmp($c->name, (string) ($user->basicDetail->birth_placed ?? '')) === 0
                                ))->id
                        );
                    @endphp
                    @include('frontend.partials.birth_place_select', [
                        'cities' => $cities ?? collect(),
                        'selectedBirthCityId' => $selectedBirthCityId,
                        'birthPlaceRequired' => true,
                        'birthPlaceClass' => 'form-control account',
                        'birthPlaceLabel' => 'Place of Birth (مقامِ پیدائش)',
                    ])
                </div>
            </div>


            <!-- Age -->
            <div class="col-6">
                <div class="form-group">
                    <label>Age Nearest Birth-date (عمر)<span class="text-danger"> *</span></label>
                    <input type="text" required id="age_birth" value="{{$user->basicDetail->age_nearest_date ?? ''}}" readonly name="age_nearest_date" class="form-control account">
                </div>
            </div>

            <!-- Gender -->
            <div class="col-6">
                <div class="form-group">
                    <label>Gender/Sex (جنس)<span class="text-danger"> *</span></label>
                    <select name='gender' id="gender" class="form-control" required>
                        <option value="">Select Gender</option>
                        <option value="Male" {{ ($user->basicDetail->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ ($user->basicDetail->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ ($user->basicDetail->gender ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>

            <!-- Marital Status -->
            <div class="col-6">
                <div class="form-group">
                    <label>Marital Status (ازدواجی حیثیت)<span class="text-danger"> *</span></label>
                    <select name="marital_status" id="marital_status" class="form-control" required>
                        <option value="">Select Marital Status</option>
                        <option value="Married" {{ ($user->basicDetail->marital_status ?? '') == 'Married' ? 'selected' : '' }}>Married</option>
                        <option value="Unmarried" {{ ($user->basicDetail->marital_status ?? '') == 'Unmarried' ? 'selected' : '' }}>Unmarried</option>
                    </select>
                </div>
            </div>

            <!-- Wife Name -->
            <div class="col-6" id="wife_name_wrap" style="display: none;">
                <div class="form-group">
                    <label>Wife Name of Life Proposed (بیمہ کنندہ کی بیوی کا نام)<span class="text-danger"> *</span></label>
                    <input type="text" id="wife_name" name="wife_name" class="form-control account"
                        value="{{ $user->basicDetail->wife_name ?? '' }}">
                </div>
            </div>

            <!-- Husband Name -->
            <div class="col-6" id="husband_name_wrap" style="display: none;">
                <div class="form-group">
                    <label>Husband Name of Life Proposed (بیمہ کنندہ کے شوہر کا نام)<span class="text-danger"> *</span></label>
                    <input type="text" id="husband_name" name="husband_name" class="form-control account"
                        value="{{ $user->basicDetail->husband_name ?? '' }}">
                </div>
            </div>

            <!-- Mother Maiden Name -->
            <div class="col-6">
                <div class="form-group">
                    <label>Mother Maiden Name (والدہ کا خاندانی نام)<span class="text-danger"> *</span></label>
                    <input required type="text" value="{{ $user->basicDetail->mother_maiden_name ?? '' }}" name='mother_maiden_name' class="form-control account">
                </div>
            </div>

            <!-- Father Name -->
            <div class="col-6">
                <div class="form-group">
                    <label>Father’s Name of Life Proposed (مجوزہ بیمہ کے والد کا نام)<span class="text-danger"> *</span></label>
                    <input required type="text" name='father_name' class="form-control account" value="{{ $user->basicDetail->father_name ?? '' }}">
                </div>
            </div>

            <!-- Religion -->
            <div class="col-6">
                <div class="form-group">
                    <label>Religion (مذہب)<span class="text-danger"> *</span></label>
                    <input type="text" required name='religion' class="form-control account" value="{{ $user->basicDetail->religion ?? '' }}">
                </div>
            </div>

            <!-- Email -->
            <div class="col-6">
                <div class="form-group">
                    <label>Email Address (ای میل ایڈریس)<span class="text-danger"> *</span></label>
                    <input type="email" name="email" class="form-control required account" value="{{ old('email', $user->basicDetail?->email ?: ($user->email ?? '')) }}">
                </div>
            </div>

            <!-- Age Proof -->
            {{-- <div class="col-6">
                <div class="form-group">
                    <label>Age Proof (عمر کا ثبوت)<span class="text-danger"> *</span></label>
                    <input type="text" name='age_proof' required class="form-control account" value="{{ $user->basicDetail->age_proof ?? '' }}">
        </div>
    </div>
    --}}

    <!-- Office Phone -->
    <div class="col-6">
        <div class="form-group">
            <label>Phone Number Office (آفس فون نمبر)</label>
            <input type="text" name='phone_number_office' class="form-control account" value="{{ $user->basicDetail->phone_number_office ?? '' }}">
        </div>
    </div>

    <!-- Residential Phone -->
    <div class="col-6">
        <div class="form-group">
            <label>Phone Number Residential (رہائشی فون نمبر)</label>
            <input type="text" name='phone_number_residente' class="form-control account" value="{{ $user->basicDetail->phone_number_residente ?? '' }}">
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            @include('frontend.partials.country_select', [
                'countries' => $countries ?? collect(),
                'fieldName' => 'country_of_residence_id',
                'countrySelectId' => 'country_of_residence_id',
                'selectedCountryId' => old('country_of_residence_id', $user->basicDetail?->country_of_residence_id ?: ($user->country_of_residence_id ?? null)),
                'countryRequired' => true,
                'countrySelectClass' => 'form-control account',
                'countryLabel' => 'Country of Residence (رہائشی ملک)',
            ])
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label>Current Address (موجودہ پتہ)<span class="text-danger"> *</span></label>
            <textarea name="current_address" class="form-control account" rows="2" required minlength="5">{{ old('current_address', $user->basicDetail?->current_address ?: ($user->current_address ?? '')) }}</textarea>
        </div>
    </div>

    <!-- Dual National -->
    <div class="col-6">
        <div class="form-group">
            <label>Is Client Dual National? (کیا سائل دوہری قومیت رکھتا ہے؟)<span class="text-danger"> *</span></label>
            <select name="is_client_dual_national" required class="form-control" id="is_client_dual_national">
                <option value="">Select Option</option>
                <option value="Yes" {{ ($user->basicDetail->is_client_dual_national ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                <option value="No" {{ ($user->basicDetail->is_client_dual_national ?? '') == 'No' ? 'selected' : '' }}>No</option>
            </select>
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            @include('frontend.partials.country_select', [
                'countries' => $countries ?? collect(),
                'fieldName' => 'primary_nationality_country_id',
                'countrySelectId' => 'primary_nationality_country_id',
                'selectedCountryId' => $user->basicDetail->primary_nationality_country_id ?? null,
                'selectedCountryName' => $user->basicDetail->primary_nationality ?? null,
                'selectedNameField' => 'primary_nationality',
                'countryRequired' => false,
                'countrySelectClass' => 'form-control account',
                'countryLabel' => 'Primary Nationality (قومیت)',
            ])
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            @include('frontend.partials.country_select', [
                'countries' => $countries ?? collect(),
                'fieldName' => 'dual_nationality_country_id',
                'countrySelectId' => 'dual_nationality_country_id',
                'selectedCountryId' => $user->basicDetail->dual_nationality_country_id ?? null,
                'selectedCountryName' => $user->basicDetail->dual_nationality_country ?? null,
                'selectedNameField' => 'dual_nationality_country',
                'countryRequired' => false,
                'countrySelectClass' => 'form-control account',
                'countryLabel' => 'Dual Nationality Country',
            ])
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label>Tax/TIN Number<span class="text-danger"> *</span></label>
            <input type="text" name="dual_tax_tin_number" class="form-control account" value="{{ $user->basicDetail->dual_tax_tin_number ?? '' }}">
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label>Mobile Number<span class="text-danger"> *</span></label>
            <input type="text" name="dual_mobile_number" class="form-control account" value="{{ $user->basicDetail->dual_mobile_number ?? '' }}">
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label>Address<span class="text-danger"> *</span></label>
            <textarea name="dual_address" class="form-control account" rows="2">{{ $user->basicDetail->dual_address ?? '' }}</textarea>
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <label>Passport Number<span class="text-danger"> *</span></label>
            <input type="text" name="dual_passport_number" class="form-control account" value="{{ $user->basicDetail->dual_passport_number ?? '' }}">
        </div>
    </div>

    <!-- ... (Other Basic Fields) ... -->
    </div>
    <div class="update-btn-container">
        <button type="submit" class="btn-update">Update Basic Details</button>
    </div>
    </div>
</form>

@push('js')
<script>
    $(document).ready(function() {
        $('#basicDetailsForm').on('submit', function(e) {
            e.preventDefault();

            let formData = $(this).serialize();
            let isValid = true;

            // Simple Validation: Check if required fields are empty
            $(this).find('.form-control:visible').each(function() {
                if ($(this).prop('disabled')) {
                    return;
                }
                let fieldName = $(this).attr('name');
                let fieldValue = ($(this).val() || '').trim();

                // In fields ko skip karna hai (Optional fields)
                let optionalFields = ['phone_number_office', 'phone_number_residente', 'mother_maiden_name', 'father_name'];

                // Agar field khali hai AUR wo optional list mein NAHI hai
                if (fieldValue === "" && fieldName && !optionalFields.includes(fieldName)) {
                    $(this).css('border-color', 'red');
                    isValid = false;
                } else {
                    $(this).css('border-color', ''); // Error khatam hone par border normal kar dein
                }
            });

            var proposerAge = parseInt($('input[name="age_nearest_date"]').val(), 10);
            if (!isNaN(proposerAge) && proposerAge < 18) {
                $('input[name="age_nearest_date"], input[name="date_of_birth"]').css('border-color', 'red');
                isValid = false;
            }

            function markCountry($select, valid) {
                var $ui = $select.next('.select2-container').find('.select2-selection');
                if (!valid) {
                    isValid = false;
                    if ($ui.length) {
                        $ui.css('border-color', 'red');
                    } else {
                        $select.css('border-color', 'red');
                    }
                } else {
                    $ui.css('border-color', '');
                    $select.css('border-color', '');
                }
            }

            if ($('#is_client_dual_national').val() === 'Yes') {
                markCountry($(this).find('select[name="primary_nationality_country_id"]'), !!$(this).find('select[name="primary_nationality_country_id"]').val());
                markCountry($(this).find('select[name="dual_nationality_country_id"]'), !!$(this).find('select[name="dual_nationality_country_id"]').val());
            }

            markCountry($(this).find('select[name="country_of_residence_id"]'), !!$(this).find('select[name="country_of_residence_id"]').val());

            var currentAddress = ($.trim($(this).find('[name="current_address"]').val() || ''));
            if (currentAddress.length < 5) {
                $(this).find('[name="current_address"]').css('border-color', 'red');
                isValid = false;
            }

            if (!isValid) {
                var proposerAge = parseInt($('input[name="age_nearest_date"]').val(), 10);
                if (!isNaN(proposerAge) && proposerAge < 18) {
                    Swal.fire('Error', 'Proposer must be 18 years or older.', 'error');
                    return;
                }
                Swal.fire('Error', 'Please fill all required fields.', 'error');
                return false;
            }

            // AJAX Call
            $.ajax({
                method: 'POST',
                url: '{{ route("frontend.updateBasicDetails") }}', // Apna sahi route yahan likhein
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

        function toggleSpouseNameFields() {
            let gender = ($('#gender').val() || '').trim();
            let marital = ($('#marital_status').val() || '').trim();

            $('#wife_name_wrap, #husband_name_wrap').hide();
            $('#wife_name, #husband_name').prop('required', false);

            if (marital === 'Married' && gender === 'Male') {
                $('#wife_name_wrap').show();
                $('#wife_name').prop('required', true);
                $('#husband_name').val('');
            } else if (marital === 'Married' && gender === 'Female') {
                $('#husband_name_wrap').show();
                $('#husband_name').prop('required', true);
                $('#wife_name').val('');
            } else if (marital === 'Unmarried') {
                $('#wife_name, #husband_name').val('');
            }
        }

        $('#gender, #marital_status').on('change', toggleSpouseNameFields);
        toggleSpouseNameFields();

    });
</script>
@endpush
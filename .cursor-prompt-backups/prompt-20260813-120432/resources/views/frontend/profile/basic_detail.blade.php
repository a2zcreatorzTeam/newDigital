<form action="#" method="POST" id="basicDetailsForm">
    @csrf

    <h2 class="profile-section-title">Basic Details</h2>
    <div class="box-form-login">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="">Life Proposed Full Name (بیمہ زندگی کے لئے مجوزہ کا پورا نام)<span class="text-danger"> *</span></label>
                    <input type="text" value="{{$user->basicDetail?->life_proposed_full_name ?? ''}}" name="life_proposed_full_name" class="form-control account" required>
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
                    <input type="text" value="{{$user->basicDetail->mobile_number ?? ''}}" name="mobile_number" class="form-control account" placeholder="0322-9847785" required>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="">CNIC / B-FORM NO (قومی شناختی کارڈ نمبر)<span class="text-danger"> *</span></label>
                    <input type="text" required name="cnic_number" value="{{$user->basicDetail->cnic_number ?? ''}}" class="form-control account">
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
                    <input type="date" name="date_of_birth" class="form-control account" value="{{$user->basicDetail->date_of_birth ?? ''}}" required>
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
                    <input type="email" name="email" class="form-control required account" value="{{ $user->basicDetail->email ?? '' }}">
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

    <!-- Dual National -->
    <div class="col-6">
        <div class="form-group">
            <label>Dual National? (کیا سائل ڈوئل قومیت رکھتا ہے؟)<span class="text-danger"> *</span></label>
            <select name="is_client_dual_national" required class="form-control" id="is_client_dual_national">
                <option value="">Select Option</option>
                <option value="Yes" {{ ($user->basicDetail->is_client_dual_national ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                <option value="No" {{ ($user->basicDetail->is_client_dual_national ?? '') == 'No' ? 'selected' : '' }}>No</option>
            </select>

        </div>
    </div>

    {{-- Dual nationality fields are injected dynamically by toggleDualNationalityFields() below --}}
    <div id="dual_natunality_fields" class="row"></div>

    <!-- Birth Place -->
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
                'birthPlaceLabel' => 'Birth Place (مقامِ پیدائش)',
            ])
        </div>
    </div>

    <!-- Proposer & Life Proposed Same -->
    <div class="col-6">
        <div class="form-group">
            <label>Proposer & Life Proposed are same?<span class="text-danger"> *</span></label>
            <select name="is_same_person" required class="form-control" id="is_same_person">
                <option value="">Select Option</option>
                <option value="Yes" {{ ($user->basicDetail->is_same_person ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                <option value="No" {{ ($user->basicDetail->is_same_person ?? '') == 'No' ? 'selected' : '' }}>No</option>
            </select>
        </div>
    </div>
    <div id="same_person_fields" class="row"></div>
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

            if (!isValid) {
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

        // ===== Dual Nationality Toggle (dynamic field injection) =====
        function toggleDualNationalityFields() {

            let dual_option = $('#is_client_dual_national').val();

            if (dual_option === 'Yes') {

                $('#dual_natunality_fields').html(`
            <div class="col-md-6 px-0 px-sm-3">
                <label>
                    Primary Nationality (قومیت)
                    <span class="requi">*</span>
                </label>
                <input type="text"
                       value="{{ $user->basicDetail->primary_nationality ?? '' }}"
                       name="primary_nationality"
                       class="form-control account">
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>
                    Dual Nationality (دوہری قومیت)
                    <span class="requi">*</span>
                </label>
                <input type="text"
                       value="{{ $user->basicDetail->dual_nationality ?? '' }}"
                       name="dual_nationality"
                       class="form-control account">
            </div>

            <div class="col-md-6 px-0 px-sm-3 mt-3">
                <label>
                    Dual Nationality Country
                    <span class="requi">*</span>
                </label>
                <input type="text"
                       value="{{ $user->basicDetail->dual_nationality_country ?? '' }}"
                       name="dual_nationality_country"
                       class="form-control account">
            </div>

            <div class="col-md-6 px-0 px-sm-3 mt-3">
                <label>
                    Passport Number
                    <span class="requi">*</span>
                </label>
                <input type="text"
                       value="{{ $user->basicDetail->dual_passport_number ?? '' }}"
                       name="dual_passport_number"
                       class="form-control account">
            </div>
        `);

            } else {
                $('#dual_natunality_fields').html('');
            }
        }

        // Page load par
        toggleDualNationalityFields();
        $('#is_client_dual_national').on('change', toggleDualNationalityFields);

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

        // ===== Proposer & Life Proposed Same Toggle =====
        function toggleSamePersonFields() {
            if ($('#is_same_person').val() === 'No') {
                $('#same_person_fields').html(`
            <div class="col-6">
                <div class="form-group">
                    <label>Proposer Full Name<span class="text-danger"> *</span></label>
                    <input type="text" value="{{ $user->basicDetail->life_proposed_name ?? '' }}" name="life_proposed_name" class="form-control account" required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label>Proposer CNIC<span class="text-danger"> *</span></label>
                    <input type="text" value="{{ $user->basicDetail->life_proposed_cnic ?? '' }}" name="life_proposed_cnic" class="form-control account" required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label>Proposer DOB<span class="text-danger"> *</span></label>
                    <input type="date" value="{{ $user->basicDetail->life_proposed_dob ?? '' }}" name="life_proposed_dob" class="form-control account" required>
                </div>
            </div>
            
            <div class="col-6">
                <div class="form-group">
                    <label>Relationship with Life Proposed<span class="text-danger"> *</span></label>
                    <input type="text" value="{{ $user->basicDetail->life_proposed_relationship ?? '' }}" name="life_proposed_relationship" class="form-control account" required>
                </div>
            </div>
        `);
            } else {
                $('#same_person_fields').empty();
            }
        }
        toggleSamePersonFields();
        $('#is_same_person').on('change', toggleSamePersonFields);

    });
</script>
@endpush
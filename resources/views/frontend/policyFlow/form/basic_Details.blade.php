<div id="basic_Details" role="tabpanel" aria-labelledby="basic_Details-tab" class="tab-pane fade">
    <div class="container">
        <div class="row">
            <h3 class="col-12 ib-form-subheading">Basic Details</h3>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Life Proposed Full Name (بیمہ زندگی کے لئے مجوزہ کا پورا نام)<span class="requi">*</span></label>
                <input type="text" value="{{$user->basicDetail?->life_proposed_full_name ?? ''}}" name="life_proposed_full_name" class="form-control account">
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Mobile Number Personal (ذاتی موبائل نمبر)<span class="requi">*</span></label>
                <input type="text" value="{{$user->basicDetail->mobile_number ?? ''}}" name="mobile_number" class="form-control account" placeholder="0321-6905568">
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>CNIC / B-FORM NO (قومی شناختی کارڈ نمبر)<span class="requi">*</span></label>
                <input type="text" value="{{$user->basicDetail->cnic_number ?? ''}}" name="cnic_number" id="cnic_number" class="form-control account">
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Cnic Issue Date (شناختی کارڈ جاری کرنے کی تاریخ)<span class="requi">*</span></label>
                <input type="date" value="{{$user->basicDetail->cnic_issue_date ?? ''}}" name="cnic_issue_date" class="form-control account">
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Cnic Expiry Date (شناختی کارڈ کی میعاد ختم ہونے کی تاریخ)<span class="requi">*</span></label>
                <input type="date" value="{{$user->basicDetail->cnic_expiry_date ?? ''}}" name="cnic_expiry_date" class="form-control account">
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Date Of Birth (تاریخِ پیدائش)<span class="requi">*</span></label>
               <input type="date" value="{{$user->basicDetail->date_of_birth ?? ''}}" name="date_of_birth" class="form-control account">
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Age Nearest Birth-date (عمر)<span class="requi">*</span></label>
                <input type="text" id="age_birth" value="{{$user->basicDetail->age_nearest_date ?? ''}}" name="age_nearest_date" class="form-control account" readonly>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Gender/Sex (جنس)<span class="requi">*</span></label>
                <select name="gender" class="form-control">
                    <option value="">Select Gender</option>
                    <option value="Male" {{ ($user->basicDetail->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ ($user->basicDetail->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Mother Maiden Name (والدہ کا خاندانی نام)<span class="requi">*</span></label>
                <input type="text" value="{{ $user->basicDetail->mother_maiden_name ?? '' }}" name="mother_maiden_name" class="form-control account">
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Father’s Name of Life Proposed (مجوزہ بیمہ کے والد کا نام)<span class="requi">*</span></label>
                <input type="text" value="{{ $user->basicDetail->father_name ?? '' }}" name="father_name" class="form-control account">
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Husband Name of Life Proposed (بیمہ کنندہ کے شوہر کا نام)<span class="requi">*</span></label>
                <input type="text" value="{{ $user->basicDetail->husband_name ?? '' }}" name="husband_name" class="form-control account">
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Religion (مذہب)<span class="requi">*</span></label>
                <input type="text" value="{{ $user->basicDetail->religion ?? '' }}" name="religion" class="form-control account">
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Email Address (ای میل ایڈریس)<span class="requi">*</span></label>
                <input type="email" value="{{ $user->basicDetail->email ?? '' }}" name="email" class="form-control account">
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Age Proof (عمر کا ثبوت)<span class="requi">*</span></label>
                <input type="text" value="{{ $user->basicDetail->age_proof ?? '' }}" name="age_proof" class="form-control account">
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Phone Number Office (آفس فون نمبر)<span class="requi">*</span></label>
                <input type="text" value="{{ $user->basicDetail->phone_number_office ?? '' }}" name="phone_number_office" class="form-control account">
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Phone Number Residential (رہائشی فون نمبر)<span class="requi">*</span></label>
                <input type="text" value="{{ $user->basicDetail->phone_number_residente ?? '' }}" name="phone_number_residente" class="form-control account">
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Fax No (فیکس نمبر)<span class="requi">*</span></label>
                <input type="text" value="{{ $user->basicDetail->fax_number ?? '' }}" name="fax_number" class="form-control account">
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Is Client Dual National? (کیا سائل دوہری قومیت رکھتا ہے؟)<span class="requi">*</span></label>
                <select name="is_client_dual_national" class="form-control">
                    <option value="">Select Option</option>
                    <option value="Yes" {{ ($user->basicDetail->is_client_dual_national ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                    <option value="No" {{ ($user->basicDetail->is_client_dual_national ?? '') == 'No' ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Primary Nationality (قومیت)<span class="requi">*</span></label>
                <input type="text" value="{{ $user->basicDetail->primary_nationality ?? '' }}" name="primary_nationality" class="form-control account">
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Dual Nationality (دوہری قومیت)<span class="requi">*</span></label>
                <input type="text" value="{{ $user->basicDetail->dual_nationality ?? '' }}" name="dual_nationality" class="form-control account">
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Birth Place (مقامِ پیدائش)<span class="requi">*</span></label>
                <input type="text" value="{{ $user->basicDetail->birth_placed ?? '' }}" name="birth_placed" class="form-control account">
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Proposer & Life Proposed are same?<span class="requi">*</span></label>
                <select name="is_same_person" class="form-control">
                    <option value="">Select Option</option>
                    <option value="Yes" {{ ($user->basicDetail->is_same_person ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                    <option value="No" {{ ($user->basicDetail->is_same_person ?? '') == 'No' ? 'selected' : '' }}>No</option>
                </select>
            </div>

        </div>

    </div>
</div>

@push('js')
<script>
    $(document).ready(function() {


        $('input[name="cnic_number"]').on('input', function() {
            let val = $(this).val().replace(/\D/g, '');
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












    });
</script>
@endpush
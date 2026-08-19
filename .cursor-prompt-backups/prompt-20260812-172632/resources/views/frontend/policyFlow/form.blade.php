<fieldset>
    <div class="form-card">
        <nav>
            <div id="nav-tab" role="tablist" class="nav nav-tabs ib-acq-navtab">
                <a id="nav-Personal_Details-tab" data-toggle="tab" href="#nav-Personal_Details" role="tab" aria-controls="nav-Personal_Details" aria-selected="true" class="nav-item nav-link acq-nav-btn active">Personal Details</a>
                <a id="basic_Details-tab" data-toggle="tab" href="#basic_Details" role="tab" aria-controls="basic_Details" aria-selected="false" class="nav-item nav-link acq-nav-btn">Basic Details</a>
                <a id="occupation-tab" data-toggle="tab" href="#occupation" role="tab" aria-controls="occupation" aria-selected="false" class="nav-item nav-link acq-nav-btn">Occupation</a>
                <a id="product_detail-tab" data-toggle="tab" href="#product_detail" role="tab" aria-controls="product_detail" aria-selected="false" class="nav-item nav-link acq-nav-btn">Product Details</a>
                <a id="family-history-tab" data-toggle="tab" href="#family_history" role="tab" aria-controls="family_history" aria-selected="false" class="nav-item nav-link acq-nav-btn">Family History</a>
                <a id="women-tab" data-toggle="tab" href="#women" role="tab" aria-controls="women" aria-selected="false" class="nav-item nav-link acq-nav-btn">Female Section</a>
                <a id="nominee-tab" data-toggle="tab" href="#nominee" role="tab" aria-controls="nominee" aria-selected="false" class="nav-item nav-link acq-nav-btn">Nominee</a>
                <a id="documents-tab" data-toggle="tab" href="#documents" role="tab" aria-controls="documents" aria-selected="false" class="nav-item nav-link acq-nav-btn">Documents</a>
                <a id="health_info-tab" data-toggle="tab" href="#health_info" role="tab" aria-controls="health_info" aria-selected="false" class="nav-item nav-link acq-nav-btn">Health Information</a>
            </div>
        </nav>
        <div id="nav-tabContent" class="tab-content">

            @include('frontend.policyFlow.form.Personal_Details',['user'=>$user])
            @include('frontend.policyFlow.form.basic_Details',['user'=>$user])
            @include('frontend.policyFlow.form.occupation',['user'=>$user])
            @include('frontend.policyFlow.form.product_detail',['user'=>$user,'id'=>$id,'product'=>$product,'policy_data'=>$policy_data])
            @include('frontend.policyFlow.form.health_info',['user'=>$user])
            @include('frontend.policyFlow.form.family_history',['user'=>$user])
            @include('frontend.policyFlow.form.women',['user'=>$user])
            @include('frontend.policyFlow.form.nominee',['user'=>$user])
            @include('frontend.policyFlow.form.documents',['user'=>$user])

        </div>
    </div>


</fieldset>


@push('js')
<script>
    $(document).ready(function() {

        // Saare tab ids ek array mein (order important hai)
        let tabOrder = [
            '#nav-Personal_Details-tab',
            '#basic_Details-tab',
            '#occupation-tab',
            '#product_detail-tab',
            '#family-history-tab',
            '#women-tab',
            '#nominee-tab',
            '#documents-tab',
            '#health_info-tab'
        ];

        function goToTab(direction) {
            // Current active tab ka index nikalna
            let currentIndex = tabOrder.findIndex(function(tabId) {
                return $(tabId).hasClass('active');
            });

            let newIndex = currentIndex;

            if (direction === 'next') {
                newIndex = currentIndex + 1;
            } else if (direction === 'prev') {
                newIndex = currentIndex - 1;
            }

            // Boundary check
            if (newIndex >= 0 && newIndex < tabOrder.length) {
                $(tabOrder[newIndex]).tab('show'); // Bootstrap tab switch method
            }
        }

        // Next button click (event delegation - kyunki buttons dynamic/multiple jagah hain)
        $(document).on('click', '.ib-next-btn', function() {
            goToTab('next');
        });

        // Previous button click
        $(document).on('click', '.ib-prev-btn', function() {
            goToTab('prev');
        });

    });
    $(document).ready(function() {
        $('#user_details_submited').on('click', function(e) {
            e.preventDefault();
            // let formData = $('#msform').serialize();


            let form = document.getElementById('msform');
            let formData = new FormData(form);
            // for (const [key, value] of formData.entries()) {
            //     console.log(key, value);
            // }



            // // AJAX Call
            $.ajax({
                method: 'POST',
                url: '{{ route("frontend.policyUserDataSave") }}',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function() {
                    Swal.fire({
                        title: 'Inserting Data...',
                        text: 'Please wait while we save your details',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    console.log(response);

                    Swal.close();

                    if (response.success) {
                        window.location.replace(response.redirect_url);
                        // Swal.fire({
                        //     title: 'Success!',
                        //     text: 'Data Save successfully.',
                        //     icon: 'success',
                        //     timer: 2000
                        // });
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










        // dual option visibility
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

        // Dropdown change par
        $('#is_client_dual_national').on('change', toggleDualNationalityFields);








        // business logics 
        function toggleOccupationFields() {

            let employment = $('select[name="is_emaployemnt"]').val();
            let business = $('select[name="is_business"]').val();

            // Employment Fields
            if (employment === 'Yes') {

                $('#employment_fields').html(`
            <div class="col-md-6 px-0 px-sm-3">
                <label>
                    Designation / Job Title
                    <span class="requi">*</span>
                </label>
                <input type="text"
                       name="employment_designation"
                       value="{{ $user->occupation->employment_designation ?? '' }}"
                       class="form-control jbl-dynamic-input">
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>
                    Company Name
                    <span class="requi">*</span>
                </label>
                <input type="text"
                       name="employment_company_name"
                       value="{{ $user->occupation->employment_company_name ?? '' }}"
                       class="form-control jbl-dynamic-input">
            </div>
        `);

            } else {
                $('#employment_fields').html('');
            }

            // Business Fields
            if (business === 'Yes') {

                $('#business_fields').html(`
            <div class="col-md-6 px-0 px-sm-3">
                <label>
                    Business Name
                    <span class="requi">*</span>
                </label>
                <input type="text"
                       name="business_name"
                       value="{{ $user->occupation->business_name ?? '' }}"
                       class="form-control jbl-dynamic-input">
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>
                    Nature of Business
                    <span class="requi">*</span>
                </label>
                <input type="text"
                       name="nature_of_business"
                       value="{{ $user->occupation->nature_of_business ?? '' }}"
                       class="form-control jbl-dynamic-input"
                       placeholder="e.g. Pharmacy, Electronics, Construction">
            </div>
        `);

            } else {
                $('#business_fields').html('');
            }
        }

        // Page Load
        toggleOccupationFields();

        // Change Events
        $('select[name="is_emaployemnt"]').on('change', toggleOccupationFields);
        $('select[name="is_business"]').on('change', toggleOccupationFields);







        // Proposer & Life Proposed are same?
        function toggleSamePersonFields() {

            let same_person = $('#is_same_person').val();

            if (same_person === 'No') {
                $('#same_person_fields').html(`
            <div class="col-md-6 px-0 px-sm-3 mt-3">
                <label>
                    Life Proposed Name
                    <span class="requi">*</span>
                </label>
                <input type="text"
                       name="life_proposed_name"
                       value="{{ $user->basicDetail->life_proposed_name ?? '' }}"
                       class="form-control account">
            </div>

            <div class="col-md-6 px-0 px-sm-3 mt-3">
                <label>
                    CNIC 
                    <span class="requi">*</span>
                </label>
                <input type="text"
                       name="life_proposed_cnic"
                       value="{{ $user->basicDetail->life_proposed_cnic ?? '' }}"
                       class="form-control account" id="life_proposed_cnic">
            </div>

            <div class="col-md-6 px-0 px-sm-3 mt-3">
                <label>
                    Date of Birth
                    <span class="requi">*</span>
                </label>
                <input type="date"
                       name="life_proposed_dob"
                       value="{{ $user->basicDetail->life_proposed_dob ?? '' }}"
                       class="form-control account">
            </div>

            <div class="col-md-6 px-0 px-sm-3 mt-3">
                <label>
                    Relationship with Proposer
                    <span class="requi">*</span>
                </label>
                <input type="text"
                       name="life_proposed_relationship"
                       value="{{ $user->basicDetail->life_proposed_relationship ?? '' }}"
                       class="form-control account">
            </div>
        `);

            } else {

                $('#same_person_fields').html('');

            }
        }

        // Page Load
        toggleSamePersonFields();

        // Dropdown Change
        $('#is_same_person').on('change', toggleSamePersonFields);












        function toggleLandFields() {

            let holdingLand = $('select[name="is_holding_land"]').val();

            if (holdingLand === 'Yes') {

                $('#land_fields').html(`

            <div class="col-md-6 px-0 px-sm-3">
                <label>
                    Total Acreage Owned
                    <span class="requi">*</span>
                </label>
                <input type="number"
                       step="0.01"
                       name="total_acreage"
                       value="{{ $user->occupation->total_acreage ?? '' }}"
                       class="form-control jbl-dynamic-input">
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>
                    Land Location
                    <span class="requi">*</span>
                </label>
                <input type="text"
                       name="land_location"
                       value="{{ $user->occupation->land_location ?? '' }}"
                       class="form-control jbl-dynamic-input">
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>
                    Land Type
                    <span class="requi">*</span>
                </label>
                <select name="land_type" class="form-control jbl-dynamic-input">
                    <option value="">Select Type</option>
                    <option value="Agricultural" {{ ($user->occupation->land_type ?? '') == 'Agricultural' ? 'selected' : '' }}>Agricultural</option>
                    <option value="Commercial" {{ ($user->occupation->land_type ?? '') == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                    <option value="Residential" {{ ($user->occupation->land_type ?? '') == 'Residential' ? 'selected' : '' }}>Residential</option>
                </select>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>
                    Estimated Land Value
                    <span class="requi">*</span>
                </label>
                <input type="number"
                       step="0.01"
                       name="estimated_land_value"
                       value="{{ $user->occupation->estimated_land_value ?? '' }}"
                       class="form-control jbl-dynamic-input">
            </div>

        `);

            } else {
                $('#land_fields').html('');
            }
        }
        toggleOccupationFields();

        $(document).on('change', 'select[name="is_holding_land"]', function() {
            toggleLandFields();
        });









    });


    $(document).ready(function() {

        function cmToFeet(cm) {
            if (cm == "" || isNaN(cm)) {
                return "";
            }

            return (parseFloat(cm) / 30.48).toFixed(2);
        }

        function cmToInches(cm) {
            if (cm == "" || isNaN(cm)) {
                return "";
            }

            return (parseFloat(cm) / 2.54).toFixed(2);
        }

        function bindConverter(inputSelector, outputSelector, type) {

            function calculate() {

                let value = $(inputSelector).val();

                if (value == "") {
                    $(outputSelector).val("");
                    return;
                }

                if (type == "feet") {
                    $(outputSelector).val(cmToFeet(value));
                } else {
                    $(outputSelector).val(cmToInches(value));
                }
            }

            calculate();

            $(document).on("input", inputSelector, calculate);
        }

        // Height
        bindConverter("#height_cm", "#height_ft", "feet");

        // Chest Inspiration
        bindConverter("#chest_insp_cm", "#chest_insp_inches", "inch");

        // Chest Expansion
        bindConverter("#chest_exp_cm", "#chest_exp_inches", "inch");

        // Abdomen
        bindConverter("#abdomen_cm", "#abdomen_inches", "inch");

    });


    $(document).ready(function() {

        let correctAnswer = 0;

        function generateCaptcha() {

            let num1 = Math.floor(Math.random() * 15) + 1;
            let num2 = Math.floor(Math.random() * 15) + 1;

            let operators = ["+", "-", "×"];
            let operator = operators[Math.floor(Math.random() * operators.length)];

            switch (operator) {

                case "+":
                    correctAnswer = num1 + num2;
                    break;

                case "-":

                    if (num2 > num1) {
                        let temp = num1;
                        num1 = num2;
                        num2 = temp;
                    }

                    correctAnswer = num1 - num2;
                    break;

                case "×":
                    correctAnswer = num1 * num2;
                    break;
            }

            $("#captcha-question").text(num1 + " " + operator + " " + num2 + " = ?");

            $("#captcha-answer").val("");

            $("#captcha-success").addClass("d-none");
            $("#captcha-error").addClass("d-none");

            $("#captcha-answer").css("border-color", "#ced4da");

            $("#user_details_submited").prop("disabled", true);
        }

        generateCaptcha();

        $("#captcha-answer").on("input", function() {

            let value = parseInt($(this).val());

            if ($(this).val() == "") {

                $("#captcha-success,#captcha-error").addClass("d-none");

                $(this).css("border-color", "#ced4da");

                $("#user_details_submited").prop("disabled", true);

                return;
            }

            if (value === correctAnswer) {

                $("#captcha-success").removeClass("d-none");
                $("#captcha-error").addClass("d-none");

                $(this).css("border-color", "#198754");

                $("#user_details_submited").prop("disabled", false);

            } else {

                $("#captcha-success").addClass("d-none");
                $("#captcha-error").removeClass("d-none");

                $(this).css("border-color", "#dc3545");

                $("#user_details_submited").prop("disabled", true);
            }

        });

        $("#captcha-answer").keypress(function(e) {

            if (e.which == 13) {

                e.preventDefault();

                if ($("#user_details_submited").is(":disabled")) {

                    generateCaptcha();
                }
            }

        });

    });
    $(function() {

        let captcha = "";

        function generateCaptcha(length = 6) {

            let chars = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";

            captcha = "";

            for (let i = 0; i < length; i++) {

                captcha += chars.charAt(
                    Math.floor(Math.random() * chars.length)
                );

            }

            $("#captcha-code").text(captcha);

            $("#captcha-answer").val("");

            $("#captcha-success,#captcha-error").addClass("d-none");

            $("#captcha-answer").css("border-color", "#ced4da");

            $("#user_details_submited").prop("disabled", true);

        }

        generateCaptcha();

        $("#refresh-captcha").click(function() {

            generateCaptcha();

        });

        $("#captcha-answer").on("input", function() {

            let value = $(this).val().toUpperCase();

            if (value.length != captcha.length) {

                $("#captcha-success,#captcha-error").addClass("d-none");

                $("#user_details_submited").prop("disabled", true);

                $(this).css("border-color", "#ced4da");

                return;

            }

            if (value === captcha) {

                $("#captcha-success").removeClass("d-none");

                $("#captcha-error").addClass("d-none");

                $("#user_details_submited").prop("disabled", false);

                $(this).css("border-color", "#198754");

            } else {

                $("#captcha-error").removeClass("d-none");

                $("#captcha-success").addClass("d-none");

                $("#user_details_submited").prop("disabled", true);

                $(this).css("border-color", "#dc3545");

            }

        });

    });
</script>
@endpush
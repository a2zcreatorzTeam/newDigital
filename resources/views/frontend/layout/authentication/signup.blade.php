<form id="signupForm" class="signup-form" style="display: none;">

    <h3>Sign Up</h3>
    <p>Please Sign Up to Your account</p>
    <!-- Full Name -->
    @csrf
    <div class="form-group mb-10 mt-10">
        <label for="inputFName">Full Name</label>
        <input type="text" class="form-control" id="inputFName" name="name" placeholder="Enter your full name" required>
    </div>

    <!-- Email Input -->
    <div class="form-group mb-10">
        <label for="inputEmail">Email address</label>
        <input type="email" class="form-control" name="email" id="inputEmail" placeholder="Enter email" required>
    </div>

    <div class="form-group mb-10">
        <label for="phone">Phone</label>
        <input
            type="tel"
            class="form-control"
            name="phone_no"
            id="phone"
            placeholder="Enter Phone"
            required>
        <small class="text-danger d-none" id="phoneError">Enter valid phone (03XX-XXXXXXX)</small>
    </div>

    {{-- Phone ownership & authorization (shown after valid phone) --}}
    <div id="phoneAuthQuestions" class="signup-phone-auth d-none" aria-live="polite">
        <div class="form-group mb-10">
            <label class="d-block mb-2">Is this phone number your own?</label>
            <div class="signup-radio-group" role="radiogroup" aria-label="Phone number ownership">
                <label class="signup-radio-option">
                    <input type="radio" name="phone_is_own" id="phone_is_own_yes" value="yes">
                    <span>Yes, this is my number</span>
                </label>
                <label class="signup-radio-option">
                    <input type="radio" name="phone_is_own" id="phone_is_own_no" value="no">
                    <span>No, this belongs to someone else</span>
                </label>
            </div>
        </div>

        <div id="phoneOwnerRelationshipWrap" class="form-group mb-10 d-none">
            <label for="phone_owner_relationship">What is your relationship with the owner of this phone number?</label>
            <select class="form-control" name="phone_owner_relationship" id="phone_owner_relationship">
                <option value="">Select relationship</option>
                <option value="Father">Father</option>
                <option value="Mother">Mother</option>
                <option value="Spouse">Spouse</option>
                <option value="Brother">Brother</option>
                <option value="Sister">Sister</option>
                <option value="Son">Son</option>
                <option value="Daughter">Daughter</option>
                <option value="Other">Other</option>
            </select>
            <div id="phoneOwnerRelationshipOtherWrap" class="mt-2 d-none">
                <label for="phone_owner_relationship_other">Please specify the relationship</label>
                <input type="text" class="form-control" name="phone_owner_relationship_other" id="phone_owner_relationship_other" placeholder="Enter relationship" maxlength="100">
            </div>
        </div>

        <div id="phoneOwnerPermissionWrap" class="form-group mb-10 d-none">
            <label class="d-block mb-2">Have you obtained permission from the owner to use this phone number for registration and communication?</label>
            <div class="signup-radio-group" role="radiogroup" aria-label="Phone number authorization">
                <label class="signup-radio-option">
                    <input type="radio" name="phone_owner_permission" id="phone_owner_permission_yes" value="yes">
                    <span>Yes</span>
                </label>
                <label class="signup-radio-option">
                    <input type="radio" name="phone_owner_permission" id="phone_owner_permission_no" value="no">
                    <span>No</span>
                </label>
            </div>
            <small class="text-danger d-none" id="phonePermissionError">You must have permission from the phone number owner to continue with registration.</small>
        </div>
    </div>

    <div class="form-group mb-10">
        <label for="cnic">CNIC</label>
        <input
            type="text"
            class="form-control"
            name="cnic"
            id="cnic"
            placeholder="XXXXX-XXXXXXX-X"
            pattern="^[0-9]{5}-[0-9]{7}-[0-9]$"
            required>
        <small class="text-danger d-none" id="cnicError">Enter valid CNIC (XXXXX-XXXXXXX-X)</small>
    </div>

    <!-- Password Input -->
    <div class="form-group mb-10">
        <label for="inputPassword">Password</label>
        <div class="input-group" id="show_hide_password">
            <input class="form-control" name="password" type="password" id="inputPassword" placeholder="Enter password" required>
            <div class="input-group-addon">
                <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>

    <!-- Confirm Password Input -->
    <div class="form-group mb-20">
        <label for="inputCPassword">Confirm Password</label>
        <div class="input-group" id="show_hide_password">
            <input class="form-control" type="password" name="password_confirmation" id="inputCPassword" placeholder="Enter password" required>
            <div class="input-group-addon">
                <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>

    <!-- CAPTCHA -->
    <div class="form-group mb-20">
        <label>Verify you are human</label>
        <div class="d-flex align-items-center mb-10" style="gap: 10px;">
            <div id="captchaBoxSignup"
                style="
        background:#f8f9fa;
        padding:10px 18px;
        font-weight:700;
        letter-spacing:4px;
        border:1px solid #ddd;
        border-radius:6px;
        font-size:24px;
        color:#333;
        user-select:none;
        min-width:120px;
        text-align:center;">
            </div> <button type="button" class="btn btn-sm btn-outline-secondary" id="refreshCaptchaSignup"><i class="fa fa-refresh"></i> Refresh</button>
        </div>
        <input type="text" id="captchaInputSignup" class="form-control" placeholder="Enter the code above" required>
    </div>

    <button type="submit" class="btn btn-primary" id="signupSubmitBtn">Sign Up</button>
    <p>Already a User? Please <a id="signin" class="js-show-signin" style="cursor: pointer;">Sign In</a></p>

</form>

<style>
    .signup-phone-auth .signup-radio-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .signup-phone-auth .signup-radio-option {
        display: flex;
        align-items: flex-start;
        gap: 0.55rem;
        margin: 0;
        padding: 0.65rem 0.75rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        background: #fff;
        cursor: pointer;
        font-weight: 400;
        color: #333;
        line-height: 1.35;
    }

    .signup-phone-auth .signup-radio-option:hover {
        border-color: #1f93d1;
        background: #f8fbfe;
    }

    .signup-phone-auth .signup-radio-option input {
        margin-top: 0.15rem;
        flex-shrink: 0;
        accent-color: #1f93d1;
    }

    .signup-phone-auth .signup-radio-option:has(input:checked) {
        border-color: #1f93d1;
        background: #eef7fc;
    }

    #signupSubmitBtn:disabled {
        opacity: 0.65;
        cursor: not-allowed;
    }

    #phonePermissionError {
        display: block;
        margin-top: 0.5rem;
    }
</style>

@push('js')
<script>
    $(document).ready(function() {

        let generatedCaptchaSignup = "";
        const phoneRegex = /^03[0-9]{2}-[0-9]{7}$/;

        function generateCaptchaSignup() {
            generatedCaptchaSignup = Math.floor(100000 + Math.random() * 900000).toString();
            $('#captchaBoxSignup').text(generatedCaptchaSignup);
            $('#captchaInputSignup').val('');
        }

        function isValidPhone(value) {
            return phoneRegex.test((value || '').trim());
        }

        function resetPhoneAuthUi(keepAnswers) {
            if (!keepAnswers) {
                $('input[name="phone_is_own"]').prop('checked', false);
                $('#phone_owner_relationship').val('');
                $('#phone_owner_relationship_other').val('');
                $('input[name="phone_owner_permission"]').prop('checked', false);
            }
            $('#phoneOwnerRelationshipWrap').addClass('d-none');
            $('#phoneOwnerRelationshipOtherWrap').addClass('d-none');
            $('#phoneOwnerPermissionWrap').addClass('d-none');
            $('#phonePermissionError').addClass('d-none');
            $('#signupSubmitBtn').prop('disabled', false);
        }

        function syncPhoneAuthFlow() {
            const phoneValid = isValidPhone($('#phone').val());
            const $questions = $('#phoneAuthQuestions');
            const $submit = $('#signupSubmitBtn');

            if (!phoneValid) {
                $questions.addClass('d-none');
                resetPhoneAuthUi(false);
                $submit.prop('disabled', false);
                return;
            }

            $questions.removeClass('d-none');
            $('#phoneError').addClass('d-none');

            const ownership = $('input[name="phone_is_own"]:checked').val();
            const $relWrap = $('#phoneOwnerRelationshipWrap');
            const $otherWrap = $('#phoneOwnerRelationshipOtherWrap');
            const $permWrap = $('#phoneOwnerPermissionWrap');
            const $permError = $('#phonePermissionError');

            if (!ownership) {
                $relWrap.addClass('d-none');
                $otherWrap.addClass('d-none');
                $permWrap.addClass('d-none');
                $permError.addClass('d-none');
                $submit.prop('disabled', true);
                return;
            }

            if (ownership === 'no') {
                $relWrap.removeClass('d-none');
                const rel = $('#phone_owner_relationship').val();
                if (rel === 'Other') {
                    $otherWrap.removeClass('d-none');
                } else {
                    $otherWrap.addClass('d-none');
                    $('#phone_owner_relationship_other').val('');
                }
            } else {
                $relWrap.addClass('d-none');
                $otherWrap.addClass('d-none');
                $('#phone_owner_relationship').val('');
                $('#phone_owner_relationship_other').val('');
            }

            // Permission question appears after ownership is answered
            // (and for "no", after relationship is selected — and Other text if needed)
            let canAskPermission = ownership === 'yes';
            if (ownership === 'no') {
                const rel = $('#phone_owner_relationship').val();
                if (rel && rel !== 'Other') {
                    canAskPermission = true;
                } else if (rel === 'Other' && $('#phone_owner_relationship_other').val().trim() !== '') {
                    canAskPermission = true;
                } else {
                    canAskPermission = false;
                }
            }

            if (canAskPermission) {
                $permWrap.removeClass('d-none');
            } else {
                $permWrap.addClass('d-none');
                $('input[name="phone_owner_permission"]').prop('checked', false);
                $permError.addClass('d-none');
                $submit.prop('disabled', true);
                return;
            }

            const permission = $('input[name="phone_owner_permission"]:checked').val();
            if (permission === 'no') {
                $permError.removeClass('d-none');
                $submit.prop('disabled', true);
            } else if (permission === 'yes') {
                $permError.addClass('d-none');
                $submit.prop('disabled', false);
            } else {
                $permError.addClass('d-none');
                $submit.prop('disabled', true);
            }
        }

        generateCaptchaSignup();

        $('#refreshCaptchaSignup').click(function() {
            generateCaptchaSignup();
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#phone').on('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.substring(0, 11);
            if (value.length > 4) {
                value = value.slice(0, 4) + '-' + value.slice(4);
            }
            e.target.value = value;

            if (!isValidPhone(value) && value.length > 0) {
                $('#phoneError').removeClass('d-none');
            } else {
                $('#phoneError').addClass('d-none');
            }
            syncPhoneAuthFlow();
        });

        $(document).on('change', 'input[name="phone_is_own"], input[name="phone_owner_permission"]', syncPhoneAuthFlow);
        $('#phone_owner_relationship').on('change', syncPhoneAuthFlow);
        $('#phone_owner_relationship_other').on('input', syncPhoneAuthFlow);

        syncPhoneAuthFlow();

        $('#signupForm').submit(function(e) {
            e.preventDefault();

            if (!isValidPhone($('#phone').val())) {
                $('#phoneError').removeClass('d-none');
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Phone',
                    text: 'Please enter a valid phone number (03XX-XXXXXXX).',
                });
                return false;
            }

            const ownership = $('input[name="phone_is_own"]:checked').val();
            if (!ownership) {
                Swal.fire({
                    icon: 'error',
                    title: 'Required',
                    text: 'Please confirm whether this phone number is your own.',
                });
                return false;
            }

            if (ownership === 'no') {
                const rel = $('#phone_owner_relationship').val();
                if (!rel) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Required',
                        text: 'Please select your relationship with the phone number owner.',
                    });
                    return false;
                }
                if (rel === 'Other' && !$('#phone_owner_relationship_other').val().trim()) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Required',
                        text: 'Please specify your relationship with the phone number owner.',
                    });
                    return false;
                }
            }

            const permission = $('input[name="phone_owner_permission"]:checked').val();
            if (permission !== 'yes') {
                $('#phonePermissionError').removeClass('d-none');
                $('#signupSubmitBtn').prop('disabled', true);
                Swal.fire({
                    icon: 'error',
                    title: 'Permission Required',
                    text: 'You must have permission from the phone number owner to continue with registration.',
                });
                return false;
            }

            let userEnteredCaptchaSignup = $('#captchaInputSignup').val().trim();

            if (userEnteredCaptchaSignup !== generatedCaptchaSignup) {
                Swal.fire({
                    icon: 'error',
                    title: 'CAPTCHA Failed',
                    text: 'The verification code does not match. Please try again.',
                });
                generateCaptchaSignup();
                return false;
            }

            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('frontend.signup') }}",
                type: "POST",
                data: formData,

                beforeSend: function() {
                    $('#loader_data').show();
                    $('#signupSubmitBtn').prop('disabled', true);
                },

                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    });

                    $('#signupForm').hide();
                    $('#otpForm').show();
                    $('#otp_user_id').val(response.user_id);
                    $('#signupForm')[0].reset();
                    resetPhoneAuthUi(false);
                    $('#phoneAuthQuestions').addClass('d-none');
                    generateCaptchaSignup();
                    syncPhoneAuthFlow();
                },

                error: function(xhr) {
                    generateCaptchaSignup();
                    syncPhoneAuthFlow();

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMsg = '';

                        $.each(errors, function(key, value) {
                            errorMsg += value[0] + '\n';
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: errorMsg,
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong. Please try again.',
                        });
                    }
                },

                complete: function() {
                    $('#loader_data').hide();
                    syncPhoneAuthFlow();
                }
            });

        });

    });

    document.getElementById("cnic").addEventListener("input", function() {
        let cnic = this.value;
        let regex = /^[0-9]{5}-[0-9]{7}-[0-9]$/;

        if (!regex.test(cnic)) {
            document.getElementById("cnicError").classList.remove("d-none");
        } else {
            document.getElementById("cnicError").classList.add("d-none");
        }
    });
    document.getElementById("cnic").addEventListener("input", function(e) {
        let value = e.target.value.replace(/\D/g, '');

        if (value.length > 5 && value.length <= 12)
            value = value.slice(0, 5) + '-' + value.slice(5);
        else if (value.length > 12)
            value = value.slice(0, 5) + '-' + value.slice(5, 12) + '-' + value.slice(12, 13);

        e.target.value = value;
    });
</script>
@endpush
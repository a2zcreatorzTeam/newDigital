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

    <button type="submit" class="btn btn-primary">Sign Up</button>
    <p>Already a User? Please <a id="signin" class="js-show-signin" style="cursor: pointer;">Sign In</a></p>

</form>



@push('js')
<script>
    $(document).ready(function() {

        let generatedCaptchaSignup = "";

        // ✅ Generate signup CAPTCHA
        function generateCaptchaSignup() {
            generatedCaptchaSignup = Math.floor(100000 + Math.random() * 900000).toString(); // 6-digit number
            $('#captchaBoxSignup').text(generatedCaptchaSignup);
            $('#captchaInputSignup').val('');
        }

        // Initialize CAPTCHA on load
        generateCaptchaSignup();

        // Refresh click event
        $('#refreshCaptchaSignup').click(function() {
            generateCaptchaSignup();
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#signupForm').submit(function(e) {
            e.preventDefault();

            // ✅ FRONTEND CAPTCHA VALIDATION
            let userEnteredCaptchaSignup = $('#captchaInputSignup').val().trim();

            if (userEnteredCaptchaSignup !== generatedCaptchaSignup) {
                Swal.fire({
                    icon: 'error',
                    title: 'CAPTCHA Failed',
                    text: 'The verification code does not match. Please try again.',
                });
                generateCaptchaSignup(); // Change code on failure
                return false; // Stop form from submitting via AJAX
            }

            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('frontend.signup') }}",
                type: "POST",
                data: formData,

                // ✅ Show loader before request
                beforeSend: function() {
                    $('#loader_data').show();
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

                    // ✅ Regenerate CAPTCHA after success
                    generateCaptchaSignup();
                },

                error: function(xhr) {
                    // ✅ Regenerate CAPTCHA on error
                    generateCaptchaSignup();

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

                // ✅ Hide loader after request (success or error)
                complete: function() {
                    $('#loader_data').hide();
                }
            });

        });

    });


    document.getElementById("phone").addEventListener("input", function() {
        let phone = this.value;
        let regex = /^03[0-9]{9}$/;

        if (!regex.test(phone)) {
            document.getElementById("phoneError").classList.remove("d-none");
        } else {
            document.getElementById("phoneError").classList.add("d-none");
        }
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
    document.getElementById("phone").addEventListener("input", function(e) {
        let value = e.target.value.replace(/\D/g, ''); // remove non-digits

        // limit to 11 digits only
        value = value.substring(0, 11);

        // apply formatting
        if (value.length > 4) {
            value = value.slice(0, 4) + '-' + value.slice(4);
        }

        e.target.value = value;
    });


</script>
@endpush
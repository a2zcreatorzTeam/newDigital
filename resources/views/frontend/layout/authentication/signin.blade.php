
<form class="signin-form" id="signinForm">
    <h3>Sign In</h3>
    <p class="mb-20">Please Sign in to Continue</p>

    <div class="form-group mb-10 mt-10">
        <label for="inputEmail">Email address</label>
        <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Enter email" required>
    </div>

    <div class="form-group mb-10">
        <label for="inputPassword">Password</label>
        <div class="input-group" id="show_hide_password">
            <input class="form-control" name="password" type="password" id="inputPassword" placeholder="Password" required>
            <div class="input-group-addon">
                <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>

    <div class="form-group mb-20">
        <a href="#" id="lostPasswordLink">Lost Password?</a>
    </div>

    <div class="form-group mb-20">
        <label>Verify you are human</label>
        <div class="d-flex align-items-center mb-10" style="gap: 10px;">
            <div id="captchaBox"
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
            </div> <button type="button" class="btn btn-sm btn-outline-secondary" id="refreshCaptcha"><i class="fa fa-refresh"></i> Refresh</button>
        </div>
        <input type="text" id="captchaInput" class="form-control" placeholder="Enter the code above" required>
    </div>

    <button class="btn btn-primary mb-10">Sign In</button>
    <br>
    <p>Not a User? Please <a id="signup" style="cursor: pointer;">Sign Up</a></p>
</form>
@push('js')
<script>
    $(document).ready(function() {
        let generatedCaptcha = "";

        // ✅ Function to generate frontend CAPTCHA
        // function generateCaptcha() {
        //     const chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        //     let result = "";
        //     for (let i = 0; i < 6; i++) { // 6-character captcha
        //         result += chars.charAt(Math.floor(Math.random() * chars.length));
        //     }
        //     generatedCaptcha = result;
        //     $('#captchaBox').text(generatedCaptcha);
        //     $('#captchaInput').val(''); // Clear old input
        // }
        function generateCaptcha() {
            generatedCaptcha = Math.floor(100000 + Math.random() * 900000).toString(); // 6-digit number
            $('#captchaBox').text(generatedCaptcha);
            $('#captchaInput').val('');
        }

        // Initialize CAPTCHA on load
        generateCaptcha();

        // Refresh click event
        $('#refreshCaptcha').click(function() {
            generateCaptcha();
        });

        // CSRF Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#signinForm').submit(function(e) {
            e.preventDefault();

            // ✅ FRONTEND CAPTCHA VALIDATION
            let userEnteredCaptcha = $('#captchaInput').val().trim();

            if (userEnteredCaptcha !== generatedCaptcha) {
                Swal.fire({
                    icon: 'error',
                    title: 'CAPTCHA Failed',
                    text: 'The verification code does not match. Please try again.',
                });
                generateCaptcha(); // Change code on failure
                return false; // Stop form from submitting via AJAX
            }

            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('frontend.signin') }}",
                type: "POST",
                data: formData,
                beforeSend: function() {
                    $('#loader_data').show();
                },

                success: function(response) {
                    $('#authNavbar').show();
                    $('#guestNavbar').hide();
                    $("#profile_name").text(response.data.name);

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                    $('.offcanvas-close').trigger('click');
                    $('#signinForm')[0].reset();

                    // ✅ Regenerate CAPTCHA after a successful sign-in
                    generateCaptcha();
                },

                error: function(xhr) {
                    // ✅ Regenerate CAPTCHA on backend error
                    generateCaptcha();

                    // Validation Errors (422)
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
                    }
                    // EMAIL NOT VERIFIED
                    else if (xhr.status === 403 && xhr.responseJSON.verification_required) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Email Verification Required',
                            text: xhr.responseJSON.message,
                        });

                        $('#signinForm').hide();
                        $('#otpForm').show();
                        $('#otp_user_id').val(xhr.responseJSON.user_id);
                    }
                    // Other Errors (500, etc.)
                    else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong. Please try again.',
                        });
                    }
                },
                complete: function() {
                    $('#loader_data').hide();
                }
            });
        });
    });
</script>
@endpush
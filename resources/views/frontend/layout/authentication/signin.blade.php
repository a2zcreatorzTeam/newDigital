
<form class="signin-form" id="signinForm">
    @csrf
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

    <button type="submit" class="btn btn-primary mb-10" id="signinSubmitBtn">Sign In</button>
    <br>
    <p>Not a User? Please <a id="signup" class="js-show-signup" style="cursor: pointer;">Sign Up</a></p>
</form>
C:\Users\ShoaibPc\Herd\newdigital\resources\views\frontend\layout\authentication\signin.blade.php
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

            if ($('#signinForm').data('submitting')) {
                return false;
            }

            // ✅ FRONTEND CAPTCHA VALIDATION
            let userEnteredCaptcha = $('#captchaInput').val().trim();

            if (userEnteredCaptcha !== generatedCaptcha) {
                Swal.fire({
                    icon: 'error',
                    title: 'CAPTCHA Failed',
                    text: 'The verification code does not match. Please try again.',
                });
                generateCaptcha();
                return false;
            }

            let formData = $(this).serialize();
            let $submitBtn = $('#signinSubmitBtn');

            $('#signinForm').data('submitting', true);
            $submitBtn.prop('disabled', true);

            $.ajax({
                url: "{{ route('frontend.signin') }}",
                type: "POST",
                data: formData,
                dataType: 'json',
                beforeSend: function() {
                    $('#loader_data').show();
                },

                success: function(response) {
                    var userName = (response && response.data && response.data.name) ? response.data.name : '';
                    if (userName) {
                        $("#profile_name").text(userName);
                    }
                    $('#authNavbar').show();
                    $('#guestNavbar').hide();

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: (response && response.message) ? response.message : 'Login successful',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });

                    $('.offcanvas-close').trigger('click');
                    $('#signinForm')[0].reset();
                    generateCaptcha();
                },

                error: function(xhr) {
                    generateCaptcha();

                    let errorTitle = 'Error';
                    let errorMsg = 'Something went wrong. Please try again.';
                    let payload = xhr.responseJSON || {};

                    if (xhr.status === 422) {
                        errorTitle = 'Validation Error';
                        errorMsg = '';
                        $.each(payload.errors || {}, function(key, value) {
                            errorMsg += (value[0] || value) + '\n';
                        });
                        if (!errorMsg) {
                            errorMsg = payload.message || 'Please check the form and try again.';
                        }
                    } else if (xhr.status === 403 && payload.verification_required) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Email Verification Required',
                            text: payload.message,
                        });

                        $('#signinForm').hide();
                        $('#otpForm').show();
                        $('#otp_user_id').val(payload.user_id);
                        return;
                    } else if (xhr.status === 401 || xhr.status === 404) {
                        errorTitle = 'Login Failed';
                        errorMsg = payload.message || 'Invalid email or password.';
                    } else if (payload.message) {
                        errorMsg = payload.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: errorTitle,
                        text: errorMsg,
                    });
                },
                complete: function() {
                    $('#loader_data').hide();
                    $('#signinForm').data('submitting', false);
                    $submitBtn.prop('disabled', false);
                }
            });
        });
    });
</script>
@endpush
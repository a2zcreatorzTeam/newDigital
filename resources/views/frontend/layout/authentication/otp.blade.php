<form id="otpForm" class="otp-form" style="display:none;">

    <h3>Email Verification</h3>

    <p>Please enter the OTP sent to your email</p>

    @csrf

    <input type="hidden" id="otp_user_id" name="user_id">

    <div class="form-group mb-20">

        <label for="otp">Enter OTP</label>

        <input
            type="text"
            class="form-control text-center"
            id="otp"
            name="otp"
            placeholder="Enter 6 Digit OTP"
            maxlength="6"
            required>

    </div>

    <button type="submit" class="btn btn-primary">
        Verify OTP
    </button>

    <div class="mt-3">
        <button type="button" id="resendOtpBtn" class="" style="background: white;border: none;">
            Resend OTP
        </button>
    </div>
</form>
@push('js')
  <script>
      $(document).ready(function() {
          
        $('#otpForm').submit(function(e) {

        e.preventDefault();

        $.ajax({

            url: "{{ route('frontend.verify.otp') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                user_id: $('#otp_user_id').val(),
                otp: $('#otp').val()
            },

            beforeSend: function() {
                $('#loader_data').show();
            },

            success: function(response) {

                Swal.fire({
                    icon: 'success',
                    title: 'Verified',
                    text: response.message,
                });

                $('#otpForm')[0].reset();

                $('#otpForm').hide();

                $('.offcanvas-close').trigger('click');

                window.location.href = "{{ route('frontend.index') }}";
            },

            error: function(xhr) {

                let message = 'Invalid OTP';

                if (xhr.responseJSON?.message) {
                    message = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: message,
                });
            },

            complete: function() {
                $('#loader_data').hide();
            }

        });

        });
        $('#resendOtpBtn').click(function() {

            $.ajax({

                url: "{{ route('frontend.resend.otp') }}",
                type: "POST",

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                data: {
                    user_id: $('#otp_user_id').val()
                },

                beforeSend: function() {

                    $('#loader_data').show();

                    $('#resendOtpBtn').prop('disabled', true);

                },

                success: function(response) {

                    Swal.fire({
                        icon: 'success',
                        title: 'OTP Sent',
                        text: response.message,
                    });

                },

                error: function(xhr) {

                    let message = xhr.responseJSON?.message ??
                        'Failed to resend OTP';

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: message,
                    });
                },

                complete: function() {

                    $('#loader_data').hide();

                    // enable again after 30 sec
                    setTimeout(() => {

                        $('#resendOtpBtn').prop('disabled', false);

                    }, 30000);
                }

            });

        });
      });
  </script>
  @endpush
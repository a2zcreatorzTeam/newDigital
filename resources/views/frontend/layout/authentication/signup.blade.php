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

    <!-- Phone Input -->
    <div class="form-group mb-10">
        <label for="inputPhone">Phone</label>
        <input type="tel" class="form-control" name="phone" id="inputPhone" placeholder="Enter your phone" required>
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

    <button type="submit" class="btn btn-primary">Sign Up</button>
</form>
<p >Already a User? Please <a id="signin" style="cursor: pointer;">Sign In</a></p>


@push('js')
<script>
    $(document).ready(function() {

        // CSRF
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#signupForm').submit(function(e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('frontend.signup') }}",
                type: "POST",
                data: formData,

                success: function(response) {

                    // ✅ Success Alert
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    });
                    $('.offcanvas-close').trigger('click');
                    $('#signupForm')[0].reset();
                },

                error: function(xhr) {

                    // ✅ Validation Errors (422)
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

                    // ❌ Other Errors (500, etc.)
                    else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong. Please try again.',
                        });
                    }
                }
            });

        });

    });
</script>
@endpush
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

    <button type="submit" class="btn btn-primary">Sign Up</button>
</form>
<p>Already a User? Please <a id="signin" style="cursor: pointer;">Sign In</a></p>


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
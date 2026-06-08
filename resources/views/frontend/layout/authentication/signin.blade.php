   <form class="signin-form" id="signinForm">
       <h3>Sign In</h3>
       <p class="mb-20">Please Sign in to Continue</p>
       <!-- Email Input -->
       <div class="form-group mb-10 mt-10">
           <label for="inputEmail">Email address</label>
           <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Enter email" required>
       </div>

       <!-- Password Input with Show/Hide Option -->
       <div class="form-group mb-10">
           <label for="inputPassword">Password</label>
           <div class="input-group" id="show_hide_password">
               <input class="form-control" name="password" type="password" id="inputPassword" placeholder="Password" required>
               <div class="input-group-addon">
                   <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
               </div>
           </div>

       </div>



       <!-- Forgot Password Link -->
       <div class="form-group mb-20">
           <a href="#" id="lostPasswordLink">Lost Password?</a>
       </div>

       <!-- Sign In Button -->
       <button class="btn btn-primary mb-10">Sign In</button>
       <br>
       <p>Not a User? Please <a id="signup" style="cursor: pointer;">Sign Up</a></p>
   </form>



   @push('js')
   <script>
       $(document).ready(function() {

           // CSRF
           $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });

           $('#signinForm').submit(function(e) {
               e.preventDefault();

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
                       // ✅ EMAIL NOT VERIFIED
                       else if (xhr.status === 403 && xhr.responseJSON.verification_required) {

                           Swal.fire({
                               icon: 'warning',
                               title: 'Email Verification Required',
                               text: xhr.responseJSON.message,
                           });

                           // hide signin
                           $('#signinForm').hide();

                           // show otp form
                           $('#otpForm').show();

                           // set user id
                           $('#otp_user_id').val(xhr.responseJSON.user_id);
                       }
                       // ❌ Other Errors (500, etc.)
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
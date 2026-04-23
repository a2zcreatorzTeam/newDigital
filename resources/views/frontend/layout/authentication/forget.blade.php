  <form class="lost-password" id="forgetPasswordForm" style="display: none;">
                        <div class="form-group mb-20">
                            <label for="lostEmail">Enter your email to reset password</label>
                            <input type="email" class="form-control" id="lostEmail" placeholder="Enter email" required>

                            <!-- Confirm and Cancel Buttons -->
                            <div class="mt-3">
                                <button type="submit" class="btn btn-success" style="font-size: 13px;">Confirm</button>
                                <button type="button" class="btn btn-secondary" id="cancelLostPassword" style="font-size: 13px;">Cancel</button>
                            </div>
                        </div>
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

           $('#forgetPasswordForm').submit(function(e) {
               e.preventDefault();

               let email = $('#lostEmail').val();

                $.ajax({
                    url: "{{ route('frontend.forgot.password') }}",
                    type: "POST",
                    data: {
                        email: email
                    },

                   success: function(response) {
                    
                       Swal.fire({
                           icon: 'success',
                           title: 'Success',
                           text: response.message,
                       });
                       $('#forgetPasswordForm')[0].reset();
                       $('#forgetPasswordForm').hide();
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
                       else if (xhr.status === 429) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Try again later',
                            text: xhr.responseJSON.message,
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
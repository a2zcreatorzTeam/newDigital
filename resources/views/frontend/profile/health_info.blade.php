

<form action="#" id="health_info">
    @csrf

    <h2 class="profile-section-title">Health Information</h2>

    <div class="box-form-login">
        <div class="row">

            <div class="col-6">
                <div class="form-group">
                    <label>Height (In cm) (قد سینٹی میٹر میں)<span class="text-danger"> *</span></label>
                    <input type="number" class="form-control" name="height_cm"
                        value="{{ $user->health->height_cm ?? '' }}">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>Height (In Feet)<span class="text-danger"> *</span></label>
                    <input type="number" class="form-control" name="height_ft"
                        value="{{ $user->health->height_ft ?? '' }}">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>Weight (In Kg)<span class="text-danger"> *</span></label>
                    <input type="number" class="form-control" name="weight_kg"
                        value="{{ $user->health->weight_kg ?? '' }}">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>Chest Insp (cm)<span class="text-danger"> *</span></label>
                    <input type="number" class="form-control" name="chest_insp_cm"
                        value="{{ $user->health->chest_insp_cm ?? '' }}">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>Chest Insp (Inches)<span class="text-danger"> *</span></label>
                    <input type="number" class="form-control" name="chest_insp_inches"
                        value="{{ $user->health->chest_insp_inches ?? '' }}">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>Chest Exp (cm)<span class="text-danger"> *</span></label>
                    <input type="number" class="form-control" name="chest_exp_cm"
                        value="{{ $user->health->chest_exp_cm ?? '' }}">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>Chest Exp (Inches)<span class="text-danger"> *</span></label>
                    <input type="number" class="form-control" name="chest_exp_inches"
                        value="{{ $user->health->chest_exp_inches ?? '' }}">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>Abdomen (cm)<span class="text-danger"> *</span></label>
                    <input type="number" class="form-control" name="abdomen_cm"
                        value="{{ $user->health->abdomen_cm ?? '' }}">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>Abdomen (Inches)<span class="text-danger"> *</span></label>
                    <input type="number" class="form-control" name="abdomen_inches"
                        value="{{ $user->health->abdomen_inches ?? '' }}">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>Weight Loss (Kg)<span class="text-danger"> *</span></label>
                    <input type="number" class="form-control" name="weight_loss_kg"
                        value="{{ $user->health->weight_loss_kg ?? '' }}">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>Weight Gain (Kg)<span class="text-danger"> *</span></label>
                    <input type="number" class="form-control" name="weight_gain_kg"
                        value="{{ $user->health->weight_gain_kg ?? '' }}">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>Reason of Increase Weight<span class="text-danger"> *</span></label>
                    <textarea class="form-control" name="weight_increase_reason" rows="3">{{ $user->health->weight_increase_reason ?? '' }}</textarea>
                </div>
            </div>

        </div>

        <div class="update-btn-container">
            <button type="submit" class="btn-update">Update Health Info</button>
        </div>
    </div>
</form>

  @push('js')
  <script>
      $(document).ready(function() {
          $('#health_info').on('submit', function(e) {
              e.preventDefault();

              let formData = $(this).serialize();
              let isValid = true;

              // Simple Validation: Check if required fields are empty
              $(this).find('.form-control').each(function() {
                  let fieldName = $(this).attr('name');
                  let fieldValue = $(this).val().trim();

                  // In fields ko skip karna hai (Optional fields)
                  let optionalFields = [];

                  // Agar field khali hai AUR wo optional list mein NAHI hai
                  if (fieldValue === "" && !optionalFields.includes(fieldName)) {
                      $(this).css('border-color', 'red');
                      isValid = false;
                  } else {
                      $(this).css('border-color', ''); // Error khatam hone par border normal kar dein
                  }
              });

              if (!isValid) {
                  Swal.fire('Error', 'Please fill all required fields.', 'error');
                  return false;
              }

              // AJAX Call
              $.ajax({
                  method: 'POST',
                  url: '{{ route("frontend.updateHealth") }}', // Apna sahi route yahan likhein
                  data: formData,
                  beforeSend: function() {
                      Swal.fire({
                          title: 'Updating...',
                          text: 'Please wait while we save your details',
                          allowOutsideClick: false,
                          didOpen: () => {
                              Swal.showLoading();
                          }
                      });
                  },
                  success: function(response) {
                      Swal.close();
                      console.log(response);

                      if (response.success) {
                          Swal.fire({
                              title: 'Success!',
                              text: 'Profile updated successfully.',
                              icon: 'success',
                              timer: 2000
                          });
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



      });
  </script>
  @endpush
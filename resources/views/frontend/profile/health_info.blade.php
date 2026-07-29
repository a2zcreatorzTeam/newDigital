<form action="#" id="health_info">
    @csrf

    <h2 class="profile-section-title">Health Information</h2>

    <div class="box-form-login">
        <div class="row">

            <!-- Auto Calculation Note -->
            <div class="col-12 mb-3">
                <div class="alert alert-primary border-start border-5 shadow-sm">
                    <h6 class="mb-2">
                        <i class="fas fa-info-circle me-2"></i>
                        Automatic Measurement Conversion
                    </h6>

                    <p class="mb-0 text-dark">
                        Please enter values in <strong>Centimeters (cm)</strong> and
                        <strong>Kilograms (kg)</strong> where applicable.
                        For measurement fields such as
                        <strong>Height</strong>,
                        <strong>Chest</strong>, and
                        <strong>Abdomen</strong>,
                        the system will automatically calculate and populate the corresponding values in
                        <strong>Feet</strong> and
                        <strong>Inches</strong>.
                        These auto-calculated fields are <strong>read-only</strong> to maintain data accuracy.
                    </p>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>Height (In cm) (قد سینٹی میٹر میں)<span class="text-danger"> *</span></label>
                    <input type="number" class="form-control" id="height_cm" name="height_cm"
                        value="{{ $user->health->height_cm ?? '' }}">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>Height (In Feet)<span class="text-danger"> *</span></label>
                    <input type="text" class="form-control bg-light" id="height_ft" name="height_ft"
                        value="{{ $user->health->height_ft ?? '' }}" readonly>
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
                    <input type="number" class="form-control" id="chest_insp_cm" name="chest_insp_cm"
                        value="{{ $user->health->chest_insp_cm ?? '' }}">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>Chest Insp (Inches)<span class="text-danger"> *</span></label>
                    <input type="text" class="form-control bg-light" id="chest_insp_inches" name="chest_insp_inches"
                        value="{{ $user->health->chest_insp_inches ?? '' }}" readonly>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>Chest Exp (cm)<span class="text-danger"> *</span></label>
                    <input type="number" class="form-control" id="chest_exp_cm" name="chest_exp_cm"
                        value="{{ $user->health->chest_exp_cm ?? '' }}">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>Chest Exp (Inches)<span class="text-danger"> *</span></label>
                    <input type="text" class="form-control bg-light" id="chest_exp_inches" name="chest_exp_inches"
                        value="{{ $user->health->chest_exp_inches ?? '' }}" readonly>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>Abdomen (cm)<span class="text-danger"> *</span></label>
                    <input type="number" class="form-control" id="abdomen_cm" name="abdomen_cm"
                        value="{{ $user->health->abdomen_cm ?? '' }}">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>Abdomen (Inches)<span class="text-danger"> *</span></label>
                    <input type="text" class="form-control bg-light" id="abdomen_inches" name="abdomen_inches"
                        value="{{ $user->health->abdomen_inches ?? '' }}" readonly>
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

            <div class="col-12">
                <div class="form-group">
                    <label>Reason for Weight Gain or Weight Loss<span class="text-danger"> *</span></label>
                    <textarea class="form-control" name="weight_increase_reason" rows="3">{{ $user->health->weight_increase_reason ?? '' }}</textarea>
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label>State average daily consumption of Tobacco, Pan/Niswar, Alcohol, Drugs<span class="text-danger"> *</span></label>
                    <input type="text" class="form-control" name="daily_consumption"
                        value="{{ $user->health->daily_consumption ?? '' }}"
                        placeholder="e.g. Tobacco, Pan/Niswar, Alcohol, Drugs">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>State Physical Impairments (if any)<span class="text-danger"> *</span></label>
                    <input type="text" class="form-control" name="physical_impairments"
                        value="{{ $user->health->physical_impairments ?? '' }}"
                        placeholder="e.g. Defective eyesight, hearing loss, etc.">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>When did illness or injury last keep you away from work?<span class="text-danger"> *</span></label>
                    <input type="text" class="form-control" name="last_illness_injury"
                        value="{{ $user->health->last_illness_injury ?? '' }}"
                        placeholder="State dates and describe illness or injury">
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label>Medical Investigations History<span class="text-danger"> *</span></label>
                    <input type="text" class="form-control" name="medical_investigations"
                        value="{{ $user->health->medical_investigations ?? '' }}"
                        placeholder="State dates and result of blood, urine, X-ray, ECGs, etc.">
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label>Heart Disease, Diabetes, BP, TB, Jaundice, Cancer, Asthma, etc.<span class="text-danger"> *</span></label>
                    <textarea class="form-control" name="medical_history" rows="5"
                        placeholder="Do you now or have you had any of these diseases? If so specify with dates">{{ $user->health->medical_history ?? '' }}</textarea>
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

          // ===================== cm -> ft / inches auto conversion =====================

          function cmToFeet(cm) {
              if (cm == "" || isNaN(cm)) {
                  return "";
              }

              return (parseFloat(cm) / 30.48).toFixed(2);
          }

          function cmToInches(cm) {
              if (cm == "" || isNaN(cm)) {
                  return "";
              }

              return (parseFloat(cm) / 2.54).toFixed(2);
          }

          function bindConverter(inputSelector, outputSelector, type) {

              function calculate() {

                  let value = $(inputSelector).val();

                  if (value == "") {
                      $(outputSelector).val("");
                      return;
                  }

                  if (type == "feet") {
                      $(outputSelector).val(cmToFeet(value));
                  } else {
                      $(outputSelector).val(cmToInches(value));
                  }
              }

              calculate();

              $(document).on("input", inputSelector, calculate);
          }

          // Height
          bindConverter("#height_cm", "#height_ft", "feet");

          // Chest Inspiration
          bindConverter("#chest_insp_cm", "#chest_insp_inches", "inch");

          // Chest Expansion
          bindConverter("#chest_exp_cm", "#chest_exp_inches", "inch");

          // Abdomen
          bindConverter("#abdomen_cm", "#abdomen_inches", "inch");

      });
  </script>
  @endpush
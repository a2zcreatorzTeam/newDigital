<form action="#" id='occupationForm'>
     @csrf
     <h2 class="profile-section-title">Occupation & Income</h2>
     <div class="box-form-login">
         <div class="row">
             @php
                 $empFlag = $user->occupation->is_emaployemnt ?? '';
                 $bizFlag = $user->occupation->is_business ?? '';
                 if ($empFlag === 'Yes' && $bizFlag === 'Yes') {
                     $occupationType = 'Both';
                 } elseif ($empFlag === 'Yes') {
                     $occupationType = 'Employment';
                 } elseif ($bizFlag === 'Yes') {
                     $occupationType = 'Businessman';
                 } else {
                     $occupationType = '';
                 }
             @endphp
             <div class="col-12">
                 <div class="form-group">
                     <label>Occupation Type (پیشہ کی نوعیت)<span class="text-danger">*</span></label>
                     <select class="form-control account" id="occupation_type" required>
                         <option value="">Select Option</option>
                         <option value="Employment" {{ $occupationType === 'Employment' ? 'selected' : '' }}>Employment</option>
                         <option value="Businessman" {{ $occupationType === 'Businessman' ? 'selected' : '' }}>Businessman</option>
                         <option value="Both" {{ $occupationType === 'Both' ? 'selected' : '' }}>Both</option>
                     </select>
                     <input type="hidden" name="is_emaployemnt" id="is_emaployemnt" value="{{ $empFlag }}">
                     <input type="hidden" name="is_business" id="is_business" value="{{ $bizFlag }}">
                 </div>
             </div>

             <div id="employment_fields" class="row"></div>
             <div id="business_fields" class="row"></div>

             @php
                 $filerStatus = old('filer_status', $user->occupation->filer_status ?? '');
                 $ntnNumber = old('ntn_number', $user->occupation->ntn_number ?? '');
             @endphp
             <div class="col-6">
                 <div class="form-group">
                     <label>Filer Status (فائلر کی حیثیت)<span class="text-danger">*</span></label>
                     <select class="form-control account" name="filer_status" required>
                         <option value="">Select Option</option>
                         <option value="Filer" {{ $filerStatus === 'Filer' ? 'selected' : '' }}>Filer</option>
                         <option value="Non-Filer" {{ $filerStatus === 'Non-Filer' ? 'selected' : '' }}>Non-Filer</option>
                     </select>
                 </div>
             </div>
             <div class="col-6 js-ntn-wrap">
                 <div class="form-group">
                     <label>NTN Number (این ٹی این نمبر)<span class="text-danger">*</span></label>
                     <input type="text" class="form-control account" name="ntn_number" value="{{ $ntnNumber }}" maxlength="20" placeholder="Enter NTN Number">
                 </div>
             </div>

             <!-- If holding Land? -->
             <div class="col-6">
                 <div class="form-group">
                     <label>If holding Land? ((کیا زراعتی زمین ہے؟ (مکمل تفصیلات کے ساتھ)*</label>
                     <select class="form-control account" name="is_holding_land">
                         <option value="">Select Option</option>
                         <option value="Yes" {{ ($user->occupation->is_holding_land ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                         <option value="No" {{ ($user->occupation->is_holding_land ?? '') == 'No' ? 'selected' : '' }}>No</option>
                     </select>
                 </div>
             </div>

             <div id="land_fields" class="row"></div>

             <!-- Monthly Income -->
             <div class="col-6">
                 <div class="form-group">
                     <label>What is your average monthly income from all sources? (آپ کی تمام ذرائع سے حاصل کردہ ماہانہ آمدنی کیا ہے؟)*</label>
                     <input type="number" class="form-control account" value="{{$user->occupation->avaerage_monthly_income ?? ''}}" name="avaerage_monthly_income" placeholder="Rs.">
                 </div>
             </div>

             <!-- Defence / Airline Crew -->
             <div class="col-6">
                 <div class="form-group">
                     <label>If Defence or Ex-Defence Personal, commercial Airline Flight Crew or plant protection pilot? (کیا آپ فوجی/سابقہ فوجی، عملہ شہری ہوا بازی/تحفظ فصل کے ہوا باز ہیں؟)*</label>
                     <select class="form-control account" name="ex_defence_personal">
                         <option value="">Select Option</option>
                         <option value="Yes" {{ ($user->occupation->ex_defence_personal ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                         <option value="No" {{ ($user->occupation->ex_defence_personal ?? '') == 'No' ? 'selected' : '' }}>No</option>
                     </select>
                 </div>
             </div>

             <!-- Discharged on Medical Grounds -->
             <div class="col-6">
                 <div class="form-group">
                     <label>Have you ever been discharged on medical grounds from service / employeement? (کیا آپ کبھی طبی اسباب کی وجہ سے ملازمت/خدمات سے برخاست کئے گئے ہیں؟)*</label>
                     <select class="form-control account" name="discharged_on_medical">
                         <option value="">Select Option</option>
                         <option value="Yes" {{ ($user->occupation->discharged_on_medical ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                         <option value="No" {{ ($user->occupation->discharged_on_medical ?? '') == 'No' ? 'selected' : '' }}>No</option>
                     </select>
                 </div>
             </div>

             <!-- Hazardous Occupation -->
             <div class="col-6">
                 <div class="form-group">
                     <label>Are you presently engaged or intent to engage in any hazardous occupation or pastime? (کیا آپ فی الوقت کسی پر خطر پیشے یا مشغلے سے وابستہ ہیں یا آئندہ وابستہ ہونے کا ارادہ ہے؟)*</label>
                     <select class="form-control account" name="hazardous_occupation">
                         <option value="">Select Option</option>
                         <option value="Yes" {{ ($user->occupation->hazardous_occupation ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                         <option value="No" {{ ($user->occupation->hazardous_occupation ?? '') == 'No' ? 'selected' : '' }}>No</option>
                     </select>
                 </div>
             </div>

             <!-- Comments Section -->
             <div class="col-6">
                 <div class="form-group">
                     <label>Please Enter Your Comments (If any)? (براہ کرم اپنی رائے درج کریں (اگر کوئی ہو)*</label>
                     <textarea class="form-control account" name="comment" rows="3">{{ $user->occupation->comment ?? ''  }}</textarea>
                 </div>
             </div>
         </div>
         <div class="update-btn-container">
             <button type="submit" class="btn-update">Update Occupation</button>
         </div>
     </div>
 </form>






 @push('js')
 <script>
     $(document).ready(function() {
         $('#occupationForm').on('submit', function(e) {
             e.preventDefault();

             let formData = $(this).serialize();
             let isValid = true;

             // Simple Validation: Check if required fields are empty
             $(this).find('.form-control').each(function() {
                 if ($(this).prop('disabled') || !$(this).is(':visible')) {
                     return;
                 }

                 let fieldName = $(this).attr('name');
                 let fieldValue = ($(this).val() || '').toString().trim();

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
                 url: '{{ route("frontend.updateOccupation") }}', // Apna sahi route yahan likhein
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

         $('input[name="cnic_number"]').on('input', function() {
             let val = $(this).val().replace(/\D/g, ''); // Sirf digits rakho
             let newVal = '';

             if (val.length > 0) {
                 newVal += val.substr(0, 5);
             }
             if (val.length > 5) {
                 newVal += '-' + val.substr(5, 7);
             }
             if (val.length > 12) {
                 newVal += '-' + val.substr(12, 1);
             }

             $(this).val(newVal.substring(0, 15)); // Max length 15 characters
         });


         $('input[name="mobile_number"]').on('input', function() {
             // Sirf digits allow karein
             let val = $(this).val().replace(/\D/g, '');
             let newVal = '';

             if (val.length > 0) {
                 // Pehle 4 digits (e.g., 0321)
                 newVal += val.substr(0, 4);
             }
             if (val.length > 4) {
                 // Phir dash aur baki ke 7 digits
                 newVal += '-' + val.substr(4, 7);
             }

             // Final value set karein (Total length 12: 4 digits + 1 dash + 7 digits)
             $(this).val(newVal.substring(0, 12));
         });

         // ===================== Occupation / Business / Land dynamic fields =====================

         function toggleOccupationFields() {
             let type = $('#occupation_type').val();
             let employment = 'No';
             let business = 'No';

             if (type === 'Employment') {
                 employment = 'Yes';
             } else if (type === 'Businessman') {
                 business = 'Yes';
             } else if (type === 'Both') {
                 employment = 'Yes';
                 business = 'Yes';
             }

             $('#is_emaployemnt').val(employment);
             $('#is_business').val(business);

             // Employment Fields
             if (employment === 'Yes') {
                 $('#employment_fields').html(`
                    <div class="col-md-6 px-0 px-sm-3">
                        <label>
                            Designation / Job Title
                            <span class="requi">*</span>
                        </label>
                        <input type="text"
                               name="employment_designation"
                               value="{{ $user->occupation->employment_designation ?? '' }}"
                               class="form-control jbl-dynamic-input"
                               required>
                    </div>

                    <div class="col-md-6 px-0 px-sm-3">
                        <label>
                            Company Name
                            <span class="requi">*</span>
                        </label>
                        <input type="text"
                               name="employment_company_name"
                               value="{{ $user->occupation->employment_company_name ?? '' }}"
                               class="form-control jbl-dynamic-input"
                               required>
                    </div>
                `);
             } else {
                 $('#employment_fields').html('');
             }

             // Business Fields
             if (business === 'Yes') {
                 $('#business_fields').html(`
                    <div class="col-md-6 px-0 px-sm-3">
                        <label>
                            Business Name
                            <span class="requi">*</span>
                        </label>
                        <input type="text"
                               name="business_name"
                               value="{{ $user->occupation->business_name ?? '' }}"
                               class="form-control jbl-dynamic-input"
                               required>
                    </div>

                    <div class="col-md-6 px-0 px-sm-3">
                        <label>
                            Nature of Business
                            <span class="requi">*</span>
                        </label>
                        <input type="text"
                               name="nature_of_business"
                               value="{{ $user->occupation->nature_of_business ?? '' }}"
                               class="form-control jbl-dynamic-input"
                               placeholder="e.g. Pharmacy, Electronics, Construction"
                               required>
                    </div>
                `);
             } else {
                 $('#business_fields').html('');
             }
         }

         // Page Load
         toggleOccupationFields();

         // Change Events
         $('#occupation_type').on('change', toggleOccupationFields);

         function toggleLandFields() {

             let holdingLand = $('select[name="is_holding_land"]').val();

             if (holdingLand === 'Yes') {
                 $('#land_fields').html(`
                    <div class="col-md-6 px-0 px-sm-3">
                        <label>
                            Land Unit (زمین کی اکائی)
                            <span class="requi">*</span>
                        </label>
                        <select name="land_unit" class="form-control jbl-dynamic-input" required>
                            <option value="">Select Unit</option>
                            <option value="Marla" {{ ($user->occupation->land_unit ?? '') == 'Marla' ? 'selected' : '' }}>Marla (مرلہ)</option>
                            <option value="Kanal" {{ ($user->occupation->land_unit ?? '') == 'Kanal' ? 'selected' : '' }}>Kanal (کنال)</option>
                            <option value="Acre" {{ ($user->occupation->land_unit ?? '') == 'Acre' ? 'selected' : '' }}>Acre (ایکڑ)</option>
                            <option value="Square Yard" {{ ($user->occupation->land_unit ?? '') == 'Square Yard' ? 'selected' : '' }}>Square Yard / Gaz (گز)</option>
                            <option value="Square Feet" {{ ($user->occupation->land_unit ?? '') == 'Square Feet' ? 'selected' : '' }}>Square Feet (مربع فٹ)</option>
                            <option value="Hectare" {{ ($user->occupation->land_unit ?? '') == 'Hectare' ? 'selected' : '' }}>Hectare (ہیکٹر)</option>
                        </select>
                    </div>

                    <div class="col-md-6 px-0 px-sm-3">
                        <label>
                            Total Area (کل رقبہ)
                            <span class="requi">*</span>
                        </label>
                        <input type="number" step="0.01" min="0"
                               name="total_acreage"
                               value="{{ $user->occupation->total_acreage ?? '' }}"
                               class="form-control jbl-dynamic-input"
                               placeholder="Enter value in selected unit"
                               required>
                    </div>

                    <div class="col-md-6 px-0 px-sm-3">
                        <label>
                            Land Location
                            <span class="requi">*</span>
                        </label>
                        <input type="text"
                               name="land_location"
                               value="{{ $user->occupation->land_location ?? '' }}"
                               class="form-control jbl-dynamic-input"
                               required>
                    </div>

                    <div class="col-md-6 px-0 px-sm-3">
                        <label>
                            Land Type
                            <span class="requi">*</span>
                        </label>
                        <select name="land_type" class="form-control jbl-dynamic-input" required>
                            <option value="">Select Type</option>
                            <option value="Agricultural" {{ ($user->occupation->land_type ?? '') == 'Agricultural' ? 'selected' : '' }}>Agricultural</option>
                            <option value="Commercial" {{ ($user->occupation->land_type ?? '') == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                            <option value="Residential" {{ ($user->occupation->land_type ?? '') == 'Residential' ? 'selected' : '' }}>Residential</option>
                        </select>
                    </div>

                    <div class="col-md-6 px-0 px-sm-3">
                        <label>
                            Estimated Land Value
                            <span class="requi">*</span>
                        </label>
                        <input type="number" step="0.01"
                               name="estimated_land_value"
                               value="{{ $user->occupation->estimated_land_value ?? '' }}"
                               class="form-control jbl-dynamic-input"
                               required>
                    </div>
                `);
             } else {
                 $('#land_fields').html('');
             }
         }

         // Page Load
         toggleLandFields();

         // Change Event
         $(document).on('change', 'select[name="is_holding_land"]', function() {
             toggleLandFields();
         });

     });
 </script>
 @endpush
<form action="#" id="health_info">
    @csrf

    <h2 class="profile-section-title">Health Information</h2>

    <div class="box-form-login">
        <div class="row">

            @include('frontend.partials.health_measurements', [
                'health' => $user->health ?? null,
                'fieldClass' => 'form-control',
                'selectClass' => 'form-control',
                'colClass' => 'col-6 mb-3',
            ])

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

            // Sync unit conversions into hidden DB fields first
            $('#height_value, #weight_change_type').trigger('change');

            let formData = $(this).serialize();
            let isValid = true;

            $(this).find('input:visible, select:visible, textarea:visible').each(function() {
                if (!$(this).prop('required')) {
                    return;
                }
                let fieldValue = ($(this).val() || '').toString().trim();
                if (fieldValue === '') {
                    $(this).css('border-color', 'red');
                    isValid = false;
                } else {
                    $(this).css('border-color', '');
                }
            });

            if (!isValid) {
                Swal.fire('Error', 'Please fill all required fields.', 'error');
                return false;
            }

            $.ajax({
                method: 'POST',
                url: '{{ route("frontend.updateHealth") }}',
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
                        Swal.fire('Success', response.message || 'Health info updated successfully', 'success');
                    } else {
                        Swal.fire('Error', response.message || 'Unable to update health info', 'error');
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorString = '';
                        $.each(errors, function(key, value) {
                            errorString += value[0] + '<br>';
                            $('[name="' + key + '"]').css('border-color', 'red');
                        });
                        Swal.fire({
                            title: 'Validation Error',
                            html: errorString,
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

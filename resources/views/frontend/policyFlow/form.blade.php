<fieldset>
    <div class="form-card">
        <nav>
            <div id="nav-tab" role="tablist" class="nav nav-tabs ib-acq-navtab">
                <a id="nav-Personal_Details-tab" data-toggle="tab" href="#nav-Personal_Details" role="tab" aria-controls="nav-Personal_Details" aria-selected="true" class="nav-item nav-link acq-nav-btn active">Personal Details</a>
                <a id="basic_Details-tab" data-toggle="tab" href="#basic_Details" role="tab" aria-controls="basic_Details" aria-selected="true" class="nav-item nav-link acq-nav-btn">Basic Details</a>
                <a id="occupation-tab" data-toggle="tab" href="#occupation" role="tab" aria-controls="occupation" aria-selected="false" class="nav-item nav-link acq-nav-btn" contenteditable="false" style="cursor: pointer;">Occupation</a>
                <a id="product_detail-tab" data-toggle="tab" href="#product_detail" role="tab" aria-controls="product_detail" aria-selected="false" class="nav-item nav-link acq-nav-btn" contenteditable="false" style="cursor: pointer;">Product Details</a>
                <a id="family-history-tab" data-toggle="tab" href="#family_history" role="tab" aria-controls="family_history" aria-selected="false" class="nav-item nav-link acq-nav-btn" contenteditable="false" style="cursor: pointer;">Family History</a>
                <a id="health_info-tab" data-toggle="tab" href="#health_info" role="tab" aria-controls="health_info" aria-selected="false" class="nav-item nav-link acq-nav-btn" contenteditable="false" style="cursor: pointer;">Health Information</a>
            </div>
        </nav>
        <div id="nav-tabContent" class="tab-content">

            @include('frontend.policyFlow.form.Personal_Details',['user'=>$user])
            @include('frontend.policyFlow.form.basic_Details',['user'=>$user])
            @include('frontend.policyFlow.form.occupation',['user'=>$user])
            @include('frontend.policyFlow.form.product_detail',['user'=>$user,'id'=>$id,'product'=>$product,'policy_data'=>$policy_data])
            @include('frontend.policyFlow.form.health_info',['user'=>$user])
            @include('frontend.policyFlow.form.family_history',['user'=>$user])

        </div>
    </div>


</fieldset>


@push('js')
<script>
    $(document).ready(function() {
        $('#user_details_submited').on('click', function(e) {
            e.preventDefault();
            let formData = $('#msform').serialize();
            console.log(formData);


            // // AJAX Call
            $.ajax({
                method: 'POST',
                url: '{{ route("frontend.policyUserDataSave") }}',
                data: formData,
                beforeSend: function() {
                    Swal.fire({
                        title: 'Inserting Data...',
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
                        window.location.href = response.redirect_url;
                        // Swal.fire({
                        //     title: 'Success!',
                        //     text: 'Data Save successfully.',
                        //     icon: 'success',
                        //     timer: 2000
                        // });
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
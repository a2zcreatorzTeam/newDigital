<fieldset>
    <div class="form-card">
        <nav class="dashboard-policy-tabs-wrap" aria-label="Policy form sections">
            <div id="nav-tab" role="tablist" class="nav nav-tabs ib-acq-navtab dashboard-policy-tabs">
                <a id="nav-Personal_Details-tab" data-toggle="tab" href="#nav-Personal_Details" role="tab" aria-controls="nav-Personal_Details" aria-selected="true" class="nav-item nav-link acq-nav-btn active"><span class="tab-step">1</span><span class="tab-label">Address Details</span></a>
                <a id="basic_Details-tab" data-toggle="tab" href="#basic_Details" role="tab" aria-controls="basic_Details" aria-selected="false" class="nav-item nav-link acq-nav-btn"><span class="tab-step">2</span><span class="tab-label">Basic Details</span></a>
                <a id="occupation-tab" data-toggle="tab" href="#occupation" role="tab" aria-controls="occupation" aria-selected="false" class="nav-item nav-link acq-nav-btn"><span class="tab-step">3</span><span class="tab-label">Occupation</span></a>
                <a id="product_detail-tab" data-toggle="tab" href="#product_detail" role="tab" aria-controls="product_detail" aria-selected="false" class="nav-item nav-link acq-nav-btn"><span class="tab-step">4</span><span class="tab-label">Product Details</span></a>
                <a id="family-history-tab" data-toggle="tab" href="#family_history" role="tab" aria-controls="family_history" aria-selected="false" class="nav-item nav-link acq-nav-btn"><span class="tab-step">5</span><span class="tab-label">Family History</span></a>
                <a id="women-tab" data-toggle="tab" href="#women" role="tab" aria-controls="women" aria-selected="false" class="nav-item nav-link acq-nav-btn"><span class="tab-step">6</span><span class="tab-label">Female Section</span></a>
                <a id="nominee-tab" data-toggle="tab" href="#nominee" role="tab" aria-controls="nominee" aria-selected="false" class="nav-item nav-link acq-nav-btn"><span class="tab-step">7</span><span class="tab-label">Nominee</span></a>
                <a id="documents-tab" data-toggle="tab" href="#documents" role="tab" aria-controls="documents" aria-selected="false" class="nav-item nav-link acq-nav-btn"><span class="tab-step">8</span><span class="tab-label">Documents</span></a>
                <a id="health_info-tab" data-toggle="tab" href="#health_info" role="tab" aria-controls="health_info" aria-selected="false" class="nav-item nav-link acq-nav-btn"><span class="tab-step">9</span><span class="tab-label">Health Information</span></a>
            </div>
        </nav>
        <div id="nav-tabContent" class="tab-content">

            @include('frontend.policyFlow.form.Personal_Details',['user'=>$user])
            @include('frontend.policyFlow.form.basic_Details',['user'=>$user, 'cities'=>$cities ?? collect()])
            @include('frontend.policyFlow.form.occupation',['user'=>$user])
            @include('frontend.policyFlow.form.product_detail',['user'=>$user,'id'=>$id,'product'=>$product,'policy_data'=>$policy_data])
            @include('frontend.policyFlow.form.health_info',['user'=>$user])
            @include('frontend.policyFlow.form.family_history',['user'=>$user])
            @include('frontend.policyFlow.form.women',['user'=>$user])
            @include('frontend.policyFlow.form.nominee',['user'=>$user])
            @include('frontend.policyFlow.form.documents',['user'=>$user])

        </div>

        @include('frontend.policyFlow.form.preview')
        @include('frontend.policyFlow.form.queue_autosave')
    </div>


</fieldset>


@push('js')
<script>
    $(document).ready(function() {

        // Saare tab ids ek array mein (order important hai)
        let tabOrder = [
            '#nav-Personal_Details-tab',
            '#basic_Details-tab',
            '#occupation-tab',
            '#product_detail-tab',
            '#family-history-tab',
            '#women-tab',
            '#nominee-tab',
            '#documents-tab',
            '#health_info-tab'
        ];

        var ignoreTabGuard = false;

        function paneForTabId(tabId) {
            var href = $(tabId).attr('href');
            return href ? $(href) : $();
        }

        function validatePane($pane) {
            if (!$pane || !$pane.length) {
                return true;
            }
            if (typeof window.validatePolicyStepFields === 'function') {
                return window.validatePolicyStepFields($pane);
            }
            return true;
        }

        function scrollToFirstStepError($pane) {
            if (!$pane || !$pane.length) {
                return;
            }
            var $err = $pane.find('.error-border').filter('input, select, textarea').first();
            if (!$err.length) {
                $err = $pane.find('.error-border').first();
            }
            if (!$err.length) {
                $err = $pane.find('.error-message').first();
            }
            if (!$err.length || !$err.offset()) {
                return;
            }
            $('html, body').stop(true).animate({ scrollTop: $err.offset().top - 120 }, 350);
            if ($err.is('input, select, textarea')) {
                $err.trigger('focus');
            }
        }

        window.scrollToPolicyStepError = scrollToFirstStepError;
        window.validatePolicyFormPane = validatePane;

        function scrollToFormCardTop() {
            let $target = $('.form-card').first();
            if (!$target.length) {
                $target = $('#nav-tab');
            }
            if (!$target.length) {
                window.scrollTo({ top: 0, behavior: 'smooth' });
                return;
            }

            let offsetTop = $target.offset().top - 20;
            $('html, body').stop(true).animate({ scrollTop: offsetTop }, 350);
        }

        function showTab(tabId) {
            ignoreTabGuard = true;
            $(tabId).tab('show');
            ignoreTabGuard = false;
        }

        function goToTab(direction) {
            // Current active tab ka index nikalna
            let currentIndex = tabOrder.findIndex(function(tabId) {
                return $(tabId).hasClass('active');
            });

            let newIndex = currentIndex;

            if (direction === 'next') {
                var $currentPane = paneForTabId(tabOrder[currentIndex]);
                if (!validatePane($currentPane)) {
                    scrollToFirstStepError($currentPane);
                    return;
                }
                var ageVal = parseInt($('input[name="age_nearest_date"]').val(), 10);
                if ($('#basic_Details-tab').hasClass('active') && !isNaN(ageVal) && ageVal < 18) {
                    Swal.fire('Error', 'Proposer must be 18 years or older.');
                    return;
                }
                newIndex = currentIndex + 1;
            } else if (direction === 'prev') {
                newIndex = currentIndex - 1;
            }

            // Boundary check
            if (newIndex >= 0 && newIndex < tabOrder.length) {
                showTab(tabOrder[newIndex]);
            }
        }

        // Next button click (event delegation - kyunki buttons dynamic/multiple jagah hain)
        $(document).on('click', '.ib-next-btn', function() {
            goToTab('next');
        });

        // Previous button click
        $(document).on('click', '.ib-prev-btn', function() {
            goToTab('prev');
        });

        // Block jumping ahead to a later tab while the current (or in-between) step is invalid
        $(document).on('show.bs.tab', '#nav-tab a[data-toggle="tab"]', function(e) {
            if (ignoreTabGuard) {
                return;
            }

            var targetId = '#' + e.target.id;
            var targetIndex = tabOrder.indexOf(targetId);
            var currentIndex = tabOrder.findIndex(function(tabId) {
                return $(tabId).hasClass('active');
            });

            if (targetIndex < 0 || currentIndex < 0 || targetIndex <= currentIndex) {
                return;
            }

            for (var i = currentIndex; i < targetIndex; i++) {
                var $pane = paneForTabId(tabOrder[i]);
                if (!validatePane($pane)) {
                    e.preventDefault();
                    if (i !== currentIndex) {
                        showTab(tabOrder[i]);
                    }
                    scrollToFirstStepError($pane);
                    return;
                }
            }
        });

        // After any tab switch (Next / Previous / tab click), start at the top of the card
        $(document).on('shown.bs.tab', '#nav-tab a[data-toggle="tab"]', function() {
            var href = $(this).attr('href');
            var $pane = href ? $(href) : $();
            if ($pane.find('.error-message').length) {
                scrollToFirstStepError($pane);
                return;
            }
            scrollToFormCardTop();
        });

    });
    $(document).ready(function() {
        let isSubmittingPolicy = false;

        function unlockAddressFieldsForSubmit() {
            $('#msform .dependent-address-field').prop('disabled', false);
        }

        function submitPolicyApplication($triggerBtn) {
            if (isSubmittingPolicy) {
                return;
            }

            unlockAddressFieldsForSubmit();

            let form = document.getElementById('msform');
            if (!form) {
                Swal.fire('Error', 'Form not found. Please refresh the page.', 'error');
                return;
            }

            if (typeof window.syncPolicyPreviewToForm === 'function') {
                window.syncPolicyPreviewToForm();
            }

            let formData = new FormData(form);
            let csrfToken = $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val();
            if (csrfToken && !formData.has('_token')) {
                formData.append('_token', csrfToken);
            }

            isSubmittingPolicy = true;
            $('#policy_preview_confirm_btn, #policy_preview_confirm_btn_bottom, #user_details_submited').prop('disabled', true);

            $.ajax({
                method: 'POST',
                url: '{{ route("frontend.policyUserDataSave") }}',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': csrfToken || ''
                },
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

                    if (response.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message || 'Policy data saved successfully.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(function() {
                            if (response.redirect_url) {
                                window.location.replace(response.redirect_url);
                            }
                        });
                    } else {
                        isSubmittingPolicy = false;
                        $('#policy_preview_confirm_btn, #policy_preview_confirm_btn_bottom, #user_details_submited').prop('disabled', false);
                        Swal.fire('Error', response.message || 'Something went wrong', 'error');
                    }
                },
                error: function(xhr) {
                    isSubmittingPolicy = false;
                    $('#policy_preview_confirm_btn, #policy_preview_confirm_btn_bottom, #user_details_submited').prop('disabled', false);
                    Swal.close();

                    if (xhr.status === 419) {
                        Swal.fire('Session Expired', 'Please refresh the page and try again.', 'error');
                        return;
                    }

                    if (xhr.status === 422) {
                        let errors = (xhr.responseJSON && xhr.responseJSON.errors) ? xhr.responseJSON.errors : {};
                        let errorString = '';

                        $.each(errors, function(key, value) {
                            errorString += (value[0] || value) + '<br>';
                            $('[name="' + key + '"]').css('border-color', 'red');
                        });

                        if (!errorString) {
                            errorString = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Please fix the highlighted fields.';
                        }

                        if (typeof window.hidePolicyApplicationPreview === 'function') {
                            window.hidePolicyApplicationPreview('#health_info-tab');
                        }

                        // Focus first invalid field when possible
                        var firstErrorKey = Object.keys(errors)[0];
                        if (firstErrorKey) {
                            var $errField = $('[name="' + firstErrorKey + '"]').first();
                            if ($errField.length) {
                                var $pane = $errField.closest('.tab-pane');
                                if ($pane.length && $pane.attr('id')) {
                                    var tabHref = '#' + $pane.attr('id');
                                    var $tab = $('#nav-tab a[href="' + tabHref + '"]');
                                    if ($tab.length) {
                                        $tab.tab('show');
                                    }
                                }
                                setTimeout(function() {
                                    $errField.trigger('focus');
                                }, 250);
                            }
                        }

                        Swal.fire({
                            title: 'Validation Error',
                            html: errorString,
                            icon: 'error'
                        });
                    } else {
                        let message = 'Something went wrong on the server.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire('Error', message, 'error');
                    }
                }
            });
        }

        window.submitPolicyApplicationFromPreview = function() {
            submitPolicyApplication($('#policy_preview_confirm_btn'));
        };

        // Opens review preview before payment (does not save yet)
        $('#user_details_submited').on('click', function(e) {
            e.preventDefault();
            var $healthPane = $('#health_info');
            if (typeof window.validatePolicyStepFields === 'function' && !window.validatePolicyStepFields($healthPane)) {
                if (typeof window.scrollToPolicyStepError === 'function') {
                    window.scrollToPolicyStepError($healthPane);
                }
                return;
            }
            if (typeof window.showPolicyApplicationPreview === 'function') {
                window.showPolicyApplicationPreview();
            } else {
                submitPolicyApplication($(this));
            }
        });

        $(document).on('click', '#policy_preview_confirm_btn, #policy_preview_confirm_btn_bottom', function(e) {
            e.preventDefault();
            submitPolicyApplication($(this));
        });










        // dual option visibility is handled globally by dual-nationality.js








        // business logics 
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







        // Proposer & Life Proposed are same?
        function toggleSamePersonFields() {
            let same_person = $('#is_same_person').val();
            if (typeof window.applyLifeProposedLogic === 'function') {
                window.applyLifeProposedLogic(same_person === 'Yes');
            }
        }

        // Page Load
        toggleSamePersonFields();

        // Dropdown Change
        $('#is_same_person').on('change', toggleSamePersonFields);












        function toggleLandFields() {

            let holdingLand = $('select[name="is_holding_land"]').val();

            if (holdingLand === 'Yes') {

                $('#land_fields').html(`

            <div class="col-md-6 px-0 px-sm-3">
                <label>
                    Land Unit (<span lang="ur" dir="rtl" class="urdu-text">زمین کی اکائی</span>)
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
                    Total Area (<span lang="ur" dir="rtl" class="urdu-text">کل رقبہ</span>)
                    <span class="requi">*</span>
                </label>
                <input type="number"
                       step="0.01"
                       min="0"
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
                <input type="number"
                       step="0.01"
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
        toggleOccupationFields();
        toggleLandFields();

        $(document).on('change', 'select[name="is_holding_land"]', function() {
            toggleLandFields();
        });









    });


    $(document).ready(function() {
        // Health measurement conversion is handled by frontend.partials.health_measurements
    });


    $(function() {

        let captcha = "";

        function generateCaptcha(length = 6) {

            let chars = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";

            captcha = "";

            for (let i = 0; i < length; i++) {

                captcha += chars.charAt(
                    Math.floor(Math.random() * chars.length)
                );

            }

            $("#captcha-code").text(captcha);

            $("#captcha-answer").val("");

            $("#captcha-success,#captcha-error").addClass("d-none");

            $("#captcha-answer").css("border-color", "#ced4da");

            $("#user_details_submited").prop("disabled", true);

        }

        generateCaptcha();

        $("#refresh-captcha").click(function() {

            generateCaptcha();

        });

        $("#captcha-answer").on("input", function() {

            let value = $(this).val().toUpperCase();

            if (value.length != captcha.length) {

                $("#captcha-success,#captcha-error").addClass("d-none");

                $("#user_details_submited").prop("disabled", true);

                $(this).css("border-color", "#ced4da");

                return;

            }

            if (value === captcha) {

                $("#captcha-success").removeClass("d-none");

                $("#captcha-error").addClass("d-none");

                $("#user_details_submited").prop("disabled", false);

                $(this).css("border-color", "#198754");

            } else {

                $("#captcha-error").removeClass("d-none");

                $("#captcha-success").addClass("d-none");

                $("#user_details_submited").prop("disabled", true);

                $(this).css("border-color", "#dc3545");

            }

        });

    });
</script>
@endpush

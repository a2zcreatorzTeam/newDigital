<fieldset>
    <div class="form-card">
        <nav class="dashboard-policy-tabs-wrap" aria-label="Policy form sections">
            <div id="nav-tab" role="tablist" class="nav nav-tabs ib-acq-navtab dashboard-policy-tabs">
                <a id="nav-Personal_Details-tab" data-toggle="tab" href="#nav-Personal_Details" role="tab" aria-controls="nav-Personal_Details" aria-selected="true" class="nav-item nav-link acq-nav-btn active"><span class="tab-step">1</span><span class="tab-label">{{ policy_label('address_details') }}</span></a>
                <a id="basic_Details-tab" data-toggle="tab" href="#basic_Details" role="tab" aria-controls="basic_Details" aria-selected="false" class="nav-item nav-link acq-nav-btn"><span class="tab-step">2</span><span class="tab-label">{{ policy_label('basic_details') }}</span></a>
                <a id="occupation-tab" data-toggle="tab" href="#occupation" role="tab" aria-controls="occupation" aria-selected="false" class="nav-item nav-link acq-nav-btn"><span class="tab-step">3</span><span class="tab-label">{{ policy_label('occupation') }}</span></a>
                <a id="product_detail-tab" data-toggle="tab" href="#product_detail" role="tab" aria-controls="product_detail" aria-selected="false" class="nav-item nav-link acq-nav-btn"><span class="tab-step">4</span><span class="tab-label">{{ policy_label('product_details') }}</span></a>
                <a id="family-history-tab" data-toggle="tab" href="#family_history" role="tab" aria-controls="family_history" aria-selected="false" class="nav-item nav-link acq-nav-btn"><span class="tab-step">5</span><span class="tab-label">{{ policy_label('family_history') }}</span></a>
                <a id="women-tab" data-toggle="tab" href="#women" role="tab" aria-controls="women" aria-selected="false" class="nav-item nav-link acq-nav-btn @if(($user->basicDetail->gender ?? '') !== 'Female') d-none @endif"><span class="tab-step">6</span><span class="tab-label">{{ policy_label('female_section') }}</span></a>
                <a id="nominee-tab" data-toggle="tab" href="#nominee" role="tab" aria-controls="nominee" aria-selected="false" class="nav-item nav-link acq-nav-btn"><span class="tab-step">7</span><span class="tab-label">{{ policy_label('nominee') }}</span></a>
                <a id="documents-tab" data-toggle="tab" href="#documents" role="tab" aria-controls="documents" aria-selected="false" class="nav-item nav-link acq-nav-btn"><span class="tab-step">8</span><span class="tab-label">{{ policy_label('documents') }}</span></a>
                <a id="health_info-tab" data-toggle="tab" href="#health_info" role="tab" aria-controls="health_info" aria-selected="false" class="nav-item nav-link acq-nav-btn"><span class="tab-step">9</span><span class="tab-label">{{ policy_label('health_information') }}</span></a>
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
            $('html, body').stop(true).animate({ scrollTop: Math.max(0, $err.offset().top - getStickyHeaderOffset()) }, 350);
            if ($err.is('input, select, textarea')) {
                $err.trigger('focus');
            }
        }

        window.scrollToPolicyStepError = scrollToFirstStepError;
        window.validatePolicyFormPane = validatePane;

        function getStickyHeaderOffset() {
            var $sticky = $('#sticky-header').first();
            var stickyH = ($sticky.length && $sticky.is(':visible')) ? ($sticky.outerHeight() || 0) : 0;
            // Extra breathing room so section headings are not hidden under sticky header
            return stickyH + 24;
        }

        // Horizontal nav only — never use scrollIntoView (it can move the page vertically).
        function scrollActiveTabIntoNavView($tab) {
            var $wrap = $('.dashboard-policy-tabs-wrap').first();
            if (!$wrap.length || !$tab || !$tab.length) {
                return;
            }
            var tabEl = $tab.get(0);
            var wrapEl = $wrap.get(0);
            if (!tabEl || !wrapEl) {
                return;
            }
            var left = tabEl.offsetLeft - (wrapEl.clientWidth / 2) + (tabEl.clientWidth / 2);
            $wrap.stop(true).animate({ scrollLeft: Math.max(0, left) }, 300);
        }

        // Page scroll only for explicit step navigation (click / Next / Previous).
        function scrollToFormCardTop() {
            var $target = $('#nav-tabContent .tab-pane.active.show').first();
            if (!$target.length) {
                $target = $('.form-card').first();
            }
            if (!$target.length) {
                $target = $('#nav-tab');
            }
            if (!$target.length || !$target.offset()) {
                return;
            }

            var offsetTop = $target.offset().top - getStickyHeaderOffset();
            $('html, body').stop(true).animate({ scrollTop: Math.max(0, offsetTop) }, 420);
        }

        function showTab(tabId) {
            ignoreTabGuard = true;
            $(tabId).tab('show');
            ignoreTabGuard = false;
        }

        // Page scroll only for explicit step navigation (click / Next / Previous).
        var allowPageScrollOnTabShow = false;

        function isTabVisible(tabId) {
            if (tabId === '#women-tab') {
                return window.isFemaleSectionApplicable ? window.isFemaleSectionApplicable() : (($('#gender').val() || '') === 'Female');
            }
            var $tab = $(tabId);
            if (!$tab.length) {
                return false;
            }
            return $tab.is(':visible') && !$tab.hasClass('d-none');
        }

        function nextVisibleTabIndex(fromIndex, direction) {
            var step = direction === 'next' ? 1 : -1;
            var i = fromIndex + step;
            while (i >= 0 && i < tabOrder.length) {
                if (isTabVisible(tabOrder[i])) {
                    return i;
                }
                i += step;
            }
            return -1;
        }

        window.isFemaleSectionApplicable = function () {
            // Female section applies to the life proposed / insured person.
            if (($('#is_same_person').val() || '') === 'No') {
                var lpGender = ($('#life_proposed_gender').val()
                    || $('select[name="life_proposed_gender"]').val()
                    || '').trim();
                if (lpGender) {
                    return lpGender === 'Female';
                }
            }
            return (($('#gender').val() || '').trim() === 'Female');
        };

        window.toggleFemaleSectionVisibility = function () {
            var show = window.isFemaleSectionApplicable();
            var $tab = $('#women-tab');
            var $pane = $('#women');

            if (show) {
                $tab.removeClass('d-none').attr('aria-hidden', 'false').show();
                $pane.attr('aria-hidden', 'false');
            } else {
                $tab.addClass('d-none').attr('aria-hidden', 'true').hide();
                $pane.attr('aria-hidden', 'true');
                // If user is currently on Female Section, move to Nominee.
                if ($tab.hasClass('active') || $pane.hasClass('active') || $pane.hasClass('show')) {
                    allowPageScrollOnTabShow = false;
                    showTab('#nominee-tab');
                }
            }
        };

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
                newIndex = nextVisibleTabIndex(currentIndex, 'next');
            } else if (direction === 'prev') {
                newIndex = nextVisibleTabIndex(currentIndex, 'prev');
            }

            // Boundary check
            if (newIndex >= 0 && newIndex < tabOrder.length) {
                allowPageScrollOnTabShow = true;
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

        $(document).on('change', '#gender, #life_proposed_gender, #is_same_person, select[name="life_proposed_gender"]', function () {
            if (typeof window.toggleFemaleSectionVisibility === 'function') {
                window.toggleFemaleSectionVisibility();
            }
        });
        window.toggleFemaleSectionVisibility();

        // Explicit click: switch step + smooth-scroll page. Manual page scroll never goes through here.
        $(document).on('click', '#nav-tab a.acq-nav-btn[data-toggle="tab"]', function(e) {
            e.preventDefault();
            var $tab = $(this);
            if ($tab.hasClass('d-none') || !$tab.is(':visible')) {
                return;
            }
            allowPageScrollOnTabShow = true;
            if ($tab.hasClass('active')) {
                scrollActiveTabIntoNavView($tab);
                scrollToFormCardTop();
                allowPageScrollOnTabShow = false;
                return;
            }
            $tab.tab('show');
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
                if (!isTabVisible(tabOrder[i])) {
                    continue;
                }
                var $pane = paneForTabId(tabOrder[i]);
                if (!validatePane($pane)) {
                    e.preventDefault();
                    allowPageScrollOnTabShow = false;
                    if (i !== currentIndex) {
                        showTab(tabOrder[i]);
                    }
                    scrollToFirstStepError($pane);
                    return;
                }
            }
        });

        // Block opening Female Section when gender is not Female
        $(document).on('show.bs.tab', '#women-tab', function (e) {
            if (ignoreTabGuard) {
                return;
            }
            if (!isTabVisible('#women-tab')) {
                e.preventDefault();
            }
        });

        // After tab switch: update highlight + horizontal nav.
        // Page scroll only when the user clicked a step / Next / Previous (not from other tab triggers).
        $(document).on('shown.bs.tab', '#nav-tab a[data-toggle="tab"]', function() {
            var $tab = $(this);
            var href = $tab.attr('href');
            var $pane = href ? $(href) : $();
            var shouldScrollPage = allowPageScrollOnTabShow;
            allowPageScrollOnTabShow = false;

            $('#nav-tab a.acq-nav-btn').attr('aria-selected', 'false');
            $tab.attr('aria-selected', 'true');

            scrollActiveTabIntoNavView($tab);

            if (!shouldScrollPage) {
                return;
            }

            if ($pane.find('.error-message, .error-border').length) {
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

            if (typeof window.policyUploadHasPending === 'function' && window.policyUploadHasPending()) {
                Swal.fire('Please wait', 'Some documents are still uploading. Try again in a moment.', 'warning');
                return;
            }

            if (typeof window.policyUploadHasMissingRequired === 'function' && window.policyUploadHasMissingRequired()) {
                Swal.fire('Documents required', 'Please wait for required documents to finish uploading, then try again.', 'warning');
                return;
            }

            let formData = typeof window.buildPolicyFormDataWithoutFiles === 'function'
                ? window.buildPolicyFormDataWithoutFiles(form)
                : new FormData(form);
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
                    Designation / Job Title (عہدہ / ملازمت کا عنوان)
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
                    Company Name (کمپنی کا نام)
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
                    Business Name (کاروبار کا نام)
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
                    Nature of Business (کاروبار کی نوعیت)
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
                    Land Location (زمین کا مقام)
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
                    Land Type (زمین کی قسم)
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
                    Estimated Land Value (زمین کی تخمینی قیمت)
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

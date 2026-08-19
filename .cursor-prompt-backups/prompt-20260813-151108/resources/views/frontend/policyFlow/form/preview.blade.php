{{-- Application review preview (shown before payment / voucher redirect) --}}
<div id="policy_application_preview" class="policy-preview" style="display:none;" aria-live="polite">
    <div class="policy-preview__hero">
        <div class="policy-preview__hero-text">
            <p class="policy-preview__eyebrow">Almost there</p>
            <h2 class="policy-preview__title">Review Your Application</h2>
            <p class="policy-preview__subtitle">
                Check every section below. You can edit values here, or open a section to make larger changes.
                Confirm when everything looks correct to continue to payment.
            </p>
        </div>
        <div class="policy-preview__hero-actions">
            <button type="button" class="btn policy-preview__btn-secondary" id="policy_preview_back_btn">
                <i class="fas fa-arrow-left me-1"></i> Back to Form
            </button>
            <button type="button" class="btn policy-preview__btn-primary" id="policy_preview_confirm_btn">
                Confirm &amp; Proceed to Payment <i class="fas fa-arrow-right ms-1"></i>
            </button>
        </div>
    </div>

    <div id="policy_preview_sections" class="policy-preview__sections"></div>

    <div class="policy-preview__footer">
        <button type="button" class="btn policy-preview__btn-secondary" id="policy_preview_back_btn_bottom">
            <i class="fas fa-arrow-left me-1"></i> Back to Form
        </button>
        <button type="button" class="btn policy-preview__btn-primary" id="policy_preview_confirm_btn_bottom">
            Confirm &amp; Proceed to Payment <i class="fas fa-arrow-right ms-1"></i>
        </button>
    </div>
</div>

@push('js')
<script>
(function ($) {
    var UNIT_LABELS = {
        cm: 'CM', m: 'Meters', mm: 'MM', ft: 'Feet', in: 'Inches',
        kg: 'KG', lb: 'Pounds', st: 'Stone', g: 'Grams', oz: 'Ounces'
    };

    function esc(str) {
        return $('<div>').text(str == null ? '' : String(str)).html();
    }

    function formEl(name) {
        return $('#msform').find('[name="' + name + '"]').filter(function () {
            return !$(this).closest('#policy_application_preview').length;
        }).first();
    }

    function formEls(name) {
        return $('#msform').find('[name="' + name + '"]').filter(function () {
            return !$(this).closest('#policy_application_preview').length;
        });
    }

    function rawVal(name) {
        var $el = formEl(name);
        if (!$el.length) return '';
        if ($el.is(':checkbox') || $el.is(':radio')) {
            var $checked = formEls(name).filter(':checked');
            return $checked.length ? $checked.val() : '';
        }
        return $el.val() == null ? '' : String($el.val());
    }

    function selectText(name) {
        var $el = formEl(name);
        if (!$el.length || !$el.is('select')) return rawVal(name);
        return $.trim($el.find('option:selected').text()) || rawVal(name);
    }

    function fileName(name) {
        var $el = formEl(name);
        if (!$el.length || !$el.is(':file')) return '';
        var files = $el[0].files;
        if (files && files.length) return files[0].name;
        return '';
    }

    function setFormVal(name, value) {
        var $el = formEl(name);
        if (!$el.length) return;
        if ($el.is(':file')) return;
        $el.val(value);
        $el.trigger('change');
        $el.trigger('input');
    }

    function fieldBox(opts) {
        var value = opts.value == null ? '' : String(opts.value);
        var empty = !$.trim(value);
        var cls = 'policy-preview__field' + (empty ? ' is-empty' : '') + (opts.full ? ' policy-preview__field--full' : '');
        var control = '';

        if (opts.mode === 'select') {
            var optionsHtml = '';
            (opts.options || []).forEach(function (opt) {
                var selected = String(opt.value) === String(opts.value) ? ' selected' : '';
                optionsHtml += '<option value="' + esc(opt.value) + '"' + selected + '>' + esc(opt.label) + '</option>';
            });
            control = '<select class="policy-preview__select" data-pp-name="' + esc(opts.name) + '">' + optionsHtml + '</select>';
        } else if (opts.mode === 'textarea') {
            control = '<textarea class="policy-preview__textarea" data-pp-name="' + esc(opts.name) + '" rows="3">' + esc(value) + '</textarea>';
        } else if (opts.mode === 'readonly') {
            control = '<div class="policy-preview__readonly' + (empty ? ' policy-preview__muted' : '') + '">' +
                (empty ? 'Not provided' : esc(value)) + '</div>';
        } else if (opts.mode === 'file') {
            control = empty
                ? '<div class="policy-preview__readonly policy-preview__muted">No file selected</div>'
                : '<span class="policy-preview__file-chip"><i class="fas fa-paperclip"></i> ' + esc(value) + '</span>';
        } else {
            var type = opts.inputType || 'text';
            control = '<input type="' + type + '" class="policy-preview__input" data-pp-name="' + esc(opts.name) + '" value="' + esc(value) + '">';
        }

        return '<div class="' + cls + '">' +
            '<label class="policy-preview__label">' + esc(opts.label) + '</label>' +
            control +
            '</div>';
    }

    function cloneSelectOptions(name, includeBlank) {
        var options = [];
        var $el = formEl(name);
        if (!$el.length || !$el.is('select')) return options;
        $el.find('option').each(function () {
            var v = $(this).attr('value');
            if (!includeBlank && (v === '' || v == null)) return;
            options.push({ value: v, label: $.trim($(this).text()) });
        });
        return options;
    }

    function measureField(label, valueName, unitName) {
        var value = rawVal(valueName);
        var unit = rawVal(unitName);
        var display = $.trim(value) ? (value + ' ' + (UNIT_LABELS[unit] || unit || '')) : '';
        return fieldBox({
            label: label,
            name: valueName,
            value: display,
            mode: 'readonly'
        }) + fieldBox({
            label: label + ' (edit value)',
            name: valueName,
            value: value,
            mode: 'input',
            inputType: 'number'
        }) + fieldBox({
            label: label + ' Unit',
            name: unitName,
            value: unit,
            mode: 'select',
            options: cloneSelectOptions(unitName, false)
        });
    }

    function compactMeasure(label, valueName, unitName) {
        var value = rawVal(valueName);
        var unit = rawVal(unitName);
        return '<div class="policy-preview__field">' +
            '<label class="policy-preview__label">' + esc(label) + '</label>' +
            '<div class="health-measure-group">' +
            '<input type="number" step="0.01" class="policy-preview__input" data-pp-name="' + esc(valueName) + '" value="' + esc(value) + '">' +
            '<select class="policy-preview__select" data-pp-name="' + esc(unitName) + '" style="max-width:140px;">' +
            cloneSelectOptions(unitName, false).map(function (opt) {
                return '<option value="' + esc(opt.value) + '"' + (String(opt.value) === String(unit) ? ' selected' : '') + '>' + esc(opt.label) + '</option>';
            }).join('') +
            '</select></div></div>';
    }

    function sectionHtml(step, title, tabId, bodyHtml) {
        return '<section class="policy-preview__section" data-preview-tab="' + esc(tabId) + '">' +
            '<div class="policy-preview__section-head">' +
            '<h3 class="policy-preview__section-title"><span class="policy-preview__section-badge">' + esc(step) + '</span>' + esc(title) + '</h3>' +
            '<button type="button" class="btn policy-preview__edit-section" data-edit-tab="' + esc(tabId) + '"><i class="fas fa-pen me-1"></i> Edit Section</button>' +
            '</div>' +
            '<div class="policy-preview__section-body">' + bodyHtml + '</div>' +
            '</section>';
    }

    function grid(fieldsHtml, full) {
        return '<div class="policy-preview__grid' + (full ? ' policy-preview__grid--full' : '') + '">' + fieldsHtml + '</div>';
    }

    function subsection(title, html) {
        return '<div class="policy-preview__subsection"><h4 class="policy-preview__subsection-title">' + esc(title) + '</h4>' + html + '</div>';
    }

    function editableOrSelect(label, name, asSelect) {
        if (asSelect) {
            return fieldBox({
                label: label,
                name: name,
                value: rawVal(name),
                mode: 'select',
                options: cloneSelectOptions(name, true)
            });
        }
        return fieldBox({
            label: label,
            name: name,
            value: rawVal(name),
            mode: 'input'
        });
    }

    function addressBlock(prefix, title) {
        return subsection(title, grid(
            fieldBox({ label: 'Province', name: prefix + '_province_id', value: selectText(prefix + '_province_id'), mode: 'readonly' }) +
            fieldBox({ label: 'City', name: prefix + '_city_id', value: selectText(prefix + '_city_id'), mode: 'readonly' }) +
            fieldBox({ label: 'District', name: prefix + '_district_id', value: selectText(prefix + '_district_id'), mode: 'readonly' }) +
            fieldBox({ label: 'Address Line', name: prefix + '_address', value: rawVal(prefix + '_address'), mode: 'input' })
        ));
    }

    function familyFixedMember(key, title) {
        var alive = rawVal(key + '_is_alive');
        var html = grid(
            fieldBox({ label: 'Age', name: key + '_age', value: rawVal(key + '_age'), mode: 'input', inputType: 'number' }) +
            fieldBox({ label: 'State Of Health', name: key + '_health', value: rawVal(key + '_health'), mode: 'input' }) +
            fieldBox({
                label: 'Is the member alive?',
                name: key + '_is_alive',
                value: alive,
                mode: 'select',
                options: cloneSelectOptions(key + '_is_alive', true)
            })
        );
        if (alive === 'No') {
            html += grid(
                fieldBox({ label: 'Year Of Death', name: key + '_year_of_death', value: rawVal(key + '_year_of_death'), mode: 'input', inputType: 'number' }) +
                fieldBox({ label: 'Age Of Death', name: key + '_age_of_death', value: rawVal(key + '_age_of_death'), mode: 'input', inputType: 'number' }) +
                fieldBox({ label: 'Cause Of Death', name: key + '_cause_of_death', value: rawVal(key + '_cause_of_death'), mode: 'textarea', full: true })
            );
        }
        return subsection(title, html);
    }

    function familyDynamicMembers(type, title) {
        var $ages = formEls(type + '_age[]');
        if (!$ages.length) {
            return subsection(title, '<div class="policy-preview__readonly policy-preview__muted">No ' + esc(title.toLowerCase()) + ' added</div>');
        }
        var cards = '';
        $ages.each(function (index) {
            var age = $(this).val() || '';
            if (!$.trim(age) && $ages.length === 1) {
                // keep empty single row visible lightly
            }
            var $rowScope = $(this).closest('.fh-member-row, .family-member-row, .row, .member-block, .card, tr, .dynamic-member');
            if (!$rowScope.length) {
                $rowScope = $(this).parent().parent();
            }
            var health = $rowScope.find('[name="' + type + '_health[]"]').val() || formEls(type + '_health[]').eq(index).val() || '';
            var alive = $rowScope.find('[name="' + type + '_is_alive[]"]').val() || formEls(type + '_is_alive[]').eq(index).val() || '';
            var yod = $rowScope.find('[name="' + type + '_year_of_death[]"]').val() || formEls(type + '_year_of_death[]').eq(index).val() || '';
            var aod = $rowScope.find('[name="' + type + '_age_of_death[]"]').val() || formEls(type + '_age_of_death[]').eq(index).val() || '';
            var cause = $rowScope.find('[name="' + type + '_cause_of_death[]"]').val() || formEls(type + '_cause_of_death[]').eq(index).val() || '';

            cards += '<div class="policy-preview__member-card">' +
                '<div class="policy-preview__subsection-title">' + esc(title) + ' #' + (index + 1) + '</div>' +
                grid(
                    fieldBox({ label: 'Age', name: type + '_age[]', value: age, mode: 'readonly' }) +
                    fieldBox({ label: 'State Of Health', name: type + '_health[]', value: health, mode: 'readonly' }) +
                    fieldBox({ label: 'Alive?', name: type + '_is_alive[]', value: alive, mode: 'readonly' }) +
                    (alive === 'No'
                        ? fieldBox({ label: 'Year Of Death', name: type + '_year_of_death[]', value: yod, mode: 'readonly' }) +
                          fieldBox({ label: 'Age Of Death', name: type + '_age_of_death[]', value: aod, mode: 'readonly' }) +
                          fieldBox({ label: 'Cause Of Death', name: type + '_cause_of_death[]', value: cause, mode: 'readonly' })
                        : '')
                ) +
                '</div>';
        });
        return subsection(title, cards || '<div class="policy-preview__readonly policy-preview__muted">No entries</div>');
    }

    function buildPreviewHtml() {
        var html = '';

        // 1 Personal Details
        html += sectionHtml(1, 'Personal Details', '#nav-Personal_Details-tab',
            addressBlock('permanent', 'Permanent Address') +
            addressBlock('corres', 'Correspondence Address') +
            addressBlock('temp', 'Temporary Address')
        );

        // 2 Basic Details
        var basic = grid(
            editableOrSelect('Life Proposed Full Name', 'life_proposed_full_name') +
            editableOrSelect('Mobile Number', 'mobile_number') +
            editableOrSelect('CNIC', 'cnic_number') +
            fieldBox({ label: 'CNIC Issue Date', name: 'cnic_issue_date', value: rawVal('cnic_issue_date'), mode: 'input', inputType: 'date' }) +
            fieldBox({ label: 'CNIC Expiry Date', name: 'cnic_expiry_date', value: rawVal('cnic_expiry_date'), mode: 'input', inputType: 'date' }) +
            fieldBox({ label: 'Date Of Birth', name: 'date_of_birth', value: rawVal('date_of_birth'), mode: 'input', inputType: 'date' }) +
            fieldBox({ label: 'Age Nearest Birth-date', name: 'age_nearest_date', value: rawVal('age_nearest_date'), mode: 'readonly' }) +
            editableOrSelect('Gender/Sex', 'gender', true) +
            editableOrSelect('Marital Status', 'marital_status', true) +
            editableOrSelect('Wife Name', 'wife_name') +
            editableOrSelect('Husband Name', 'husband_name') +
            editableOrSelect('Mother Maiden Name', 'mother_maiden_name') +
            editableOrSelect('Father’s Name', 'father_name') +
            editableOrSelect('Religion', 'religion') +
            fieldBox({ label: 'Email Address', name: 'user_email', value: rawVal('user_email'), mode: 'input', inputType: 'email' }) +
            editableOrSelect('Phone (Office)', 'phone_number_office') +
            editableOrSelect('Phone (Residential)', 'phone_number_residente') +
            editableOrSelect('Dual National?', 'is_client_dual_national', true) +
            editableOrSelect('Primary Nationality', 'primary_nationality') +
            editableOrSelect('Dual Nationality', 'dual_nationality') +
            editableOrSelect('Dual Nationality Country', 'dual_nationality_country') +
            editableOrSelect('Passport Number', 'dual_passport_number') +
            fieldBox({ label: 'Birth Place', name: 'birth_place_city_id', value: selectText('birth_place_city_id'), mode: 'readonly' }) +
            editableOrSelect('Proposer & Life Proposed same?', 'is_same_person', true) +
            editableOrSelect('Life Proposed Name', 'life_proposed_name') +
            editableOrSelect('Life Proposed CNIC', 'life_proposed_cnic') +
            fieldBox({ label: 'Life Proposed DOB', name: 'life_proposed_dob', value: rawVal('life_proposed_dob'), mode: 'input', inputType: 'date' }) +
            editableOrSelect('Relationship with Proposer', 'life_proposed_relationship')
        );
        html += sectionHtml(2, 'Basic Details', '#basic_Details-tab', basic);

        // 3 Occupation
        var occType = $('#occupation_type').val() || '';
        var occ = grid(
            fieldBox({ label: 'Occupation Type', name: 'occupation_type', value: occType, mode: 'readonly' }) +
            editableOrSelect('Designation / Job Title', 'employment_designation') +
            editableOrSelect('Company Name', 'employment_company_name') +
            editableOrSelect('Business Name', 'business_name') +
            editableOrSelect('Nature of Business', 'nature_of_business') +
            editableOrSelect('Holding Land?', 'is_holding_land', true) +
            editableOrSelect('Land Unit', 'land_unit', true) +
            fieldBox({ label: 'Total Area', name: 'total_acreage', value: rawVal('total_acreage'), mode: 'input', inputType: 'number' }) +
            editableOrSelect('Land Location', 'land_location') +
            editableOrSelect('Land Type', 'land_type', true) +
            fieldBox({ label: 'Estimated Land Value', name: 'estimated_land_value', value: rawVal('estimated_land_value'), mode: 'input', inputType: 'number' }) +
            fieldBox({ label: 'Average Monthly Income', name: 'avaerage_monthly_income', value: rawVal('avaerage_monthly_income'), mode: 'input', inputType: 'number' }) +
            editableOrSelect('Defence / Ex-Defence / Flight Crew?', 'ex_defence_personal', true) +
            editableOrSelect('Discharged on medical grounds?', 'discharged_on_medical', true) +
            editableOrSelect('Hazardous occupation?', 'hazardous_occupation', true) +
            fieldBox({ label: 'Comments', name: 'comment', value: rawVal('comment'), mode: 'textarea', full: true })
        );
        html += sectionHtml(3, 'Occupation', '#occupation-tab', occ);

        // 4 Product
        var product = grid(
            editableOrSelect('Table', 'table_no') +
            editableOrSelect('Term', 'term') +
            editableOrSelect('Sum Assured', 'sum_assured') +
            editableOrSelect('Payment Mode', 'payment_mode', true) +
            editableOrSelect('IS ND APPLIED?', 'is_nd_applied', true) +
            editableOrSelect('ADB Rider', 'adb_rider', true) +
            editableOrSelect('TIR Rider', 'tir_rider', true)
        );
        html += sectionHtml(4, 'Product Details', '#product_detail-tab', product);

        // 5 Family
        var family = familyFixedMember('father', 'Father') +
            familyFixedMember('mother', 'Mother') +
            familyFixedMember('spouse', 'Spouse') +
            familyDynamicMembers('brother', 'Brothers') +
            familyDynamicMembers('sister', 'Sisters') +
            familyDynamicMembers('son', 'Sons') +
            familyDynamicMembers('daughter', 'Daughters');
        html += sectionHtml(5, 'Family History', '#family-history-tab', family);

        // 6 Female
        var female = grid(
            fieldBox({ label: 'Date of last delivery', name: 'date_of_last_delivery', value: rawVal('date_of_last_delivery'), mode: 'input', inputType: 'date' }) +
            editableOrSelect('Miscarriage date(s)', 'miscarriage_dates') +
            editableOrSelect('Are you pregnant?', 'is_pregnant', true) +
            editableOrSelect('Caesarean details', 'caesarean_details') +
            fieldBox({ label: 'Date of L.M.P.', name: 'lmp_date', value: rawVal('lmp_date'), mode: 'input', inputType: 'date' }) +
            editableOrSelect('Any history of female disease?', 'female_disease_history', true) +
            fieldBox({ label: 'Monthly income — Yourself', name: 'self_monthly_income', value: rawVal('self_monthly_income'), mode: 'input', inputType: 'number' }) +
            fieldBox({ label: 'Monthly income — Husband', name: 'husband_monthly_income', value: rawVal('husband_monthly_income'), mode: 'input', inputType: 'number' }) +
            editableOrSelect('Qualification', 'qualification') +
            editableOrSelect('Pay Income Tax/Land Revenue?', 'pays_tax_land_revenue', true) +
            editableOrSelect('Husband Policy No', 'husband_policy_no') +
            editableOrSelect('Husband Zone/Company', 'husband_zone_company') +
            fieldBox({ label: 'Husband Sum Assured', name: 'husband_sum_assured', value: rawVal('husband_sum_assured'), mode: 'input', inputType: 'number' })
        );
        html += sectionHtml(6, 'Female Section', '#women-tab', female);

        // 7 Nominee
        var nominee = grid(
            editableOrSelect('Nominee Name', 'nominee_name') +
            editableOrSelect('Nominee CNIC / B-Form', 'nominee_cnic') +
            fieldBox({ label: 'Nominee Age', name: 'nominee_age', value: rawVal('nominee_age'), mode: 'input', inputType: 'number' }) +
            editableOrSelect('Relationship with you', 'nominee_relationship') +
            editableOrSelect('Appointee Name', 'appointee_name') +
            editableOrSelect('Appointee Relationship', 'appointee_relationship') +
            editableOrSelect('Appointee CNIC', 'appointee_cnic')
        );
        html += sectionHtml(7, 'Nominee', '#nominee-tab', nominee);

        // 8 Documents
        var docs = grid(
            fieldBox({ label: 'Proposer CNIC Front', name: 'proposer_cnic_front', value: fileName('proposer_cnic_front'), mode: 'file' }) +
            fieldBox({ label: 'Proposer CNIC Back', name: 'proposer_cnic_back', value: fileName('proposer_cnic_back'), mode: 'file' }) +
            fieldBox({ label: 'Nominee Document', name: 'nominee_document', value: fileName('nominee_document'), mode: 'file' }) +
            fieldBox({ label: 'Passport Photograph', name: 'proposer_photo', value: fileName('proposer_photo'), mode: 'file' }) +
            fieldBox({ label: 'Proof of Income', name: 'income_proof', value: fileName('income_proof'), mode: 'file' }) +
            fieldBox({ label: 'Medical: Referred/OPD', name: 'medical_doc_referred_opd', value: fileName('medical_doc_referred_opd'), mode: 'file' }) +
            fieldBox({ label: 'Medical: Previous OPD', name: 'medical_doc_previous_opd', value: fileName('medical_doc_previous_opd'), mode: 'file' }) +
            fieldBox({ label: 'Medical: Summary/Reports', name: 'medical_doc_summary_reports', value: fileName('medical_doc_summary_reports'), mode: 'file' }) +
            fieldBox({ label: 'Medical: Present History', name: 'medical_doc_present_history', value: fileName('medical_doc_present_history'), mode: 'file' }) +
            fieldBox({ label: 'Medical: Death/MLC', name: 'medical_doc_death_mlc', value: fileName('medical_doc_death_mlc'), mode: 'file' }) +
            fieldBox({ label: 'Medical: Medicolegal', name: 'medical_doc_medicolegal', value: fileName('medical_doc_medicolegal'), mode: 'file' })
        );
        html += sectionHtml(8, 'Documents', '#documents-tab', docs +
            '<p class="policy-preview__readonly policy-preview__muted mt-2 mb-0">To replace uploaded files, use Edit Section.</p>');

        // 9 Health
        var weightChangeLabel = rawVal('weight_change_type') === 'Loss' ? 'Expected Weight Loss' : 'Expected Weight Gain';
        var reasonLabel = rawVal('weight_change_type') === 'Loss' ? 'Reason for Weight Loss'
            : (rawVal('weight_change_type') === 'Gain' ? 'Reason for Weight Gain' : 'Reason for Weight Change');
        var health = grid(
            compactMeasure('Height', 'height_value', 'height_unit') +
            compactMeasure('Weight', 'weight_value', 'weight_unit') +
            compactMeasure('Chest Inspiration', 'chest_insp_value', 'chest_insp_unit') +
            compactMeasure('Chest Expansion', 'chest_exp_value', 'chest_exp_unit') +
            compactMeasure('Abdomen', 'abdomen_value', 'abdomen_unit') +
            editableOrSelect('Weight Change', 'weight_change_type', true) +
            compactMeasure(weightChangeLabel, 'weight_change_value', 'weight_change_unit') +
            fieldBox({ label: reasonLabel, name: 'weight_increase_reason', value: rawVal('weight_increase_reason'), mode: 'textarea', full: true }) +
            editableOrSelect('Daily consumption (Tobacco/Pan/Alcohol/Drugs)', 'daily_consumption') +
            editableOrSelect('Physical Impairments', 'physical_impairments') +
            editableOrSelect('Last illness/injury away from work', 'last_illness_injury') +
            editableOrSelect('Medical Investigations History', 'medical_investigations') +
            fieldBox({ label: 'Medical History / Conditions', name: 'medical_history', value: rawVal('medical_history'), mode: 'textarea', full: true })
        );
        html += sectionHtml(9, 'Health Information', '#health_info-tab', health);

        return html;
    }

    function bindPreviewEditors() {
        $('#policy_preview_sections').off('input.pp change.pp').on('input.pp change.pp', '[data-pp-name]', function () {
            var name = $(this).attr('data-pp-name');
            if (!name || name.indexOf('[]') !== -1) return;
            setFormVal(name, $(this).val());
        });
    }

    window.syncPolicyPreviewToForm = function () {
        $('#policy_preview_sections').find('[data-pp-name]').each(function () {
            var name = $(this).attr('data-pp-name');
            if (!name || name.indexOf('[]') !== -1) return;
            setFormVal(name, $(this).val());
        });
        // Keep measurement hidden DB fields in sync
        if ($('#height_value').length) {
            $('#height_value, #weight_change_type, #weight_unit').trigger('change');
        }
    };

    window.hidePolicyApplicationPreview = function (tabSelector) {
        $('#policy_application_preview').hide();
        $('.dashboard-policy-tabs-wrap').show();
        $('#nav-tabContent').show();
        if (tabSelector) {
            $(tabSelector).tab('show');
        }
        let $target = $('.form-card').first();
        if ($target.length) {
            $('html, body').stop(true).animate({ scrollTop: $target.offset().top - 20 }, 350);
        }
    };

    window.showPolicyApplicationPreview = function () {
        // Ensure conversions are current before reading values
        if ($('#height_value').length) {
            $('#height_value').trigger('input');
        }

        $('#policy_preview_sections').html(buildPreviewHtml());
        bindPreviewEditors();

        $('.dashboard-policy-tabs-wrap').hide();
        $('#nav-tabContent').hide();
        $('#policy_application_preview').show();

        let $target = $('#policy_application_preview');
        if ($target.length) {
            $('html, body').stop(true).animate({ scrollTop: $target.offset().top - 20 }, 350);
        }
    };

    $(document).ready(function () {
        $(document).on('click', '#policy_preview_back_btn, #policy_preview_back_btn_bottom', function (e) {
            e.preventDefault();
            window.syncPolicyPreviewToForm();
            window.hidePolicyApplicationPreview('#health_info-tab');
        });

        $(document).on('click', '.policy-preview__edit-section', function (e) {
            e.preventDefault();
            var tab = $(this).data('edit-tab');
            window.syncPolicyPreviewToForm();
            window.hidePolicyApplicationPreview(tab);
        });
    });
})(jQuery);
</script>
@endpush

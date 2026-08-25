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

    function miscarriageDatesJoined() {
        var vals = [];
        $('#msform').find('[name="miscarriage_dates[]"]').filter(function () {
            return !$(this).closest('#policy_application_preview').length;
        }).each(function () {
            var v = $.trim($(this).val() || '');
            if (v) {
                vals.push(v);
            }
        });
        return vals.join(', ');
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

        var next = value == null ? '' : String(value);
        var current = $el.val() == null ? '' : String($el.val());
        if (current === next) {
            return;
        }

        $el.val(next);
        // Only fire change when the value actually changed (avoids side-effect handlers)
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
            control = '<div class="policy-preview__readonly' + (empty ? ' policy-preview__muted' : '') + '" data-pp-display="' + esc(opts.name) + '">' +
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
            fieldBox({ label: 'Province (صوبہ)', name: prefix + '_province_id', value: selectText(prefix + '_province_id'), mode: 'readonly' }) +
            fieldBox({ label: 'City (شہر)', name: prefix + '_city_id', value: selectText(prefix + '_city_id'), mode: 'readonly' }) +
            fieldBox({ label: 'District (ضلع)', name: prefix + '_district_id', value: selectText(prefix + '_district_id'), mode: 'readonly' }) +
            fieldBox({ label: 'Address Line (پتہ)', name: prefix + '_address', value: rawVal(prefix + '_address'), mode: 'input' })
        ));
    }

    function familyFixedMember(key, title) {
        var alive = rawVal(key + '_is_alive');
        var html = grid(
            fieldBox({ label: 'Age (عمر)', name: key + '_age', value: rawVal(key + '_age'), mode: 'input', inputType: 'number' }) +
            fieldBox({ label: 'State Of Health (صحت کی حالت)', name: key + '_health', value: rawVal(key + '_health'), mode: 'input' }) +
            fieldBox({
                label: 'Is the member alive? (کیا رکن زندہ ہے؟)',
                name: key + '_is_alive',
                value: alive,
                mode: 'select',
                options: cloneSelectOptions(key + '_is_alive', true)
            })
        );
        if (alive === 'No') {
            html += grid(
                fieldBox({ label: 'Year Of Death (وفات کا سال)', name: key + '_year_of_death', value: rawVal(key + '_year_of_death'), mode: 'input', inputType: 'number' }) +
                fieldBox({ label: 'Age Of Death (وفات کی عمر)', name: key + '_age_of_death', value: rawVal(key + '_age_of_death'), mode: 'input', inputType: 'number' }) +
                fieldBox({ label: 'Cause Of Death (وفات کی وجہ)', name: key + '_cause_of_death', value: rawVal(key + '_cause_of_death'), mode: 'textarea', full: true })
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
                    fieldBox({ label: 'Age (عمر)', name: type + '_age[]', value: age, mode: 'readonly' }) +
                    fieldBox({ label: 'State Of Health (صحت کی حالت)', name: type + '_health[]', value: health, mode: 'readonly' }) +
                    fieldBox({ label: 'Is Alive? (کیا زندہ ہے؟)', name: type + '_is_alive[]', value: alive, mode: 'readonly' }) +
                    (alive === 'No'
                        ? fieldBox({ label: 'Year Of Death (وفات کا سال)', name: type + '_year_of_death[]', value: yod, mode: 'readonly' }) +
                          fieldBox({ label: 'Age Of Death (وفات کی عمر)', name: type + '_age_of_death[]', value: aod, mode: 'readonly' }) +
                          fieldBox({ label: 'Cause Of Death (وفات کی وجہ)', name: type + '_cause_of_death[]', value: cause, mode: 'readonly' })
                        : '')
                ) +
                '</div>';
        });
        return subsection(title, cards || '<div class="policy-preview__readonly policy-preview__muted">No entries</div>');
    }

    function buildPreviewHtml() {
        var html = '';

        // 1 Address Details
        html += sectionHtml(1, 'Address Details (پتے کی تفصیلات)', '#nav-Personal_Details-tab',
            addressBlock('permanent', 'Permanent Address (مستقل پتہ)') +
            addressBlock('corres', 'Correspondence Address (رابطے کا پتہ)') +
            addressBlock('temp', 'Temporary Address (عارضی پتہ)')
        );

        // 2 Basic Details
        var basic = grid(
            editableOrSelect('Life Proposed Full Name (مجوزہ زندگی کا پورا نام)', 'life_proposed_full_name') +
            editableOrSelect('Mobile Number Personal (ذاتی موبائل نمبر)', 'mobile_number') +
            editableOrSelect('CNIC (قومی شناختی کارڈ نمبر)', 'cnic_number') +
            fieldBox({ label: 'CNIC Issue Date (شناختی کارڈ جاری کرنے کی تاریخ)', name: 'cnic_issue_date', value: rawVal('cnic_issue_date'), mode: 'input', inputType: 'date' }) +
            fieldBox({ label: 'CNIC Expiry Date (شناختی کارڈ کی میعاد ختم ہونے کی تاریخ)', name: 'cnic_expiry_date', value: rawVal('cnic_expiry_date'), mode: 'input', inputType: 'date' }) +
            fieldBox({ label: 'Date of Birth (تاریخ پیدائش)', name: 'date_of_birth', value: rawVal('date_of_birth'), mode: 'input', inputType: 'date' }) +
            fieldBox({ label: 'Place of Birth (مقام پیدائش)', name: 'birth_place_city_id', value: selectText('birth_place_city_id'), mode: 'readonly' }) +
            fieldBox({ label: 'Age Nearest Birth-date (قریب ترین تاریخ پیدائش کی عمر)', name: 'age_nearest_date', value: rawVal('age_nearest_date'), mode: 'readonly' }) +
            editableOrSelect('Gender/Sex (جنس)', 'gender', true) +
            editableOrSelect('Marital Status (ازدواجی حیثیت)', 'marital_status', true) +
            editableOrSelect('Wife Name of Life Proposed (بیمہ کنندہ کی بیوی کا نام)', 'wife_name') +
            editableOrSelect('Husband Name of Life Proposed (بیمہ کنندہ کے شوہر کا نام)', 'husband_name') +
            editableOrSelect('Mother Maiden Name (والدہ کا خاندانی نام)', 'mother_maiden_name') +
            editableOrSelect('Father’s Name of Life Proposed (مجوزہ بیمہ کے والد کا نام)', 'father_name') +
            editableOrSelect('Religion (مذہب)', 'religion') +
            fieldBox({ label: 'Email Address (ای میل ایڈریس)', name: 'user_email', value: rawVal('user_email'), mode: 'input', inputType: 'email' }) +
            editableOrSelect('Phone Number Office (دفتری فون نمبر)', 'phone_number_office') +
            editableOrSelect('Phone Number Residential (رہائشی فون نمبر)', 'phone_number_residente') +
            editableOrSelect('Country of Residence (رہائش کا ملک)', 'country_of_residence_id', true) +
            fieldBox({ label: 'Current Address (موجودہ پتہ)', name: 'current_address', value: rawVal('current_address'), mode: 'textarea' }) +
            editableOrSelect('Is Client Dual National? (کیا کلائنٹ دوہری شہریت رکھتا ہے؟)', 'is_client_dual_national', true) +
            editableOrSelect('Primary Nationality (قومیت)', 'primary_nationality_country_id', true) +
            editableOrSelect('Dual Nationality Country (دوہری شہریت کا ملک)', 'dual_nationality_country_id', true) +
            editableOrSelect('Tax/TIN Number (ٹیکس / ٹی آئی این نمبر)', 'dual_tax_tin_number') +
            editableOrSelect('Mobile Number (موبائل نمبر)', 'dual_mobile_number') +
            fieldBox({ label: 'Address (پتہ)', name: 'dual_address', value: rawVal('dual_address'), mode: 'textarea' }) +
            editableOrSelect('Passport Number (پاسپورٹ نمبر)', 'dual_passport_number') +
            editableOrSelect('Proposer & Life Proposed are same? (کیا تجویز کنندہ اور مجوزہ زندگی ایک ہی شخص ہیں؟)', 'is_same_person', true) +
            editableOrSelect('Life Proposed Full Name (مجوزہ زندگی کا پورا نام)', 'life_proposed_name') +
            editableOrSelect('Mobile Number Personal (ذاتی موبائل نمبر)', 'life_proposed_mobile') +
            editableOrSelect('CNIC / B-Form No (شناختی کارڈ / بی فارم نمبر)', 'life_proposed_cnic') +
            editableOrSelect('CNIC Issue Date (شناختی کارڈ جاری کرنے کی تاریخ)', 'life_proposed_cnic_issue_date') +
            editableOrSelect('CNIC Expiry Date (شناختی کارڈ کی میعاد ختم ہونے کی تاریخ)', 'life_proposed_cnic_expiry_date') +
            fieldBox({ label: 'Date of Birth (تاریخ پیدائش)', name: 'life_proposed_dob', value: rawVal('life_proposed_dob'), mode: 'input', inputType: 'date' }) +
            fieldBox({ label: 'Place of Birth (مقام پیدائش)', name: 'life_proposed_birth_place_city_id', value: selectText('life_proposed_birth_place_city_id'), mode: 'readonly' }) +
            fieldBox({ label: 'Age (عمر)', name: 'life_proposed_age', value: rawVal('life_proposed_age'), mode: 'readonly' }) +
            editableOrSelect('Gender/Sex (جنس)', 'life_proposed_gender', true) +
            editableOrSelect('Marital Status (ازدواجی حیثیت)', 'life_proposed_marital_status', true) +
            editableOrSelect('Wife Name of Life Proposed (بیمہ کنندہ کی بیوی کا نام)', 'life_proposed_wife_name') +
            editableOrSelect('Husband Name of Life Proposed (بیمہ کنندہ کے شوہر کا نام)', 'life_proposed_husband_name') +
            editableOrSelect('Mother Maiden Name (والدہ کا خاندانی نام)', 'life_proposed_mother_maiden_name') +
            editableOrSelect('Father’s Name of Life Proposed (مجوزہ بیمہ کے والد کا نام)', 'life_proposed_father_name') +
            editableOrSelect('Religion (مذہب)', 'life_proposed_religion') +
            editableOrSelect('Email Address (ای میل ایڈریس)', 'life_proposed_email') +
            editableOrSelect('Phone Number Office (دفتری فون نمبر)', 'life_proposed_phone_office') +
            editableOrSelect('Phone Number Residential (رہائشی فون نمبر)', 'life_proposed_phone_residential') +
            editableOrSelect('Country of Residence (رہائش کا ملک)', 'life_proposed_country_of_residence_id', true) +
            fieldBox({ label: 'Current Address (موجودہ پتہ)', name: 'life_proposed_current_address', value: rawVal('life_proposed_current_address'), mode: 'textarea' }) +
            editableOrSelect('Is Client Dual National? (کیا کلائنٹ دوہری شہریت رکھتا ہے؟)', 'life_proposed_is_client_dual_national', true) +
            editableOrSelect('Primary Nationality (قومیت)', 'life_proposed_primary_nationality_country_id', true) +
            editableOrSelect('Dual Nationality Country (دوہری شہریت کا ملک)', 'life_proposed_dual_nationality_country_id', true) +
            editableOrSelect('Tax/TIN Number (ٹیکس / ٹی آئی این نمبر)', 'life_proposed_dual_tax_tin_number') +
            editableOrSelect('Mobile Number (موبائل نمبر)', 'life_proposed_dual_mobile_number') +
            fieldBox({ label: 'Address (پتہ)', name: 'life_proposed_dual_address', value: rawVal('life_proposed_dual_address'), mode: 'textarea' }) +
            editableOrSelect('Passport Number (پاسپورٹ نمبر)', 'life_proposed_dual_passport_number') +
            editableOrSelect('Relationship with Proposer (تجویز کنندہ کے ساتھ رشتہ)', 'life_proposed_relationship')
        );
        html += sectionHtml(2, 'Basic Details (بنیادی تفصیلات)', '#basic_Details-tab', basic);

        // 3 Occupation
        var occType = $('#occupation_type').val() || '';
        var occ = grid(
            fieldBox({ label: 'Occupation Type (پیشہ کی نوعیت)', name: 'occupation_type', value: occType, mode: 'readonly' }) +
            editableOrSelect('Designation / Job Title (عہدہ / ملازمت کا عنوان)', 'employment_designation') +
            editableOrSelect('Company Name (کمپنی کا نام)', 'employment_company_name') +
            editableOrSelect('Business Name (کاروبار کا نام)', 'business_name') +
            editableOrSelect('Nature of Business (کاروبار کی نوعیت)', 'nature_of_business') +
            editableOrSelect('Filer Status (فائلر کی حیثیت)', 'filer_status', true) +
            editableOrSelect('NTN Number (این ٹی این نمبر)', 'ntn_number') +
            editableOrSelect('If holding Land? (کیا زراعتی زمین ہے؟)', 'is_holding_land', true) +
            editableOrSelect('Land Unit (زمین کی اکائی)', 'land_unit', true) +
            fieldBox({ label: 'Total Area (کل رقبہ)', name: 'total_acreage', value: rawVal('total_acreage'), mode: 'input', inputType: 'number' }) +
            editableOrSelect('Land Location (زمین کا مقام)', 'land_location') +
            editableOrSelect('Land Type (زمین کی قسم)', 'land_type', true) +
            fieldBox({ label: 'Estimated Land Value (زمین کی تخمینی قیمت)', name: 'estimated_land_value', value: rawVal('estimated_land_value'), mode: 'input', inputType: 'number' }) +
            fieldBox({ label: 'Average Monthly Income (اوسط ماہانہ آمدنی)', name: 'avaerage_monthly_income', value: rawVal('avaerage_monthly_income'), mode: 'input', inputType: 'number' }) +
            editableOrSelect('If Defence or Ex-Defence Personal, commercial Airline Flight Crew or plant protection pilot? (کیا آپ دفاعی / سابقہ دفاعی عملہ، کمرشل ایئر لائن فلائٹ کریو یا پودوں کے تحفظ کے پائلٹ ہیں؟)', 'ex_defence_personal', true) +
            editableOrSelect('Have you ever been discharged on medical grounds? (کیا آپ کبھی طبی بنیادوں پر فارغ کیے گئے ہیں؟)', 'discharged_on_medical', true) +
            editableOrSelect('Are you engaged in hazardous occupation? (کیا آپ خطرناک پیشے سے وابستہ ہیں؟)', 'hazardous_occupation', true) +
            fieldBox({ label: 'Comments (تبصرے)', name: 'comment', value: rawVal('comment'), mode: 'textarea', full: true })
        );
        html += sectionHtml(3, 'Occupation (پیشہ)', '#occupation-tab', occ);

        // 4 Product
        var product = grid(
            editableOrSelect('Table (منصوبہ نمبر)', 'table_no') +
            editableOrSelect('Term (میعاد)', 'term') +
            editableOrSelect('Sum Assured (زرِ بیمہ)', 'sum_assured') +
            editableOrSelect('Payment Mode (ادائیگی کا طریقہ)', 'payment_mode', true) +
            editableOrSelect('IS ND APPLIED? (YES/NO) (کیا این ڈی لاگو ہے؟)', 'is_nd_applied', true) +
            (rawVal('is_nd_applied') === 'Yes'
                ? ''
                : editableOrSelect('Accidental Death Benefit (ADB) (حادثاتی موت کے فوائد کا ضمنی معاہدہ)', 'adb_rider', true) +
                  editableOrSelect('Term Insurance Rider (TIR) (ٹرم انشورنس رائڈر)', 'tir_rider', true))
        );
        html += sectionHtml(4, 'Product Details (پروڈکٹ کی تفصیلات)', '#product_detail-tab', product);

        // 5 Family
        var family = familyFixedMember('father', 'Father (والد)') +
            familyFixedMember('mother', 'Mother (والدہ)') +
            familyFixedMember('spouse', 'Spouse (شریک حیات)') +
            familyDynamicMembers('brother', 'Brothers (بھائی)') +
            familyDynamicMembers('sister', 'Sisters (بہنیں)') +
            familyDynamicMembers('son', 'Sons (بیٹے)') +
            familyDynamicMembers('daughter', 'Daughters (بیٹیاں)');
        html += sectionHtml(5, 'Family History (خاندانی تاریخ)', '#family-history-tab', family);

        // 6 Female (only when insured gender is Female)
        if (typeof window.isFemaleSectionApplicable === 'function' ? window.isFemaleSectionApplicable() : (rawVal('gender') === 'Female')) {
            var female = grid(
                fieldBox({ label: 'Date of last delivery (آخری ڈیلیوری کی تاریخ)', name: 'date_of_last_delivery', value: rawVal('date_of_last_delivery'), mode: 'input', inputType: 'date' }) +
                fieldBox({ label: 'Date(s) of any miscarriage(s) (اسقاط حمل کی تاریخ/تاریخیں)', name: 'miscarriage_dates_preview', value: miscarriageDatesJoined(), mode: 'readonly' }) +
                editableOrSelect('Are you pregnant? (کیا آپ حاملہ ہیں؟)', 'is_pregnant', true) +
                editableOrSelect('Date(s) of any caesarean (give reason) (آپریشن سے ہونے والی زچگی کی تاریخیں اور اسباب)', 'caesarean_details') +
                fieldBox({ label: 'Date of L.M.P. (آخری ایام حیض کی تاریخ)', name: 'lmp_date', value: rawVal('lmp_date'), mode: 'input', inputType: 'date' }) +
                editableOrSelect('Any history of female disease? (کیا آپ نسوانی مرض میں مبتلا رہی ہیں؟)', 'female_disease_history', true) +
                editableOrSelect('Female disease (نسوانی مرض)', 'female_disease_name', true) +
                editableOrSelect('Description (تفصیل)', 'female_disease_details') +
                fieldBox({ label: 'Approximate monthly income - Yourself (اندازاً ماہانہ آمدنی - آپ کی اپنی)', name: 'self_monthly_income', value: rawVal('self_monthly_income'), mode: 'input', inputType: 'number' }) +
                fieldBox({ label: 'Approximate monthly income - Husband (اندازاً ماہانہ آمدنی - شوہر کی)', name: 'husband_monthly_income', value: rawVal('husband_monthly_income'), mode: 'input', inputType: 'number' }) +
                editableOrSelect('Qualification (قابلیت)', 'qualification') +
                editableOrSelect('Tax Paid (ادا شدہ ٹیکس)', 'pays_tax_land_revenue', true) +
                editableOrSelect('Husband’s Insurance (شوہر کی انشورنس)', 'husband_policy_no') +
                editableOrSelect('Husband Zone/Company', 'husband_zone_company') +
                fieldBox({ label: 'Sum Assured (زرِ بیمہ)', name: 'husband_sum_assured', value: rawVal('husband_sum_assured'), mode: 'input', inputType: 'number' })
            );
            html += sectionHtml(6, 'Female Section (خواتین کا سیکشن)', '#women-tab', female);
        }

        // 7 Nominee
        var nominee = grid(
            editableOrSelect('Name of nominee(s) (نامزد کا نام)', 'nominee_name') +
            editableOrSelect('C.N.I.C. No (Adult) or B-Form No (Minor) (شناختی کارڈ / بی فارم نمبر)', 'nominee_cnic') +
            fieldBox({ label: 'Age (عمر)', name: 'nominee_age', value: rawVal('nominee_age'), mode: 'input', inputType: 'number' }) +
            editableOrSelect('Relationship with you (آپ کے ساتھ رشتہ)', 'nominee_relationship') +
            editableOrSelect('Appointee’s Name (نام سرپرست)', 'appointee_name') +
            editableOrSelect('Appointee’s Relationship (سرپرست کا رشتہ)', 'appointee_relationship') +
            editableOrSelect('Appointee’s CNIC (سرپرست کا شناختی کارڈ)', 'appointee_cnic') +
            editableOrSelect('Appointee’s Mobile (سرپرست کا موبائل)', 'appointee_mobile')
        );
        html += sectionHtml(7, 'Nominee (نامزد)', '#nominee-tab', nominee);

        // 8 Documents
        var docs = grid(
            fieldBox({ label: 'Proposer CNIC Front (شناختی کارڈ فرنٹ)', name: 'proposer_cnic_front', value: fileName('proposer_cnic_front'), mode: 'file' }) +
            fieldBox({ label: 'Proposer CNIC Back (شناختی کارڈ بیک)', name: 'proposer_cnic_back', value: fileName('proposer_cnic_back'), mode: 'file' }) +
            fieldBox({ label: 'Life Proposed CNIC / B-Form Copy (مجوزہ بیمہ کا شناختی کارڈ/بی فارم)', name: 'life_proposed_document', value: fileName('life_proposed_document'), mode: 'file' }) +
            fieldBox({ label: 'Nominee CNIC / B-Form (نامزد کا شناختی کارڈ/بی فارم)', name: 'nominee_document', value: fileName('nominee_document'), mode: 'file' }) +
            fieldBox({ label: 'Passport Size Photograph (پاسپورٹ سائز تصویر)', name: 'proposer_photo', value: fileName('proposer_photo'), mode: 'file' }) +
            fieldBox({ label: 'Proof of Income (آمدنی کا ثبوت)', name: 'income_proof', value: fileName('income_proof'), mode: 'file' }) +
            fieldBox({ label: 'Referred / OPD Documents (حوالہ / او پی ڈی دستاویزات)', name: 'medical_doc_referred_opd', value: fileName('medical_doc_referred_opd'), mode: 'file' }) +
            fieldBox({ label: 'Previous OPD Documents (سابقہ او پی ڈی دستاویزات)', name: 'medical_doc_previous_opd', value: fileName('medical_doc_previous_opd'), mode: 'file' }) +
            fieldBox({ label: 'Summary / Discharge Documents (خلاصہ / ڈسچارج دستاویزات)', name: 'medical_doc_summary_reports', value: fileName('medical_doc_summary_reports'), mode: 'file' }) +
            fieldBox({ label: 'Present / Brief History (موجودہ / مختصر تاریخ)', name: 'medical_doc_present_history', value: fileName('medical_doc_present_history'), mode: 'file' }) +
            fieldBox({ label: 'Death / MLC Documents (وفات / ایم ایل سی دستاویزات)', name: 'medical_doc_death_mlc', value: fileName('medical_doc_death_mlc'), mode: 'file' }) +
            fieldBox({ label: 'Medicolegal Documents (میڈیکو لیگل دستاویزات)', name: 'medical_doc_medicolegal', value: fileName('medical_doc_medicolegal'), mode: 'file' })
        );
        html += sectionHtml(8, 'Documents (دستاویزات)', '#documents-tab', docs +
            '<p class="policy-preview__readonly policy-preview__muted mt-2 mb-0">To replace uploaded files, use Edit Section.</p>');

        // 9 Health
        var weightChangeLabel = rawVal('weight_change_type') === 'Loss' ? 'Expected Weight Loss (متوقع وزن میں کمی)' : 'Expected Weight Gain (متوقع وزن میں اضافہ)';
        var reasonLabel = rawVal('weight_change_type') === 'Loss' ? 'Reason for Weight Loss (وزن کم ہونے کی وجہ)'
            : (rawVal('weight_change_type') === 'Gain' ? 'Reason for Weight Gain (وزن بڑھنے کی وجہ)' : 'Reason for Weight Change (وزن میں تبدیلی کی وجہ)');
        var health = grid(
            compactMeasure('Height (قد)', 'height_value', 'height_unit') +
            compactMeasure('Weight (وزن)', 'weight_value', 'weight_unit') +
            compactMeasure('Chest Inspiration (سینے کی کشش)', 'chest_insp_value', 'chest_insp_unit') +
            compactMeasure('Chest Expansion (سینے کی توسیع)', 'chest_exp_value', 'chest_exp_unit') +
            compactMeasure('Abdomen (پیٹ)', 'abdomen_value', 'abdomen_unit') +
            editableOrSelect('Weight Change (وزن میں تبدیلی)', 'weight_change_type', true) +
            compactMeasure(weightChangeLabel, 'weight_change_value', 'weight_change_unit') +
            fieldBox({ label: reasonLabel, name: 'weight_increase_reason', value: rawVal('weight_increase_reason'), mode: 'textarea', full: true }) +
            editableOrSelect('State average daily consumption of Tobacco, Pan/Niswar, Alcohol, Drugs (تمباکو، پان/نسوار، الکحل، منشیات کی اوسط یومیہ مقدار)', 'daily_consumption') +
            editableOrSelect('State Physical Impairments (if any) (جسمانی معذوریاں، اگر کوئی ہوں)', 'physical_impairments') +
            editableOrSelect('When did illness or injury last keep you away from work? (آخری بار بیماری یا چوٹ نے کب کام سے روکا؟)', 'last_illness_injury') +
            editableOrSelect('Medical Investigations History (طبی تحقیقات کی تاریخ)', 'medical_investigations') +
            fieldBox({ label: 'Heart Disease, Diabetes, BP, TB, Jaundice, Cancer, Asthma, etc. (دل کی بیماری، ذیابیطس، بلڈ پریشر، ٹی بی، یرقان، کینسر، دمہ وغیرہ)', name: 'medical_history', value: rawVal('medical_history'), mode: 'textarea', full: true })
        );
        html += sectionHtml(9, 'Health Information (صحت کی معلومات)', '#health_info-tab', health);

        return html;
    }

    function bindPreviewEditors() {
        $('#policy_preview_sections').off('input.pp change.pp').on('input.pp change.pp', '[data-pp-name]', function () {
            var $el = $(this);
            var name = $el.attr('data-pp-name');
            if (!name || name.indexOf('[]') !== -1) return;

            // Convert displayed measure value when preview unit changes (prevents wrong CM/KG).
            if (/_unit$/.test(name) && $el.closest('.health-measure-group').length && window.UnitConverter) {
                var $group = $el.closest('.health-measure-group');
                var $value = $group.find('input[type="number"]').first();
                var fromUnit = $el.data('prev-unit') || $el.find('option').filter(function () {
                    return this.defaultSelected;
                }).val() || $el.val();
                var toUnit = $el.val();
                if (!$el.data('prev-unit')) {
                    // First interaction: prev is whatever was selected when preview rendered.
                    fromUnit = $el.data('initial-unit') || fromUnit;
                }
                window.UnitConverter.convertDisplayedValue($el, $value, fromUnit, toUnit);
                $el.data('prev-unit', toUnit);
                if ($value.attr('data-pp-name')) {
                    setFormVal($value.attr('data-pp-name'), $value.val());
                }
            }

            setFormVal(name, $el.val());
            if (window.UnitConverter && typeof window.UnitConverter.syncHealthForm === 'function') {
                window.UnitConverter.syncHealthForm();
            }
        });

        $('#policy_preview_sections').find('select[data-pp-name$="_unit"]').each(function () {
            $(this).data('initial-unit', $(this).val()).data('prev-unit', $(this).val());
        });
    }

    window.syncPolicyPreviewToForm = function () {
        $('#policy_preview_sections').find('[data-pp-name]').each(function () {
            var name = $(this).attr('data-pp-name');
            if (!name || name.indexOf('[]') !== -1) return;
            if (this.disabled) return;
            setFormVal(name, $(this).val());
        });
        // Keep measurement hidden DB fields in sync without re-triggering unit conversion.
        if (window.UnitConverter && typeof window.UnitConverter.syncHealthForm === 'function') {
            window.UnitConverter.syncHealthForm();
        } else if ($('#height_value').length) {
            $('#height_value').trigger('input');
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
        if (window.UnitConverter && typeof window.UnitConverter.syncHealthForm === 'function') {
            window.UnitConverter.syncHealthForm();
        } else if ($('#height_value').length) {
            $('#height_value').trigger('input');
        }

        $('#policy_preview_sections').html(buildPreviewHtml());
        bindPreviewEditors();
        if (typeof window.FieldHelp !== 'undefined' && typeof window.FieldHelp.enhance === 'function') {
            window.FieldHelp.enhance('#policy_application_preview');
        }
        if (typeof window.applyDualNationalityLogic === 'function') {
            window.applyDualNationalityLogic();
        }
        if (typeof window.applyFilerStatusLogic === 'function') {
            window.applyFilerStatusLogic(false);
        }
        if (typeof window.applyAppointeeLogic === 'function') {
            window.applyAppointeeLogic(false);
        }
        if (typeof window.applyFemaleDiseaseLogic === 'function') {
            window.applyFemaleDiseaseLogic(false);
        }
        if (typeof window.applyLifeProposedLogic === 'function') {
            window.applyLifeProposedLogic(false);
        }

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

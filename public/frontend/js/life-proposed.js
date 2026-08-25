(function (window, document) {
    'use strict';

    var MINOR_AGE = 18;
    var ALWAYS_REQUIRED = [
        'life_proposed_name',
        'life_proposed_mobile',
        'life_proposed_cnic',
        'life_proposed_dob',
        'life_proposed_age',
        'life_proposed_gender',
        'life_proposed_marital_status',
        'life_proposed_mother_maiden_name',
        'life_proposed_father_name',
        'life_proposed_religion',
        'life_proposed_email',
        'life_proposed_country_of_residence_id',
        'life_proposed_current_address',
        'life_proposed_is_client_dual_national',
        'life_proposed_birth_place_city_id',
        'life_proposed_relationship',
        'life_proposed_document'
    ];
    var ALL_NAMES = ALWAYS_REQUIRED.concat([
        'life_proposed_cnic_issue_date',
        'life_proposed_cnic_expiry_date',
        'life_proposed_wife_name',
        'life_proposed_husband_name',
        'life_proposed_phone_office',
        'life_proposed_phone_residential',
        'life_proposed_primary_nationality',
        'life_proposed_primary_nationality_country_id',
        'life_proposed_dual_nationality_country',
        'life_proposed_dual_nationality_country_id',
        'life_proposed_dual_tax_tin_number',
        'life_proposed_dual_mobile_number',
        'life_proposed_dual_address',
        'life_proposed_dual_passport_number',
        'life_proposed_birth_placed'
    ]);

    function fieldSelector(name) {
        return 'input[name="' + name + '"], select[name="' + name + '"], textarea[name="' + name + '"], [data-pp-name="' + name + '"]';
    }

    function allNamed(name) {
        return Array.prototype.slice.call(document.querySelectorAll(fieldSelector(name)));
    }

    function currentNamedValue(name) {
        var checked = document.querySelector(
            'input[name="' + name + '"]:checked, input[data-pp-name="' + name + '"]:checked'
        );
        if (checked) {
            return checked.value;
        }
        var value = '';
        allNamed(name).forEach(function (el) {
            if (el.type === 'radio' || el.type === 'checkbox') {
                return;
            }
            if (el.value) {
                value = el.value;
            }
        });
        return value;
    }

    function wrapFor(el) {
        return el.closest('.js-life-proposed-doc-wrap, .js-life-proposed-wrap, .policy-preview__field')
            || el.closest('.col-md-6, .col-md-3, .col-md-4, .col-6')
            || el.parentElement;
    }

    function setWrapVisible(el, visible) {
        var wrap = wrapFor(el);
        if (wrap) {
            wrap.style.display = visible ? '' : 'none';
        }
    }

    function setFieldValue(el, value) {
        if (el.type === 'file') {
            if (value === '' || value == null) {
                el.value = '';
            }
            return;
        }
        el.value = value == null ? '' : String(value);
        if (window.jQuery) {
            var $el = window.jQuery(el);
            $el.val(el.value);
            if ($el.hasClass('select2-hidden-accessible')) {
                $el.trigger('change.select2');
            }
        }
    }

    function hasExistingFile(el) {
        if (el.getAttribute('data-has-existing') === '1') {
            return true;
        }
        var wrap = el.closest('.js-life-proposed-doc-wrap');
        if (!wrap) {
            return false;
        }
        var img = wrap.querySelector('img[src]');
        return !!(img && img.getAttribute('src'));
    }

    function isMinorDob(raw) {
        if (!raw || typeof window.ageNearestBirthday !== 'function') {
            return false;
        }
        var age = window.ageNearestBirthday(raw);
        return age !== '' && age < MINOR_AGE;
    }

    function updateLabels(separate, minor) {
        var idLabel = separate
            ? (minor ? 'B-Form No (بی فارم نمبر)' : 'C.N.I.C. No (شناختی کارڈ نمبر)')
            : '';
        var docLabel = separate
            ? (minor
                ? 'Life Proposed B-Form Copy / مجوزہ بیمہ کا بی فارم'
                : 'Life Proposed CNIC Copy / مجوزہ بیمہ کا شناختی کارڈ')
            : '';

        document.querySelectorAll('.js-life-proposed-id-label').forEach(function (el) {
            if (idLabel) {
                el.textContent = idLabel;
            }
        });
        document.querySelectorAll('.js-life-proposed-doc-label').forEach(function (el) {
            if (docLabel) {
                el.textContent = docLabel;
            }
        });
    }

    function toggleSpouseFields(separate) {
        var gender = currentNamedValue('life_proposed_gender');
        var marital = currentNamedValue('life_proposed_marital_status');
        var showWife = separate && marital === 'Married' && gender === 'Male';
        var showHusband = separate && marital === 'Married' && gender === 'Female';

        document.querySelectorAll('.js-lp-wife-wrap').forEach(function (wrap) {
            wrap.style.display = showWife ? '' : 'none';
        });
        document.querySelectorAll('.js-lp-husband-wrap').forEach(function (wrap) {
            wrap.style.display = showHusband ? '' : 'none';
        });
        allNamed('life_proposed_wife_name').forEach(function (el) {
            el.required = !!showWife;
            if (!showWife) {
                setFieldValue(el, '');
            }
        });
        allNamed('life_proposed_husband_name').forEach(function (el) {
            el.required = !!showHusband;
            if (!showHusband) {
                setFieldValue(el, '');
            }
        });
    }

    function applyLifeProposedLogic(clearWhenSame) {
        var separate = currentNamedValue('is_same_person') === 'No';
        var minor = separate && isMinorDob(currentNamedValue('life_proposed_dob'));

        document.querySelectorAll('.js-life-proposed-section, #same_person_fields, #lifeProposedWrapper').forEach(function (section) {
            section.style.display = separate ? '' : 'none';
        });

        ALL_NAMES.forEach(function (name) {
            allNamed(name).forEach(function (el) {
                var isDoc = el.type === 'file' || !!el.closest('.js-life-proposed-doc-wrap');
                var isPreview = !!el.closest('.policy-preview__field');
                var alwaysRequired = ALWAYS_REQUIRED.indexOf(name) !== -1;
                var cnicDate = name === 'life_proposed_cnic_issue_date' || name === 'life_proposed_cnic_expiry_date';

                el.disabled = !separate;
                if (window.jQuery) {
                    window.jQuery(el).prop('disabled', !separate);
                }

                if (isDoc) {
                    el.required = !!separate && !hasExistingFile(el);
                    if (!separate && clearWhenSame !== false) {
                        setFieldValue(el, '');
                    }
                } else if (cnicDate) {
                    el.required = !!separate && !minor;
                } else if (alwaysRequired) {
                    el.required = !!separate;
                }

                if (!separate && clearWhenSame !== false && el.type !== 'file') {
                    if (el.name === 'life_proposed_age' || el.getAttribute('data-pp-name') === 'life_proposed_age') {
                        setFieldValue(el, '');
                    }
                }

                if (isDoc || isPreview) {
                    setWrapVisible(el, separate);
                }
            });
        });

        document.querySelectorAll('.js-life-proposed-cnic-date').forEach(function (wrap) {
            wrap.style.display = separate && !minor ? '' : 'none';
        });

        if (!separate && clearWhenSame !== false) {
            ALL_NAMES.forEach(function (name) {
                allNamed(name).forEach(function (el) {
                    if (el.type !== 'file') {
                        setFieldValue(el, '');
                    }
                });
            });
        }

        toggleSpouseFields(separate);
        updateLabels(separate, minor);
        window.isLifeProposedMinor = minor;

        if (typeof window.applyDualNationalityLogic === 'function') {
            window.applyDualNationalityLogic(false);
        }
        if (separate && typeof window.applyAgeFromDob === 'function') {
            var dob = currentNamedValue('life_proposed_dob');
            if (dob) {
                window.applyAgeFromDob(dob, 'life_proposed_dob');
            }
        }
    }

    function isSamePersonField(target) {
        return target && (
            target.getAttribute('name') === 'is_same_person'
            || target.getAttribute('data-pp-name') === 'is_same_person'
        );
    }

    function isLifeProposedDobField(target) {
        return target && (
            target.getAttribute('name') === 'life_proposed_dob'
            || target.getAttribute('data-pp-name') === 'life_proposed_dob'
        );
    }

    function isSpouseSource(target) {
        var name = target && (target.getAttribute('name') || target.getAttribute('data-pp-name') || '');
        return name === 'life_proposed_gender' || name === 'life_proposed_marital_status';
    }

    function onChange(event) {
        if (isSamePersonField(event.target) || isLifeProposedDobField(event.target)) {
            applyLifeProposedLogic(event.target.getAttribute('name') === 'is_same_person' && event.target.value === 'Yes');
        } else if (isSpouseSource(event.target)) {
            toggleSpouseFields(currentNamedValue('is_same_person') === 'No');
        }
    }

    document.addEventListener('change', onChange, true);

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            applyLifeProposedLogic(false);
        });
    } else {
        applyLifeProposedLogic(false);
    }

    window.applyLifeProposedLogic = applyLifeProposedLogic;
})(window, document);

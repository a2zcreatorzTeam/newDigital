(function (window, document) {
    'use strict';

    var MINOR_AGE = 18;
    var APPOINTEE_NAMES = [
        'appointee_name',
        'appointee_relationship',
        'appointee_cnic',
        'appointee_mobile'
    ];

    function fieldSelector(name) {
        return 'input[name="' + name + '"], select[name="' + name + '"], textarea[name="' + name + '"], [data-pp-name="' + name + '"]';
    }

    function allNamed(name) {
        return Array.prototype.slice.call(document.querySelectorAll(fieldSelector(name)));
    }

    function wrapFor(el) {
        return el.closest('.js-appointee-wrap, .col-md-6, .col-md-4, .col-md-3, .col-6, .col-12, .policy-preview__field')
            || el.closest('.form-group')
            || el.closest('.detail-box')
            || el.parentElement;
    }

    function setWrapVisible(el, visible) {
        var wrap = wrapFor(el);
        if (wrap) {
            wrap.style.display = visible ? '' : 'none';
        }
    }

    function setFieldValue(el, value) {
        el.value = value == null ? '' : String(value);
        if (window.jQuery) {
            window.jQuery(el).val(el.value);
        }
    }

    function applyFieldState(el, visible, required, clearValue) {
        if (clearValue) {
            setFieldValue(el, '');
        }

        el.required = !!required;
        el.disabled = !visible;
        if (window.jQuery) {
            window.jQuery(el).prop('disabled', !visible);
        }
        setWrapVisible(el, visible);
    }

    function currentNomineeAge() {
        var value = '';
        allNamed('nominee_age').forEach(function (el) {
            if (el.value !== '') {
                value = el.value;
            }
        });
        return value;
    }

    function isMinorAge(raw) {
        if (raw === '' || raw == null) {
            return false;
        }
        var age = parseInt(raw, 10);
        return !isNaN(age) && age < MINOR_AGE;
    }

    function toggleSections(visible) {
        document.querySelectorAll('.js-appointee-section').forEach(function (section) {
            section.style.display = visible ? '' : 'none';
        });
    }

    function applyAppointeeLogic(clearWhenAdult) {
        if (!allNamed('nominee_age').length) {
            return;
        }

        var minor = isMinorAge(currentNomineeAge());
        toggleSections(minor);

        APPOINTEE_NAMES.forEach(function (name) {
            allNamed(name).forEach(function (el) {
                applyFieldState(el, minor, minor, !minor && clearWhenAdult !== false);
            });
        });
    }

    function isNomineeAgeField(target) {
        if (!target) {
            return false;
        }

        return target.getAttribute('name') === 'nominee_age'
            || target.getAttribute('data-pp-name') === 'nominee_age';
    }

    function digitsOnly(value) {
        return String(value || '').replace(/\D+/g, '');
    }

    function formatCnic(raw) {
        var digits = digitsOnly(raw).slice(0, 13);
        var out = '';
        if (digits.length > 0) {
            out += digits.substr(0, 5);
        }
        if (digits.length > 5) {
            out += '-' + digits.substr(5, 7);
        }
        if (digits.length > 12) {
            out += '-' + digits.substr(12, 1);
        }
        return out;
    }

    function formatMobile(raw) {
        var digits = digitsOnly(raw).slice(0, 11);
        var out = '';
        if (digits.length > 0) {
            out += digits.substr(0, 4);
        }
        if (digits.length > 4) {
            out += '-' + digits.substr(4, 7);
        }
        return out;
    }

    function onInput(event) {
        var target = event.target;
        if (!target) {
            return;
        }

        var name = target.getAttribute('name') || target.getAttribute('data-pp-name') || '';
        if (name === 'nominee_cnic' || name === 'appointee_cnic') {
            target.value = formatCnic(target.value);
        }
        if (name === 'appointee_mobile') {
            target.value = formatMobile(target.value);
        }
        if (isNomineeAgeField(target)) {
            applyAppointeeLogic(true);
        }
    }

    function onAgeChange(event) {
        if (!isNomineeAgeField(event.target)) {
            return;
        }
        applyAppointeeLogic(true);
    }

    document.addEventListener('input', onInput, true);
    document.addEventListener('change', onAgeChange, true);

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            applyAppointeeLogic(false);
        });
    } else {
        applyAppointeeLogic(false);
    }

    window.applyAppointeeLogic = applyAppointeeLogic;
})(window, document);

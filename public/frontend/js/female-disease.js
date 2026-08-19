(function (window, document) {
    'use strict';

    var OTHER = 'Other';

    function fieldSelector(name) {
        return 'input[name="' + name + '"], select[name="' + name + '"], textarea[name="' + name + '"], [data-pp-name="' + name + '"]';
    }

    function allNamed(name) {
        return Array.prototype.slice.call(document.querySelectorAll(fieldSelector(name)));
    }

    function wrapFor(el) {
        return el.closest('.js-female-disease-wrap, .policy-preview__field')
            || el.closest('.form-group')
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

    function currentHistory() {
        var value = '';
        allNamed('female_disease_history').forEach(function (el) {
            if (el.value) {
                value = el.value;
            }
        });
        return value;
    }

    function currentDiseaseName() {
        var value = '';
        allNamed('female_disease_name').forEach(function (el) {
            if (!el.disabled && el.value) {
                value = el.value;
            }
        });
        return value;
    }

    function applyFemaleDiseaseLogic(clearWhenNo) {
        if (!allNamed('female_disease_history').length) {
            return;
        }

        var yes = currentHistory() === 'Yes';
        var other = yes && currentDiseaseName() === OTHER;

        allNamed('female_disease_name').forEach(function (el) {
            applyFieldState(el, yes, yes, !yes && clearWhenNo !== false);
        });

        allNamed('female_disease_details').forEach(function (el) {
            applyFieldState(el, yes, other, !yes && clearWhenNo !== false);
        });
    }

    function isHistoryField(target) {
        if (!target) {
            return false;
        }

        return target.getAttribute('name') === 'female_disease_history'
            || target.getAttribute('data-pp-name') === 'female_disease_history';
    }

    function isDiseaseNameField(target) {
        if (!target) {
            return false;
        }

        return target.getAttribute('name') === 'female_disease_name'
            || target.getAttribute('data-pp-name') === 'female_disease_name';
    }

    function onChange(event) {
        if (isHistoryField(event.target)) {
            applyFemaleDiseaseLogic(event.target.value !== 'Yes');
            return;
        }

        if (isDiseaseNameField(event.target)) {
            applyFemaleDiseaseLogic(false);
        }
    }

    document.addEventListener('change', onChange, true);

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            applyFemaleDiseaseLogic(false);
        });
    } else {
        applyFemaleDiseaseLogic(false);
    }

    window.applyFemaleDiseaseLogic = applyFemaleDiseaseLogic;
})(window, document);

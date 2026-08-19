(function (window, document) {
    'use strict';

    var previousFilerValue = null;

    function fieldSelector(name) {
        return 'input[name="' + name + '"], select[name="' + name + '"], textarea[name="' + name + '"], [data-pp-name="' + name + '"]';
    }

    function allNamed(name) {
        return Array.prototype.slice.call(document.querySelectorAll(fieldSelector(name)));
    }

    function wrapFor(el) {
        return el.closest('.js-ntn-wrap, .col-md-6, .col-md-4, .col-md-3, .col-6, .col-12, .policy-preview__field')
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

    function applyNtnState(el, visible, required, clearValue) {
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

    function currentFilerStatus() {
        var value = '';
        allNamed('filer_status').forEach(function (select) {
            if (select.value) {
                value = select.value;
            }
        });
        return value;
    }

    function applyFilerStatusLogic(clearNtn) {
        var selects = allNamed('filer_status');
        if (!selects.length) {
            return;
        }

        var value = currentFilerStatus();
        var ntnFields = allNamed('ntn_number');

        if (value === 'Filer') {
            ntnFields.forEach(function (el) {
                applyNtnState(el, true, true, false);
            });
            previousFilerValue = 'Filer';
            return;
        }

        if (value === 'Non-Filer') {
            ntnFields.forEach(function (el) {
                applyNtnState(el, false, false, true);
            });
            previousFilerValue = 'Non-Filer';
            return;
        }

        ntnFields.forEach(function (el) {
            applyNtnState(el, false, false, false);
        });
        previousFilerValue = value;
    }

    function isFilerStatusField(target) {
        if (!target) {
            return false;
        }

        return target.getAttribute('name') === 'filer_status'
            || target.getAttribute('data-pp-name') === 'filer_status';
    }

    function onChange(event) {
        if (!isFilerStatusField(event.target)) {
            return;
        }

        applyFilerStatusLogic(event.target.value === 'Non-Filer');
    }

    document.addEventListener('change', onChange, true);

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            applyFilerStatusLogic(false);
        });
    } else {
        applyFilerStatusLogic(false);
    }

    window.applyFilerStatusLogic = applyFilerStatusLogic;
})(window, document);

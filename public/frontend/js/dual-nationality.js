(function (window, document) {
    'use strict';

    var PAKISTANI = 'Pakistani';
    var PRIMARY_NAMES = ['primary_nationality', 'primary_nationality_country_id'];
    var EXTRA_NAMES = [
        'dual_nationality',
        'dual_nationality_country',
        'dual_nationality_country_id',
        'dual_passport_number',
        'dual_tax_tin_number',
        'dual_mobile_number',
        'dual_address'
    ];
    var previousDualValue = {};
    var SCOPES = ['', 'life_proposed_'];

    if (!document.getElementById('js-dual-nationality-style')) {
        var style = document.createElement('style');
        style.id = 'js-dual-nationality-style';
        style.textContent = '.js-nationality-locked{background-color:#e9ecef !important;cursor:not-allowed;}';
        document.head.appendChild(style);
    }

    function fieldSelector(name) {
        return 'input[name="' + name + '"], select[name="' + name + '"], textarea[name="' + name + '"], [data-pp-name="' + name + '"]';
    }

    function allNamed(name) {
        return Array.prototype.slice.call(document.querySelectorAll(fieldSelector(name)));
    }

    function wrapFor(el) {
        return el.closest('.col-md-6, .col-md-3, .col-6, .col-md-4, .col-md-12, .policy-preview__field')
            || el.closest('.form-group')
            || el.parentElement;
    }

    function setWrapVisible(el, visible) {
        var wrap = wrapFor(el);
        if (wrap) {
            wrap.style.display = visible ? '' : 'none';
        }
    }

    function setSelectValue(el, value) {
        el.value = value == null ? '' : String(value);
        if (window.jQuery) {
            var $el = window.jQuery(el);
            $el.val(el.value);
            if ($el.hasClass('select2-hidden-accessible')) {
                $el.trigger('change.select2');
            }
        }
    }

    function pakistanValue(el) {
        if (!el || el.tagName !== 'SELECT') {
            return PAKISTANI;
        }
        var byCode = el.querySelector('option[data-code="PK"]');
        if (byCode) {
            return byCode.value;
        }
        var options = el.querySelectorAll('option');
        for (var i = 0; i < options.length; i++) {
            var label = (options[i].textContent || '').trim().toLowerCase();
            if (label === 'pakistan' || label === 'pakistani') {
                return options[i].value;
            }
        }
        return '';
    }

    function reinitCountrySelect(el) {
        if (!window.jQuery || el.tagName !== 'SELECT' || !el.classList.contains('js-country-select')) {
            return;
        }
        var $el = window.jQuery(el);
        if (typeof $el.select2 !== 'function') {
            return;
        }
        if ($el.hasClass('select2-hidden-accessible')) {
            $el.select2('destroy');
        }
        $el.select2({
            placeholder: $el.data('placeholder') || 'Select Country',
            allowClear: !el.disabled && !el.required,
            width: '100%'
        });
    }

    function setLocked(el, locked) {
        if (el.tagName === 'SELECT') {
            el.disabled = !!locked;
            if (window.jQuery) {
                window.jQuery(el).prop('disabled', !!locked);
            }
        } else {
            el.readOnly = !!locked;
            if (locked) {
                el.setAttribute('readonly', 'readonly');
            } else {
                el.removeAttribute('readonly');
            }
        }
        if (locked) {
            el.classList.add('js-nationality-locked');
        } else {
            el.classList.remove('js-nationality-locked');
        }
    }

    function clearField(el) {
        setSelectValue(el, '');
        el.required = false;
        setLocked(el, false);
        setWrapVisible(el, false);
    }

    function showField(el, required) {
        el.required = !!required;
        setWrapVisible(el, true);
        reinitCountrySelect(el);
    }

    function applyPrimaryNo(el) {
        setSelectValue(el, pakistanValue(el) || PAKISTANI);
        el.required = true;
        setLocked(el, true);
        setWrapVisible(el, true);
        reinitCountrySelect(el);
    }

    function applyPrimaryYes(el, clearAutoPakistani) {
        setLocked(el, false);
        el.required = true;
        setWrapVisible(el, true);
        if (clearAutoPakistani) {
            setSelectValue(el, '');
        }
        reinitCountrySelect(el);
    }

    function applyDualNationalityLogicFor(prefix, clearAutoPakistani) {
        var flagName = prefix + 'is_client_dual_national';
        var selects = allNamed(flagName);
        if (!selects.length) {
            return;
        }

        var value = '';
        selects.forEach(function (select) {
            if (select.disabled) {
                return;
            }
            if (select.value) {
                value = select.value;
            }
        });

        var primaries = [];
        PRIMARY_NAMES.forEach(function (name) {
            primaries = primaries.concat(allNamed(prefix + name));
        });
        var extras = [];
        EXTRA_NAMES.forEach(function (name) {
            extras = extras.concat(allNamed(prefix + name));
        });

        if (value === 'No') {
            primaries.forEach(applyPrimaryNo);
            extras.forEach(clearField);
            if (!prefix) {
                document.querySelectorAll('[data-pp-display="primary_nationality"]').forEach(function (el) {
                    el.textContent = PAKISTANI;
                });
            }
            previousDualValue[prefix] = 'No';
            return;
        }

        if (value === 'Yes') {
            primaries.forEach(function (el) {
                applyPrimaryYes(el, !!clearAutoPakistani);
            });
            extras.forEach(function (el) {
                showField(el, true);
            });
            previousDualValue[prefix] = 'Yes';
            return;
        }

        primaries.forEach(function (el) {
            el.required = false;
            setLocked(el, false);
            setWrapVisible(el, false);
        });
        extras.forEach(function (el) {
            el.required = false;
            setWrapVisible(el, false);
        });
        previousDualValue[prefix] = value;
    }

    function applyDualNationalityLogic(clearAutoPakistani) {
        SCOPES.forEach(function (prefix) {
            applyDualNationalityLogicFor(prefix, clearAutoPakistani);
        });
    }

    function isDualNationalField(target) {
        if (!target) {
            return false;
        }

        var name = target.getAttribute('name') || target.getAttribute('data-pp-name') || '';
        return name === 'is_client_dual_national'
            || name === 'life_proposed_is_client_dual_national'
            || target.id === 'is_client_dual_national'
            || target.id === 'isClientDualNationalSelect';
    }

    function onChange(event) {
        if (!isDualNationalField(event.target)) {
            return;
        }
        var prefix = (event.target.getAttribute('name') || '').indexOf('life_proposed_') === 0
            ? 'life_proposed_'
            : '';
        applyDualNationalityLogicFor(prefix, previousDualValue[prefix] === 'No' && event.target.value === 'Yes');
    }

    document.addEventListener('change', onChange, true);

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', applyDualNationalityLogic);
    } else {
        applyDualNationalityLogic();
    }

    window.applyDualNationalityLogic = applyDualNationalityLogic;
})(window, document);

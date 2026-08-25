/**
 * Centralized frontend unit conversion (mirrors App\Support\UnitConverter).
 * Backend standards: length = CM, weight = KG.
 *
 * window.UnitConverter = { toCm, fromCm, toKg, fromKg, convertLength, convertWeight, syncHealthForm, ... }
 */
(function (global) {
    'use strict';

    var LENGTH_TO_CM = { cm: 1, m: 100, mm: 0.1, in: 2.54, ft: 30.48 };
    var WEIGHT_TO_KG = { kg: 1, lb: 0.45359237, st: 6.35029318, g: 0.001, oz: 0.028349523125 };
    var PRECISION = 4;

    function configure(cfg) {
        if (!cfg) return;
        if (cfg.length_to_cm) LENGTH_TO_CM = cfg.length_to_cm;
        if (cfg.weight_to_kg) WEIGHT_TO_KG = cfg.weight_to_kg;
        if (cfg.precision != null) PRECISION = cfg.precision;
    }

    function toNum(v) {
        if (v === null || v === undefined || v === '') return null;
        var n = parseFloat(v);
        return isNaN(n) ? null : n;
    }

    function round(n, precision) {
        if (n === null || n === undefined || isNaN(n)) return n;
        var p = precision == null ? PRECISION : precision;
        return parseFloat(Number(n).toFixed(p));
    }

    function lengthFactor(unit) {
        unit = String(unit || 'cm').toLowerCase();
        if (unit === 'inch' || unit === 'inches') unit = 'in';
        if (unit === 'feet' || unit === 'foot') unit = 'ft';
        return LENGTH_TO_CM[unit] || 1;
    }

    function weightFactor(unit) {
        unit = String(unit || 'kg').toLowerCase();
        if (unit === 'lbs' || unit === 'pound' || unit === 'pounds') unit = 'lb';
        if (unit === 'stone' || unit === 'stones') unit = 'st';
        return WEIGHT_TO_KG[unit] || 1;
    }

    function toCm(value, unit) {
        var n = toNum(value);
        return n === null ? null : n * lengthFactor(unit);
    }

    function fromCm(cm, unit) {
        var n = toNum(cm);
        if (n === null) return null;
        var f = lengthFactor(unit);
        return f === 0 ? null : n / f;
    }

    function toKg(value, unit) {
        var n = toNum(value);
        return n === null ? null : n * weightFactor(unit);
    }

    function fromKg(kg, unit) {
        var n = toNum(kg);
        if (n === null) return null;
        var f = weightFactor(unit);
        return f === 0 ? null : n / f;
    }

    function convertLength(value, fromUnit, toUnit) {
        var cm = toCm(value, fromUnit);
        return cm === null ? null : fromCm(cm, toUnit);
    }

    function convertWeight(value, fromUnit, toUnit) {
        var kg = toKg(value, fromUnit);
        return kg === null ? null : fromKg(kg, toUnit);
    }

    function isLengthUnitSelect($el) {
        var id = ($el.attr('id') || '') + ' ' + ($el.attr('name') || '') + ' ' + ($el.attr('data-pp-name') || '');
        return /height_unit|chest_insp_unit|chest_exp_unit|abdomen_unit/i.test(id);
    }

    function convertDisplayedValue($unitSelect, $valueInput, fromUnit, toUnit) {
        var val = toNum($valueInput.val());
        if (val === null || fromUnit === toUnit) return;
        var converted = isLengthUnitSelect($unitSelect)
            ? convertLength(val, fromUnit, toUnit)
            : convertWeight(val, fromUnit, toUnit);
        if (converted !== null) {
            $valueInput.val(round(converted));
        }
    }

    function syncHealthForm(root) {
        var $ = global.jQuery;
        if (!$) return;
        var $root = root ? $(root) : $(document);

        function find(sel) {
            var $el = $root.find(sel);
            return $el.length ? $el : $(sel);
        }

        var heightVal = toNum(find('#height_value').val());
        var heightUnit = find('#height_unit').val() || 'cm';
        if (heightVal !== null) {
            var heightCm = toCm(heightVal, heightUnit);
            find('#height_cm').val(round(heightCm));
            find('#height_ft').val(round(fromCm(heightCm, 'ft')));
        }

        var weightVal = toNum(find('#weight_value').val());
        var weightUnit = find('#weight_unit').val() || 'kg';
        if (weightVal !== null) {
            find('#weight_kg').val(round(toKg(weightVal, weightUnit)));
        }

        function syncLength(prefix) {
            var val = toNum(find('#' + prefix + '_value').val());
            var unit = find('#' + prefix + '_unit').val() || 'cm';
            if (val === null) return;
            var cm = toCm(val, unit);
            find('#' + prefix + '_cm').val(round(cm));
            find('#' + prefix + '_inches').val(round(fromCm(cm, 'in')));
        }
        syncLength('chest_insp');
        syncLength('chest_exp');
        syncLength('abdomen');

        var changeType = find('#weight_change_type').val();
        var changeVal = toNum(find('#weight_change_value').val());
        var changeUnit = find('#weight_change_unit').val() || 'kg';
        var kg = changeVal !== null ? round(toKg(changeVal, changeUnit)) : null;

        if (changeType === 'Gain') {
            find('#weight_gain_kg').val(kg !== null ? kg : '');
            find('#weight_loss_kg').val(0);
        } else if (changeType === 'Loss') {
            find('#weight_loss_kg').val(kg !== null ? kg : '');
            find('#weight_gain_kg').val(0);
        }
    }

    var unitConverterBound = false;

    function bindHealthForm(options) {
        var $ = global.jQuery;
        if (!$ || unitConverterBound) return;
        unitConverterBound = true;
        options = options || {};
        var labels = options.labels || {};

        function toggleWeightChangeUi() {
            var type = $('#weight_change_type').val();
            var $wrap = $('#weight_change_value_wrap');
            var $value = $('#weight_change_value');
            if (type === 'Gain' || type === 'Loss') {
                $wrap.show();
                $value.prop('required', true);
                if ($('#weight_change_value_label').length) {
                    $('#weight_change_value_label').html(
                        (type === 'Gain' ? (labels.expectedGain || 'Expected Weight Gain') : (labels.expectedLoss || 'Expected Weight Loss')) +
                        ' <span class="requi text-danger">*</span>'
                    );
                }
                if ($('#weight_change_reason_label').length) {
                    $('#weight_change_reason_label').html(
                        (type === 'Gain' ? (labels.reasonGain || 'Reason for Weight Gain') : (labels.reasonLoss || 'Reason for Weight Loss')) +
                        ' <span class="requi text-danger">*</span>'
                    );
                }
            } else {
                $wrap.hide();
                $value.prop('required', false).val('');
                if ($('#weight_change_reason_label').length) {
                    $('#weight_change_reason_label').html(
                        (labels.reasonEither || 'Reason for Weight Change') +
                        ' <span class="requi text-danger">*</span>'
                    );
                }
                $('#weight_gain_kg').val('');
                $('#weight_loss_kg').val('');
            }
            syncHealthForm();
        }

        $(document).ready(function () {
            $('.health-measure-unit, #weight_change_unit').each(function () {
                $(this).data('prev-unit', $(this).val());
            });

            $(document).on('change', '.health-measure-unit, #weight_change_unit', function () {
                var $unit = $(this);
                var fromUnit = $unit.data('prev-unit') || $unit.val();
                var toUnit = $unit.val();
                var $value = $unit.closest('.health-measure-group').find('input[type="number"]').first();
                convertDisplayedValue($unit, $value, fromUnit, toUnit);
                $unit.data('prev-unit', toUnit);
                syncHealthForm();
            });

            // Preview / dynamically injected measure groups
            $(document).on('change', '.policy-preview__field .health-measure-group select[data-pp-name$="_unit"]', function () {
                var $unit = $(this);
                var fromUnit = $unit.data('prev-unit') || $unit.attr('data-prev-unit') || $unit.val();
                var toUnit = $unit.val();
                var $value = $unit.closest('.health-measure-group').find('input[type="number"]').first();
                if (!$unit.data('prev-unit')) {
                    $unit.data('prev-unit', fromUnit);
                }
                convertDisplayedValue($unit, $value, fromUnit, toUnit);
                $unit.data('prev-unit', toUnit);
                if ($value.attr('data-pp-name')) {
                    $value.trigger('input');
                }
                // Mirror into main form fields if present
                var valueName = $value.attr('data-pp-name');
                var unitName = $unit.attr('data-pp-name');
                if (valueName && $('#' + valueName.replace(/\[|\]/g, '\\$&')).length === 0) {
                    var $formVal = $('[name="' + valueName + '"]').not('[data-pp-name]');
                    var $formUnit = $('[name="' + unitName + '"]').not('[data-pp-name]');
                    if ($formVal.length) $formVal.val($value.val());
                    if ($formUnit.length) {
                        var prev = $formUnit.data('prev-unit') || $formUnit.val();
                        $formUnit.val(toUnit).data('prev-unit', toUnit);
                        // Form value already converted via preview input sync path below
                        if (prev !== toUnit) {
                            // value already converted in preview; just set form fields
                        }
                    }
                }
                syncHealthForm();
            });

            $(document).on('input', '.health-measure-input, #weight_change_value', function () {
                syncHealthForm();
            });
            $(document).on('change', '#weight_change_type', toggleWeightChangeUi);
            toggleWeightChangeUi();
            syncHealthForm();

            $(document).on('submit', 'form', function () {
                if ($(this).find('#height_value').length) {
                    syncHealthForm(this);
                }
            });
            $(document).on('click', '#user_details_submited', function () {
                syncHealthForm();
            });
        });
    }

    global.UnitConverter = {
        configure: configure,
        toCm: toCm,
        fromCm: fromCm,
        toKg: toKg,
        fromKg: fromKg,
        convertLength: convertLength,
        convertWeight: convertWeight,
        convertDisplayedValue: convertDisplayedValue,
        syncHealthForm: syncHealthForm,
        bindHealthForm: bindHealthForm,
        round: round
    };
})(window);

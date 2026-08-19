{{--
  Simplified health measurements UI.
  Expects: $health (object/array with existing values) OR individual defaults.
  Optional: $fieldClass, $labelClass, $wrapperClass, $colClass
--}}
@php
    $health = $health ?? null;
    $fieldClass = $fieldClass ?? 'form-control jbl-dynamic-input';
    $selectClass = $selectClass ?? 'form-control';
    $labelClass = $labelClass ?? '';
    $colClass = $colClass ?? 'col-md-6 px-0 px-sm-3 mb-3';
    $showBanner = $showBanner ?? true;

    $heightCm = (float) old('height_cm', data_get($health, 'height_cm', 0));
    $weightKg = (float) old('weight_kg', data_get($health, 'weight_kg', 0));
    $chestInspCm = (float) old('chest_insp_cm', data_get($health, 'chest_insp_cm', 0));
    $chestExpCm = (float) old('chest_exp_cm', data_get($health, 'chest_exp_cm', 0));
    $abdomenCm = (float) old('abdomen_cm', data_get($health, 'abdomen_cm', 0));
    $gain = (float) old('weight_gain_kg', data_get($health, 'weight_gain_kg', 0));
    $loss = (float) old('weight_loss_kg', data_get($health, 'weight_loss_kg', 0));

    $heightValue = old('height_value', $heightCm ?: '');
    $heightUnit = old('height_unit', 'cm');
    $weightValue = old('weight_value', $weightKg ?: '');
    $weightUnit = old('weight_unit', 'kg');
    $chestInspValue = old('chest_insp_value', $chestInspCm ?: '');
    $chestInspUnit = old('chest_insp_unit', 'cm');
    $chestExpValue = old('chest_exp_value', $chestExpCm ?: '');
    $chestExpUnit = old('chest_exp_unit', 'cm');
    $abdomenValue = old('abdomen_value', $abdomenCm ?: '');
    $abdomenUnit = old('abdomen_unit', 'cm');

    if ($gain > 0 && $loss <= 0) {
        $defaultChangeType = 'Gain';
        $defaultChangeValue = $gain;
    } elseif ($loss > 0 && $gain <= 0) {
        $defaultChangeType = 'Loss';
        $defaultChangeValue = $loss;
    } elseif ($gain > 0 && $loss > 0) {
        // Prefer the larger non-zero value if both exist historically
        $defaultChangeType = $gain >= $loss ? 'Gain' : 'Loss';
        $defaultChangeValue = $gain >= $loss ? $gain : $loss;
    } else {
        $defaultChangeType = '';
        $defaultChangeValue = '';
    }
    $weightChangeType = old('weight_change_type', $defaultChangeType);
    $weightChangeValue = old('weight_change_value', $defaultChangeValue);
    $weightChangeUnit = old('weight_change_unit', 'kg');
    $weightReason = old('weight_increase_reason', data_get($health, 'weight_increase_reason', ''));
@endphp

@if($showBanner)
<div class="{{ $colClass }} col-md-12">
    <div class="alert alert-primary border-start border-5 shadow-sm mb-0">
        <h6 class="mb-2"><i class="fas fa-info-circle me-2"></i>Simple Measurements</h6>
        <p class="mb-0 text-dark">
            Enter each measurement once and choose a unit. The system automatically converts and stores
            all required units (cm/ft/inches, kg) for you.
        </p>
    </div>
</div>
@endif

{{-- Height --}}
<div class="{{ $colClass }}">
    <div class="{{ isset($useDetailBox) && $useDetailBox ? 'detail-box' : 'form-group' }}">
        <label class="{{ $labelClass }}">Height (قد)<span class="requi text-danger">*</span></label>
        <div class="input-group health-measure-group">
            <input type="number" step="0.01" min="0.01" name="height_value" id="height_value"
                class="{{ $fieldClass }} health-measure-input" value="{{ $heightValue }}" required>
            <select name="height_unit" id="height_unit" class="{{ $selectClass }} health-measure-unit" required style="max-width:110px;">
                <option value="cm" @selected($heightUnit === 'cm')>CM</option>
                <option value="ft" @selected($heightUnit === 'ft')>Feet</option>
            </select>
        </div>
        <input type="hidden" name="height_cm" id="height_cm" value="{{ old('height_cm', data_get($health, 'height_cm')) }}">
        <input type="hidden" name="height_ft" id="height_ft" value="{{ old('height_ft', data_get($health, 'height_ft')) }}">
    </div>
</div>

{{-- Weight --}}
<div class="{{ $colClass }}">
    <div class="{{ isset($useDetailBox) && $useDetailBox ? 'detail-box' : 'form-group' }}">
        <label class="{{ $labelClass }}">Weight (وزن)<span class="requi text-danger">*</span></label>
        <div class="input-group health-measure-group">
            <input type="number" step="0.01" min="0.01" name="weight_value" id="weight_value"
                class="{{ $fieldClass }} health-measure-input" value="{{ $weightValue }}" required>
            <select name="weight_unit" id="weight_unit" class="{{ $selectClass }} health-measure-unit" required style="max-width:110px;">
                <option value="kg" @selected($weightUnit === 'kg')>KG</option>
                <option value="lb" @selected($weightUnit === 'lb')>LB</option>
            </select>
        </div>
        <input type="hidden" name="weight_kg" id="weight_kg" value="{{ old('weight_kg', data_get($health, 'weight_kg')) }}">
    </div>
</div>

{{-- Chest Insp --}}
<div class="{{ $colClass }}">
    <div class="{{ isset($useDetailBox) && $useDetailBox ? 'detail-box' : 'form-group' }}">
        <label class="{{ $labelClass }}">Chest Inspiration<span class="requi text-danger">*</span></label>
        <div class="input-group health-measure-group">
            <input type="number" step="0.01" min="0.01" name="chest_insp_value" id="chest_insp_value"
                class="{{ $fieldClass }} health-measure-input" value="{{ $chestInspValue }}" required>
            <select name="chest_insp_unit" id="chest_insp_unit" class="{{ $selectClass }} health-measure-unit" required style="max-width:110px;">
                <option value="cm" @selected($chestInspUnit === 'cm')>CM</option>
                <option value="in" @selected($chestInspUnit === 'in')>Inches</option>
            </select>
        </div>
        <input type="hidden" name="chest_insp_cm" id="chest_insp_cm" value="{{ old('chest_insp_cm', data_get($health, 'chest_insp_cm')) }}">
        <input type="hidden" name="chest_insp_inches" id="chest_insp_inches" value="{{ old('chest_insp_inches', data_get($health, 'chest_insp_inches')) }}">
    </div>
</div>

{{-- Chest Exp --}}
<div class="{{ $colClass }}">
    <div class="{{ isset($useDetailBox) && $useDetailBox ? 'detail-box' : 'form-group' }}">
        <label class="{{ $labelClass }}">Chest Expansion<span class="requi text-danger">*</span></label>
        <div class="input-group health-measure-group">
            <input type="number" step="0.01" min="0.01" name="chest_exp_value" id="chest_exp_value"
                class="{{ $fieldClass }} health-measure-input" value="{{ $chestExpValue }}" required>
            <select name="chest_exp_unit" id="chest_exp_unit" class="{{ $selectClass }} health-measure-unit" required style="max-width:110px;">
                <option value="cm" @selected($chestExpUnit === 'cm')>CM</option>
                <option value="in" @selected($chestExpUnit === 'in')>Inches</option>
            </select>
        </div>
        <input type="hidden" name="chest_exp_cm" id="chest_exp_cm" value="{{ old('chest_exp_cm', data_get($health, 'chest_exp_cm')) }}">
        <input type="hidden" name="chest_exp_inches" id="chest_exp_inches" value="{{ old('chest_exp_inches', data_get($health, 'chest_exp_inches')) }}">
    </div>
</div>

{{-- Abdomen --}}
<div class="{{ $colClass }}">
    <div class="{{ isset($useDetailBox) && $useDetailBox ? 'detail-box' : 'form-group' }}">
        <label class="{{ $labelClass }}">Abdomen<span class="requi text-danger">*</span></label>
        <div class="input-group health-measure-group">
            <input type="number" step="0.01" min="0.01" name="abdomen_value" id="abdomen_value"
                class="{{ $fieldClass }} health-measure-input" value="{{ $abdomenValue }}" required>
            <select name="abdomen_unit" id="abdomen_unit" class="{{ $selectClass }} health-measure-unit" required style="max-width:110px;">
                <option value="cm" @selected($abdomenUnit === 'cm')>CM</option>
                <option value="in" @selected($abdomenUnit === 'in')>Inches</option>
            </select>
        </div>
        <input type="hidden" name="abdomen_cm" id="abdomen_cm" value="{{ old('abdomen_cm', data_get($health, 'abdomen_cm')) }}">
        <input type="hidden" name="abdomen_inches" id="abdomen_inches" value="{{ old('abdomen_inches', data_get($health, 'abdomen_inches')) }}">
    </div>
</div>

{{-- Weight Change Type --}}
<div class="{{ $colClass }}">
    <div class="{{ isset($useDetailBox) && $useDetailBox ? 'detail-box' : 'form-group' }}">
        <label class="{{ $labelClass }}">Weight Change<span class="requi text-danger">*</span></label>
        <select name="weight_change_type" id="weight_change_type" class="{{ $selectClass }}" required>
            <option value="">Select Gain or Loss</option>
            <option value="Gain" @selected($weightChangeType === 'Gain')>Gain</option>
            <option value="Loss" @selected($weightChangeType === 'Loss')>Loss</option>
        </select>
    </div>
</div>

<div class="{{ $colClass }}" id="weight_change_value_wrap" style="{{ $weightChangeType ? '' : 'display:none;' }}">
    <div class="{{ isset($useDetailBox) && $useDetailBox ? 'detail-box' : 'form-group' }}">
        <label class="{{ $labelClass }}" id="weight_change_value_label">
            @if($weightChangeType === 'Loss') Expected Weight Loss @else Expected Weight Gain @endif
            <span class="requi text-danger">*</span>
        </label>
        <div class="input-group health-measure-group">
            <input type="number" step="0.01" min="0" name="weight_change_value" id="weight_change_value"
                class="{{ $fieldClass }}" value="{{ $weightChangeValue }}" @if($weightChangeType) required @endif>
            <select name="weight_change_unit" id="weight_change_unit" class="{{ $selectClass }}" required style="max-width:110px;">
                <option value="kg" @selected($weightChangeUnit === 'kg')>KG</option>
                <option value="lb" @selected($weightChangeUnit === 'lb')>LB</option>
            </select>
        </div>
        <input type="hidden" name="weight_gain_kg" id="weight_gain_kg" value="{{ old('weight_gain_kg', data_get($health, 'weight_gain_kg')) }}">
        <input type="hidden" name="weight_loss_kg" id="weight_loss_kg" value="{{ old('weight_loss_kg', data_get($health, 'weight_loss_kg')) }}">
    </div>
</div>

<div class="{{ str_replace('col-md-6', 'col-md-12', $colClass) }}">
    <div class="{{ isset($useDetailBox) && $useDetailBox ? 'detail-box' : 'form-group' }}">
        <label class="{{ $labelClass }}" id="weight_change_reason_label">
            @if($weightChangeType === 'Loss')
                Reason for Weight Loss
            @elseif($weightChangeType === 'Gain')
                Reason for Weight Gain
            @else
                Reason for Weight Gain or Weight Loss
            @endif
            <span class="requi text-danger">*</span>
        </label>
        <textarea name="weight_increase_reason" id="weight_increase_reason" rows="3"
            class="{{ $fieldClass }}" required>{{ $weightReason }}</textarea>
    </div>
</div>

@once
@push('js')
<script>
(function ($) {
    function toNum(v) {
        var n = parseFloat(v);
        return isNaN(n) ? null : n;
    }

    function convertDisplayedValue($unitSelect, $valueInput, fromUnit, toUnit) {
        var val = toNum($valueInput.val());
        if (val === null || fromUnit === toUnit) {
            return;
        }
        var converted = val;
        // Height
        if ($unitSelect.is('#height_unit')) {
            if (fromUnit === 'cm' && toUnit === 'ft') converted = val / 30.48;
            else if (fromUnit === 'ft' && toUnit === 'cm') converted = val * 30.48;
        }
        // Weight / weight-change
        else if ($unitSelect.is('#weight_unit') || $unitSelect.is('#weight_change_unit')) {
            if (fromUnit === 'kg' && toUnit === 'lb') converted = val / 0.45359237;
            else if (fromUnit === 'lb' && toUnit === 'kg') converted = val * 0.45359237;
        }
        // Length (cm <-> in)
        else {
            if (fromUnit === 'cm' && toUnit === 'in') converted = val / 2.54;
            else if (fromUnit === 'in' && toUnit === 'cm') converted = val * 2.54;
        }
        $valueInput.val(parseFloat(converted.toFixed(2)));
    }

    function syncHealthMeasurements() {
        var heightVal = toNum($('#height_value').val());
        var heightUnit = $('#height_unit').val();
        if (heightVal !== null) {
            if (heightUnit === 'ft') {
                $('#height_ft').val(heightVal.toFixed(2));
                $('#height_cm').val((heightVal * 30.48).toFixed(2));
            } else {
                $('#height_cm').val(heightVal.toFixed(2));
                $('#height_ft').val((heightVal / 30.48).toFixed(2));
            }
        }

        var weightVal = toNum($('#weight_value').val());
        var weightUnit = $('#weight_unit').val();
        if (weightVal !== null) {
            $('#weight_kg').val(weightUnit === 'lb' ? (weightVal * 0.45359237).toFixed(2) : weightVal.toFixed(2));
        }

        function syncLength(prefix) {
            var val = toNum($('#' + prefix + '_value').val());
            var unit = $('#' + prefix + '_unit').val();
            if (val === null) return;
            if (unit === 'in') {
                $('#' + prefix + '_inches').val(val.toFixed(2));
                $('#' + prefix + '_cm').val((val * 2.54).toFixed(2));
            } else {
                $('#' + prefix + '_cm').val(val.toFixed(2));
                $('#' + prefix + '_inches').val((val / 2.54).toFixed(2));
            }
        }
        syncLength('chest_insp');
        syncLength('chest_exp');
        syncLength('abdomen');

        var changeType = $('#weight_change_type').val();
        var changeVal = toNum($('#weight_change_value').val());
        var changeUnit = $('#weight_change_unit').val();
        var kg = null;
        if (changeVal !== null) {
            kg = changeUnit === 'lb' ? (changeVal * 0.45359237) : changeVal;
            kg = parseFloat(kg.toFixed(2));
        }
        if (changeType === 'Gain') {
            $('#weight_gain_kg').val(kg !== null ? kg : '');
            $('#weight_loss_kg').val(0);
        } else if (changeType === 'Loss') {
            $('#weight_loss_kg').val(kg !== null ? kg : '');
            $('#weight_gain_kg').val(0);
        }
    }

    function toggleWeightChangeUi() {
        var type = $('#weight_change_type').val();
        var $wrap = $('#weight_change_value_wrap');
        var $value = $('#weight_change_value');
        if (type === 'Gain' || type === 'Loss') {
            $wrap.show();
            $value.prop('required', true);
            $('#weight_change_value_label').html(
                (type === 'Gain' ? 'Expected Weight Gain' : 'Expected Weight Loss') +
                ' <span class="requi text-danger">*</span>'
            );
            $('#weight_change_reason_label').html(
                (type === 'Gain' ? 'Reason for Weight Gain' : 'Reason for Weight Loss') +
                ' <span class="requi text-danger">*</span>'
            );
        } else {
            $wrap.hide();
            $value.prop('required', false).val('');
            $('#weight_change_reason_label').html(
                'Reason for Weight Gain or Weight Loss <span class="requi text-danger">*</span>'
            );
            $('#weight_gain_kg').val('');
            $('#weight_loss_kg').val('');
        }
        syncHealthMeasurements();
    }

    $(document).ready(function () {
        $('.health-measure-unit, #weight_change_unit').each(function () {
            $(this).data('prev-unit', $(this).val());
        });

        $(document).on('change', '.health-measure-unit, #weight_change_unit', function () {
            var $unit = $(this);
            var fromUnit = $unit.data('prev-unit') || $unit.val();
            var toUnit = $unit.val();
            var $value = $unit.closest('.input-group').find('input[type="number"]').first();
            convertDisplayedValue($unit, $value, fromUnit, toUnit);
            $unit.data('prev-unit', toUnit);
            syncHealthMeasurements();
        });

        $(document).on('input', '.health-measure-input, #weight_change_value', syncHealthMeasurements);
        $(document).on('change', '#weight_change_type', toggleWeightChangeUi);
        toggleWeightChangeUi();
        syncHealthMeasurements();

        // Ensure conversions run before any form submit containing these fields
        $(document).on('submit', 'form', function () {
            if ($(this).find('#height_value').length) {
                syncHealthMeasurements();
            }
        });
        $(document).on('click', '#user_details_submited', function () {
            syncHealthMeasurements();
        });
    });
})(jQuery);
</script>
@endpush
@endonce

{{--
  Simplified health measurements UI.
  Expects: $health (object/array with existing values) OR individual defaults.
  Optional: $fieldClass, $labelClass, $wrapperClass, $colClass, $bilingualLabels
  Backend stores length in CM and weight in KG via App\Support\UnitConverter.
--}}
@php
    $health = $health ?? null;
    $fieldClass = $fieldClass ?? 'form-control jbl-dynamic-input';
    $selectClass = $selectClass ?? 'form-control';
    $labelClass = $labelClass ?? '';
    $colClass = $colClass ?? 'col-md-6 px-0 px-sm-3 mb-3';
    $showBanner = $showBanner ?? true;
    $bilingualLabels = $bilingualLabels ?? false;

    $lblHeight = $bilingualLabels ? policy_label('height') : 'Height (قد)';
    $lblWeight = $bilingualLabels ? policy_label('weight') : 'Weight (وزن)';
    $lblChestInsp = $bilingualLabels ? policy_label('chest_inspiration') : 'Chest Inspiration';
    $lblChestExp = $bilingualLabels ? policy_label('chest_expansion') : 'Chest Expansion';
    $lblAbdomen = $bilingualLabels ? policy_label('abdomen') : 'Abdomen';
    $lblWeightChange = $bilingualLabels ? policy_label('weight_change') : 'Weight Change';
    $lblExpectedGain = $bilingualLabels ? policy_label('expected_weight_gain') : 'Expected Weight Gain';
    $lblExpectedLoss = $bilingualLabels ? policy_label('expected_weight_loss') : 'Expected Weight Loss';
    $lblReasonGain = $bilingualLabels ? policy_label('reason_weight_gain') : 'Reason for Weight Gain';
    $lblReasonLoss = $bilingualLabels ? policy_label('reason_weight_loss') : 'Reason for Weight Loss';
    $lblReasonEither = $bilingualLabels ? policy_label('reason_weight_change') : 'Reason for Weight Gain or Weight Loss';

    $m = \App\Support\UnitConverter::displayHealthMeasurements($health);
    $heightValue = $m['height_value'];
    $heightUnit = $m['height_unit'];
    $weightValue = $m['weight_value'];
    $weightUnit = $m['weight_unit'];
    $chestInspValue = $m['chest_insp_value'];
    $chestInspUnit = $m['chest_insp_unit'];
    $chestExpValue = $m['chest_exp_value'];
    $chestExpUnit = $m['chest_exp_unit'];
    $abdomenValue = $m['abdomen_value'];
    $abdomenUnit = $m['abdomen_unit'];
    $weightChangeType = $m['weight_change_type'];
    $weightChangeValue = $m['weight_change_value'];
    $weightChangeUnit = $m['weight_change_unit'];
    $weightReason = $m['weight_increase_reason'];
@endphp

<style>
    .health-measure-group {
        display: flex;
        gap: 0.5rem;
        align-items: stretch;
        width: 100%;
    }
    .health-measure-group .health-measure-input,
    .health-measure-group #weight_change_value {
        flex: 1 1 auto;
        min-width: 0;
        width: auto !important;
    }
    .health-measure-group .health-measure-unit,
    .health-measure-group #weight_change_unit {
        flex: 0 0 140px;
        max-width: 140px;
        width: 140px !important;
    }
</style>

@if($showBanner)
<div class="{{ $colClass }} col-md-12">
    <div class="alert alert-primary border-start border-5 shadow-sm mb-0">
        <h6 class="mb-2"><i class="fas fa-info-circle me-2"></i>Simple Measurements</h6>
        <p class="mb-0 text-dark">
            Enter each measurement once and choose a unit (cm, m, ft, in, kg, lb, stone, etc.).
            The system automatically converts and stores all required units for you.
        </p>
    </div>
</div>
@endif

{{-- Height --}}
<div class="{{ $colClass }}">
    <div class="{{ isset($useDetailBox) && $useDetailBox ? 'detail-box' : 'form-group' }}">
        <label class="{{ $labelClass }}">{{ $lblHeight }}<span class="requi text-danger">*</span></label>
        <div class="health-measure-group">
            <input type="number" step="0.01" min="0.01" name="height_value" id="height_value"
                class="{{ $fieldClass }} health-measure-input" value="{{ $heightValue }}" required>
            <select name="height_unit" id="height_unit" class="{{ $selectClass }} health-measure-unit" required>
                <option value="cm" @selected($heightUnit === 'cm')>CM</option>
                <option value="m" @selected($heightUnit === 'm')>Meters (M)</option>
                <option value="mm" @selected($heightUnit === 'mm')>MM</option>
                <option value="ft" @selected($heightUnit === 'ft')>Feet (FT)</option>
                <option value="in" @selected($heightUnit === 'in')>Inches (IN)</option>
            </select>
        </div>
        <input type="hidden" name="height_cm" id="height_cm" value="{{ $m['height_cm'] }}">
        <input type="hidden" name="height_ft" id="height_ft" value="{{ $m['height_ft'] }}">
    </div>
</div>

{{-- Weight --}}
<div class="{{ $colClass }}">
    <div class="{{ isset($useDetailBox) && $useDetailBox ? 'detail-box' : 'form-group' }}">
        <label class="{{ $labelClass }}">{{ $lblWeight }}<span class="requi text-danger">*</span></label>
        <div class="health-measure-group">
            <input type="number" step="0.01" min="0.01" name="weight_value" id="weight_value"
                class="{{ $fieldClass }} health-measure-input" value="{{ $weightValue }}" required>
            <select name="weight_unit" id="weight_unit" class="{{ $selectClass }} health-measure-unit" required>
                <option value="kg" @selected($weightUnit === 'kg')>KG</option>
                <option value="lb" @selected($weightUnit === 'lb')>Pounds (LB)</option>
                <option value="st" @selected($weightUnit === 'st')>Stone (ST)</option>
                <option value="g" @selected($weightUnit === 'g')>Grams (G)</option>
                <option value="oz" @selected($weightUnit === 'oz')>Ounces (OZ)</option>
            </select>
        </div>
        <input type="hidden" name="weight_kg" id="weight_kg" value="{{ $m['weight_kg'] }}">
    </div>
</div>

{{-- Chest Insp --}}
<div class="{{ $colClass }}">
    <div class="{{ isset($useDetailBox) && $useDetailBox ? 'detail-box' : 'form-group' }}">
        <label class="{{ $labelClass }}">{{ $lblChestInsp }}<span class="requi text-danger">*</span></label>
        <div class="health-measure-group">
            <input type="number" step="0.01" min="0.01" name="chest_insp_value" id="chest_insp_value"
                class="{{ $fieldClass }} health-measure-input" value="{{ $chestInspValue }}" required>
            <select name="chest_insp_unit" id="chest_insp_unit" class="{{ $selectClass }} health-measure-unit" required>
                <option value="cm" @selected($chestInspUnit === 'cm')>CM</option>
                <option value="in" @selected($chestInspUnit === 'in')>Inches (IN)</option>
                <option value="mm" @selected($chestInspUnit === 'mm')>MM</option>
                <option value="m" @selected($chestInspUnit === 'm')>Meters (M)</option>
            </select>
        </div>
        <input type="hidden" name="chest_insp_cm" id="chest_insp_cm" value="{{ old('chest_insp_cm', data_get($health, 'chest_insp_cm')) }}">
        <input type="hidden" name="chest_insp_inches" id="chest_insp_inches" value="{{ old('chest_insp_inches', data_get($health, 'chest_insp_inches')) }}">
    </div>
</div>

{{-- Chest Exp --}}
<div class="{{ $colClass }}">
    <div class="{{ isset($useDetailBox) && $useDetailBox ? 'detail-box' : 'form-group' }}">
        <label class="{{ $labelClass }}">{{ $lblChestExp }}<span class="requi text-danger">*</span></label>
        <div class="health-measure-group">
            <input type="number" step="0.01" min="0.01" name="chest_exp_value" id="chest_exp_value"
                class="{{ $fieldClass }} health-measure-input" value="{{ $chestExpValue }}" required>
            <select name="chest_exp_unit" id="chest_exp_unit" class="{{ $selectClass }} health-measure-unit" required>
                <option value="cm" @selected($chestExpUnit === 'cm')>CM</option>
                <option value="m" @selected($chestExpUnit === 'm')>Meters (M)</option>
                <option value="mm" @selected($chestExpUnit === 'mm')>MM</option>
                <option value="ft" @selected($chestExpUnit === 'ft')>Feet (FT)</option>
                <option value="in" @selected($chestExpUnit === 'in')>Inches (IN)</option>
            </select>
        </div>
        <input type="hidden" name="chest_exp_cm" id="chest_exp_cm" value="{{ $m['chest_exp_cm'] }}">
        <input type="hidden" name="chest_exp_inches" id="chest_exp_inches" value="{{ $m['chest_exp_inches'] }}">
    </div>
</div>

{{-- Abdomen --}}
<div class="{{ $colClass }}">
    <div class="{{ isset($useDetailBox) && $useDetailBox ? 'detail-box' : 'form-group' }}">
        <label class="{{ $labelClass }}">{{ $lblAbdomen }}<span class="requi text-danger">*</span></label>
        <div class="health-measure-group">
            <input type="number" step="0.01" min="0.01" name="abdomen_value" id="abdomen_value"
                class="{{ $fieldClass }} health-measure-input" value="{{ $abdomenValue }}" required>
            <select name="abdomen_unit" id="abdomen_unit" class="{{ $selectClass }} health-measure-unit" required>
                <option value="cm" @selected($abdomenUnit === 'cm')>CM</option>
                <option value="m" @selected($abdomenUnit === 'm')>Meters (M)</option>
                <option value="mm" @selected($abdomenUnit === 'mm')>MM</option>
                <option value="ft" @selected($abdomenUnit === 'ft')>Feet (FT)</option>
                <option value="in" @selected($abdomenUnit === 'in')>Inches (IN)</option>
            </select>
        </div>
        <input type="hidden" name="abdomen_cm" id="abdomen_cm" value="{{ $m['abdomen_cm'] }}">
        <input type="hidden" name="abdomen_inches" id="abdomen_inches" value="{{ $m['abdomen_inches'] }}">
    </div>
</div>

{{-- Weight Change Type --}}
<div class="{{ $colClass }}">
    <div class="{{ isset($useDetailBox) && $useDetailBox ? 'detail-box' : 'form-group' }}">
        <label class="{{ $labelClass }}">{{ $lblWeightChange }}<span class="requi text-danger">*</span></label>
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
            @if($weightChangeType === 'Loss') {{ $lblExpectedLoss }} @else {{ $lblExpectedGain }} @endif
            <span class="requi text-danger">*</span>
        </label>
        <div class="health-measure-group">
            <input type="number" step="0.01" min="0" name="weight_change_value" id="weight_change_value"
                class="{{ $fieldClass }}" value="{{ $weightChangeValue }}" @if($weightChangeType) required @endif>
            <select name="weight_change_unit" id="weight_change_unit" class="{{ $selectClass }}" required>
                <option value="kg" @selected($weightChangeUnit === 'kg')>KG</option>
                <option value="lb" @selected($weightChangeUnit === 'lb')>Pounds (LB)</option>
                <option value="st" @selected($weightChangeUnit === 'st')>Stone (ST)</option>
                <option value="g" @selected($weightChangeUnit === 'g')>Grams (G)</option>
                <option value="oz" @selected($weightChangeUnit === 'oz')>Ounces (OZ)</option>
            </select>
        </div>
        <input type="hidden" name="weight_gain_kg" id="weight_gain_kg" value="{{ $m['weight_gain_kg'] }}">
        <input type="hidden" name="weight_loss_kg" id="weight_loss_kg" value="{{ $m['weight_loss_kg'] }}">
    </div>
</div>

<div class="{{ str_replace('col-md-6', 'col-md-12', $colClass) }}">
    <div class="{{ isset($useDetailBox) && $useDetailBox ? 'detail-box' : 'form-group' }}">
        <label class="{{ $labelClass }}" id="weight_change_reason_label">
            @if($weightChangeType === 'Loss')
                {{ $lblReasonLoss }}
            @elseif($weightChangeType === 'Gain')
                {{ $lblReasonGain }}
            @else
                {{ $lblReasonEither }}
            @endif
            <span class="requi text-danger">*</span>
        </label>
        <textarea name="weight_increase_reason" id="weight_increase_reason" rows="3"
            class="{{ $fieldClass }}" required>{{ $weightReason }}</textarea>
    </div>
</div>

@once
@push('js')
<script src="{{ asset('frontend/js/unit-converter.js') }}"></script>
<script>
(function () {
    if (typeof window.UnitConverter === 'undefined') {
        return;
    }
    window.UnitConverter.configure(@json(\App\Support\UnitConverter::jsConfig()));
    window.UnitConverter.bindHealthForm({
        labels: {
            expectedGain: @json($lblExpectedGain),
            expectedLoss: @json($lblExpectedLoss),
            reasonGain: @json($lblReasonGain),
            reasonLoss: @json($lblReasonLoss),
            reasonEither: @json($lblReasonEither)
        }
    });
})();
</script>
@endpush
@endonce

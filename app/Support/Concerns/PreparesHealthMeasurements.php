<?php

namespace App\Support\Concerns;

use App\Support\UnitConverter;

trait PreparesHealthMeasurements
{
    /**
     * UI-only fields that must not be mass-assigned / persisted.
     * Preferred units ARE persisted for edit round-trip.
     */
    protected function healthMeasurementUiOnlyKeys(): array
    {
        return [
            'height_value',
            'weight_value',
            'chest_insp_value',
            'chest_exp_value',
            'abdomen_value',
            'weight_change_type',
            'weight_change_value',
        ];
    }

    /**
     * Drop UI-only measurement keys from a validated payload.
     * Named helper so this trait can be combined with PreparesFemaleDiseaseHistory.
     */
    protected function exceptHealthMeasurementUiKeys(mixed $validated, mixed $key = null): mixed
    {
        if ($key !== null || !is_array($validated)) {
            return $validated;
        }

        return collect($validated)
            ->except($this->healthMeasurementUiOnlyKeys())
            ->all();
    }

    /**
     * Map simplified UI measurement inputs (+ units) onto existing DB columns.
     * Always converts to backend standards: length=CM, weight=KG.
     */
    protected function mergeConvertedHealthMeasurements(): void
    {
        $converted = UnitConverter::convertHealthMeasurements($this->all());
        if ($converted !== []) {
            $this->merge($converted);
        }
    }

    protected function healthMeasurementUiRules(): array
    {
        $lengthUnits = implode(',', UnitConverter::LENGTH_UNITS);
        $weightUnits = implode(',', UnitConverter::WEIGHT_UNITS);

        return [
            'height_value' => 'required|numeric|gt:0|max:1000',
            'height_unit' => 'required|in:' . $lengthUnits,
            'weight_value' => 'required|numeric|gt:0|max:5000',
            'weight_unit' => 'required|in:' . $weightUnits,
            'chest_insp_value' => 'required|numeric|gt:0|max:5000',
            'chest_insp_unit' => 'required|in:' . $lengthUnits,
            'chest_exp_value' => 'required|numeric|gt:0|max:5000',
            'chest_exp_unit' => 'required|in:' . $lengthUnits,
            'abdomen_value' => 'required|numeric|gt:0|max:5000',
            'abdomen_unit' => 'required|in:' . $lengthUnits,
            'weight_change_type' => 'required|in:Gain,Loss',
            'weight_change_value' => 'required|numeric|gte:0|max:5000',
            'weight_change_unit' => 'required|in:' . $weightUnits,
            'weight_increase_reason' => 'required|string|max:1000',
        ];
    }

    protected function healthMeasurementDbRules(): array
    {
        $lengthUnits = implode(',', UnitConverter::LENGTH_UNITS);
        $weightUnits = implode(',', UnitConverter::WEIGHT_UNITS);

        return [
            'height_cm' => 'required|numeric|min:0|max:400',
            'height_ft' => 'required|numeric|min:0',
            'weight_kg' => 'required|numeric|min:0|max:1000',
            'chest_insp_cm' => 'required|numeric|min:0',
            'chest_insp_inches' => 'required|numeric|min:0',
            'chest_exp_cm' => 'required|numeric|min:0',
            'chest_exp_inches' => 'required|numeric|min:0',
            'abdomen_cm' => 'required|numeric|min:0',
            'abdomen_inches' => 'required|numeric|min:0',
            'weight_loss_kg' => 'nullable|numeric|min:0',
            'weight_gain_kg' => 'nullable|numeric|min:0',
            'height_unit' => 'nullable|in:' . $lengthUnits,
            'weight_unit' => 'nullable|in:' . $weightUnits,
            'chest_insp_unit' => 'nullable|in:' . $lengthUnits,
            'chest_exp_unit' => 'nullable|in:' . $lengthUnits,
            'abdomen_unit' => 'nullable|in:' . $lengthUnits,
            'weight_change_unit' => 'nullable|in:' . $weightUnits,
        ];
    }
}

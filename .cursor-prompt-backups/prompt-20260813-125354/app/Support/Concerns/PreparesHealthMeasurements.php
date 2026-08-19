<?php

namespace App\Support\Concerns;

trait PreparesHealthMeasurements
{
    /**
     * UI-only fields that must not be mass-assigned / persisted.
     */
    protected function healthMeasurementUiOnlyKeys(): array
    {
        return [
            'height_value',
            'height_unit',
            'weight_value',
            'weight_unit',
            'chest_insp_value',
            'chest_insp_unit',
            'chest_exp_value',
            'chest_exp_unit',
            'abdomen_value',
            'abdomen_unit',
            'weight_change_type',
            'weight_change_value',
            'weight_change_unit',
        ];
    }

    /**
     * Drop UI-only measurement keys from validated payloads.
     */
    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);

        if ($key !== null) {
            return $validated;
        }

        return collect($validated)
            ->except($this->healthMeasurementUiOnlyKeys())
            ->all();
    }

    /**
     * Convert a length value to centimeters.
     */
    protected function lengthToCm(float $value, string $unit): float
    {
        return match ($unit) {
            'm' => $value * 100,
            'mm' => $value * 0.1,
            'in' => $value * 2.54,
            'ft' => $value * 30.48,
            default => $value, // cm
        };
    }

    /**
     * Convert a weight value to kilograms.
     */
    protected function weightToKg(float $value, string $unit): float
    {
        return match ($unit) {
            'lb', 'lbs' => $value * 0.45359237,
            'st' => $value * 6.35029318,
            'g' => $value * 0.001,
            'oz' => $value * 0.0283495231,
            default => $value, // kg
        };
    }

    /**
     * Map simplified UI measurement inputs (+ units) onto existing DB columns.
     */
    protected function mergeConvertedHealthMeasurements(): void
    {
        $merge = [];

        // Height → height_cm + height_ft
        if ($this->filled('height_value')) {
            $cm = $this->lengthToCm(
                (float) $this->input('height_value'),
                (string) $this->input('height_unit', 'cm')
            );
            $merge['height_cm'] = round($cm, 2);
            $merge['height_ft'] = round($cm / 30.48, 2);
        }

        // Weight → weight_kg
        if ($this->filled('weight_value')) {
            $kg = $this->weightToKg(
                (float) $this->input('weight_value'),
                (string) $this->input('weight_unit', 'kg')
            );
            $merge['weight_kg'] = round($kg, 2);
        }

        // Body circumferences → *_cm + *_inches
        foreach (['chest_insp', 'chest_exp', 'abdomen'] as $prefix) {
            $valueKey = $prefix . '_value';
            if (!$this->filled($valueKey)) {
                continue;
            }
            $cm = $this->lengthToCm(
                (float) $this->input($valueKey),
                (string) $this->input($prefix . '_unit', 'cm')
            );
            $merge[$prefix . '_cm'] = round($cm, 2);
            $merge[$prefix . '_inches'] = round($cm / 2.54, 2);
        }

        // Weight change: Gain XOR Loss → weight_gain_kg / weight_loss_kg
        if ($this->filled('weight_change_type') && $this->filled('weight_change_value')) {
            $kg = round($this->weightToKg(
                (float) $this->input('weight_change_value'),
                (string) $this->input('weight_change_unit', 'kg')
            ), 2);
            $type = $this->input('weight_change_type');

            if ($type === 'Gain') {
                $merge['weight_gain_kg'] = $kg;
                $merge['weight_loss_kg'] = 0;
            } elseif ($type === 'Loss') {
                $merge['weight_loss_kg'] = $kg;
                $merge['weight_gain_kg'] = 0;
            }
        } elseif ($this->filled('weight_change_type') && !$this->filled('weight_change_value')) {
            if ($this->input('weight_change_type') === 'Gain') {
                $merge['weight_loss_kg'] = 0;
            }
            if ($this->input('weight_change_type') === 'Loss') {
                $merge['weight_gain_kg'] = 0;
            }
        }

        if (!empty($merge)) {
            $this->merge($merge);
        }
    }

    protected function healthMeasurementUiRules(): array
    {
        return [
            'height_value' => 'required|numeric|gt:0|max:1000',
            'height_unit' => 'required|in:cm,m,ft,in',
            'weight_value' => 'required|numeric|gt:0|max:5000',
            'weight_unit' => 'required|in:kg,lb,st,g,oz',
            'chest_insp_value' => 'required|numeric|gt:0|max:5000',
            'chest_insp_unit' => 'required|in:cm,in,mm,m',
            'chest_exp_value' => 'required|numeric|gt:0|max:5000',
            'chest_exp_unit' => 'required|in:cm,in,mm,m',
            'abdomen_value' => 'required|numeric|gt:0|max:5000',
            'abdomen_unit' => 'required|in:cm,in,mm,m',
            'weight_change_type' => 'required|in:Gain,Loss',
            'weight_change_value' => 'required|numeric|gte:0|max:5000',
            'weight_change_unit' => 'required|in:kg,lb,st,g,oz',
            'weight_increase_reason' => 'required|string|max:1000',
        ];
    }

    protected function healthMeasurementDbRules(): array
    {
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
        ];
    }
}

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
     * Map simplified UI measurement inputs (+ units) onto existing DB columns.
     */
    protected function mergeConvertedHealthMeasurements(): void
    {
        $merge = [];

        // Height: cm <-> ft
        if ($this->filled('height_value')) {
            $value = (float) $this->input('height_value');
            $unit = $this->input('height_unit', 'cm');
            if ($unit === 'ft') {
                $merge['height_ft'] = round($value, 2);
                $merge['height_cm'] = round($value * 30.48, 2);
            } else {
                $merge['height_cm'] = round($value, 2);
                $merge['height_ft'] = round($value / 30.48, 2);
            }
        }

        // Weight: kg <-> lb
        if ($this->filled('weight_value')) {
            $value = (float) $this->input('weight_value');
            $unit = $this->input('weight_unit', 'kg');
            $merge['weight_kg'] = $unit === 'lb'
                ? round($value * 0.45359237, 2)
                : round($value, 2);
        }

        // Length helpers (cm <-> in)
        foreach (['chest_insp', 'chest_exp', 'abdomen'] as $prefix) {
            $valueKey = $prefix . '_value';
            $unitKey = $prefix . '_unit';
            if (!$this->filled($valueKey)) {
                continue;
            }
            $value = (float) $this->input($valueKey);
            $unit = $this->input($unitKey, 'cm');
            $cmKey = $prefix . '_cm';
            $inKey = $prefix . '_inches';
            if ($unit === 'in') {
                $merge[$inKey] = round($value, 2);
                $merge[$cmKey] = round($value * 2.54, 2);
            } else {
                $merge[$cmKey] = round($value, 2);
                $merge[$inKey] = round($value / 2.54, 2);
            }
        }

        // Weight change: Gain XOR Loss
        if ($this->filled('weight_change_type') && $this->filled('weight_change_value')) {
            $value = (float) $this->input('weight_change_value');
            $unit = $this->input('weight_change_unit', 'kg');
            $kg = $unit === 'lb' ? round($value * 0.45359237, 2) : round($value, 2);
            $type = $this->input('weight_change_type');

            if ($type === 'Gain') {
                $merge['weight_gain_kg'] = $kg;
                $merge['weight_loss_kg'] = 0;
            } elseif ($type === 'Loss') {
                $merge['weight_loss_kg'] = $kg;
                $merge['weight_gain_kg'] = 0;
            }
        } elseif ($this->filled('weight_change_type') && !$this->filled('weight_change_value')) {
            // Ensure exclusive clear when type chosen but value blank (validation will catch)
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
            'height_value' => 'required|numeric|gt:0|max:400',
            'height_unit' => 'required|in:cm,ft',
            'weight_value' => 'required|numeric|gt:0|max:1000',
            'weight_unit' => 'required|in:kg,lb',
            'chest_insp_value' => 'required|numeric|gt:0|max:400',
            'chest_insp_unit' => 'required|in:cm,in',
            'chest_exp_value' => 'required|numeric|gt:0|max:400',
            'chest_exp_unit' => 'required|in:cm,in',
            'abdomen_value' => 'required|numeric|gt:0|max:400',
            'abdomen_unit' => 'required|in:cm,in',
            'weight_change_type' => 'required|in:Gain,Loss',
            'weight_change_value' => 'required|numeric|gte:0|max:500',
            'weight_change_unit' => 'required|in:kg,lb',
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

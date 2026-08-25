<?php

namespace App\Support;

/**
 * Centralized measurement conversion.
 * Backend standards: length = CM, weight = KG.
 */
final class UnitConverter
{
    /** @var array<string, float> Factors to convert TO centimeters */
    public const LENGTH_TO_CM = [
        'cm' => 1.0,
        'm' => 100.0,
        'mm' => 0.1,
        'in' => 2.54,
        'inch' => 2.54,
        'inches' => 2.54,
        'ft' => 30.48,
        'feet' => 30.48,
        'foot' => 30.48,
    ];

    /** @var array<string, float> Factors to convert TO kilograms */
    public const WEIGHT_TO_KG = [
        'kg' => 1.0,
        'lb' => 0.45359237,
        'lbs' => 0.45359237,
        'st' => 6.35029318,
        'stone' => 6.35029318,
        'g' => 0.001,
        'oz' => 0.028349523125,
    ];

    public const LENGTH_UNITS = ['cm', 'm', 'mm', 'in', 'ft'];
    public const WEIGHT_UNITS = ['kg', 'lb', 'st', 'g', 'oz'];

    /** Decimal places for persisted canonical values */
    public const STORAGE_PRECISION = 4;

    /** Decimal places for UI display values */
    public const DISPLAY_PRECISION = 4;

    public static function normalizeLengthUnit(?string $unit): string
    {
        $unit = strtolower(trim((string) $unit));

        return match ($unit) {
            'inch', 'inches', '"' => 'in',
            'feet', 'foot', "'" => 'ft',
            'meter', 'meters', 'metre', 'metres' => 'm',
            'millimeter', 'millimeters', 'millimetre', 'millimetres' => 'mm',
            'centimeter', 'centimeters', 'centimetre', 'centimetres' => 'cm',
            default => $unit !== '' && isset(self::LENGTH_TO_CM[$unit]) ? $unit : 'cm',
        };
    }

    public static function normalizeWeightUnit(?string $unit): string
    {
        $unit = strtolower(trim((string) $unit));

        return match ($unit) {
            'lbs', 'pound', 'pounds' => 'lb',
            'stone', 'stones' => 'st',
            'gram', 'grams' => 'g',
            'ounce', 'ounces' => 'oz',
            'kilogram', 'kilograms' => 'kg',
            default => $unit !== '' && isset(self::WEIGHT_TO_KG[$unit]) ? $unit : 'kg',
        };
    }

    public static function toCm(float|int|string|null $value, ?string $unit): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        $num = (float) $value;
        $factor = self::LENGTH_TO_CM[self::normalizeLengthUnit($unit)] ?? 1.0;

        return $num * $factor;
    }

    public static function fromCm(float|int|string|null $cm, ?string $unit): ?float
    {
        if ($cm === null || $cm === '') {
            return null;
        }

        $factor = self::LENGTH_TO_CM[self::normalizeLengthUnit($unit)] ?? 1.0;
        if ($factor == 0.0) {
            return null;
        }

        return ((float) $cm) / $factor;
    }

    public static function toKg(float|int|string|null $value, ?string $unit): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        $num = (float) $value;
        $factor = self::WEIGHT_TO_KG[self::normalizeWeightUnit($unit)] ?? 1.0;

        return $num * $factor;
    }

    public static function fromKg(float|int|string|null $kg, ?string $unit): ?float
    {
        if ($kg === null || $kg === '') {
            return null;
        }

        $factor = self::WEIGHT_TO_KG[self::normalizeWeightUnit($unit)] ?? 1.0;
        if ($factor == 0.0) {
            return null;
        }

        return ((float) $kg) / $factor;
    }

    public static function convertLength(float|int|string|null $value, ?string $fromUnit, ?string $toUnit): ?float
    {
        $cm = self::toCm($value, $fromUnit);
        if ($cm === null) {
            return null;
        }

        return self::fromCm($cm, $toUnit);
    }

    public static function convertWeight(float|int|string|null $value, ?string $fromUnit, ?string $toUnit): ?float
    {
        $kg = self::toKg($value, $fromUnit);
        if ($kg === null) {
            return null;
        }

        return self::fromKg($kg, $toUnit);
    }

    public static function round(?float $value, ?int $precision = null): ?float
    {
        if ($value === null) {
            return null;
        }

        return round($value, $precision ?? self::STORAGE_PRECISION);
    }

    /**
     * Build canonical DB fields from UI value+unit inputs.
     *
     * @param  array<string, mixed>  $input
     * @return array<string, mixed>
     */
    public static function convertHealthMeasurements(array $input): array
    {
        $out = [];

        if (self::filled($input, 'height_value')) {
            $cm = self::toCm($input['height_value'], $input['height_unit'] ?? 'cm');
            if ($cm !== null) {
                $out['height_cm'] = self::round($cm);
                $out['height_ft'] = self::round(self::fromCm($cm, 'ft'));
            }
        }

        if (self::filled($input, 'weight_value')) {
            $kg = self::toKg($input['weight_value'], $input['weight_unit'] ?? 'kg');
            if ($kg !== null) {
                $out['weight_kg'] = self::round($kg);
            }
        }

        foreach (['chest_insp', 'chest_exp', 'abdomen'] as $prefix) {
            if (!self::filled($input, $prefix . '_value')) {
                continue;
            }
            $cm = self::toCm($input[$prefix . '_value'], $input[$prefix . '_unit'] ?? 'cm');
            if ($cm === null) {
                continue;
            }
            $out[$prefix . '_cm'] = self::round($cm);
            $out[$prefix . '_inches'] = self::round(self::fromCm($cm, 'in'));
        }

        if (self::filled($input, 'weight_change_type') && self::filled($input, 'weight_change_value')) {
            $kg = self::round(self::toKg(
                $input['weight_change_value'],
                $input['weight_change_unit'] ?? 'kg'
            ));
            $type = $input['weight_change_type'];
            if ($type === 'Gain') {
                $out['weight_gain_kg'] = $kg;
                $out['weight_loss_kg'] = 0;
            } elseif ($type === 'Loss') {
                $out['weight_loss_kg'] = $kg;
                $out['weight_gain_kg'] = 0;
            }
        } elseif (self::filled($input, 'weight_change_type') && !self::filled($input, 'weight_change_value')) {
            if (($input['weight_change_type'] ?? '') === 'Gain') {
                $out['weight_loss_kg'] = 0;
            }
            if (($input['weight_change_type'] ?? '') === 'Loss') {
                $out['weight_gain_kg'] = 0;
            }
        }

        // Persist preferred display units (round-trip on edit).
        foreach ([
            'height_unit',
            'weight_unit',
            'chest_insp_unit',
            'chest_exp_unit',
            'abdomen_unit',
            'weight_change_unit',
        ] as $unitKey) {
            if (array_key_exists($unitKey, $input) && $input[$unitKey] !== null && $input[$unitKey] !== '') {
                if (str_contains($unitKey, 'weight')) {
                    $out[$unitKey] = self::normalizeWeightUnit((string) $input[$unitKey]);
                } else {
                    $out[$unitKey] = self::normalizeLengthUnit((string) $input[$unitKey]);
                }
            }
        }

        return $out;
    }

    /**
     * Prepare UI display values from stored CM/KG (+ optional preferred units).
     *
     * @param  object|array<string, mixed>|null  $health
     * @return array<string, mixed>
     */
    public static function displayHealthMeasurements(object|array|null $health): array
    {
        $get = static fn (string $key, mixed $default = null) => data_get($health, $key, $default);

        $heightUnit = self::normalizeLengthUnit((string) old('height_unit', $get('height_unit', 'cm')));
        $weightUnit = self::normalizeWeightUnit((string) old('weight_unit', $get('weight_unit', 'kg')));
        $chestInspUnit = self::normalizeLengthUnit((string) old('chest_insp_unit', $get('chest_insp_unit', 'cm')));
        $chestExpUnit = self::normalizeLengthUnit((string) old('chest_exp_unit', $get('chest_exp_unit', 'cm')));
        $abdomenUnit = self::normalizeLengthUnit((string) old('abdomen_unit', $get('abdomen_unit', 'cm')));
        $weightChangeUnit = self::normalizeWeightUnit((string) old('weight_change_unit', $get('weight_change_unit', 'kg')));

        $heightCm = (float) old('height_cm', $get('height_cm', 0));
        $weightKg = (float) old('weight_kg', $get('weight_kg', 0));
        $chestInspCm = (float) old('chest_insp_cm', $get('chest_insp_cm', 0));
        $chestExpCm = (float) old('chest_exp_cm', $get('chest_exp_cm', 0));
        $abdomenCm = (float) old('abdomen_cm', $get('abdomen_cm', 0));
        $gain = (float) old('weight_gain_kg', $get('weight_gain_kg', 0));
        $loss = (float) old('weight_loss_kg', $get('weight_loss_kg', 0));

    $format = static function (?float $value): string|float|int {
        if ($value === null || abs($value) < 1e-12) {
            return '';
        }
        $rounded = round($value, self::DISPLAY_PRECISION);

        return $rounded + 0;
    };

        if ($gain > 0 && $loss <= 0) {
            $changeType = 'Gain';
            $changeKg = $gain;
        } elseif ($loss > 0 && $gain <= 0) {
            $changeType = 'Loss';
            $changeKg = $loss;
        } elseif ($gain > 0 && $loss > 0) {
            $changeType = $gain >= $loss ? 'Gain' : 'Loss';
            $changeKg = $gain >= $loss ? $gain : $loss;
        } else {
            $changeType = '';
            $changeKg = 0;
        }

        return [
            'height_unit' => $heightUnit,
            'weight_unit' => $weightUnit,
            'chest_insp_unit' => $chestInspUnit,
            'chest_exp_unit' => $chestExpUnit,
            'abdomen_unit' => $abdomenUnit,
            'weight_change_unit' => $weightChangeUnit,
            'height_value' => old('height_value', $heightCm > 0 ? $format(self::fromCm($heightCm, $heightUnit)) : ''),
            'weight_value' => old('weight_value', $weightKg > 0 ? $format(self::fromKg($weightKg, $weightUnit)) : ''),
            'chest_insp_value' => old('chest_insp_value', $chestInspCm > 0 ? $format(self::fromCm($chestInspCm, $chestInspUnit)) : ''),
            'chest_exp_value' => old('chest_exp_value', $chestExpCm > 0 ? $format(self::fromCm($chestExpCm, $chestExpUnit)) : ''),
            'abdomen_value' => old('abdomen_value', $abdomenCm > 0 ? $format(self::fromCm($abdomenCm, $abdomenUnit)) : ''),
            'weight_change_type' => old('weight_change_type', $changeType),
            'weight_change_value' => old(
                'weight_change_value',
                $changeKg > 0 ? $format(self::fromKg($changeKg, $weightChangeUnit)) : ''
            ),
            'height_cm' => old('height_cm', $get('height_cm')),
            'height_ft' => old('height_ft', $get('height_ft')),
            'weight_kg' => old('weight_kg', $get('weight_kg')),
            'chest_insp_cm' => old('chest_insp_cm', $get('chest_insp_cm')),
            'chest_insp_inches' => old('chest_insp_inches', $get('chest_insp_inches')),
            'chest_exp_cm' => old('chest_exp_cm', $get('chest_exp_cm')),
            'chest_exp_inches' => old('chest_exp_inches', $get('chest_exp_inches')),
            'abdomen_cm' => old('abdomen_cm', $get('abdomen_cm')),
            'abdomen_inches' => old('abdomen_inches', $get('abdomen_inches')),
            'weight_gain_kg' => old('weight_gain_kg', $get('weight_gain_kg')),
            'weight_loss_kg' => old('weight_loss_kg', $get('weight_loss_kg')),
            'weight_increase_reason' => old('weight_increase_reason', $get('weight_increase_reason', '')),
        ];
    }

    /**
     * Factors payload for frontend JS (keep FE/BE in sync).
     *
     * @return array{length_to_cm: array<string, float>, weight_to_kg: array<string, float>, precision: int}
     */
    public static function jsConfig(): array
    {
        return [
            'length_to_cm' => [
                'cm' => self::LENGTH_TO_CM['cm'],
                'm' => self::LENGTH_TO_CM['m'],
                'mm' => self::LENGTH_TO_CM['mm'],
                'in' => self::LENGTH_TO_CM['in'],
                'ft' => self::LENGTH_TO_CM['ft'],
            ],
            'weight_to_kg' => [
                'kg' => self::WEIGHT_TO_KG['kg'],
                'lb' => self::WEIGHT_TO_KG['lb'],
                'st' => self::WEIGHT_TO_KG['st'],
                'g' => self::WEIGHT_TO_KG['g'],
                'oz' => self::WEIGHT_TO_KG['oz'],
            ],
            'precision' => self::DISPLAY_PRECISION,
        ];
    }

    private static function filled(array $input, string $key): bool
    {
        return array_key_exists($key, $input)
            && $input[$key] !== null
            && $input[$key] !== '';
    }
}

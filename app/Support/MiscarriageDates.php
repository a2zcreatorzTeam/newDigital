<?php

namespace App\Support;

class MiscarriageDates
{
    public static function split(mixed $value): array
    {
        if (is_array($value)) {
            $dates = [];
            foreach ($value as $item) {
                $normalized = self::normalizeDate((string) $item);
                if ($normalized !== '') {
                    $dates[] = $normalized;
                }
            }

            return $dates !== [] ? $dates : [''];
        }

        $raw = trim((string) $value);
        if ($raw === '') {
            return [''];
        }

        $decoded = json_decode($raw, true);
        if (is_array($decoded)) {
            return self::split($decoded);
        }

        $parts = preg_split('/\s*,\s*/', $raw) ?: [];

        return self::split($parts);
    }

    public static function join(mixed $value): ?string
    {
        $dates = array_values(array_filter(self::split($value), fn ($date) => $date !== ''));

        return $dates === [] ? null : implode(', ', $dates);
    }

    public static function display(?string $value): string
    {
        $joined = self::join($value);

        return $joined === null || $joined === '' ? '---' : $joined;
    }

    protected static function normalizeDate(string $value): string
    {
        $value = trim($value);
        if ($value === '') {
            return '';
        }

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
            return $value;
        }

        $timestamp = strtotime($value);
        if ($timestamp === false) {
            return $value;
        }

        return date('Y-m-d', $timestamp);
    }
}

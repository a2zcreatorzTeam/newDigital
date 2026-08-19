<?php

namespace App\Support;

class FemaleDiseases
{
    public const OTHER = 'Other';

    public static function options(): array
    {
        return [
            'Menstrual disorders' => 'Menstrual disorders',
            'PCOS' => 'PCOS',
            'Endometriosis' => 'Endometriosis',
            'Fibroids' => 'Fibroids',
            'Ovarian cyst' => 'Ovarian cyst',
            'Breast disease / lump' => 'Breast disease / lump',
            'Cervical disease' => 'Cervical disease',
            'Uterine prolapse' => 'Uterine prolapse',
            'Pelvic inflammatory disease' => 'Pelvic inflammatory disease',
            'Infertility' => 'Infertility',
            self::OTHER => 'Other',
        ];
    }

    public static function values(): array
    {
        return array_keys(self::options());
    }

    public static function pack(?string $name, ?string $details): ?string
    {
        $name = trim((string) $name);
        $details = trim((string) $details);

        if ($name === '' && $details === '') {
            return null;
        }

        return json_encode([
            'name' => $name === '' ? null : $name,
            'details' => $details === '' ? null : $details,
        ], JSON_UNESCAPED_UNICODE);
    }

    public static function unpack(mixed $value): array
    {
        $empty = ['name' => null, 'details' => null];
        if ($value === null || $value === '') {
            return $empty;
        }

        if (is_array($value)) {
            return [
                'name' => $value['name'] ?? null,
                'details' => $value['details'] ?? null,
            ];
        }

        $decoded = json_decode((string) $value, true);
        if (is_array($decoded) && (array_key_exists('name', $decoded) || array_key_exists('details', $decoded))) {
            return [
                'name' => $decoded['name'] ?? null,
                'details' => $decoded['details'] ?? null,
            ];
        }

        return ['name' => (string) $value, 'details' => null];
    }

    public static function name(mixed $value): ?string
    {
        $name = self::unpack($value)['name'];

        return $name === '' ? null : $name;
    }

    public static function details(mixed $value): ?string
    {
        $details = self::unpack($value)['details'];

        return $details === '' ? null : $details;
    }
}

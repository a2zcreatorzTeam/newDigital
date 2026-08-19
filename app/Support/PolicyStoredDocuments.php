<?php

namespace App\Support;

class PolicyStoredDocuments
{
    public static function medical(mixed $json): array
    {
        return self::decode($json);
    }

    public static function others(mixed $json): array
    {
        return array_values(array_filter(
            LifeProposedDocument::items($json),
            fn ($doc) => ($doc['key'] ?? '') !== LifeProposedDocument::KEY
        ));
    }

    public static function formatForExport(array $items): string
    {
        if ($items === []) {
            return '---';
        }

        return collect($items)->map(function ($doc) {
            $label = $doc['label'] ?? 'Document';
            $file = $doc['file'] ?? '';

            return trim($label . ': ' . $file);
        })->implode(' | ');
    }

    public static function isImage(?string $file): bool
    {
        $ext = strtolower(pathinfo((string) $file, PATHINFO_EXTENSION));

        return in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true);
    }

    private static function decode(mixed $json): array
    {
        if (is_array($json)) {
            return $json;
        }

        $raw = trim((string) $json);
        if ($raw === '') {
            return [];
        }

        $decoded = json_decode($raw, true);

        return is_array($decoded) ? $decoded : [];
    }
}

<?php

namespace App\Support;

class LifeProposedDocument
{
    public const KEY = 'life_proposed_document';

    public static function filename(mixed $otherDocumentsJson): ?string
    {
        foreach (self::items($otherDocumentsJson) as $doc) {
            if (($doc['key'] ?? '') === self::KEY) {
                $file = $doc['file'] ?? null;

                return $file ? (string) $file : null;
            }
        }

        return null;
    }

    public static function put(mixed $otherDocumentsJson, ?string $fileName): ?string
    {
        $docs = array_values(array_filter(
            self::items($otherDocumentsJson),
            fn ($doc) => ($doc['key'] ?? '') !== self::KEY
        ));

        if ($fileName) {
            array_unshift($docs, [
                'key' => self::KEY,
                'label' => 'Life Proposed CNIC / B-Form',
                'file' => $fileName,
            ]);
        }

        return $docs === [] ? null : json_encode($docs);
    }

    public static function items(mixed $otherDocumentsJson): array
    {
        if (is_array($otherDocumentsJson)) {
            return $otherDocumentsJson;
        }

        $raw = trim((string) $otherDocumentsJson);
        if ($raw === '') {
            return [];
        }

        $decoded = json_decode($raw, true);

        return is_array($decoded) ? $decoded : [];
    }
}

<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Stores policy document uploads one file at a time (ModSecurity-friendly),
 * then promotes them to the permanent public folder on final form save.
 */
class PolicyTempUpload
{
    public const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'pdf'];

    public const ALLOWED_MIMES = [
        'image/jpeg',
        'image/png',
        'application/pdf',
    ];

    public const MAX_BYTES = 4194304; // 4 MB

    private const TEMP_ROOT = 'policy-temp-uploads';

    private const PERMANENT_FOLDER = 'uploads/policy_documents';

    /**
     * @return array{token: string, original_name: string, field: string}
     */
    public static function store(UploadedFile $file, int $userId, string $field): array
    {
        self::assertValidUpload($file);

        $token = (string) Str::uuid();
        $extension = strtolower((string) $file->getClientOriginalExtension());
        $originalName = $file->getClientOriginalName();
        $mime = strtolower((string) $file->getMimeType());
        $size = (int) $file->getSize();
        $storedName = $token . '.' . $extension;

        $userDir = self::userDirectory($userId);
        if (!is_dir($userDir)) {
            mkdir($userDir, 0755, true);
        }

        $file->move($userDir, $storedName);

        return self::writeMeta($userDir, $token, $field, $originalName, $storedName, $mime, $size);
    }

    /**
     * Store from base64 payload (ModSecurity-friendly alternative to multipart).
     *
     * @return array{token: string, original_name: string, field: string}
     */
    public static function storeFromBase64(string $base64, string $originalName, int $userId, string $field): array
    {
        $binary = self::decodeBase64Payload($base64);
        $size = strlen($binary);
        if ($size <= 0) {
            throw new RuntimeException('Upload payload is empty.');
        }
        if ($size > self::MAX_BYTES) {
            throw new RuntimeException('File must not exceed 4MB.');
        }

        $extension = strtolower((string) pathinfo($originalName, PATHINFO_EXTENSION));
        if ($extension === '' || !in_array($extension, self::ALLOWED_EXTENSIONS, true)) {
            throw new RuntimeException('Only JPG, PNG, and PDF files are allowed.');
        }
        if (in_array($extension, ['php', 'phtml', 'phar', 'cgi', 'pl', 'py', 'sh', 'exe'], true)) {
            throw new RuntimeException('This file type is not allowed.');
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = strtolower((string) $finfo->buffer($binary));
        if (!in_array($mime, self::ALLOWED_MIMES, true)) {
            // Some hosts report jpeg as image/jpg
            if (!($mime === 'image/jpg' && in_array('image/jpeg', self::ALLOWED_MIMES, true))) {
                throw new RuntimeException('Only JPG, PNG, and PDF files are allowed.');
            }
            $mime = 'image/jpeg';
        }

        $token = (string) Str::uuid();
        $storedName = $token . '.' . $extension;
        $userDir = self::userDirectory($userId);
        if (!is_dir($userDir)) {
            mkdir($userDir, 0755, true);
        }

        $path = $userDir . DIRECTORY_SEPARATOR . $storedName;
        if (file_put_contents($path, $binary) === false) {
            throw new RuntimeException('Unable to store temporary upload.');
        }

        return self::writeMeta($userDir, $token, $field, $originalName, $storedName, $mime, $size);
    }

    /**
     * @return array{token: string, original_name: string, field: string}
     */
    private static function writeMeta(
        string $userDir,
        string $token,
        string $field,
        string $originalName,
        string $storedName,
        string $mime,
        int $size
    ): array {
        $meta = [
            'token' => $token,
            'field' => $field,
            'original_name' => $originalName,
            'stored_name' => $storedName,
            'mime' => $mime,
            'size' => $size,
            'created_at' => now()->toIso8601String(),
        ];

        file_put_contents(
            $userDir . DIRECTORY_SEPARATOR . $token . '.json',
            json_encode($meta, JSON_THROW_ON_ERROR)
        );

        return [
            'token' => $token,
            'original_name' => $meta['original_name'],
            'field' => $field,
        ];
    }

    private static function decodeBase64Payload(string $base64): string
    {
        $payload = trim($base64);
        if (str_contains($payload, ',')) {
            $payload = substr($payload, strpos($payload, ',') + 1);
        }
        $binary = base64_decode($payload, true);
        if ($binary === false) {
            throw new RuntimeException('Invalid upload encoding.');
        }

        return $binary;
    }

    /**
     * Move a temp upload into the permanent folder; returns the stored filename.
     */
    public static function promote(int $userId, string $token, string $expectedField): string
    {
        $meta = self::readMeta($userId, $token);

        if (($meta['field'] ?? '') !== $expectedField) {
            throw new RuntimeException('Upload token does not match the expected field.');
        }

        $userDir = self::userDirectory($userId);
        $storedName = (string) ($meta['stored_name'] ?? '');
        $source = $userDir . DIRECTORY_SEPARATOR . $storedName;

        if (!is_file($source)) {
            throw new RuntimeException('Temporary upload file is missing.');
        }

        $extension = pathinfo($storedName, PATHINFO_EXTENSION);
        $permanentName = uniqid('', true) . '_' . time() . '.' . $extension;
        $destDir = public_path(self::PERMANENT_FOLDER);

        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        $destination = $destDir . DIRECTORY_SEPARATOR . $permanentName;

        if (!@rename($source, $destination)) {
            if (!@copy($source, $destination)) {
                throw new RuntimeException('Unable to move uploaded file to permanent storage.');
            }
            @unlink($source);
        }

        self::deleteMeta($userId, $token);

        return $permanentName;
    }

    public static function discard(int $userId, string $token): void
    {
        $meta = self::readMeta($userId, $token);
        $userDir = self::userDirectory($userId);
        $stored = $userDir . DIRECTORY_SEPARATOR . (string) ($meta['stored_name'] ?? '');

        if (is_file($stored)) {
            @unlink($stored);
        }

        self::deleteMeta($userId, $token);
    }

    /**
     * @return array<string, mixed>
     */
    private static function readMeta(int $userId, string $token): array
    {
        if (!Str::isUuid($token)) {
            throw new RuntimeException('Invalid upload token.');
        }

        $metaPath = self::userDirectory($userId) . DIRECTORY_SEPARATOR . $token . '.json';

        if (!is_file($metaPath)) {
            throw new RuntimeException('Upload token not found or expired.');
        }

        $meta = json_decode((string) file_get_contents($metaPath), true);

        if (!is_array($meta)) {
            throw new RuntimeException('Upload metadata is corrupt.');
        }

        return $meta;
    }

    private static function deleteMeta(int $userId, string $token): void
    {
        $metaPath = self::userDirectory($userId) . DIRECTORY_SEPARATOR . $token . '.json';
        if (is_file($metaPath)) {
            @unlink($metaPath);
        }
    }

    private static function userDirectory(int $userId): string
    {
        return storage_path('app/' . self::TEMP_ROOT . '/' . $userId);
    }

    public static function assertValidUpload(UploadedFile $file): void
    {
        if (!$file->isValid()) {
            throw new RuntimeException($file->getErrorMessage() ?: 'Upload failed.');
        }

        if ($file->getSize() > self::MAX_BYTES) {
            throw new RuntimeException('File must not exceed 4MB.');
        }

        $extension = strtolower((string) $file->getClientOriginalExtension());
        $mime = strtolower((string) $file->getMimeType());

        if (
            !in_array($extension, self::ALLOWED_EXTENSIONS, true)
            || !in_array($mime, self::ALLOWED_MIMES, true)
        ) {
            throw new RuntimeException('Only JPG, PNG, and PDF files are allowed.');
        }

        if (in_array($extension, ['php', 'phtml', 'phar', 'cgi', 'pl', 'py', 'sh', 'exe'], true)) {
            throw new RuntimeException('This file type is not allowed.');
        }
    }

    /** Remove temp uploads older than 24 hours for the given user. */
    public static function purgeStaleForUser(int $userId): void
    {
        $dir = self::userDirectory($userId);
        if (!is_dir($dir)) {
            return;
        }

        $cutoff = now()->subDay()->getTimestamp();

        foreach (glob($dir . '/*.json') ?: [] as $metaFile) {
            $meta = json_decode((string) file_get_contents($metaFile), true);
            $created = isset($meta['created_at']) ? strtotime((string) $meta['created_at']) : false;
            if ($created !== false && $created < $cutoff) {
                $token = basename($metaFile, '.json');
                self::discard($userId, $token);
            }
        }
    }
}

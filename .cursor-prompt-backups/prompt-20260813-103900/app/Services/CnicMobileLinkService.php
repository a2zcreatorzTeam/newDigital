<?php

namespace App\Services;

use App\Exceptions\CnicMobileConflictException;
use App\Models\BasicDetail;
use App\Models\CnicMobileLink;
use App\Models\User;
use App\Models\UserPolicyData;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CnicMobileLinkService
{
    public const MESSAGE = CnicMobileConflictException::MESSAGE;

    /**
     * Normalize CNIC to dashed display format (42101-1234567-1).
     */
    public function normalizeCnic(?string $cnic): ?string
    {
        if ($cnic === null || trim($cnic) === '') {
            return null;
        }

        $digits = $this->digitsOnly($cnic);
        if (strlen($digits) !== 13) {
            return trim($cnic);
        }

        return substr($digits, 0, 5) . '-' . substr($digits, 5, 7) . '-' . substr($digits, 12, 1);
    }

    /**
     * Normalize mobile to dashed display format (0300-1234567).
     */
    public function normalizeMobile(?string $mobile): ?string
    {
        if ($mobile === null || trim($mobile) === '') {
            return null;
        }

        $digits = $this->digitsOnly($mobile);

        // Convert +92 / 92XXXXXXXXXX → 03XXXXXXXXX
        if (str_starts_with($digits, '92') && strlen($digits) === 12) {
            $digits = '0' . substr($digits, 2);
        }

        if (strlen($digits) === 11 && str_starts_with($digits, '03')) {
            return substr($digits, 0, 4) . '-' . substr($digits, 4);
        }

        return trim($mobile);
    }

    public function cnicDigits(?string $cnic): ?string
    {
        $digits = $this->digitsOnly((string) $cnic);

        return $digits !== '' ? $digits : null;
    }

    public function mobileDigits(?string $mobile): ?string
    {
        $normalized = $this->normalizeMobile($mobile);
        $digits = $this->digitsOnly((string) $normalized);

        if (str_starts_with($digits, '92') && strlen($digits) === 12) {
            $digits = '0' . substr($digits, 2);
        }

        return $digits !== '' ? $digits : null;
    }

    public function digitsOnly(string $value): string
    {
        return preg_replace('/\D+/', '', $value) ?? '';
    }

    /**
     * Returns true when the mobile may be linked to this CNIC.
     */
    public function canLink(?string $cnic, ?string $mobile): bool
    {
        $cnicDigits = $this->cnicDigits($cnic);
        $mobileDigits = $this->mobileDigits($mobile);

        if (!$cnicDigits || !$mobileDigits) {
            return true;
        }

        $existing = CnicMobileLink::query()
            ->where('mobile_digits', $mobileDigits)
            ->where('status', 'active')
            ->first();

        if (!$existing) {
            return true;
        }

        return $existing->cnic_digits === $cnicDigits;
    }

    /**
     * @throws CnicMobileConflictException
     */
    public function assertCanLink(?string $cnic, ?string $mobile): void
    {
        if (!$this->canLink($cnic, $mobile)) {
            throw new CnicMobileConflictException();
        }
    }

    /**
     * Create or refresh the CNIC↔mobile relationship.
     *
     * @throws CnicMobileConflictException
     */
    public function ensureLink(
        ?string $cnic,
        ?string $mobile,
        string $source = 'unknown',
        ?int $userId = null
    ): ?CnicMobileLink {
        $cnicFormatted = $this->normalizeCnic($cnic);
        $mobileFormatted = $this->normalizeMobile($mobile);
        $cnicDigits = $this->cnicDigits($cnicFormatted);
        $mobileDigits = $this->mobileDigits($mobileFormatted);

        if (!$cnicDigits || !$mobileDigits) {
            return null;
        }

        $actorId = $userId ?? Auth::id();

        try {
            return DB::transaction(function () use (
                $cnicFormatted,
                $mobileFormatted,
                $cnicDigits,
                $mobileDigits,
                $source,
                $userId,
                $actorId
            ) {
                $existing = CnicMobileLink::query()
                    ->where('mobile_digits', $mobileDigits)
                    ->lockForUpdate()
                    ->first();

                if ($existing) {
                    if ($existing->cnic_digits !== $cnicDigits) {
                        Log::warning('CNIC-mobile link conflict', [
                            'mobile_digits' => $mobileDigits,
                            'existing_cnic' => $existing->cnic_digits,
                            'attempted_cnic' => $cnicDigits,
                            'source' => $source,
                            'user_id' => $userId,
                        ]);
                        throw new CnicMobileConflictException();
                    }

                    $existing->fill([
                        'cnic' => $cnicFormatted,
                        'mobile_number' => $mobileFormatted,
                        'source' => $source,
                        'user_id' => $userId ?? $existing->user_id,
                        'status' => 'active',
                        'updated_by' => $actorId,
                    ]);
                    $existing->save();

                    return $existing;
                }

                return CnicMobileLink::create([
                    'cnic' => $cnicFormatted,
                    'cnic_digits' => $cnicDigits,
                    'mobile_number' => $mobileFormatted,
                    'mobile_digits' => $mobileDigits,
                    'source' => $source,
                    'user_id' => $userId,
                    'status' => 'active',
                    'created_by' => $actorId,
                    'updated_by' => $actorId,
                ]);
            });
        } catch (QueryException $e) {
            // Concurrent insert hit unique index on mobile_digits
            if ($this->isUniqueConstraintViolation($e)) {
                $existing = CnicMobileLink::query()
                    ->where('mobile_digits', $mobileDigits)
                    ->first();

                if ($existing && $existing->cnic_digits !== $cnicDigits) {
                    throw new CnicMobileConflictException();
                }

                if ($existing) {
                    return $existing;
                }
            }

            throw $e;
        }
    }

    /**
     * Sync historical pairs from users / basic details / policy data.
     * On conflict, keeps the earliest link and logs the skip.
     *
     * @return array{created:int,skipped:int,conflicts:int}
     */
    public function syncExistingData(): array
    {
        $stats = ['created' => 0, 'skipped' => 0, 'conflicts' => 0];

        User::query()
            ->whereNotNull('cnic')
            ->whereNotNull('phone_no')
            ->orderBy('id')
            ->chunkById(200, function ($users) use (&$stats) {
                foreach ($users as $user) {
                    $this->syncPair($user->cnic, $user->phone_no, 'users_sync', $user->id, $stats);
                }
            });

        BasicDetail::query()
            ->whereNotNull('cnic_number')
            ->whereNotNull('mobile_number')
            ->orderBy('id')
            ->chunkById(200, function ($rows) use (&$stats) {
                foreach ($rows as $row) {
                    $this->syncPair($row->cnic_number, $row->mobile_number, 'basic_details_sync', $row->user_id, $stats);
                }
            });

        UserPolicyData::query()
            ->whereNotNull('cnic_number')
            ->whereNotNull('mobile_number')
            ->orderBy('id')
            ->chunkById(200, function ($rows) use (&$stats) {
                foreach ($rows as $row) {
                    $this->syncPair($row->cnic_number, $row->mobile_number, 'policy_data_sync', $row->user_id, $stats);
                }
            });

        return $stats;
    }

    protected function syncPair(?string $cnic, ?string $mobile, string $source, ?int $userId, array &$stats): void
    {
        try {
            $before = CnicMobileLink::query()
                ->where('mobile_digits', $this->mobileDigits($mobile))
                ->exists();

            $link = $this->ensureLink($cnic, $mobile, $source, $userId);

            if (!$link) {
                $stats['skipped']++;
                return;
            }

            $stats[$before ? 'skipped' : 'created']++;
        } catch (CnicMobileConflictException $e) {
            $stats['conflicts']++;
            Log::warning('CNIC-mobile sync conflict skipped', [
                'cnic' => $cnic,
                'mobile' => $mobile,
                'source' => $source,
                'user_id' => $userId,
                'message' => $e->getMessage(),
            ]);
        }
    }

    protected function isUniqueConstraintViolation(QueryException $e): bool
    {
        $code = (string) ($e->errorInfo[1] ?? '');
        // MySQL duplicate = 1062, SQLite = 19 / SQLSTATE 23000
        return $code === '1062'
            || str_contains(strtolower($e->getMessage()), 'unique')
            || str_contains(strtolower($e->getMessage()), 'duplicate');
    }
}

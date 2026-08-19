<?php

namespace App\Support;

use Carbon\Carbon;
use DateTimeInterface;
use Throwable;

class AgeNearestBirthday
{
    /**
     * Age nearest birthday using a 6-month threshold after the last birthday.
     *
     * Completed years are kept when the remainder is under 6 months.
     * At 6 months 0 days or more, the year is increased by 1.
     */
    public static function calculate(null|string|DateTimeInterface $dateOfBirth, null|string|DateTimeInterface $asOf = null): ?int
    {
        if ($dateOfBirth === null || $dateOfBirth === '') {
            return null;
        }

        try {
            $dob = Carbon::parse($dateOfBirth)->startOfDay();
            $today = $asOf === null
                ? Carbon::now('Asia/Karachi')->startOfDay()
                : Carbon::parse($asOf)->startOfDay();
        } catch (Throwable) {
            return null;
        }

        if ($today->lt($dob)) {
            return 0;
        }

        $interval = $dob->diff($today);
        $age = (int) $interval->y;

        if ((int) $interval->m >= 6) {
            $age++;
        }

        return $age;
    }
}

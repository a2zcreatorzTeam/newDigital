<?php

namespace App\Support\Concerns;

use App\Support\AgeNearestBirthday;

trait PreparesAgeNearestBirthday
{
    protected function mergeAgeNearestBirthday(): void
    {
        if (!$this->filled('date_of_birth')) {
            return;
        }

        $age = AgeNearestBirthday::calculate($this->input('date_of_birth'));
        if ($age !== null) {
            $this->merge(['age_nearest_date' => $age]);
        }
    }
}

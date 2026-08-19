<?php

namespace App\Support\Concerns;

use App\Support\MiscarriageDates;

trait PreparesMiscarriageDates
{
    protected function mergeMiscarriageDates(): void
    {
        $this->merge([
            'miscarriage_dates' => MiscarriageDates::join($this->input('miscarriage_dates')),
        ]);
    }
}

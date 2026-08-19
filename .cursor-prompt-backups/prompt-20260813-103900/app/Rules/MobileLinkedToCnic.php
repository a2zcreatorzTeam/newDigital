<?php

namespace App\Rules;

use App\Services\CnicMobileLinkService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MobileLinkedToCnic implements ValidationRule
{
    public function __construct(
        protected string $cnicField = 'cnic_number'
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null || $value === '') {
            return;
        }

        $cnic = request()->input($this->cnicField);

        if ($cnic === null || $cnic === '') {
            return;
        }

        /** @var CnicMobileLinkService $service */
        $service = app(CnicMobileLinkService::class);

        if (!$service->canLink($cnic, (string) $value)) {
            $fail(CnicMobileLinkService::MESSAGE);
        }
    }
}

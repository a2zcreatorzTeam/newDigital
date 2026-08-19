<?php

namespace App\Observers;

use App\Exceptions\CnicMobileConflictException;
use App\Models\BasicDetail;
use App\Models\User;
use App\Models\UserPolicyData;
use App\Services\CnicMobileLinkService;
use Illuminate\Validation\ValidationException;

class CnicMobileLinkObserver
{
    public function __construct(protected CnicMobileLinkService $service) {}

    public function savingUser(User $user): void
    {
        $this->guardAndLink(
            $user->cnic,
            $user->phone_no,
            'users',
            $user->id
        );
    }

    public function savingBasicDetail(BasicDetail $detail): void
    {
        $this->guardAndLink(
            $detail->cnic_number,
            $detail->mobile_number,
            'basic_details',
            $detail->user_id
        );
    }

    public function savingPolicyData(UserPolicyData $policy): void
    {
        $this->guardAndLink(
            $policy->cnic_number,
            $policy->mobile_number,
            'policy_data',
            $policy->user_id
        );
    }

    protected function guardAndLink(?string $cnic, ?string $mobile, string $source, ?int $userId): void
    {
        if (!$cnic || !$mobile) {
            return;
        }

        try {
            $this->service->ensureLink($cnic, $mobile, $source, $userId);
        } catch (CnicMobileConflictException $e) {
            throw ValidationException::withMessages([
                'mobile_number' => [$e->getMessage()],
                'phone_no' => [$e->getMessage()],
            ]);
        }
    }
}

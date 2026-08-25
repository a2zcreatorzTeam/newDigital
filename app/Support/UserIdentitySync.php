<?php

namespace App\Support;

use App\Models\BasicDetail;
use App\Models\User;

/**
 * Keep signup identity on `users` and professional/policy profile on
 * `user_basic_details` aligned so users are not asked to re-enter the same data.
 */
class UserIdentitySync
{
    /**
     * Ensure a BasicDetail row exists and fill empty identity fields from User.
     * Never overwrites values the user already saved on the profile.
     */
    public static function seedBasicDetailFromUser(User $user): BasicDetail
    {
        $detail = BasicDetail::query()->firstOrNew(['user_id' => $user->id]);

        $map = [
            'life_proposed_full_name' => $user->name,
            'mobile_number' => $user->phone_no,
            'cnic_number' => $user->cnic,
            'email' => $user->email,
            'country_of_residence_id' => $user->country_of_residence_id,
            'current_address' => $user->current_address,
        ];

        $dirty = false;
        foreach ($map as $column => $value) {
            if ($value === null || $value === '') {
                continue;
            }

            $current = $detail->{$column} ?? null;
            if ($current === null || $current === '') {
                $detail->{$column} = $value;
                $dirty = true;
            }
        }

        if (!$detail->exists || $dirty) {
            $detail->user_id = $user->id;
            $detail->save();
        }

        return $detail;
    }

    /**
     * When professional profile identity fields change, mirror them onto `users`
     * so account and profile stay consistent across sessions.
     */
    public static function syncUserFromBasicDetail(User $user, array $data): void
    {
        $updates = [];

        if (!empty($data['life_proposed_full_name']) && $data['life_proposed_full_name'] !== $user->name) {
            $updates['name'] = $data['life_proposed_full_name'];
        }

        if (!empty($data['mobile_number']) && $data['mobile_number'] !== $user->phone_no) {
            $updates['phone_no'] = $data['mobile_number'];
        }

        if (!empty($data['cnic_number']) && $data['cnic_number'] !== $user->cnic) {
            $updates['cnic'] = $data['cnic_number'];
        }

        if (!empty($data['email']) && $data['email'] !== $user->email) {
            $emailTaken = User::query()
                ->where('email', $data['email'])
                ->where('id', '!=', $user->id)
                ->exists();

            if (!$emailTaken) {
                $updates['email'] = $data['email'];
            }
        }

        if (array_key_exists('country_of_residence_id', $data)
            && filled($data['country_of_residence_id'])
            && (string) $data['country_of_residence_id'] !== (string) $user->country_of_residence_id
        ) {
            $updates['country_of_residence_id'] = (int) $data['country_of_residence_id'];
        }

        if (array_key_exists('current_address', $data)
            && filled($data['current_address'])
            && $data['current_address'] !== $user->current_address
        ) {
            $updates['current_address'] = $data['current_address'];
        }

        if ($updates === []) {
            return;
        }

        $user->fill($updates);
        $user->save();
    }
}

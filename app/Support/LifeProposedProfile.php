<?php

namespace App\Support;

use App\Models\BasicDetail;
use App\Models\City;
use App\Models\LifeProposedDetail;
use App\Models\UserPolicyData;

class LifeProposedProfile
{
    public const COLUMN_KEYS = ['name', 'cnic', 'dob', 'relationship'];

    public const EXTRA_KEYS = [
        'mobile',
        'cnic_issue_date',
        'cnic_expiry_date',
        'age',
        'gender',
        'marital_status',
        'wife_name',
        'husband_name',
        'mother_maiden_name',
        'father_name',
        'religion',
        'email',
        'phone_office',
        'phone_residential',
        'country_of_residence_id',
        'country_of_residence',
        'current_address',
        'is_client_dual_national',
        'primary_nationality_country_id',
        'primary_nationality',
        'dual_nationality_country_id',
        'dual_nationality_country',
        'dual_tax_tin_number',
        'dual_mobile_number',
        'dual_address',
        'dual_passport_number',
        'birth_place_city_id',
        'birth_placed',
    ];

    public static function field(string $key): string
    {
        return 'life_proposed_' . $key;
    }

    public static function extraFieldNames(): array
    {
        return array_map(fn (string $key) => self::field($key), self::EXTRA_KEYS);
    }

    public static function values(?object $owner): array
    {
        $values = array_fill_keys(array_merge(self::COLUMN_KEYS, self::EXTRA_KEYS), null);
        if (!$owner) {
            return $values;
        }

        $values['name'] = $owner->life_proposed_name ?? null;
        $values['cnic'] = $owner->life_proposed_cnic ?? null;
        $values['dob'] = $owner->life_proposed_dob ?? null;
        $values['relationship'] = $owner->life_proposed_relationship ?? null;

        $payload = $owner->lifeProposedDetail->payload ?? [];
        if (is_string($payload)) {
            $payload = json_decode($payload, true) ?: [];
        }
        if (!is_array($payload)) {
            $payload = [];
        }

        foreach (self::EXTRA_KEYS as $key) {
            if (array_key_exists($key, $payload)) {
                $values[$key] = $payload[$key];
            }
        }

        return $values;
    }

    public static function pullFrom(array &$data): array
    {
        $extras = [];
        foreach (self::EXTRA_KEYS as $key) {
            $field = self::field($key);
            if (array_key_exists($field, $data)) {
                $extras[$key] = $data[$field];
                unset($data[$field]);
            }
        }

        if (!empty($extras['birth_place_city_id'])) {
            $city = City::query()->find($extras['birth_place_city_id']);
            if ($city) {
                $extras['birth_placed'] = $city->name;
            }
        }

        if (!empty($extras['country_of_residence_id'])) {
            $country = \App\Models\Country::query()->find($extras['country_of_residence_id']);
            if ($country) {
                $extras['country_of_residence'] = $country->name;
            }
        }

        return $extras;
    }

    public static function syncForPolicy(UserPolicyData $policy, string $isSamePerson, array $extras): void
    {
        self::sync($policy, $isSamePerson, $extras, 'policy');
    }

    public static function syncForProfile(BasicDetail $detail, string $isSamePerson, array $extras): void
    {
        self::sync($detail, $isSamePerson, $extras, 'profile');
    }

    protected static function sync(object $owner, string $isSamePerson, array $extras, string $type): void
    {
        $query = $type === 'policy'
            ? LifeProposedDetail::query()->where('policy_data_id', $owner->id)
            : LifeProposedDetail::query()->where('user_id', $owner->user_id)->whereNull('policy_data_id');

        if ($isSamePerson !== 'No') {
            $query->delete();

            return;
        }

        $row = $query->first() ?? new LifeProposedDetail();
        if ($type === 'policy') {
            $row->policy_data_id = $owner->id;
            $row->user_id = null;
        } else {
            $row->user_id = $owner->user_id;
            $row->policy_data_id = null;
        }
        $row->payload = $extras;
        $row->save();
    }
}

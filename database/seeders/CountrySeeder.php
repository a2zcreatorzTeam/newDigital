<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = require database_path('seeders/data/iso_countries.php');
        $now = now();

        foreach ($countries as $code => $name) {
            Country::query()->updateOrCreate(
                ['code' => strtoupper($code)],
                [
                    'name' => $name,
                    'status' => true,
                    'updated_at' => $now,
                ]
            );
        }

        $this->backfillCountryIds('user_basic_details', 'dual_nationality_country', 'dual_nationality_country_id', true);
        $this->backfillCountryIds('user_personal_policy_data', 'dual_nationality_country', 'dual_nationality_country_id', true);
        $this->backfillCountryIds('user_basic_details', 'primary_nationality', 'primary_nationality_country_id', false);
        $this->backfillCountryIds('user_personal_policy_data', 'primary_nationality', 'primary_nationality_country_id', false);
    }

    protected function backfillCountryIds(string $table, string $nameColumn, string $idColumn, bool $normalizeStoredName): void
    {
        if (!Schema::hasTable($table)
            || !Schema::hasColumn($table, $nameColumn)
            || !Schema::hasColumn($table, $idColumn)
        ) {
            return;
        }

        $countries = Country::query()->get(['id', 'name', 'code']);
        if ($countries->isEmpty()) {
            return;
        }

        $byName = [];
        $byCode = [];
        $namesById = [];
        foreach ($countries as $country) {
            $byName[$this->normalize($country->name)] = $country->id;
            $byCode[strtoupper($country->code)] = $country->id;
            $namesById[$country->id] = $country->name;
        }

        foreach ($this->aliases() as $alias => $code) {
            $code = strtoupper($code);
            if (isset($byCode[$code])) {
                $byName[$this->normalize($alias)] = $byCode[$code];
            }
        }

        DB::table($table)
            ->whereNotNull($nameColumn)
            ->where($nameColumn, '!=', '')
            ->whereNull($idColumn)
            ->orderBy('id')
            ->chunkById(200, function ($rows) use ($table, $nameColumn, $idColumn, $byName, $byCode, $namesById, $normalizeStoredName) {
                foreach ($rows as $row) {
                    $raw = trim((string) $row->{$nameColumn});
                    $key = $this->normalize($raw);
                    $id = $byName[$key] ?? $byCode[strtoupper($raw)] ?? null;
                    if (!$id) {
                        continue;
                    }

                    $payload = [$idColumn => $id];
                    if ($normalizeStoredName) {
                        $payload[$nameColumn] = $namesById[$id] ?? $raw;
                    }

                    DB::table($table)->where('id', $row->id)->update($payload);
                }
            });
    }

    protected function normalize(string $value): string
    {
        $value = str_replace(['’', '`'], "'", $value);

        return mb_strtolower(trim($value));
    }

    /**
     * Common stored names / abbreviations → ISO code.
     *
     * @return array<string, string>
     */
    protected function aliases(): array
    {
        return [
            'pakistani' => 'PK',
            'usa' => 'US',
            'u.s.a' => 'US',
            'u.s.a.' => 'US',
            'united states of america' => 'US',
            'america' => 'US',
            'uk' => 'GB',
            'u.k.' => 'GB',
            'great britain' => 'GB',
            'britain' => 'GB',
            'england' => 'GB',
            'uae' => 'AE',
            'u.a.e.' => 'AE',
            'korea' => 'KR',
            'south korea' => 'KR',
            'north korea' => 'KP',
            'russia' => 'RU',
            'vietnam' => 'VN',
            'czech republic' => 'CZ',
            'ivory coast' => 'CI',
            'palestine' => 'PS',
            'syria' => 'SY',
            'laos' => 'LA',
            'brunei' => 'BN',
            'bolivia, plurinational state of' => 'BO',
            'venezuela, bolivarian republic of' => 'VE',
            'iran, islamic republic of' => 'IR',
            'macedonia' => 'MK',
            'swaziland' => 'SZ',
            'holland' => 'NL',
            'turkey' => 'TR',
        ];
    }
}

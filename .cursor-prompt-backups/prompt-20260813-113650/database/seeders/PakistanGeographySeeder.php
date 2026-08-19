<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\District;
use App\Models\Provinces;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * Idempotent Pakistan geography seeder.
 *
 * Source: open-admin-data/pakistan-administrative-divisions
 * (compiled from Pakistan administrative units; CC-BY-4.0)
 *
 * IMPORTANT — this project's cascade is:
 *   Province → City (cities.province_id) → District (districts.city_id)
 *
 * Mapping from official admin hierarchy:
 *   Official Province  → provinces
 *   Official District  → cities
 *   Official Tehsil    → districts
 *
 * Existing rows are never deleted; duplicates are skipped via normalized name match.
 */
class PakistanGeographySeeder extends Seeder
{
    protected int $provincesInserted = 0;
    protected int $provincesSkipped = 0;
    protected int $citiesInserted = 0;
    protected int $citiesSkipped = 0;
    protected int $districtsInserted = 0;
    protected int $districtsSkipped = 0;
    protected int $citiesReassigned = 0;

    /** @var array<string, int> normalized province name => id */
    protected array $provinceMap = [];

    /** @var array<string, int> normalized city name => id */
    protected array $cityMap = [];

    /** Official province English name => canonical DB name */
    protected array $provinceCanonical = [
        'azad kashmir' => 'Azad Jammu & Kashmir',
        'balochistan' => 'Balochistan',
        'gilgit baltistan' => 'Gilgit-Baltistan',
        'islamabad' => 'Islamabad Capital Territory',
        'khyber pakhtunkhwa' => 'Khyber Pakhtunkhwa',
        'punjab' => 'Punjab',
        'sindh' => 'Sindh',
    ];

    /**
     * Alias keys (normalized) that should resolve to an existing/canonical province.
     * Value is the canonical target key used in $provinceCanonical / lookup.
     */
    protected array $provinceAliases = [
        'sindh' => 'sindh',
        'punjab' => 'punjab',
        'balochistan' => 'balochistan',
        'baluchistan' => 'balochistan',
        'khyber pakhtunkhwa' => 'khyber pakhtunkhwa',
        'kpk' => 'khyber pakhtunkhwa',
        'kp' => 'khyber pakhtunkhwa',
        'nwfp' => 'khyber pakhtunkhwa',
        'khyberpakhtunkhwa' => 'khyber pakhtunkhwa',
        'islamabad' => 'islamabad',
        'islamabad capital territory' => 'islamabad',
        'ict' => 'islamabad',
        'islamabad ict' => 'islamabad',
        'islamabad ict gilgit baltistan azad kashmir' => 'islamabad', // combined legacy bucket handled separately
        'azad kashmir' => 'azad kashmir',
        'azad jammu kashmir' => 'azad kashmir',
        'azad jammu and kashmir' => 'azad kashmir',
        'ajk' => 'azad kashmir',
        'gilgit baltistan' => 'gilgit baltistan',
        'gilgit-baltistan' => 'gilgit baltistan',
        'gb' => 'gilgit baltistan',
    ];

    /** Cities currently under the combined legacy province → target province key */
    protected array $legacyCityProvinceMap = [
        'islamabad' => 'islamabad',
        'gilgit' => 'gilgit baltistan',
        'skardu' => 'gilgit baltistan',
        'chilas' => 'gilgit baltistan',
        'hunza' => 'gilgit baltistan',
        'muzaffarabad' => 'azad kashmir',
        'mirpur' => 'azad kashmir',
        'rawalakot' => 'azad kashmir',
        'bagh' => 'azad kashmir',
        'kotli' => 'azad kashmir',
    ];

    public function run(): void
    {
        $provincePath = database_path('data/pk_provinces.json');
        $districtPath = database_path('data/pk_districts.json');
        $tehsilPath = database_path('data/pk_tehsils.json');

        foreach ([$provincePath, $districtPath, $tehsilPath] as $path) {
            if (!File::exists($path)) {
                throw new \RuntimeException("Missing geography data file: {$path}");
            }
        }

        $provincesJson = json_decode(File::get($provincePath), true, 512, JSON_THROW_ON_ERROR);
        $districtsJson = json_decode(File::get($districtPath), true, 512, JSON_THROW_ON_ERROR);
        $tehsilsJson = json_decode(File::get($tehsilPath), true, 512, JSON_THROW_ON_ERROR);

        DB::transaction(function () use ($provincesJson, $districtsJson, $tehsilsJson) {
            $this->seedProvinces($provincesJson);
            $this->reassignLegacyTerritoryCities();
            $this->seedCitiesFromDistricts($districtsJson);
            $this->seedDistrictsFromTehsils($tehsilsJson);
            $this->ensureFallbackDistricts();
        });

        $this->command?->info('Pakistan geography seeding complete.');
        $this->command?->table(
            ['Entity', 'Inserted', 'Skipped (existing)'],
            [
                ['Provinces', $this->provincesInserted, $this->provincesSkipped],
                ['Cities (official districts)', $this->citiesInserted, $this->citiesSkipped],
                ['Districts (official tehsils)', $this->districtsInserted, $this->districtsSkipped],
            ]
        );

        if ($this->citiesReassigned > 0) {
            $this->command?->info("Reassigned {$this->citiesReassigned} legacy territory city(ies) to proper provinces.");
        }

        $this->verifyIntegrity();
    }

    protected function seedProvinces(array $provincesJson): void
    {
        // Index existing provinces by normalized aliases
        foreach (Provinces::query()->get() as $existing) {
            $norm = $this->normalize($existing->name);
            $this->provinceMap[$norm] = (int) $existing->id;

            $aliasKey = $this->resolveProvinceAliasKey($existing->name);
            if ($aliasKey) {
                $this->provinceMap[$aliasKey] = (int) $existing->id;
                $canonical = $this->provinceCanonical[$aliasKey] ?? null;
                if ($canonical) {
                    $this->provinceMap[$this->normalize($canonical)] = (int) $existing->id;
                }
            }
        }

        foreach ($provincesJson as $row) {
            $sourceName = $row['name']['en'] ?? null;
            if (!$sourceName) {
                continue;
            }

            $aliasKey = $this->resolveProvinceAliasKey($sourceName);
            if (!$aliasKey) {
                $aliasKey = $this->normalize($sourceName);
            }

            $canonicalName = $this->provinceCanonical[$aliasKey] ?? $sourceName;

            // Prefer an already-mapped province (e.g. existing "KPK")
            if (isset($this->provinceMap[$aliasKey]) || isset($this->provinceMap[$this->normalize($canonicalName)])) {
                $id = $this->provinceMap[$aliasKey]
                    ?? $this->provinceMap[$this->normalize($canonicalName)];
                $this->provinceMap[$aliasKey] = $id;
                $this->provinceMap[$this->normalize($canonicalName)] = $id;
                $this->provinceMap[$this->normalize($sourceName)] = $id;
                $this->provincesSkipped++;
                continue;
            }

            // Case-insensitive match on any existing province name
            $existing = Provinces::query()
                ->get()
                ->first(function ($p) use ($aliasKey, $canonicalName, $sourceName) {
                    $n = $this->normalize($p->name);
                    return $n === $aliasKey
                        || $n === $this->normalize($canonicalName)
                        || $n === $this->normalize($sourceName)
                        || $this->resolveProvinceAliasKey($p->name) === $aliasKey;
                });

            if ($existing) {
                $this->provinceMap[$aliasKey] = (int) $existing->id;
                $this->provinceMap[$this->normalize($canonicalName)] = (int) $existing->id;
                $this->provinceMap[$this->normalize($existing->name)] = (int) $existing->id;
                $this->provincesSkipped++;
                continue;
            }

            $created = Provinces::query()->create(['name' => $canonicalName]);
            $this->provinceMap[$aliasKey] = (int) $created->id;
            $this->provinceMap[$this->normalize($canonicalName)] = (int) $created->id;
            $this->provincesInserted++;
        }

        // Ensure all canonical provinces exist even if JSON naming differs
        foreach ($this->provinceCanonical as $key => $canonicalName) {
            if (isset($this->provinceMap[$key])) {
                continue;
            }
            $existing = Provinces::query()
                ->get()
                ->first(fn ($p) => $this->resolveProvinceAliasKey($p->name) === $key
                    || $this->normalize($p->name) === $this->normalize($canonicalName));

            if ($existing) {
                $this->provinceMap[$key] = (int) $existing->id;
                $this->provincesSkipped++;
            } else {
                $created = Provinces::query()->create(['name' => $canonicalName]);
                $this->provinceMap[$key] = (int) $created->id;
                $this->provinceMap[$this->normalize($canonicalName)] = (int) $created->id;
                $this->provincesInserted++;
            }
        }
    }

    protected function reassignLegacyTerritoryCities(): void
    {
        $legacy = Provinces::query()
            ->get()
            ->first(function ($p) {
                $n = $this->normalize($p->name);
                return str_contains($n, 'gilgit') && str_contains($n, 'islamabad')
                    || str_contains($n, 'azad kashmir') && str_contains($n, 'islamabad');
            });

        if (!$legacy) {
            return;
        }

        $cities = City::query()->where('province_id', $legacy->id)->get();
        foreach ($cities as $city) {
            $key = $this->normalize($city->name);
            $targetKey = $this->legacyCityProvinceMap[$key] ?? null;
            if (!$targetKey || empty($this->provinceMap[$targetKey])) {
                continue;
            }
            $newProvinceId = $this->provinceMap[$targetKey];
            if ((int) $city->province_id === $newProvinceId) {
                continue;
            }
            $city->province_id = $newProvinceId;
            $city->save();
            $this->citiesReassigned++;
        }
    }

    protected function seedCitiesFromDistricts(array $districtsJson): void
    {
        // Build city map from existing
        foreach (City::query()->get() as $city) {
            $this->cityMap[$this->normalize($city->name)] = (int) $city->id;
        }

        foreach ($districtsJson as $row) {
            $cityName = $this->cleanPlaceName($row['name']['en'] ?? '');
            $parentProvinceName = $row['parent']['name']['en'] ?? '';
            if ($cityName === '' || $parentProvinceName === '') {
                continue;
            }

            $provinceId = $this->findProvinceId($parentProvinceName);
            if (!$provinceId) {
                $this->command?->warn("Skipping city '{$cityName}': province '{$parentProvinceName}' not found.");
                continue;
            }

            $norm = $this->normalize($cityName);
            if (isset($this->cityMap[$norm])) {
                // Ensure province association is correct when possible
                $city = City::query()->find($this->cityMap[$norm]);
                if ($city && (int) $city->province_id !== $provinceId) {
                    // Only reassign if current province is the legacy combined bucket
                    $currentProvince = Provinces::query()->find($city->province_id);
                    $currentNorm = $this->normalize($currentProvince->name ?? '');
                    if (
                        (str_contains($currentNorm, 'islamabad') && str_contains($currentNorm, 'gilgit'))
                        || (int) $city->province_id !== $provinceId
                    ) {
                        // Prefer official mapping for territory cities; for others keep existing to avoid FK surprise
                        if (isset($this->legacyCityProvinceMap[$norm]) || str_contains($currentNorm, 'gilgit')) {
                            $city->province_id = $provinceId;
                            $city->save();
                            $this->citiesReassigned++;
                        }
                    }
                }
                $this->citiesSkipped++;
                continue;
            }

            // Also try matching without trailing "district"
            $existing = City::query()
                ->get()
                ->first(fn ($c) => $this->normalize($c->name) === $norm);

            if ($existing) {
                $this->cityMap[$norm] = (int) $existing->id;
                $this->citiesSkipped++;
                continue;
            }

            $created = City::query()->create([
                'name' => $cityName,
                'province_id' => $provinceId,
            ]);
            $this->cityMap[$norm] = (int) $created->id;
            $this->citiesInserted++;
        }
    }

    protected function seedDistrictsFromTehsils(array $tehsilsJson): void
    {
        foreach ($tehsilsJson as $row) {
            $districtName = $this->cleanPlaceName($row['name']['en'] ?? '');
            $parentCityName = $this->cleanPlaceName($row['parent']['name']['en'] ?? '');
            if ($districtName === '' || $parentCityName === '') {
                continue;
            }

            $cityId = $this->cityMap[$this->normalize($parentCityName)] ?? null;
            if (!$cityId) {
                // Try fuzzy: parent may include "District"
                $cityId = $this->findCityIdByName($parentCityName);
            }
            if (!$cityId) {
                continue;
            }

            $norm = $this->normalize($districtName);
            $exists = District::query()
                ->where('city_id', $cityId)
                ->get()
                ->first(fn ($d) => $this->normalize($d->name) === $norm);

            if ($exists) {
                $this->districtsSkipped++;
                continue;
            }

            District::query()->create([
                'name' => $districtName,
                'city_id' => $cityId,
            ]);
            $this->districtsInserted++;
        }
    }

    /**
     * Every city needs at least one district so dependent dropdowns work.
     */
    protected function ensureFallbackDistricts(): void
    {
        $cities = City::query()->get();
        foreach ($cities as $city) {
            $hasDistrict = District::query()->where('city_id', $city->id)->exists();
            if ($hasDistrict) {
                continue;
            }

            District::query()->create([
                'name' => $city->name,
                'city_id' => $city->id,
            ]);
            $this->districtsInserted++;
        }
    }

    protected function findProvinceId(string $name): ?int
    {
        $aliasKey = $this->resolveProvinceAliasKey($name);
        if ($aliasKey && isset($this->provinceMap[$aliasKey])) {
            return $this->provinceMap[$aliasKey];
        }

        $norm = $this->normalize($name);
        if (isset($this->provinceMap[$norm])) {
            return $this->provinceMap[$norm];
        }

        $canonical = $aliasKey ? ($this->provinceCanonical[$aliasKey] ?? null) : null;
        if ($canonical && isset($this->provinceMap[$this->normalize($canonical)])) {
            return $this->provinceMap[$this->normalize($canonical)];
        }

        return null;
    }

    protected function findCityIdByName(string $name): ?int
    {
        $norm = $this->normalize($name);
        if (isset($this->cityMap[$norm])) {
            return $this->cityMap[$norm];
        }

        foreach ($this->cityMap as $cityNorm => $id) {
            if ($cityNorm === $norm || str_contains($cityNorm, $norm) || str_contains($norm, $cityNorm)) {
                return $id;
            }
        }

        return null;
    }

    protected function resolveProvinceAliasKey(string $name): ?string
    {
        $norm = $this->normalize($name);

        // Combined legacy province name
        if (
            str_contains($norm, 'islamabad')
            && (str_contains($norm, 'gilgit') || str_contains($norm, 'azad'))
        ) {
            return null;
        }

        if (isset($this->provinceAliases[$norm])) {
            return $this->provinceAliases[$norm];
        }

        foreach ($this->provinceAliases as $alias => $key) {
            if ($norm === $alias || str_contains($norm, $alias)) {
                return $key;
            }
        }

        return null;
    }

    protected function cleanPlaceName(string $name): string
    {
        $name = trim($name);
        $name = preg_replace('/\s+/', ' ', $name) ?? $name;
        // Strip leading "District " / trailing " District"
        $name = preg_replace('/^\s*district\s+/i', '', $name) ?? $name;
        $name = preg_replace('/\s+district\s*$/i', '', $name) ?? $name;
        $name = preg_replace('/^\s*tehsil\s+/i', '', $name) ?? $name;
        $name = preg_replace('/\s+tehsil\s*$/i', '', $name) ?? $name;

        return trim($name);
    }

    protected function normalize(?string $value): string
    {
        $value = strtolower(trim((string) $value));
        $value = str_replace(['&', '/', '-', '_', '.', ',', '(', ')'], ' ', $value);
        $value = preg_replace('/\s+/', ' ', $value) ?? $value;

        return trim($value);
    }

    protected function verifyIntegrity(): void
    {
        $orphanCities = DB::table('cities')
            ->leftJoin('provinces', 'cities.province_id', '=', 'provinces.id')
            ->whereNull('provinces.id')
            ->count();

        $orphanDistricts = DB::table('districts')
            ->leftJoin('cities', 'districts.city_id', '=', 'cities.id')
            ->whereNull('cities.id')
            ->count();

        $dupProvinces = DB::table('provinces')
            ->select(DB::raw('LOWER(TRIM(name)) as n'), DB::raw('COUNT(*) as c'))
            ->groupBy('n')
            ->having('c', '>', 1)
            ->count();

        $dupCities = DB::table('cities')
            ->select(DB::raw('LOWER(TRIM(name)) as n'), DB::raw('COUNT(*) as c'))
            ->groupBy('n')
            ->having('c', '>', 1)
            ->count();

        $dupDistricts = DB::table('districts')
            ->select('city_id', DB::raw('LOWER(TRIM(name)) as n'), DB::raw('COUNT(*) as c'))
            ->groupBy('city_id', 'n')
            ->having('c', '>', 1)
            ->count();

        $this->command?->info('Verification:');
        $this->command?->line('  Total provinces: ' . Provinces::count());
        $this->command?->line('  Total cities: ' . City::count());
        $this->command?->line('  Total districts: ' . District::count());
        $this->command?->line("  Orphan cities: {$orphanCities}");
        $this->command?->line("  Orphan districts: {$orphanDistricts}");
        $this->command?->line("  Duplicate province names: {$dupProvinces}");
        $this->command?->line("  Duplicate city names: {$dupCities}");
        $this->command?->line("  Duplicate district names (per city): {$dupDistricts}");
    }
}

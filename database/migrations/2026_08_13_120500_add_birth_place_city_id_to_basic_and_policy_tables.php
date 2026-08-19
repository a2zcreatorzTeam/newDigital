<?php

use App\Models\City;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('user_basic_details') && !Schema::hasColumn('user_basic_details', 'birth_place_city_id')) {
            Schema::table('user_basic_details', function (Blueprint $table) {
                $table->unsignedBigInteger('birth_place_city_id')->nullable()->after('birth_placed');
                $table->index('birth_place_city_id');
            });
        }

        if (Schema::hasTable('user_personal_policy_data') && !Schema::hasColumn('user_personal_policy_data', 'birth_place_city_id')) {
            Schema::table('user_personal_policy_data', function (Blueprint $table) {
                $table->unsignedBigInteger('birth_place_city_id')->nullable()->after('birth_placed');
                $table->index('birth_place_city_id');
            });
        }

        $this->backfillCityIds('user_basic_details');
        $this->backfillCityIds('user_personal_policy_data');
    }

    public function down(): void
    {
        if (Schema::hasTable('user_basic_details') && Schema::hasColumn('user_basic_details', 'birth_place_city_id')) {
            Schema::table('user_basic_details', function (Blueprint $table) {
                $table->dropIndex(['birth_place_city_id']);
                $table->dropColumn('birth_place_city_id');
            });
        }

        if (Schema::hasTable('user_personal_policy_data') && Schema::hasColumn('user_personal_policy_data', 'birth_place_city_id')) {
            Schema::table('user_personal_policy_data', function (Blueprint $table) {
                $table->dropIndex(['birth_place_city_id']);
                $table->dropColumn('birth_place_city_id');
            });
        }
    }

    protected function backfillCityIds(string $table): void
    {
        if (!Schema::hasTable($table) || !Schema::hasColumn($table, 'birth_place_city_id')) {
            return;
        }

        $cities = City::query()->get(['id', 'name']);
        if ($cities->isEmpty()) {
            return;
        }

        $byName = [];
        foreach ($cities as $city) {
            $byName[mb_strtolower(trim($city->name))] = $city->id;
        }

        DB::table($table)
            ->whereNotNull('birth_placed')
            ->where('birth_placed', '!=', '')
            ->whereNull('birth_place_city_id')
            ->orderBy('id')
            ->chunkById(200, function ($rows) use ($table, $byName) {
                foreach ($rows as $row) {
                    $key = mb_strtolower(trim((string) $row->birth_placed));
                    if (!isset($byName[$key])) {
                        continue;
                    }
                    DB::table($table)->where('id', $row->id)->update([
                        'birth_place_city_id' => $byName[$key],
                    ]);
                }
            });
    }
};

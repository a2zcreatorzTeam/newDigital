<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_occupation', function (Blueprint $table) {
            if (!Schema::hasColumn('user_occupation', 'land_unit')) {
                $table->string('land_unit', 30)->nullable()->after('total_acreage');
            }
        });

        Schema::table('user_personal_policy_data', function (Blueprint $table) {
            if (!Schema::hasColumn('user_personal_policy_data', 'land_unit')) {
                $table->string('land_unit', 30)->nullable()->after('total_acreage');
            }
        });
    }

    public function down(): void
    {
        Schema::table('user_occupation', function (Blueprint $table) {
            if (Schema::hasColumn('user_occupation', 'land_unit')) {
                $table->dropColumn('land_unit');
            }
        });

        Schema::table('user_personal_policy_data', function (Blueprint $table) {
            if (Schema::hasColumn('user_personal_policy_data', 'land_unit')) {
                $table->dropColumn('land_unit');
            }
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->addPrimaryCountryIdColumn('user_basic_details');
        $this->addPrimaryCountryIdColumn('user_personal_policy_data');
    }

    public function down(): void
    {
        $this->dropPrimaryCountryIdColumn('user_basic_details');
        $this->dropPrimaryCountryIdColumn('user_personal_policy_data');
    }

    protected function addPrimaryCountryIdColumn(string $tableName): void
    {
        if (!Schema::hasTable($tableName) || Schema::hasColumn($tableName, 'primary_nationality_country_id')) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            $column = $table->unsignedBigInteger('primary_nationality_country_id')->nullable();
            if (Schema::hasColumn($tableName, 'primary_nationality')) {
                $column->after('primary_nationality');
            }
            $table->index('primary_nationality_country_id');
        });
    }

    protected function dropPrimaryCountryIdColumn(string $tableName): void
    {
        if (!Schema::hasTable($tableName) || !Schema::hasColumn($tableName, 'primary_nationality_country_id')) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) {
            $table->dropIndex(['primary_nationality_country_id']);
            $table->dropColumn('primary_nationality_country_id');
        });
    }
};

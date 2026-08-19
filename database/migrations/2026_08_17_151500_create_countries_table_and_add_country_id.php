<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('countries')) {
            Schema::create('countries', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->char('code', 2);
                $table->boolean('status')->default(true);
                $table->timestamps();

                $table->unique('code');
                $table->index('name');
                $table->index('status');
            });
        }

        $this->addCountryIdColumn('user_basic_details');
        $this->addCountryIdColumn('user_personal_policy_data');
    }

    public function down(): void
    {
        $this->dropCountryIdColumn('user_basic_details');
        $this->dropCountryIdColumn('user_personal_policy_data');

        Schema::dropIfExists('countries');
    }

    protected function addCountryIdColumn(string $tableName): void
    {
        if (!Schema::hasTable($tableName)) {
            return;
        }

        if (!Schema::hasColumn($tableName, 'dual_nationality_country')) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('dual_nationality_country')->nullable();
            });
        }

        if (Schema::hasColumn($tableName, 'dual_nationality_country_id')) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            $column = $table->unsignedBigInteger('dual_nationality_country_id')->nullable();
            if (Schema::hasColumn($tableName, 'dual_nationality_country')) {
                $column->after('dual_nationality_country');
            }
            $table->index('dual_nationality_country_id');
        });
    }

    protected function dropCountryIdColumn(string $tableName): void
    {
        if (!Schema::hasTable($tableName) || !Schema::hasColumn($tableName, 'dual_nationality_country_id')) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) {
            $table->dropIndex(['dual_nationality_country_id']);
            $table->dropColumn('dual_nationality_country_id');
        });
    }
};

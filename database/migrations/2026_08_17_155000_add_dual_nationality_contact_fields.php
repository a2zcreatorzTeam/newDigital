<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->addDualContactColumns('user_basic_details');
        $this->addDualContactColumns('user_personal_policy_data');
    }

    public function down(): void
    {
        $this->dropDualContactColumns('user_basic_details');
        $this->dropDualContactColumns('user_personal_policy_data');
    }

    protected function addDualContactColumns(string $tableName): void
    {
        if (!Schema::hasTable($tableName)) {
            return;
        }

        if (!Schema::hasColumn($tableName, 'dual_tax_tin_number')) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $column = $table->string('dual_tax_tin_number', 50)->nullable();
                if (Schema::hasColumn($tableName, 'dual_passport_number')) {
                    $column->after('dual_passport_number');
                }
            });
        }

        if (!Schema::hasColumn($tableName, 'dual_mobile_number')) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $column = $table->string('dual_mobile_number', 30)->nullable();
                if (Schema::hasColumn($tableName, 'dual_tax_tin_number')) {
                    $column->after('dual_tax_tin_number');
                }
            });
        }

        if (!Schema::hasColumn($tableName, 'dual_address')) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $column = $table->text('dual_address')->nullable();
                if (Schema::hasColumn($tableName, 'dual_mobile_number')) {
                    $column->after('dual_mobile_number');
                }
            });
        }
    }

    protected function dropDualContactColumns(string $tableName): void
    {
        if (!Schema::hasTable($tableName)) {
            return;
        }

        $columns = array_values(array_filter([
            Schema::hasColumn($tableName, 'dual_tax_tin_number') ? 'dual_tax_tin_number' : null,
            Schema::hasColumn($tableName, 'dual_mobile_number') ? 'dual_mobile_number' : null,
            Schema::hasColumn($tableName, 'dual_address') ? 'dual_address' : null,
        ]));

        if ($columns === []) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) use ($columns) {
            $table->dropColumn($columns);
        });
    }
};

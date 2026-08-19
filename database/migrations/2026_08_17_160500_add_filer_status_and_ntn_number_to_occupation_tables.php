<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->addFilerColumns('user_occupation');
        $this->addFilerColumns('user_personal_policy_data');
    }

    public function down(): void
    {
        $this->dropFilerColumns('user_occupation');
        $this->dropFilerColumns('user_personal_policy_data');
    }

    protected function addFilerColumns(string $tableName): void
    {
        if (!Schema::hasTable($tableName)) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            if (!Schema::hasColumn($tableName, 'filer_status')) {
                $column = $table->string('filer_status', 20)->nullable();
                if (Schema::hasColumn($tableName, 'nature_of_business')) {
                    $column->after('nature_of_business');
                }
            }
        });

        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            if (!Schema::hasColumn($tableName, 'ntn_number')) {
                // user_personal_policy_data is at MySQL InnoDB row-size limit; TEXT avoids varchar row overhead.
                $column = $tableName === 'user_personal_policy_data'
                    ? $table->text('ntn_number')->nullable()
                    : $table->string('ntn_number', 20)->nullable();

                if (Schema::hasColumn($tableName, 'filer_status')) {
                    $column->after('filer_status');
                }
            }
        });
    }

    protected function dropFilerColumns(string $tableName): void
    {
        if (!Schema::hasTable($tableName)) {
            return;
        }

        $columns = array_values(array_filter([
            Schema::hasColumn($tableName, 'ntn_number') ? 'ntn_number' : null,
            Schema::hasColumn($tableName, 'filer_status') ? 'filer_status' : null,
        ]));

        if ($columns === []) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) use ($columns) {
            $table->dropColumn($columns);
        });
    }
};

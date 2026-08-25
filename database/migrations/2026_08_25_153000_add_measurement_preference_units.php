<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $columns = [
            'height_unit',
            'weight_unit',
            'chest_insp_unit',
            'chest_exp_unit',
            'abdomen_unit',
            'weight_change_unit',
        ];

        foreach (['user_health', 'user_personal_policy_data'] as $tableName) {
            if (!Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName, $columns) {
                foreach ($columns as $name) {
                    if (!Schema::hasColumn($tableName, $name)) {
                        $table->string($name, 10)->nullable();
                    }
                }
            });
        }
    }

    public function down(): void
    {
        $columns = [
            'height_unit',
            'weight_unit',
            'chest_insp_unit',
            'chest_exp_unit',
            'abdomen_unit',
            'weight_change_unit',
        ];

        foreach (['user_health', 'user_personal_policy_data'] as $tableName) {
            if (!Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName, $columns) {
                $drop = [];
                foreach ($columns as $name) {
                    if (Schema::hasColumn($tableName, $name)) {
                        $drop[] = $name;
                    }
                }
                if ($drop !== []) {
                    $table->dropColumn($drop);
                }
            });
        }
    }
};

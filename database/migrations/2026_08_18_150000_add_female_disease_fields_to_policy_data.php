<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('user_personal_policy_data')) {
            return;
        }

        if (Schema::hasColumn('user_personal_policy_data', 'female_disease_name')) {
            return;
        }

        Schema::table('user_personal_policy_data', function (Blueprint $table) {
            // TEXT avoids MySQL InnoDB row-size limit on this table.
            // Name + description are packed as JSON in this single column.
            $column = $table->text('female_disease_name')->nullable();
            if (Schema::hasColumn('user_personal_policy_data', 'female_disease_history')) {
                $column->after('female_disease_history');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('user_personal_policy_data')) {
            return;
        }

        if (!Schema::hasColumn('user_personal_policy_data', 'female_disease_name')) {
            return;
        }

        Schema::table('user_personal_policy_data', function (Blueprint $table) {
            $table->dropColumn('female_disease_name');
        });
    }
};

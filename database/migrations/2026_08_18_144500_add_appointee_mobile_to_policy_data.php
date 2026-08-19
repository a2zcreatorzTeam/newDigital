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

        if (Schema::hasColumn('user_personal_policy_data', 'appointee_mobile')) {
            return;
        }

        Schema::table('user_personal_policy_data', function (Blueprint $table) {
            // TEXT avoids MySQL InnoDB row-size limit on this table.
            $column = $table->text('appointee_mobile')->nullable();
            if (Schema::hasColumn('user_personal_policy_data', 'appointee_cnic')) {
                $column->after('appointee_cnic');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('user_personal_policy_data')) {
            return;
        }

        if (!Schema::hasColumn('user_personal_policy_data', 'appointee_mobile')) {
            return;
        }

        Schema::table('user_personal_policy_data', function (Blueprint $table) {
            $table->dropColumn('appointee_mobile');
        });
    }
};

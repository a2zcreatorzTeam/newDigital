<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_basic_details', function (Blueprint $table) {
            if (!Schema::hasColumn('user_basic_details', 'marital_status')) {
                $table->string('marital_status', 20)->nullable()->after('gender');
            }
            if (!Schema::hasColumn('user_basic_details', 'wife_name')) {
                $table->string('wife_name', 150)->nullable()->after('husband_name');
            }
        });

        Schema::table('user_personal_policy_data', function (Blueprint $table) {
            if (!Schema::hasColumn('user_personal_policy_data', 'marital_status')) {
                $table->string('marital_status', 20)->nullable()->after('gender');
            }
            if (!Schema::hasColumn('user_personal_policy_data', 'wife_name')) {
                // TEXT avoids MySQL row-size limit on this wide table
                $table->text('wife_name')->nullable()->after('husband_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('user_basic_details', function (Blueprint $table) {
            if (Schema::hasColumn('user_basic_details', 'marital_status')) {
                $table->dropColumn('marital_status');
            }
            if (Schema::hasColumn('user_basic_details', 'wife_name')) {
                $table->dropColumn('wife_name');
            }
        });

        Schema::table('user_personal_policy_data', function (Blueprint $table) {
            if (Schema::hasColumn('user_personal_policy_data', 'marital_status')) {
                $table->dropColumn('marital_status');
            }
            if (Schema::hasColumn('user_personal_policy_data', 'wife_name')) {
                $table->dropColumn('wife_name');
            }
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_personal_policy_data', function (Blueprint $table) {
            $table->string('dual_nationality_country')->nullable()->after('dual_nationality');
            $table->string('dual_passport_number')->nullable()->after('dual_nationality_country');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_personal_policy_data', function (Blueprint $table) {
            $table->dropColumn([
                'dual_nationality_country',
                'dual_passport_number'
            ]);
        });
    }
};

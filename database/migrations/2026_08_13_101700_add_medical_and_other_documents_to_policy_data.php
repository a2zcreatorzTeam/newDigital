<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_personal_policy_data', function (Blueprint $table) {
            if (!Schema::hasColumn('user_personal_policy_data', 'medical_documents')) {
                $table->longText('medical_documents')->nullable()->after('medical_reports');
            }
            if (!Schema::hasColumn('user_personal_policy_data', 'other_documents')) {
                $table->longText('other_documents')->nullable()->after('medical_documents');
            }
        });
    }

    public function down(): void
    {
        Schema::table('user_personal_policy_data', function (Blueprint $table) {
            if (Schema::hasColumn('user_personal_policy_data', 'medical_documents')) {
                $table->dropColumn('medical_documents');
            }
            if (Schema::hasColumn('user_personal_policy_data', 'other_documents')) {
                $table->dropColumn('other_documents');
            }
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->addIdentityColumns('users');
        $this->addIdentityColumns('user_basic_details');
        $this->shrinkPolicyVarchars();
        $this->addPolicyColumns();
    }

    public function down(): void
    {
        $this->dropIdentityColumns('users');
        $this->dropIdentityColumns('user_basic_details');
        $this->dropPolicyColumns();
    }

    protected function addIdentityColumns(string $tableName): void
    {
        if (!Schema::hasTable($tableName)) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            if (!Schema::hasColumn($tableName, 'country_of_residence_id')) {
                $table->unsignedBigInteger('country_of_residence_id')->nullable();
                $table->index('country_of_residence_id');
            }

            if (!Schema::hasColumn($tableName, 'current_address')) {
                $table->text('current_address')->nullable();
            }
        });
    }

    protected function shrinkPolicyVarchars(): void
    {
        $tableName = 'user_personal_policy_data';
        if (!Schema::hasTable($tableName)) {
            return;
        }

        // Free InnoDB row budget so new columns can be added on this wide table.
        $shrink = [
            'cnic_issue_date' => 'varchar(40) null',
            'cnic_expiry_date' => 'varchar(40) null',
            'date_of_birth' => 'varchar(40) null',
            'age_nearest_date' => 'varchar(20) null',
            'gender' => 'varchar(20) null',
            'is_client_dual_national' => 'varchar(10) null',
            'is_same_person' => 'varchar(10) null',
            'payment_mode' => 'varchar(50) null',
            'table_no' => 'varchar(50) null',
            'term' => 'varchar(50) null',
            'height_cm' => 'varchar(20) null',
            'height_ft' => 'varchar(20) null',
            'weight_kg' => 'varchar(20) null',
            'chest_insp_cm' => 'varchar(20) null',
            'chest_insp_inches' => 'varchar(20) null',
            'chest_exp_cm' => 'varchar(20) null',
            'chest_exp_inches' => 'varchar(20) null',
            'abdomen_cm' => 'varchar(20) null',
            'abdomen_inches' => 'varchar(20) null',
            'weight_loss_kg' => 'varchar(20) null',
            'weight_gain_kg' => 'varchar(20) null',
            'adb_rider' => 'varchar(50) null',
            'tir_rider' => 'varchar(50) null',
            'fib_rider' => 'varchar(50) null',
            'aib_rider' => 'varchar(50) null',
            'nominee_age' => 'varchar(20) null',
            'life_proposed_dob' => 'varchar(40) null',
        ];

        foreach ($shrink as $column => $definition) {
            if (!Schema::hasColumn($tableName, $column)) {
                continue;
            }
            try {
                DB::statement("ALTER TABLE `{$tableName}` MODIFY `{$column}` {$definition}");
            } catch (\Throwable $e) {
                // Keep going; best-effort space recovery.
            }
        }
    }

    protected function addPolicyColumns(): void
    {
        $tableName = 'user_personal_policy_data';
        if (!Schema::hasTable($tableName)) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            if (!Schema::hasColumn($tableName, 'country_of_residence_id')) {
                $table->unsignedBigInteger('country_of_residence_id')->nullable();
            }

            if (!Schema::hasColumn($tableName, 'current_address')) {
                $table->text('current_address')->nullable();
            }
        });
    }

    protected function dropIdentityColumns(string $tableName): void
    {
        if (!Schema::hasTable($tableName)) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            if (Schema::hasColumn($tableName, 'country_of_residence_id')) {
                try {
                    $table->dropIndex(['country_of_residence_id']);
                } catch (\Throwable $e) {
                }
                $table->dropColumn('country_of_residence_id');
            }
            if (Schema::hasColumn($tableName, 'current_address')) {
                $table->dropColumn('current_address');
            }
        });
    }

    protected function dropPolicyColumns(): void
    {
        $tableName = 'user_personal_policy_data';
        if (!Schema::hasTable($tableName)) {
            return;
        }

        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            if (Schema::hasColumn($tableName, 'country_of_residence_id')) {
                $table->dropColumn('country_of_residence_id');
            }
            if (Schema::hasColumn($tableName, 'current_address')) {
                $table->dropColumn('current_address');
            }
        });
    }
};

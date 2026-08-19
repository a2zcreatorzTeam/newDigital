<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cnic_mobile_links', function (Blueprint $table) {
            $table->id();
            $table->string('cnic', 20);
            $table->string('cnic_digits', 13)->index();
            $table->string('mobile_number', 20);
            $table->string('mobile_digits', 15)->unique();
            $table->string('source', 100)->nullable()->comment('signup, basic_details, policy_form, etc.');
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('status', 20)->default('active')->index();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->index(['cnic_digits', 'mobile_digits']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cnic_mobile_links');
    }
};

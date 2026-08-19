<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('policy_form_drafts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedBigInteger('product_id');
            $table->string('product_name')->nullable();
            $table->string('last_tab')->nullable();
            $table->string('progress_label')->nullable();
            $table->unsignedTinyInteger('filled_sections')->default(0);
            $table->json('form_payload');
            $table->timestamps();

            $table->index(['user_id', 'updated_at']);
            $table->index(['user_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('policy_form_drafts');
    }
};

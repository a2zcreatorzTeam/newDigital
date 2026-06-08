<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('consumer_number', 18)->unique(); // Kuickpay inquiry number [cite: 23, 105]
            $table->string('customer_name', 50);
            $table->decimal('amount_within_due_date', 10, 2);
            $table->decimal('amount_after_due_date', 10, 2);
            $table->date('due_date');
            $table->string('billing_month', 4); // Format: yyMM (e.g., 2606) [cite: 95]
            $table->string('email', 50)->nullable();
            $table->string('contact_number', 15)->nullable();
            $table->enum('status', ['U', 'P', 'B'])->default('U'); // U=Unpaid, P=Paid, B=Blocked [cite: 85]
            
            // Payment details (Kuickpay fills these on successful payment)
            $table->string('tran_auth_id', 20)->nullable(); // [cite: 95, 105]
            $table->dateTime('date_paid')->nullable();
            $table->string('bank_mnemonic', 10)->nullable(); // [cite: 23, 105]
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
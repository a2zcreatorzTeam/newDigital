<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Filename is stored inside existing other_documents JSON.
        // A dedicated column cannot be added: this table is at MySQL's InnoDB row-size limit.
    }

    public function down(): void
    {
        //
    }
};

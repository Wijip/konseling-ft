<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE counseling_sessions MODIFY COLUMN status ENUM('pending', 'in_progress', 'completed', 'rejected') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE counseling_sessions MODIFY COLUMN status ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending'");
    }
};
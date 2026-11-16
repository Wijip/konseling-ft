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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'phone_number')) {
                $table->string('phone_number')->nullable()->unique()->after('email');
            }
        });

        Schema::table('password_reset_tokens', function (Blueprint $table) {
            if (!Schema::hasColumn('password_reset_tokens', 'phone_number')) {
                $table->string('phone_number')->nullable()->index()->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'phone_number')) {
                $table->dropColumn('phone_number');
            }
        });

        Schema::table('password_reset_tokens', function (Blueprint $table) {
            if (Schema::hasColumn('password_reset_tokens', 'phone_number')) {
                $table->dropColumn('phone_number');
            }
        });
    }
};

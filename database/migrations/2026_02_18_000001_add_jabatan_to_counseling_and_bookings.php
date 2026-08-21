<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('counseling_sessions', function (Blueprint $table) {
            $table->string('jabatan')->nullable()->after('division');
        });

        Schema::table('meeting_bookings', function (Blueprint $table) {
            $table->string('jabatan')->nullable()->after('division');
        });
    }

    public function down(): void
    {
        Schema::table('counseling_sessions', function (Blueprint $table) {
            $table->dropColumn('jabatan');
        });

        Schema::table('meeting_bookings', function (Blueprint $table) {
            $table->dropColumn('jabatan');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('meeting_schedules', function (Blueprint $table) {
            $table->dropForeign(['konselor_id']);
            $table->dropColumn('konselor_id');
            $table->string('konselor_name')->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('meeting_schedules', function (Blueprint $table) {
            $table->dropColumn('konselor_name');
            $table->foreignId('konselor_id')->after('id')->constrained('users');
        });
    }
};

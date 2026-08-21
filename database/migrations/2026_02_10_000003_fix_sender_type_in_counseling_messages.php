<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::table('counseling_messages')
            ->where('sender_type', 'admin')
            ->update(['sender_type' => 'konselor']);
    }

    public function down(): void
    {

    }
};

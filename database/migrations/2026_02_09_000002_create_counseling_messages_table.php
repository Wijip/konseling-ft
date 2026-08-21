<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('counseling_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('counseling_session_id')->constrained('counseling_sessions')->onDelete('cascade');
            $table->enum('sender_type', ['user', 'konselor']);
            $table->text('message');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('counseling_messages');
    }
};

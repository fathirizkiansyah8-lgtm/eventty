<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // kapten / pendaftar utama
            $table->string('team_name');
            $table->string('captain_name');
            $table->json('members'); // array of member names (strings)
            $table->timestamps();

            // Satu user hanya bisa daftar satu tim per event
            $table->unique(['event_id', 'user_id']);
            $table->index(['event_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_registrations');
    }
};

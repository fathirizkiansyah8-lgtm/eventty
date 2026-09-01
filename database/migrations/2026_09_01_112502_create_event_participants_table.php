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
        Schema::create('event_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('registration_date')->useCurrent();
            $table->enum('attendance_status', ['registered', 'present', 'absent', 'cancelled'])->default('registered');
            $table->timestamp('attendance_checked_at')->nullable();
            $table->foreignId('attendance_checked_by')->nullable()->constrained('users');
            $table->text('notes')->nullable(); // Admin notes about participant
            $table->timestamps();

            // Prevent duplicate registrations
            $table->unique(['event_id', 'user_id']);

            // Add indexes for better performance
            $table->index(['event_id', 'attendance_status']);
            $table->index(['user_id', 'attendance_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_participants');
    }
};

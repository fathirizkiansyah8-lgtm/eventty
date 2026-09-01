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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->enum('certificate_type', ['participation', 'completion', 'attendance', 'achievement'])->default('participation');
            $table->string('certificate_number')->unique(); // Unique certificate number
            $table->string('certificate_path')->nullable(); // Path to generated PDF
            $table->date('issued_date');
            $table->enum('status', ['generated', 'issued', 'revoked'])->default('generated');
            $table->foreignId('issued_by')->constrained('users'); // Admin who issued
            $table->text('description')->nullable(); // Additional certificate details
            $table->timestamps();

            // Prevent duplicate certificates for same user-event-type
            $table->unique(['user_id', 'event_id', 'certificate_type']);

            // Add indexes for better performance
            $table->index(['user_id', 'status']);
            $table->index(['event_id', 'status']);
            $table->index('certificate_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};

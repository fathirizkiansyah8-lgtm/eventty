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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->enum('target', ['all_students', 'participants', 'all_users', 'specific_class'])->default('all_students');
            $table->json('target_filter')->nullable(); // For specific targeting (classes, events, etc.)
            $table->enum('status', ['active', 'inactive', 'scheduled'])->default('active');
            $table->timestamp('publish_date')->useCurrent();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->string('priority')->default('normal'); // normal, high, urgent
            $table->boolean('is_pinned')->default(false);
            $table->timestamps();

            // Add indexes for better performance
            $table->index(['status', 'publish_date']);
            $table->index(['target', 'status']);
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};

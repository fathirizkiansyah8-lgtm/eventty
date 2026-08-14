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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('category');
            $table->string('location');
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('capacity');
            $table->integer('current_participants_count')->default(0);
            $table->foreignId('organizer_id')->constrained('users')->onDelete('cascade');
            $table->string('status')->default('pending');
            $table->string('thumbnail_image_path')->nullable();
            $table->string('certificate_template_path')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->decimal('price', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};

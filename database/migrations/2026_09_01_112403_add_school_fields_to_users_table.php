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
            $table->string('nis')->unique()->nullable()->after('email'); // Student ID Number
            $table->string('class')->nullable()->after('nis'); // Class (e.g., "XII IPA 1")
            $table->enum('role', ['student', 'admin'])->default('student')->after('class');
            $table->string('avatar_path')->nullable()->after('role');
            $table->string('phone')->nullable()->after('avatar_path');
            $table->text('address')->nullable()->after('phone');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nis', 'class', 'role', 'avatar_path', 'phone', 'address', 'status']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Batas akhir pendaftaran (nullable = tidak ada batas waktu khusus)
            $table->dateTime('registration_deadline')->nullable()->after('has_certificate');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('registration_deadline');
        });
    }
};

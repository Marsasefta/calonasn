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
        Schema::table('exam_sessions', function (Blueprint $table) {
            // Pastikan kolom end_time sudah ada di tabel kamu
            $table->integer('score_twk')->default(0)->after('end_time');
            $table->integer('score_tiu')->default(0)->after('score_twk');
            $table->integer('score_tkp')->default(0)->after('score_tiu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exam_sessions', function (Blueprint $table) {
            $table->dropColumn(['score_twk', 'score_tiu', 'score_tkp']);
        });
    }
};

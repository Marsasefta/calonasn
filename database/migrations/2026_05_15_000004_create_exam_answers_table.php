<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_answers', function (Blueprint $table) {
        $table->id();
        $table->foreignId('exam_session_id')->constrained('exam_sessions')->cascadeOnDelete();
        $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
        
        // Diubah menjadi nullable() untuk menampung soal yang tidak dijawab/dilewati
        $table->foreignId('option_id')->nullable()->constrained('question_options')->cascadeOnDelete();
        
        $table->unsignedTinyInteger('score_earned')->default(0);
        $table->timestamps();

        // Proteksi tingkat tinggi: Satu sesi ujian hanya boleh mencatat satu jawaban untuk satu nomor soal
        $table->unique(['exam_session_id', 'question_id']);
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_answers');
    }
};

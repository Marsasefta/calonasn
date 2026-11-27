<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tryout_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->foreignId('exam_session_id')->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('rating');
            $table->enum('recommendation', ['yes', 'maybe', 'no'])->default('yes');
            $table->text('message');
            $table->boolean('is_passed')->default(false);
            $table->unsignedSmallInteger('total_score')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tryout_feedbacks');
    }
};

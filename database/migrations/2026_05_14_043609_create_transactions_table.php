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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            // Tabel users pasti sudah ada bawaan Laravel
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); 
            
            // Hapus constrained() agar tidak mencari tabel tryouts dulu
            $table->unsignedBigInteger('tryout_id'); 
            
            $table->string('order_id')->unique();
            $table->integer('amount');
            $table->enum('status', ['pending', 'success'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

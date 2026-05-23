<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel.
     */
    public function up(): void
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id(); // Membuat kolom 'id' auto-increment (Primary Key)
            $table->string('code')->unique(); // Kolom teks untuk kode promo (harus unik)
            $table->decimal('discount_amount', 10, 2); // Kolom nominal potongan harga (contoh: 5000.00)
            $table->enum('status', ['aktif', 'non-aktif'])->default('aktif'); // Kolom status berupa pilihan
            $table->timestamps(); // Otomatis membuat kolom 'created_at' dan 'updated_at'
        });
    }

    /**
     * Batalkan migrasi (jika melakukan rollback).
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_codes');
    }
};
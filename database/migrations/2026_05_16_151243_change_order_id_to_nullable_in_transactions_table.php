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
        Schema::table('transactions', function (Blueprint $table) {
            // Mengubah kolom order_id menjadi nullable (boleh kosong)
            $table->string('order_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Mengembalikan kolom order_id menjadi tidak boleh kosong (wajib) jika di-rollback
            $table->string('order_id')->nullable(false)->change();
        });
    }
};

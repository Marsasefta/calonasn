<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Menambah kolom ID promo yang dipakai (boleh kosong jika tidak pakai promo)
            $table->unsignedBigInteger('promo_code_id')->nullable()->after('invoice_number');
            
            // Menambah kolom nominal diskon (default 0)
            $table->integer('discount_amount')->default(0)->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['promo_code_id', 'discount_amount']);
        });
    }
};

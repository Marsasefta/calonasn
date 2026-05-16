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
        
            if (!Schema::hasColumn('transactions', 'invoice_number')) {
                $table->string('invoice_number')->unique()->after('id')->nullable();
            }

            if (!Schema::hasColumn('transactions', 'amount')) {
                $table->integer('amount')->after('tryout_id')->default(0);
            }

            if (!Schema::hasColumn('transactions', 'unique_code')) {
                $table->integer('unique_code')->after('amount')->default(0);
            }

            if (!Schema::hasColumn('transactions', 'total_amount')) {
                $table->integer('total_amount')->after('unique_code')->default(0);
            }

            if (!Schema::hasColumn('transactions', 'payment_method')) {
                $table->string('payment_method')->default('qris')->after('total_amount');
            }

            if (!Schema::hasColumn('transactions', 'payment_proof')) {
                $table->string('payment_proof')->nullable()->after('payment_method');
            }

            if (!Schema::hasColumn('transactions', 'status')) {
                $table->enum('status', ['pending', 'verifying', 'paid', 'failed'])->default('pending')->after('payment_proof');
            }

            if (!Schema::hasColumn('transactions', 'expired_at')) {
                $table->timestamp('expired_at')->nullable()->after('status');
            }
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
};

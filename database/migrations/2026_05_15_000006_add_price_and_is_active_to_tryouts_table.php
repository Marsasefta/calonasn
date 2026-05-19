<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tryouts', function (Blueprint $table) {
            if (!Schema::hasColumn('tryouts', 'price')) {
                $table->integer('price')->default(0)->after('description');
            }
            if (!Schema::hasColumn('tryouts', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tryouts', function (Blueprint $table) {
            if (Schema::hasColumn('tryouts', 'is_active')) {
                $table->dropColumn('is_active');
            }
            if (Schema::hasColumn('tryouts', 'price')) {
                $table->dropColumn('price');
            }
        });
    }
};

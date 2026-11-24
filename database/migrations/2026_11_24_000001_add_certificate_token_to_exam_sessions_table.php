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
        if (!Schema::hasColumn('exam_sessions', 'certificate_token')) {
            Schema::table('exam_sessions', function (Blueprint $table) {
                $table->string('certificate_token', 32)->nullable()->unique()->after('total_score');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('exam_sessions', 'certificate_token')) {
            Schema::table('exam_sessions', function (Blueprint $table) {
                $table->dropColumn('certificate_token');
            });
        }
    }
};

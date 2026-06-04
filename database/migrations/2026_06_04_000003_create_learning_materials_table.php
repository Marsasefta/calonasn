<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('learning_materials', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('learning_chapter_id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->integer('order_number')->default(1);
            $table->boolean('is_locked')->default(false);
            $table->timestamps();

            $table->foreign('learning_chapter_id')->references('id')->on('learning_chapters')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('learning_materials');
    }
};

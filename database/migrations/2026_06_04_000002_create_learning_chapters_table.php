<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('learning_chapters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('learning_category_id');
            $table->string('title');
            $table->integer('order_number')->default(1);
            $table->timestamps();

            $table->foreign('learning_category_id')->references('id')->on('learning_categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('learning_chapters');
    }
};

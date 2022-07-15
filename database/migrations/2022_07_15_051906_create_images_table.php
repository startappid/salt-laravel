<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('fullpath', 1024);
            $table->string('path', 1024);
            $table->string('filename', 1024);
            $table->string('title', 1024)->nullable();
            $table->string('alt', 1024)->nullable();
            $table->string('description', 1024)->nullable();
            $table->unsignedInteger('size'); // in KB
            $table->string('ext', 20); // jpg, jpeg, png
            $table->unsignedInteger('dimension_width');
            $table->unsignedInteger('dimension_height');
            $table->enum('type', ['image', 'thumbnail', 'banner', 'profile', 'icon', 'other'])->default('image');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
};

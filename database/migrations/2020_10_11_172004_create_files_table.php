<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('fullpath', 255);
            $table->string('path', 255);
            $table->string('filename', 255);
            $table->string('title', 255)->nullable();
            $table->string('description', 1024)->nullable();
            $table->unsignedInteger('size'); // in KB
            $table->string('ext', 10); // zip, tar, targz, pdf
            $table->enum('type', ['compress', 'document', 'image', 'other'])->default('other');
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
        Schema::dropIfExists('files');
    }
}

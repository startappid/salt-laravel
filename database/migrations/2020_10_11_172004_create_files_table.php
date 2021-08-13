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
            $table->string('ext', 10);
            $table->enum('type', [
                'compress', // zip, tar, tar.gz, etc
                'document', // doc, excel, ppt, pdf, etc
                'image', // jpeg, gif, png, etc
                'video', // mp4, mov, etc
                'audio', // bmp, wav, etc
                'other'
            ])->default('other');
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

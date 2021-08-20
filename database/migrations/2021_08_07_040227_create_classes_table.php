<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('level_id')->constrained('levels');
            $table->foreignId('degree_id')->constrained('degrees');
            $table->foreignId('major_id')->nullable()->constrained('majors');
            $table->foreignId('field_id')->nullable()->constrained('fields');
            $table->string('class')->nullable(); // NOTE: {level} {degree} {major}. ex: XII SMA IPA
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
        Schema::dropIfExists('classes');
    }
}

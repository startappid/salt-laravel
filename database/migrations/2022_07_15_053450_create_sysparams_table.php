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
        Schema::create('sysparams', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('group');
            $table->string('key');
            $table->string('value');
            $table->json('data')->nullable();
            $table->tinyInteger('order')->unsigned()->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
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
        Schema::dropIfExists('sysparams');
    }
};

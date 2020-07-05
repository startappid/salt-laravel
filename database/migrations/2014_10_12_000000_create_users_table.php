<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username', 100)->unique(100);
            $table->string('email', 200)->unique(200);
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->string('phone', 25)->nullable();
            $table->enum('gender', [0, 1])->nullable();
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

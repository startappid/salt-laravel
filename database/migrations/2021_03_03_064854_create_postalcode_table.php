<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostalcodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postalcode', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subdistrict_id')->constrained('subdistricts');
            $table->foreignId('district_id')->constrained('districts');
            $table->foreignId('city_id')->constrained('cities');
            $table->foreignId('province_id')->constrained('provinces');
            $table->foreignId('country_id')->constrained('countries');
            $table->string('postal_code', 255);
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
        Schema::dropIfExists('postalcode');
    }
}

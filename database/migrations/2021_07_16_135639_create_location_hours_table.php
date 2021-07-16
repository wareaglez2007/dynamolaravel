<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('location_hours', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('locations_id');
            $table->foreign('locations_id')->references('id')->on('locations')
                ->onDelete('cascade');
            $table->string("days")->nullable();
            $table->string("hours")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('location_hours');
    }
}

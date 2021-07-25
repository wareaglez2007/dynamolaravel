<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('locations_id');
            $table->foreign('locations_id')->references('id')->on('locations')
                ->onDelete('cascade');
                //Need contact type (phone, fax)
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('maps_url')->nullable();
            $table->string('fax')->nullable();
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
        Schema::dropIfExists('location_contacts');
    }
}

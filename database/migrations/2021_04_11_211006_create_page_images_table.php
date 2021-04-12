<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('upload_images_id');
            $table->foreign('upload_images_id')->references('id')->on('upload_images')
            ->onDelete('cascade');
            $table->unsignedBigInteger('pages_id');
            $table->foreign('pages_id')->references('id')->on('pages')
            ->onDelete('cascade');
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
        Schema::dropIfExists('page_images');
    }
}

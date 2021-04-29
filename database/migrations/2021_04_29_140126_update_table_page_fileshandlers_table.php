<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTablePageFileshandlersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('page_files', function (Blueprint $table) {
            $table->unsignedBigInteger('fileshandlers_id');
            $table->foreign('fileshandlers_id')->references('id')->on('fileshandlers')
            ->onDelete('cascade');
            $table->unsignedBigInteger('pages_id');
            $table->foreign('pages_id')->references('id')->on('pages')
            ->onDelete('cascade');
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
        Schema::table('page_files', function (Blueprint $table) {
            //
        });
    }
}

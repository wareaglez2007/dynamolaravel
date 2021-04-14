<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileshandlersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fileshandlers', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('extension');
            $table->string('storage_path');
            $table->string('file_size');
            $table->text('content')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('uploaded_by')->nullable();
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
        Schema::dropIfExists('fileshandlers');
    }
}

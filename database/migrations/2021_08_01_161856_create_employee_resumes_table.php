<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeResumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_resumes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employees_id');
            $table->foreign('employees_id')->references('id')->on('employees')
                ->onDelete('cascade');
            $table->string('bio')->nullable();
            $table->string('file_name')->nullable();
            $table->string('saved_location')->nullable();
            $table->string('added_by');
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
        Schema::dropIfExists('employee_resumes');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hs_doctor_departments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('department_id')->unsigned()->reference('id')->on('hs_departments')->onDelete('cascade');
            $table->bigInteger('doctor_id')->unsigned()->reference('id')->on('hs_doctors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hs_doctor_departments');
    }
}

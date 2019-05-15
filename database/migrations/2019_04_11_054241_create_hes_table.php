<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedInteger('patient_id');
            $table->unsignedInteger('student_id');
            $table->unsignedTinyInteger('building_id');
            $table->unsignedInteger('program_id');
            $table->unsignedInteger('supervisor_id');
            $table->unsignedTinyInteger('egress_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hes');
    }
}

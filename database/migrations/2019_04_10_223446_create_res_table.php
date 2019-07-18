<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('res', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            // $table->unsignedInteger('patient_id');
            // $table->unsignedInteger('student_id');
            // $table->unsignedTinyInteger('building_id');
            // $table->unsignedInteger('program_id');
            // $table->unsignedInteger('supervisor_id');
            // $table->boolean('refer_needed');
            // $table->string('refer_place')->nullable();
            $table->unsignedInteger('program_id');
            $table->unsignedInteger('patient_id');
            $table->unsignedInteger('user_id');
            $table->boolean('referencia_necesaria');
            $table->string('lugar_de_referencia')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('res');
    }
}

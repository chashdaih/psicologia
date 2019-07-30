<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('fdg_id');
            $table->unsignedInteger('cdr_program_id')->default(0);
            $table->unsignedInteger('cdr_id')->default(0);
            $table->unsignedInteger('ps_program_id')->default(0);
            $table->unsignedInteger('ps_id')->default(0);
            $table->unsignedInteger('re_program_id')->default(0);
            $table->unsignedInteger('re_id')->default(0);
            $table->unsignedInteger('rs6_program_id')->default(0);
            $table->unsignedInteger('rs6_id')->default(0);
            $table->unsignedInteger('rs7_program_id')->default(0);
            $table->unsignedInteger('rs7_id')->default(0);
            $table->unsignedInteger('he_program_id')->default(0);
            $table->unsignedInteger('he_id')->default(0);
            $table->unsignedInteger('cssp_program_id')->default(0);
            $table->unsignedInteger('cssp_id')->default(0);
            $table->unsignedTinyInteger('status')->default(0); // por definir
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}

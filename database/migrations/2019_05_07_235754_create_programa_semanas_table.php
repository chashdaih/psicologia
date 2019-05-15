<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramaSemanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programa_semanas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('program_id');
            $table->string('semana')->nullable();
            $table->text('actividad')->nullable();
            $table->text('competencias')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programa_semanas');
    }
}

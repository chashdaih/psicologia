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
            $table->unsignedInteger('assign_id'); // patient_assign table
            $table->unsignedInteger('user_id'); // filler
            // $table->string('file_number')->nullable();
            $table->text('tecnicas_evaluacion')->nullable();
            $table->text('resultados_obtenidos')->nullable();
            $table->text('indicadores_evolucion')->nullable();
            $table->boolean('referencia_necesaria');
            $table->text('tipo_problematica')->nullable();
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

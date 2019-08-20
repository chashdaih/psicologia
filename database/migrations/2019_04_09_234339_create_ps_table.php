<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ps', function (Blueprint $table) {
            $table->bigIncrements('id'); // No. expediente
            $table->timestamps();
            $table->unsignedInteger('assign_id');
            $table->unsignedBigInteger('user_id');
            $table->string('file_number')->nullable();

            $table->unsignedTinyInteger('tipo_de_intervencion');
            $table->string('modelo_psicoterapia')->nullable();
            $table->unsignedTinyInteger('modalidad_de_servicio');
            $table->text('sugerencias_de_intervencion')->nullable();

            // TODO foreign keys?
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ps');
    }
}

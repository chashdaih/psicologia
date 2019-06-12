<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupervisorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supervisores', function (Blueprint $table) {
            $table->increments('id_supervisor');
            $table->string('nombre', 1000);
            $table->string('ap_paterno', 120);
            $table->string('ap_materno', 120);
            $table->string('coordinacion', 120);
            $table->string('nombramiento', 120);
            $table->string('telefono', 50);
            $table->string('celular', 20);
            $table->string('correo', 120);
            $table->string('num_trabajador', 12);
            $table->string('rfc', 30);
            $table->unsignedTinyInteger('tipo_supervisor');
            $table->string('estatus', 15);
            $table->string('password', 30);
            $table->unsignedTinyInteger('id_centro');
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
        Schema::dropIfExists('supervisores');
    }
}

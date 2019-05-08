<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaracteristicasServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caracteristicas_servicios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('program_id');
            $table->string('gen_horas_total');
            $table->boolean('gen_l')->default(false);
            $table->string('gen_hora_l')->nullable();
            $table->boolean('gen_ma')->default(false);
            $table->string('gen_hora_ma')->nullable();
            $table->boolean('gen_mi')->default(false);
            $table->string('gen_hora_mi')->nullable();
            $table->boolean('gen_j')->default(false);
            $table->string('gen_hora_j')->nullable();
            $table->boolean('gen_v')->default(false);
            $table->string('gen_hora_v')->nullable();
            $table->boolean('gen_s')->default(false);
            $table->string('gen_hora_s')->nullable();
            $table->string('serv_horas_total');
            $table->boolean('serv_l')->default(false);
            $table->string('serv_hora_l')->nullable();
            $table->boolean('serv_ma')->default(false);
            $table->string('serv_hora_ma')->nullable();
            $table->boolean('serv_mi')->default(false);
            $table->string('serv_hora_mi')->nullable();
            $table->boolean('serv_j')->default(false);
            $table->string('serv_hora_j')->nullable();
            $table->boolean('serv_v')->default(false);
            $table->string('serv_hora_v')->nullable();
            $table->boolean('serv_s')->default(false);
            $table->string('serv_hora_s')->nullable();
            $table->unsignedTinyInteger('pacientes_semana');
            $table->unsignedTinyInteger('minimo_pacientes_semestre');
            $table->unsignedTinyInteger('tipo_servicio');
            // problematica atendida
            $table->boolean('depresion')->default(false);
            $table->boolean('duelo')->default(false);
            $table->boolean('psicosis')->default(false);
            $table->boolean('epilepsia')->default(false);
            $table->boolean('demencia')->default(false);
            $table->boolean('emocionales_niños')->default(false);
            $table->boolean('emocionales_ad')->default(false);
            $table->boolean('desarrollo_niños')->default(false);
            $table->boolean('desarrollo_ad')->default(false);
            $table->boolean('conductuales_niños')->default(false);
            $table->boolean('conductuales_ad')->default(false);
            $table->boolean('auutolesion')->default(false);
            $table->boolean('ansiedad')->default(false);
            $table->boolean('estres')->default(false);
            $table->boolean('sexualidad')->default(false);
            $table->boolean('violencia')->default(false);
            $table->boolean('sustancias')->default(false);
            $table->boolean('intervencion')->default(false);
            $table->string('otra_problematica')->nullable();
            $table->unsignedTinyInteger('enfoque_servicio');
            // caracteristicas de la supervisión y evaluación
            $table->boolean('individual')->default(false);
            $table->boolean('grupal')->default(false);
            $table->boolean('colaborativa')->default(false);
            $table->boolean('indirecta')->default(false);
            $table->boolean('directa')->default(false);
            $table->string('supervision_otra')->nullable();
            // estratedias de enseñanza y supervisión
            $table->boolean('observacion')->default(false);
            $table->boolean('juego_roles')->default(false);
            $table->boolean('modelamiento')->default(false);
            $table->boolean('moldeamiento')->default(false);
            $table->boolean('cascada')->default(false);
            $table->boolean('auto_supervision')->default(false);
            $table->boolean('equipo_reflexivo')->default(false);
            $table->boolean('con_colegas')->default(false);
            $table->boolean('analisis_caso')->default(false);
            $table->string('ensenanza_otra')->nullable();
            $table->text('contenido_tematico');
            $table->text('seguimiento_impacto');
            // competencias profesionales a desarrollar
            $table->boolean('fundamentales')->default(false);
            $table->boolean('entrevista')->default(false);
            $table->boolean('evaluacion')->default(false);
            $table->boolean('impresion_diagnostica')->default(false);
            $table->boolean('implementacion_intervenciones')->default(false);
            $table->boolean('integracion_expediente')->default(false);
            $table->boolean('elaboracion_documentos')->default(false);
            $table->string('competencias_otra')->nullable();
            // estrategias de evaluación de competencias
            $table->boolean('formativa')->default(false);
            $table->boolean('integrativa')->default(false);
            $table->boolean('contextual')->default(false);
            $table->boolean('holistica')->default(false);
            $table->boolean('plural')->default(false);
            $table->boolean('reflexiva')->default(false);
            // acreditación
            $table->string('cuando_acreditacion');
            $table->string('como_acreditacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caracteristicas_servicios');
    }
}

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
            $table->unsignedInteger('assign_id'); // patient assign table
            $table->unsignedInteger('user_id'); // person who filled the form
            $table->unsignedTinyInteger('egress_type');
            $table->text('descripcion_del_egreso')->nullable();
            $table->text('observaciones_recomendaciones')->nullable();
            $table->unsignedMediumInteger('hi1')->nullable();
            $table->unsignedMediumInteger('ht1')->nullable();
            $table->boolean('ha1')->nullable();
            $table->unsignedMediumInteger('hi2')->nullable();
            $table->unsignedMediumInteger('ht2')->nullable();
            $table->boolean('ha2')->nullable();
            $table->unsignedMediumInteger('hi3')->nullable();
            $table->unsignedMediumInteger('ht3')->nullable();
            $table->boolean('ha3')->nullable();
            $table->unsignedMediumInteger('hi4')->nullable();
            $table->unsignedMediumInteger('ht4')->nullable();
            $table->boolean('ha4')->nullable();
            $table->unsignedMediumInteger('hi5')->nullable();
            $table->unsignedMediumInteger('ht5')->nullable();
            $table->boolean('ha5')->nullable();
            $table->unsignedMediumInteger('hi6')->nullable();
            $table->unsignedMediumInteger('ht6')->nullable();
            $table->boolean('ha6')->nullable();
            $table->unsignedMediumInteger('hi7')->nullable();
            $table->unsignedMediumInteger('ht7')->nullable();
            $table->boolean('ha7')->nullable();
            $table->unsignedMediumInteger('hi8')->nullable();
            $table->unsignedMediumInteger('ht8')->nullable();
            $table->boolean('ha8')->nullable();
            $table->unsignedMediumInteger('hi9')->nullable();
            $table->unsignedMediumInteger('ht9')->nullable();
            $table->boolean('ha9')->nullable();
            $table->unsignedMediumInteger('hi10')->nullable();
            $table->unsignedMediumInteger('ht10')->nullable();
            $table->boolean('ha10')->nullable();
            $table->unsignedMediumInteger('hi11')->nullable();
            $table->unsignedMediumInteger('ht11')->nullable();
            $table->boolean('ha11')->nullable();
            $table->unsignedMediumInteger('hi12')->nullable();
            $table->unsignedMediumInteger('ht12')->nullable();
            $table->boolean('ha12')->nullable();
            $table->unsignedMediumInteger('hi13')->nullable();
            $table->unsignedMediumInteger('ht13')->nullable();
            $table->boolean('ha13')->nullable();
            $table->unsignedMediumInteger('hi14')->nullable();
            $table->unsignedMediumInteger('ht14')->nullable();
            $table->boolean('ha14')->nullable();
            $table->unsignedMediumInteger('hi15')->nullable();
            $table->unsignedMediumInteger('ht15')->nullable();
            $table->boolean('ha15')->nullable();
            $table->unsignedMediumInteger('hi16')->nullable();
            $table->unsignedMediumInteger('ht16')->nullable();
            $table->boolean('ha16')->nullable();
            $table->unsignedMediumInteger('hi17')->nullable();
            $table->unsignedMediumInteger('ht17')->nullable();
            $table->boolean('ha17')->nullable();
            $table->unsignedMediumInteger('hi18')->nullable();
            $table->unsignedMediumInteger('ht18')->nullable();
            $table->boolean('ha18')->nullable();
            $table->unsignedMediumInteger('hi19')->nullable();
            $table->unsignedMediumInteger('ht19')->nullable();
            $table->boolean('ha19')->nullable();
            $table->unsignedMediumInteger('hi20')->nullable();
            $table->unsignedMediumInteger('ht20')->nullable();
            $table->boolean('ha20')->nullable();
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

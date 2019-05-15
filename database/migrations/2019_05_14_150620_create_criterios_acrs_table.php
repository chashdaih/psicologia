<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCriteriosAcrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criterios_acrs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('program_id');
            $table->string('criterio')->nullable();
            $table->string('cuando')->nullable();
            $table->string('como')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('criterios_acrs');
    }
}

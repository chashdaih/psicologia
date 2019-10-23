<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('es', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedTinyInteger('q11');
            $table->unsignedTinyInteger('q12');
            $table->unsignedTinyInteger('q13');
            $table->unsignedTinyInteger('q14');
            $table->unsignedTinyInteger('q15');
            $table->unsignedTinyInteger('q16');
            $table->unsignedTinyInteger('q2');
            $table->unsignedTinyInteger('q3');
            $table->unsignedTinyInteger('q4');
            $table->unsignedTinyInteger('q5');
            $table->unsignedTinyInteger('q6');
            $table->text('comments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('es');
    }
}

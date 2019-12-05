<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEcposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecpos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedInteger('filler_id');
            $table->unsignedTinyInteger('evaluation_phase');
            $table->unsignedTinyInteger('q11')->nullable();
            $table->unsignedTinyInteger('q12')->nullable();
            $table->unsignedTinyInteger('q13')->nullable();
            $table->unsignedTinyInteger('q14')->nullable();
            $table->unsignedTinyInteger('q15')->nullable();
            $table->unsignedTinyInteger('q16')->nullable();
            $table->unsignedTinyInteger('q17')->nullable();
            $table->unsignedTinyInteger('q18')->nullable();
            $table->unsignedTinyInteger('q19')->nullable();
            $table->unsignedTinyInteger('q110')->nullable();
            $table->unsignedTinyInteger('q111')->nullable();
            $table->unsignedTinyInteger('q21')->nullable();
            $table->unsignedTinyInteger('q22')->nullable();
            $table->unsignedTinyInteger('q23')->nullable();
            $table->unsignedTinyInteger('q24')->nullable();
            $table->unsignedTinyInteger('q25')->nullable();
            $table->unsignedTinyInteger('q26')->nullable();
            $table->unsignedTinyInteger('q27')->nullable();
            $table->unsignedTinyInteger('q28')->nullable();
            $table->unsignedTinyInteger('q29')->nullable();
            $table->unsignedTinyInteger('q31')->nullable();
            $table->unsignedTinyInteger('q32')->nullable();
            $table->unsignedTinyInteger('q33')->nullable();
            $table->unsignedTinyInteger('q34')->nullable();
            $table->unsignedTinyInteger('q35')->nullable();
            $table->unsignedTinyInteger('q36')->nullable();
            $table->unsignedTinyInteger('q41')->nullable();
            $table->unsignedTinyInteger('q42')->nullable();
            $table->unsignedTinyInteger('q43')->nullable();
            $table->unsignedTinyInteger('q51')->nullable();
            $table->unsignedTinyInteger('q52')->nullable();
            $table->unsignedTinyInteger('q53')->nullable();
            $table->unsignedTinyInteger('q54')->nullable();
            $table->unsignedTinyInteger('q55')->nullable();
            $table->unsignedTinyInteger('q56')->nullable();
            $table->unsignedTinyInteger('q57')->nullable();
            $table->unsignedTinyInteger('q61')->nullable();
            $table->unsignedTinyInteger('q62')->nullable();
            $table->unsignedTinyInteger('q63')->nullable();
            $table->unsignedTinyInteger('q64')->nullable();
            $table->unsignedTinyInteger('q65')->nullable();
            $table->unsignedTinyInteger('q66')->nullable();
            $table->unsignedTinyInteger('q71')->nullable();
            $table->unsignedTinyInteger('q72')->nullable();
            $table->unsignedTinyInteger('q73')->nullable();

            // TODO foreign keys
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecpos');
    }
}

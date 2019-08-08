<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEcprsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ecprs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedTinyInteger('semester');
            $table->unsignedTinyInteger('evaluation_phase');
            $table->unsignedTinyInteger('q11');
            $table->unsignedTinyInteger('q12');
            $table->unsignedTinyInteger('q13');
            $table->unsignedTinyInteger('q14');
            $table->unsignedTinyInteger('q15');
            $table->unsignedTinyInteger('q16');
            $table->unsignedTinyInteger('q17');
            $table->unsignedTinyInteger('q18');
            $table->unsignedTinyInteger('q19');
            $table->unsignedTinyInteger('q110');
            $table->unsignedTinyInteger('q21');
            $table->unsignedTinyInteger('q22');
            $table->unsignedTinyInteger('q23');
            $table->unsignedTinyInteger('q24');
            $table->unsignedTinyInteger('q25');
            $table->unsignedTinyInteger('q26');
            $table->unsignedTinyInteger('q27');
            $table->unsignedTinyInteger('q28');
            $table->unsignedTinyInteger('q29');
            $table->unsignedTinyInteger('q31');
            $table->unsignedTinyInteger('q32');
            $table->unsignedTinyInteger('q33');
            $table->unsignedTinyInteger('q34');
            $table->unsignedTinyInteger('q35');
            $table->unsignedTinyInteger('q36');
            $table->unsignedTinyInteger('q41');
            $table->unsignedTinyInteger('q42');
            $table->unsignedTinyInteger('q43');
            $table->unsignedTinyInteger('q51');
            $table->unsignedTinyInteger('q52');
            $table->unsignedTinyInteger('q53');
            $table->unsignedTinyInteger('q54');
            $table->unsignedTinyInteger('q55');
            $table->unsignedTinyInteger('q56');
            $table->unsignedTinyInteger('q57');
            $table->unsignedTinyInteger('q58');
            $table->unsignedTinyInteger('q61');
            $table->unsignedTinyInteger('q62');
            $table->unsignedTinyInteger('q63');
            $table->unsignedTinyInteger('q64');
            $table->unsignedTinyInteger('q65');
            $table->unsignedTinyInteger('q66');
            $table->unsignedTinyInteger('q71');
            $table->unsignedTinyInteger('q72');
            $table->unsignedTinyInteger('q73');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ecprs');
    }
}

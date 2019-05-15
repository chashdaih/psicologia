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
            $table->string('active_sem', 12);
            $table->string('student', 12);
            $table->unsignedTinyInteger('semester');
            $table->unsignedTinyInteger('evaluation_phase');
            $table->unsignedBigInteger('supervisor');
            $table->unsignedBigInteger('q11');
            $table->unsignedBigInteger('q12');
            $table->unsignedBigInteger('q13');
            $table->unsignedBigInteger('q14');
            $table->unsignedBigInteger('q15');
            $table->unsignedBigInteger('q16');
            $table->unsignedBigInteger('q17');
            $table->unsignedBigInteger('q18');
            $table->unsignedBigInteger('q19');
            $table->unsignedBigInteger('q110');
            $table->unsignedBigInteger('q111');
            $table->unsignedBigInteger('q21');
            $table->unsignedBigInteger('q22');
            $table->unsignedBigInteger('q23');
            $table->unsignedBigInteger('q24');
            $table->unsignedBigInteger('q25');
            $table->unsignedBigInteger('q26');
            $table->unsignedBigInteger('q27');
            $table->unsignedBigInteger('q28');
            $table->unsignedBigInteger('q29');
            $table->unsignedBigInteger('q31');
            $table->unsignedBigInteger('q32');
            $table->unsignedBigInteger('q33');
            $table->unsignedBigInteger('q34');
            $table->unsignedBigInteger('q35');
            $table->unsignedBigInteger('q36');
            $table->unsignedBigInteger('q41');
            $table->unsignedBigInteger('q42');
            $table->unsignedBigInteger('q43');
            $table->unsignedBigInteger('q51');
            $table->unsignedBigInteger('q52');
            $table->unsignedBigInteger('q53');
            $table->unsignedBigInteger('q54');
            $table->unsignedBigInteger('q55');
            $table->unsignedBigInteger('q56');
            $table->unsignedBigInteger('q57');
            $table->unsignedBigInteger('q61');
            $table->unsignedBigInteger('q62');
            $table->unsignedBigInteger('q63');
            $table->unsignedBigInteger('q64');
            $table->unsignedBigInteger('q65');
            $table->unsignedBigInteger('q66');
            $table->unsignedBigInteger('q71');
            $table->unsignedBigInteger('q72');
            $table->unsignedBigInteger('q73');

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

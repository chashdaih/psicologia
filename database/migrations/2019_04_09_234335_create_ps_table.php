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
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('file_number');
            $table->unsignedBigInteger('patient_id');
            $table->unsignedInteger('center_id');
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('supervisor_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedTinyInteger('intervention_type');
            $table->string('other_intervention')->nullable();
            $table->unsignedTinyInteger('service_modality');
            $table->text('intervention_suggestions');

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
        Schema::dropIfExists('ps');
    }
}

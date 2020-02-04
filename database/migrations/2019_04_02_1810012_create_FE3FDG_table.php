<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFe3fdgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FE3FDG', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('user_id'); // account who made the interview
            $table->string('other_filler')->nullable();
            $table->smallInteger('file_year')->nullable();
            $table->string('file_number')->nullable();
            $table->unsignedTinyInteger('center_id'); // where was registered
            //$table->unsignedBigInteger('program_id');
            // identification
            $table->string('name');
            $table->string('last_name');
            $table->string('mothers_name');
            $table->string('curp');
            $table->boolean('gender');
            $table->date('birthdate');
            $table->string('birth_place')->nullable();
            $table->unsignedTinyInteger('marital_status');
            $table->boolean('is_unam');
            $table->string('academic_entity')->nullable();
            $table->unsignedTinyInteger('position')->nullable();
            $table->string('career')->nullable();
            $table->string('semester')->nullable();
            $table->unsignedTinyInteger('person_requesting');
            $table->string('name_requester')->nullable();
            // if underage, tutor's data
            $table->string('tutor_name_1')->nullable();
            $table->unsignedTinyInteger('relationship_1')->nullable();
            $table->date('tutor_birthdate_1')->nullable();
            $table->unsignedTinyInteger('studies_level_1')->nullable();
            $table->string('occupation_1')->nullable();
            $table->string('tutor_name_2')->nullable();
            $table->unsignedTinyInteger('relationship_2')->nullable();
            $table->date('tutor_birthdate_2')->nullable();
            $table->unsignedTinyInteger('studies_level_2')->nullable();
            $table->string('occupation_2')->nullable();
            // address
            $table->string('street_name');
            $table->string('external_number');
            $table->string('internal_number')->nullable();
            $table->string('neighborhood');
            $table->string('postal_code');
            $table->string('municipality');
            $table->string('state');
            $table->string('house_phone')->nullable();
            $table->string('cell_phone')->nullable();
            $table->string('work_phone')->nullable();
            $table->string('work_phone_ext')->nullable();
            $table->string('email')->nullable();
            // socio-economic situation
            $table->unsignedTinyInteger('scholarship');
            $table->unsignedTinyInteger('studied_years');
            $table->boolean('has_work');
            $table->string('who_depends_on')->nullable();
            $table->boolean('has_salary')->nullable();
            $table->string('work_description')->nullable();
            $table->unsignedTinyInteger('household_members');
            $table->string('monthly_family_income');
            $table->unsignedTinyInteger('number_people_contributing');
            $table->unsignedTinyInteger('number_people_depending');
            $table->unsignedTinyInteger('house_is');
            $table->string('house_other')->nullable();
            // about the service
            $table->unsignedTinyInteger('service_type');
            $table->unsignedTinyInteger('service_modality');
            $table->text('consultation_cause');
            $table->unsignedTinyInteger('mhGAP_cause_classification')->nullable();
            $table->string('problem_since');
            $table->boolean('has_recived_previous_treatment');
            $table->unsignedTinyInteger('number_times_treatment')->nullable();
            $table->unsignedTinyInteger('type_previous_treatment')->nullable();
            $table->string('other_previous_treatment')->nullable();
            $table->unsignedTinyInteger('refer');
            $table->string('refer_where')->nullable();
            $table->string('refer_other')->nullable();
            $table->string('refer_problem')->nullable();
            $table->boolean('unam_previous_treatment');
            $table->unsignedInteger('unam_previous_treatment_program')->nullable();
            $table->boolean('has_health_issue');
            $table->string('health_issue')->nullable();
            $table->boolean('takes_medication')->nullable();
            $table->string('medication')->nullable();
            $table->string('medication_dose')->nullable();
            $table->unsignedTinyInteger('prefer_time');
            // appointment **Is correct here?
            // $table->date('appointment_date')->nullable();
            // $table->time('appointment_time')->nullable();
            // $table->unsignedBigInteger('supervisor')->nullable();
            // $table->unsignedInteger('program');

            // $table->foreign('filler')->references('id')->on('users'); // TODO define delete action
            // $table->foreign('supervisor')->references('id')->on('users');
            // $table->foreign('unam_previous_treatment_program')->references('id_centro')->on('centros');
            // $table->foreign('program')->references('id_centro')->on('centros');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fe3fdg');
    }
}

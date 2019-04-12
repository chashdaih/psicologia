<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rps', function (Blueprint $table) {
            // program
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('program_number');
            $table->string('scene');
            $table->string('scene_institution');
            $table->string('scene_chars');
            $table->boolean('colaboration');
            $table->string('colaboration_number')->nullable();
            $table->boolean('anual');
            $table->unsignedTinyInteger('targeted_semester');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('monday');
            $table->time('monday_start')->nullable();
            $table->time('monday_end')->nullable();
            $table->boolean('tuesday');
            $table->time('tuesday_start')->nullable();
            $table->time('tuesday_end')->nullable();
            $table->boolean('wednesday');
            $table->time('wednesday_start')->nullable();
            $table->time('wednesday_end')->nullable();
            $table->boolean('thursday');
            $table->time('thursday_start')->nullable();
            $table->time('thursday_end')->nullable();
            $table->boolean('friday');
            $table->time('friday_start')->nullable();
            $table->time('friday_end')->nullable();
            $table->boolean('saturday');
            $table->time('saturday_start')->nullable();
            $table->time('saturday_end')->nullable();
            $table->unsignedTinyInteger('weekly_hours');
            $table->unsignedTinyInteger('max_students');
            $table->text('entry_requirements');
            $table->text('subjects_2008');
            // supervisor data
            $table->unsignedInteger('supervisor_id');
            // specialized situations
            $table->text('summary');
            $table->text('justification');
            $table->text('overall_objective');
            $table->text('specific_objectives');
            $table->text('theory_practical_interaction');
            $table->text('service_approach');
            $table->text('service_approach');
            $table->text('suggested_courses');
            $table->text('supervision_model');
            $table->text('service_impact_evaluation');
            $table->text('professional_skills');
            $table->text('professional_skills_activities');
            $table->text('professional_skills_evaluation');
            $table->text('accreditation_criteria');
            $table->text('references_apa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rps');
    }
}

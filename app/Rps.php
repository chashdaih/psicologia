<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rps extends Model
{
    protected $guarded = ['id', 'updated_at', 'created_at'];
    protected $dates = ['start_date', 'end_date'];

    protected $attributes = [
        "program_name" => null,
        "scene" => null,
        "scene_address" => null,
        "scene_institution" => null,
        "scene_chars" => null,
        'colaboration' => false,
        'anual' => 0,
        'target_5' => false,
        'target_6' => false,
        'target_7' => false,
        "start_date" => null,
        "end_date" => null,
        "days" => null,
        "time" => null,
        "weekly_hours" => null,
        "max_students" => null,
        "entry_requirements" => null,
        "subjects_2008" => null,
        // special
        "summary" => null,
        "justification" => null,
        "overall_objective" => null,
        "specific_objectives" => null,
        "theory_practical_interaction" => null,
        "service_approach" => null,
        "suggested_courses" => null,
        "relation" => null,
        "rules" => null,
        "supervision_model" => null,
        "service_impact_evaluation" => null,
        "professional_skills" => null,
        "professional_skills_activities" => null,
        "professional_skills_evaluation" => null,
        "accreditation_criteria" => null,
        // apa
        "references_apa" => null
    ];
}

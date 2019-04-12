<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class He extends Model
{
    protected $guarded = ['id', 'updated_at'];
    protected $dates = ['created_at'];

    protected $attributes = [
        'created_at' => null,
        'patient_id' => 0,
        'building_id' => 0,
        'program_id' => 0,
        'supervisor_id' => 1,
        'student_id' => 0,
        'egress_type' => 0
    ];

    public function student() {
        return $this->belongsTo(Student::class, 'student_id', 'id_usuario');
    }
    public function patient() {
        return $this->belongsTo(FE3FDG::class);
    }
    public function center() {
        return $this->belongsTo(Building::class, 'building_id', 'id_centro');
    }
    public function program() {
        return $this->belongsTo(Program::class, 'program_id', 'id_practica');
    }
    public function supervisor(){
        return $this->belongsTo(Supervisor::class, 'supervisor_id', 'id_supervisor');
    }
}

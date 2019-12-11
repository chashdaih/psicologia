<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientAssign extends Model
{
    protected $guarded = [];

    public function program()
    {
        return $this->belongsTo('App\Program', 'program_id', 'id_practica');
    }

    public function patient()
    {
        return $this->belongsTo('App\Patient', 'patient_id', 'id');
    }
}

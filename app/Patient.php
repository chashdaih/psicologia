<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $guarded = [];

    public function fdg()
    {
        return $this->belongsTo('App\FE3FDG', 'fdg_id', 'id');
    }

    // public function program()
    // {
    //     return $this->belongsTo('App\Program', 'ps_program_id', 'id_practica');
    // }

    public function assigned()
    {
        return $this->hasMany('App\PatientAssign', 'patient_id', 'id');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'cita';
    protected $primaryKey = 'id_cita';
    public $timestamps = false;

    protected $guarded = [];

    // public function student()
    // {
    //     return $this->belongsTo('App\Student', 'id_terapeuta');
    // }

    public function supervisor()
    {
        return $this->belongsTo('App\Supervisor', 'id_supervisor');
    }

    public function patient()
    {
        return $this->belongsTo('App\Patient', 'id_paciente');
    }
}

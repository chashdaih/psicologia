<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partaker extends Model
{
    protected $table = 'participante';
    protected $primaryKey = 'num_cuenta';
    public $timestamps = false;

    protected $guarded = [];

    public function getFullNameAttribute() {
        return preg_replace('/\s+/', ' ',ucwords(mb_strtolower($this->nombre_part.' '.$this->ap_paterno.' '.$this->ap_materno)));
    }

    public function ess()
    {
        return $this->hasMany('App\Es', 'student_id', 'num_cuenta');
    }

    public function evaluation()
    {
        return $this->belongsTo('App\EvaluateStudent', 'num_cuenta', 'partaker_id');
    }

    public function tramites()
    {
        return $this->belongsTo('App\ProgramPartaker', 'num_cuenta', 'id_participante');
    }

    public function programs()
    {
        return $this->belongsToMany('App\Program', 'asigna_practica', 'id_participante', 'id_practica');
    }
}

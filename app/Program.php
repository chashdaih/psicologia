<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'practicas';
    protected $primaryKey = 'id_practica';

    public $timestamps = false;

    protected $guarded = [];
    
    public function center()
    {
        return $this->belongsTo(Center::class, 'id_centro', 'id_centro');
    }

    public function supervisor()
    {
        return $this->belongsTo('App\Supervisor', 'id_supervisor', 'id_supervisor');
    }

    public function partakers()
    {
        return $this->belongsToMany('App\Partaker', 'asigna_practica', 'id_practica', 'id_participante');
    }

    public function ie4s()
    {
        return $this->belongsToMany('App\Partaker', 'ie4s', 'program_id', 'partaker_id');
    }

    public function fe2s()
    {
        return $this->belongsToMany('App\Partaker', 'fe2s', 'program_id', 'partaker_id')->withPivot('evaluation_stage');
    }

    public function nas()
    {
        return $this->belongsToMany('App\Partaker', 'nas', 'program_id', 'provider_id');
    }

}

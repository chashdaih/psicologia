<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'practicas';
    protected $primaryKey = 'id_practica';

    public $timestamps = false;

    protected $guarded = [];

    protected $attributes = [
        'id_supervisord' => null,
        'coordinacion'=> '',
        'descripcion'=> '',
        'nombre_supervisor'=> '',
        'Piloto'=> 0,
        'problema'=> '',
        'semestre_activo'=> '2020-1', // TODO get global variable
        'tipo_programa'=> '', 
        'titulacion'=> 0,
        'convenio'=> '',
        'num_convenio'=> '',
        'horas_sem'=> '',
        'horario'=> '',
        'dias_pr'=> '',
        'escenario'=> '',
        'direccion'=> '',
        'semestre'=> '',
        'institucion'=> '',
        'car_esc'=> '',
        // estos datos si se llenan, pero ahora se permiten registros incompletos
        'cupo' => '0',
        // 'id_centro' => 'required',
        // 'id_supervisor' => 'required',
        'periodicidad' => '0',
        'programa' => '',
        // 'tipo' => 'required',
    ];
    
    public function center()
    {
        return $this->belongsTo('App\Building', 'id_centro', 'id_centro');
    }

    public function program_data()
    {
        return $this->hasOne('App\ProgramData', 'id_practica', 'id_practica');
    }

    public function supervisor()
    {
        return $this->belongsTo('App\Supervisor', 'id_supervisor', 'id_supervisor');
    }
    public function supervisord()
    {
        return $this->belongsTo('App\Supervisor', 'id_supervisord', 'id_supervisor');
    }

    public function partakers()
    {
        return $this->belongsToMany('App\Partaker', 'asigna_practica', 'id_practica', 'id_participante');
    }

    public function evaluations()
    {
        // return $this->belongsToMany('App\EvaluateStudent','participante', 'partaker_id', 'id_participante');
        return $this->belongsToMany('App\Partaker','evaluate_students', 'program_id', 'partaker_id');
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

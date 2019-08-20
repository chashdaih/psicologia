<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ps extends Model
{
    protected $guarded = [];
    // protected $fillable = ['created_at', 'user_id', 'FE3FDG_id', 'program_id', 'tipo_de_intervencion', 'modelo_psicoterapia', 'modalidad_de_servicio', 'sugerencias_de_intervencion', 'file_number'];
    protected $dates = ['created_at'];

    public function assign()
    {
        return $this->belongsTo('App\PatientAssign', 'assign_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}

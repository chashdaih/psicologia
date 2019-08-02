<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ps extends Model
{
    // protected $guarded = ['id', 'updated_at'];
    protected $fillable = ['created_at', 'user_id', 'FE3FDG_id', 'program_id', 'tipo_de_intervencion', 'modelo_psicoterapia', 'modalidad_de_servicio', 'sugerencias_de_intervencion', 'file_number'];
    protected $dates = ['created_at'];


    public function patient() {
        return $this->belongsTo(FE3FDG::class, 'FE3FDG_id', 'id');
    }

    public function program() {
        return $this->belongsTo(Program::class, 'program_id', 'id_practica');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class He extends Model
{
    protected $guarded = ['id', 'updated_at'];
    protected $dates = ['created_at'];

    protected $tiposEgreso = ['Alta/Cierre', 'Interrupción del tratamiento por mejoría', 'Interrupción del tratamiento sin mejoría', 'Alta con referencia', 'Primer contacto sin asistencia'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function assign()
    {
        return $this->belongsTo('App\PatientAssign', 'assign_id', 'id');
    }

    public function getEgresoAttribute() { return @$this->tiposEgreso[$this->egress_type]; }
}

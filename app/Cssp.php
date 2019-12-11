<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cssp extends Model
{
    protected $guarded = ['id', 'updated_at'];
    protected $dates = ['created_at'];

    protected $calidades = ['Excelente', 'Buena', 'Regular', 'Mala'];
    protected $utilidades = ['Sí, definitivamente', 'Sí, en general', 'Muy poco', 'Definitivamente no'];
    protected $ayudaProblemas = ['Sí, me ayudaron mucho', 'Sí, me aydaron algo', 'No me ayudaron', 'Definitivamente no me ayudaron'];
    protected $satisfacciones = ['Muy satisfecho/a', 'Moderadamente satisfecho', 'Algo insatisfecho/a', 'Muy insatisfecho'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function assign()
    {
        return $this->belongsTo('App\PatientAssign', 'assign_id', 'id');
    }

    public function getCalidadAttribute() { return @$this->calidades[$this->q1]; }
    public function getUtilidadAttribute() { return @$this->utilidades[$this->q2]; }
    public function getRecomendariaAttribute() { return @$this->utilidades[$this->q3]; }
    public function getAyudadoAttribute() { return @$this->ayudaProblemas[$this->q4]; }
    public function getSatisfechoAttribute() { return @$this->satisfacciones[$this->q5]; }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramPartaker extends Model
{
    protected $table = 'asigna_practica';
    protected $primaryKey = 'id_tramite';

    public $timestamps = false;

    protected $guarded = [];

    public function document()
    {
        return $this->belongsTo('App\Document', 'id_tramite', 'id_tramite');
    }

    public function program()
    {
        return $this->belongsTo('App\Program', 'id_practica', 'id_practica');
    }

    public function partaker()
    {
        return $this->belongsTo('App\Partaker', 'id_participante', 'num_cuenta');
    }
}

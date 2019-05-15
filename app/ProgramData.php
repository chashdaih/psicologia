<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramData extends Model
{
    protected $table = 'informacion_practicas';
    protected $primaryKey = 'id_practica';

    public $timestamps = false;

    protected $guarded = [];

    protected $attributes = [
        'metodologia'=> '',
        'recursos'=> '',
        'mec_int'=> '',
        'enfoque'=> '',
        'act_ac_sug'=> '',
        'rel_serv_psic'=> '',
        'lin_pract'=> '',
        'mod_sup'=> '',
        'competencias'=> '',
        'estra_ev_comp'=> '',
        'criterios_eva' => ''
    ];
}

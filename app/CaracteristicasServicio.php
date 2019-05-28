<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaracteristicasServicio extends Model
{
    protected $guarded = [];

    protected $attributes = [
        // 'fecha_inicio' => '',
        // 'fecha_fin' => '',
        'gen_horas_total' => '0',
        'serv_horas_total' => '0',
        'pacientes_semana' => '0',
        'minimo_pacientes_semestre' => '0',
    ];

    public $timestamps = false;
}

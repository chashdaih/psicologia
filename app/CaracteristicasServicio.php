<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaracteristicasServicio extends Model
{
    protected $guarded = [];

    protected $dates = ['fecha_inicio', 'fecha_fin'];

    protected $attributes = [
        // 'fecha_inicio' => '',
        // 'fecha_fin' => '',
        'gen_horas_total' => '0',
        'serv_horas_total' => '0',
        'pacientes_semana' => '0',
        'minimo_pacientes_semestre' => '0',
    ];

    public $timestamps = false;

    public function days()
    {
        $fields = ['gen_l', 'gen_ma', 'gen_mi', 'gen_j', 'gen_v', 'gen_s'];
        $week = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sábado'];

        $days = [];
        foreach ($fields as $key => $field) {
            if ($this->{$field}) {
                array_push($days, $week[$key]);
            }
        }
        $text = '';
        foreach ($days as $key => $day) {
            if ($key == 0) {
                $text = $day;
            } else {
                $app = ($key == count($days) - 1) ? ' y ' : ', ';
                $text = $text.$app.$day;
            }
        }
        return $text;
    }
}

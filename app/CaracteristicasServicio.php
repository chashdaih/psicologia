<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaracteristicasServicio extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $attributes = [
        'gen_l' => false
    ];
}

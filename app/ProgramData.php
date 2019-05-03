<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramData extends Model
{
    protected $table = 'informacion_practicas';
    protected $primaryKey = 'id_practica';

    public $timestamps = false;

    protected $guarded = [];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'terapeuta';
    protected $primaryKey = 'id_usuario';

    public function name()
    {
        return "hola";
    }

    public function appointment()
    {
        return $this->hasMany('App\Appointment');
    }
}

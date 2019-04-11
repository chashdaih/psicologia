<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'terapeuta';
    protected $primaryKey = 'id_usuario';

    public function getFullNameAttribute() {
        return $this->nombre_t.' '.$this->ap_paterno_t.' '.$this->ap_materno_t;
    }
}

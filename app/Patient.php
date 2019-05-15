<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'paciente';
    protected $primaryKey = 'id_paciente';

    public function getFullNameAttribute() {
        return $this->nombre.' '.$this->a_paterno.' '.$this->a_materno;
    }
}

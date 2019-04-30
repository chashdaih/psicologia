<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partaker extends Model
{
    protected $table = 'participante';
    protected $primaryKey = 'num_cuenta';

    public function getFullNameAttribute() {
        return $this->nombre_part.' '.$this->ap_paterno.' '.$this->ap_materno;
    }

    public function ess()
    {
        return $this->hasMany('App\Es', 'student_id', 'num_cuenta');
    }

}

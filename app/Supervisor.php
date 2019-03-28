<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    protected $table = 'supervisores';
    protected $primaryKey = 'id_supervisor';

    // protected $appends = ['full_name'];

    public function getFullNameAttribute() {
        return $this->nombre.' '.$this->ap_paterno.' '.$this->ap_materno;
    }
}

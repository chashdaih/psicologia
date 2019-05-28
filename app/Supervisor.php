<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    protected $table = 'supervisores';
    protected $primaryKey = 'id_supervisor';
    public $timestamps = false;

    protected $guarded = [];

    protected $attributes = [
        'estatus' => 'Activa',
        'password' => ''
    ];

    public function getFullNameAttribute() {
        return preg_replace('/\s+/', ' ',ucwords(mb_strtolower($this->nombre.' '.$this->ap_paterno.' '.$this->ap_materno)));
    }
    
    public function getPrimaryKeyAttribute() {
        return $this->id_supervisor;
    }
}

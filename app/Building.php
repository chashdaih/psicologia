<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $table = 'centros';
    protected $primaryKey = 'id_centro';

    public function getFullNameAttribute() {
        return $this->nombre;
    }
    public function getPrimaryKeyAttribute() {
        return $this->id_centro;
    }
}

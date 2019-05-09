<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluateStudent extends Model
{
    protected $guarded = [];

    public function partaker()
    {
        return $this->belongsTo('App\Partaker', 'partaker_id', 'id_participante');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Es extends Model
{
    protected $guarded = [];

    public function partaker()
    {
        return $this->belongsTo('App\Partaker', 'student_id', 'num_cuenta');
    }
}

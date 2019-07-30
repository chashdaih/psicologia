<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $guarded = [];

    public function fdg()
    {
        return $this->belongsTo('App\FE3FDG', 'fdg_id', 'id');
    }

}

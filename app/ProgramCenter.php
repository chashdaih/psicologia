<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramCenter extends Model
{
    protected $guarded = [];
    
    public function center()
    {
        return $this->belongsTo('App\Building', 'center_id', 'id_centro');
    }
}

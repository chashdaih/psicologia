<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupInSitu extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    
    
    public function supervisor()
    {
        return $this->belongsTo('App\Supervisor', 'reg_sup_id', 'id_supervisor');
    }
}

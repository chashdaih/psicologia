<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rs extends Model
{
    protected $guarded = ['id', 'updated_at'];
    protected $dates = ['created_at'];

    public function assign()
    {
        return $this->belongsTo('App\PatientAssign', 'assign_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    
}

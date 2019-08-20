<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cssp extends Model
{
    protected $guarded = ['id', 'updated_at'];
    protected $dates = ['created_at'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function assign()
    {
        return $this->belongsTo('App\PatientAssign', 'assign_id', 'id');
    }

}

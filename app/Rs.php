<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rs extends Model
{
    protected $guarded = ['id', 'updated_at'];
    protected $dates = ['created_at'];

    protected $attributes = [
        'created_at' => null,
        'patient_id' => 0,
        'supervisor_id' => 1,
        'session_number' => 1,
        'exist' => true
    ];
    
    public function patient() {
        return $this->belongsTo(FE3FDG::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cssp extends Model
{
    protected $guarded = ['id', 'updated_at'];
    protected $dates = ['created_at'];

    protected $attributes = [
        'created_at' => null,
        'patient_id' => 0,
        'file_number' => '',
        'q1' => 4,
        'q2' => 4,
        'q3' => 4,
        'q4' => 4,
        'q5' => 4,
        'o1' => '',
        'o2' => ''
    ];
    
    public function patient() {
        return $this->belongsTo(FE3FDG::class);
    }
}

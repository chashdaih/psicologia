<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fe3cdr extends Model
{
    protected $guarded = [];

    
    public function patient()
    {
        // return $this->belongsTo(FE3FDG::class, 'FE3FDG_id', 'id');
        return $this->belongsTo('App\Patient', 'patient_id', 'id_paciente');
    }
}

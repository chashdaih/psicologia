<?php

namespace App;

use \DateTime;
use Illuminate\Database\Eloquent\Model;

class FE3FDG extends Model
{
    protected $table = 'fe3fdg';
    protected $guarded = [];
    protected $dates = ['birthdate', 'tutor_birthdate_1', 'tutor_birthdate_2'];
    
    public function getFullNameAttribute()
    {
        return $this->name.' '.$this->last_name.' '.$this->mothers_name;
    }
    public function getIsUnderAgeAttribute()
    {
        return $this->birthdate->age < 18;
    }

    public function prev_program()
    {
        return $this->belongsTo(Building::class, 'unam_previous_treatment_program', 'id_centro');
    }

    public function assigned_program()
    {
        return $this->belongsTo(Building::class, 'program', 'id_centro');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'filler');
    }
    public function super_user()
    {
        return $this->belongsTo(User::class, 'supervisor');
    }


}

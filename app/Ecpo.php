<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ecpo extends Model
{
    protected $guarded = ['id'];
    protected $dates = ['created_at'];

    protected $attributes = [
        'student' => 0,
        'semester' => 1,
        'evaluation_phase' => 0,
        'q11' => 0,
        'q12' => 0,
        'q13' => 0,
        'q14' => 0,
        'q15' => 0,
        'q16' => 0,
        'q17' => 0,
        'q18' => 0,
        'q19' => 0,
        'q110' => 0,
        'q111' => 0,
        'q21' => 0,
        'q22' => 0,
        'q23' => 0,
        'q24' => 0,
        'q25' => 0,
        'q26' => 0,
        'q27' => 0,
        'q28' => 0,
        'q29' => 0,
        'q31' => 0,
        'q32' => 0,
        'q33' => 0,
        'q34' => 0,
        'q35' => 0,
        'q36' => 0,
        'q41' => 0,
        'q42' => 0,
        'q43' => 0,
        'q51' => 0,
        'q52' => 0,
        'q53' => 0,
        'q54' => 0,
        'q55' => 0,
        'q56' => 0,
        'q57' => 0,
        'q61' => 0,
        'q62' => 0,
        'q63' => 0,
        'q64' => 0,
        'q65' => 0,
        'q66' => 0,
        'q71' => 0,
        'q72' => 0,
        'q73' => 0,
    ];

    public function partaker()
    {
        return $this->belongsTo('App\Partaker', 'student', 'num_cuenta');
    }
    public function its_supervisor()
    {
        return $this->belongsTo(Supervisor::class, 'supervisor', 'id_supervisor');
    }
}

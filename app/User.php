<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class, 'number', 'num_trabajador');
    }

    public function partaker()
    {
        return $this->belongsTo('App\Partaker', 'number', 'num_cuenta');
    }
}

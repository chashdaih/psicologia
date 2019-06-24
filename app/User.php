<?php

namespace App;

use App\Notifications\MyResetPassword; 
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
        'type', 'email', 'password',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MyResetPassword($token));
    }

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
        return $this->belongsTo('App\Supervisor', 'email', 'correo');
    }

    public function partaker()
    {
        return $this->belongsTo('App\Partaker', 'email', 'num_cuenta');
    }
}

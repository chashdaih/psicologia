<?php

namespace App\Http\Controllers\Auth;

use App\Supervisor;
use App\Partaker;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $supervisors = Supervisor::whereRaw("num_trabajador REGEXP '^[0-9]+$'")->take(10)->get();

        // $supervisors = Supervisor::where('nombre', 'violeta')->get();
        // foreach ($supervisors as $supervisor) {
        //     User::create([
        //         'email' => $supervisor->correo,
        //         'number' => $supervisor->num_trabajador,
        //         'password' => Hash::make($supervisor->password),
        //         'type' => 2
        //     ]);
        // }
        
        $student = Partaker::where('num_cuenta', '408077109')->first();
        User::create([
            'email' => $student->correo,
            'number' => $student->num_cuenta,
            'password' => Hash::make($student->num_cuenta),
            'type' => 3
        ]);


        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}

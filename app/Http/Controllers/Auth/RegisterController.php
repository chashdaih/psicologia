<?php

namespace App\Http\Controllers\Auth;

use App\Building;
use App\Supervisor;
use App\User;
use App\Http\Controllers\Controller;
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
        $fields = [
            'type' => 'required|integer',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
        ];

        if($data['type'] == 2) {
            $fields = array_merge($fields,[
                'nombre' => 'required|string',
                'ap_paterno' => 'required|string',
                'ap_materno' => 'required|string',
                'num_trabajador' => 'required|string',
                'rfc' => 'required|string',
                'coordinacion' => 'required|string',
                'nombramiento' => 'required|string',
                'id_centro' => 'required|integer',
                'telefono' => 'required|string',
                'celular' => 'required|string',
            ]);
        }

        return Validator::make($data, $fields);
    }

    public function showRegistrationForm()
    {
        $buildings = Building::all();
        return view('auth.register', compact('buildings'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if ($data['type'] == 2) {
            Supervisor::create([
                'nombre' => $data['nombre'],
                'ap_paterno' => $data['ap_paterno'],
                'ap_materno' => $data['ap_materno'],
                'coordinacion' => $data['coordinacion'],
                'nombramiento' => $data['nombramiento'],
                'telefono' => $data['telefono'],
                'celular' => $data['celular'],
                'correo' => $data['email'],
                'num_trabajador' => $data['num_trabajador'],
                'rfc' => $data['rfc'],
                'tipo_supervisor' => $data['type'],
                'id_centro' => $data['id_centro'],
            ]);
        }

        return User::create([
            'type' => $data['type'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}

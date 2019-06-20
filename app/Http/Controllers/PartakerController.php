<?php

namespace App\Http\Controllers;

use App\Partaker;
use Illuminate\Http\Request;
use App\User;

class PartakerController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        return view('partaker.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'telefono' => 'required|string|max:15',
            'password' => 'required|confirmed|min:4',
            // 'password_confirmation' => 'required_with:password|string|min:4',
            'correo' => 'required|email',
            'nombre_part' => 'required|string|max:120',
            'ap_paterno' => 'required|string|max:120',
            'ap_materno' => 'required|string|max:120',
            'f_nac' => 'required|string|max:10',
            'telefono' => 'required|string|max:14',
            'sistema' => 'required|string|max:40',
            'sexo' => 'required|string|max:5',
            'semestre' => 'required|string|max:50'
        ]);

        Partaker::create([
            'num_cuenta' => $request['num_cuenta'],
            'nombre_part' => $request['nombre_part'],
            'ap_paterno' => $request['ap_paterno'],
            'ap_materno' => $request['ap_materno'],
            'f_nac' => $request['f_nac'],
            'telefono' => $request['telefono'],
            'correo' => $request['correo'],
            'semestre' => $request['semestre'],
            'sistema' => $request['sistema'],
            'programa_es' => '',
            'estatus' => 'Registrado',
            'sexo' => $request['sexo'],
            'registro_extemporaneo' => 0,
        ]);

        User::create([
            'type' => 3,
            'email' => $request['num_cuenta'],
            'password' => bcrypt($request['password']),
        ]);

        return redirect()->route('home')->with('success', 'Participante registrado exitosamente');

    }

    public function show(Partaker $partaker)
    {
        //
    }

    public function edit(Partaker $partaker)
    {
        //
    }

    public function update(Request $request, Partaker $partaker)
    {
        //
    }

    public function destroy(Partaker $partaker)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Partaker;
use Illuminate\Http\Request;
use App\User;

class PartakerController extends Controller
{
    public function index()
    {
        return view('partaker.index');
    }

    public function create()
    {
        return view('partaker.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'num_cuenta' => 'required|string|max:15|unique:participante',
            'password' => 'required|confirmed|min:4',
            // 'password_confirmation' => 'required_with:password|string|min:4',
            'correo' => 'nullable|email',
            'nombre_part' => 'nullable|string|max:120',
            'ap_paterno' => 'nullable|string|max:120',
            'ap_materno' => 'nullable|string|max:120',
            'f_nac' => 'nullable|string|max:10',
            'telefono' => 'nullable|string|max:14',
            'sistema' => 'nullable|string|max:40',
            'sexo' => 'nullable|string|max:5',
            'semestre' => 'nullable|string|max:50'
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

    // public function show(Partaker $partaker)
    // {
    // }

    public function edit(Partaker $partaker)
    {
        return view('partaker.create', compact('partaker'));
    }

    public function update(Request $request, Partaker $partaker)
    {
        $this->validate($request, [
            'correo' => 'nullable|email',
            'nombre_part' => 'nullable|string|max:120',
            'ap_paterno' => 'nullable|string|max:120',
            'ap_materno' => 'nullable|string|max:120',
            'f_nac' => 'nullable|string|max:10',
            'telefono' => 'nullable|string|max:14',
            'sistema' => 'nullable|string|max:40',
            'sexo' => 'nullable|string|max:5',
            'semestre' => 'nullable|string|max:50'
        ]);

        $partaker->update($request->all());

        return redirect()->route('home')->with('success', 'Los datos se han actualizado');
    }

    public function destroy(Partaker $partaker)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Partaker;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class PartakerController extends Controller
{
    public function index()
    {
        $partakers = Partaker::orderBy('nombre_part')->paginate(10);

        return view('partaker.index', compact('partakers'));
    }

    public function search($searchTerm)
    {
        $partakers = DB::table('participante as p')
            ->select('num_cuenta', DB::raw("CONCAT(p.nombre_part, ' ', p.ap_paterno, ' ', p.ap_materno) AS full_name"))
            ->where('nombre_part', 'LIKE', "%{$searchTerm}%")
            ->orWhere('ap_paterno', 'LIKE', "%{$searchTerm}%")
            ->orWhere('ap_materno', 'LIKE', "%{$searchTerm}%")
            ->orWhere('num_cuenta', 'LIKE', "%{$searchTerm}%")
            ->orderBy('nombre_part')->get();
            // ->limit(100)->get();

            return $partakers;

        // return $this->fixNames($partakers);
    }
    
    protected function fixNames($records)
    {
        if($records) {
            foreach ($records as $record) {
                $record->full_name = ucwords(mb_strtolower($record->full_name));
                // $record->full_name = preg_replace('/\s+/', ' ',ucwords(mb_strtolower($record->full_name)));
            }
        }
        return $records;
    }

    public function create()
    {
        $migajas = [route('home')=>'Inicio', route('partaker.index')=>'Participantes', '#'=>'Registrar participante'];
        return view('partaker.create', compact('migajas'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'num_cuenta' => 'required|string|max:15|unique:participante',
            'password' => 'required|confirmed|min:4',
            'correo' => 'required|email',
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
            'email' => $request['correo'],
            'password' => bcrypt($request['password']),
        ]);

        return redirect()->route('home')->with('success', 'Participante registrado exitosamente');

    }

    // public function show(Partaker $partaker)
    // {
    // }

    public function edit(Partaker $partaker)
    {
        $migajas = [route('home')=>'Inicio', route('partaker.index')=>'Participantes', '#'=>'Editar participante'];

        return view('partaker.create', compact('partaker', 'migajas'));
    }

    public function update(Request $request, Partaker $partaker)
    {
        $this->validate($request, [
            'correo' => 'required|email',
            'password' => 'nullable|confirmed|min:4',
            'nombre_part' => 'nullable|string|max:120',
            'ap_paterno' => 'nullable|string|max:120',
            'ap_materno' => 'nullable|string|max:120',
            'f_nac' => 'nullable|string|max:10',
            'telefono' => 'nullable|string|max:14',
            'sistema' => 'nullable|string|max:40',
            'sexo' => 'nullable|string|max:5',
            'semestre' => 'nullable|string|max:50'
        ]);

        // $fields = collect($request->except(['_token', '_method', 'correo', 'password']))->toArray();

        $partaker->update($request->except(['_token', '_method', 'correo', 'password', 'password_confirmation']));

        $user = User::where('email', $request['correo'])->first();

        if ($user) {
            $user->email = $request['correo'];
            if($request['password'] != null) {
               $user->password = bcrypt($request['password']);
            }
            $user->save();
        } else {
            $this->validate($request, [
                'password' => 'required|confirmed|min:4',
            ]);
            User::create([
                'type' => 3,
                'email' => $request['correo'],
                'password' => bcrypt($request['password']),
            ]);
        }

        return redirect()->route('partaker.edit', $partaker)->with('success', 'Los datos se han actualizado');
    }

    public function destroy(Partaker $partaker)
    {
        //
    }
}

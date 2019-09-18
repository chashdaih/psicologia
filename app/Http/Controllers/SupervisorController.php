<?php

namespace App\Http\Controllers;

use auth;
use App\Building;
use App\Supervisor;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupervisorController extends Controller
{

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

    public function index()
    {
        $center_id = 0;
        
        if (Auth::user()->type == 6) {
            $stages = Building::all();
        } else {
            $center_id = Auth::user()->supervisor->center->id_centro;
            $stages = Building::where('id_centro', $center_id)->get();
        }

        $supervisors = DB::table('supervisores as s')
            ->join('centros as c', 's.id_centro', '=', 'c.id_centro')
            ->when($center_id != 0, function($q) use ($center_id) {
                return $q->where('c.id_centro', $center_id);
            })
            ->select('s.id_supervisor', 'c.nombre as centro', 's.estatus', 'c.id_centro',
            DB::raw("CONCAT(s.nombre, ' ', s.ap_paterno, ' ', s.ap_materno) AS full_name"))
            ->orderBy('s.nombre', 'asc')
            ->get();
        $supervisors = $this->fixNames($supervisors);

        return view('supervisor.index', compact('supervisors', 'stages'));
    }

    // public function create() // se crean en register
    // {
    // }
    public function store(Request $request)
    {
        $fields = [
            'type' => 'required|integer',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
        ];

        if($request['type'] == 2) {
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

        $this->validate($request, $fields);

        if ($request['type'] == 2 || $request['type'] == 5 || $request['type'] == 6) {
            Supervisor::create([
                'nombre' => $request['nombre'],
                'ap_paterno' => $request['ap_paterno'],
                'ap_materno' => $request['ap_materno'],
                'coordinacion' => $request['coordinacion'],
                'nombramiento' => $request['nombramiento'],
                'telefono' => $request['telefono'],
                'celular' => $request['celular'],
                'correo' => $request['email'],
                'num_trabajador' => $request['num_trabajador'],
                'rfc' => $request['rfc'],
                'tipo_supervisor' => $request['type'],
                'id_centro' => $request['id_centro'],
            ]);
        }

        User::create([
            'type' => $request['type'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);

        return redirect()->route('home');
    }
    // public function show($id) // se podrán ver los datos en edit
    // {
    // }

    public function edit(Supervisor $supervisor)
    {
        $buildings = Building::where('id_centro', '<', 12)->get();

        $sup_types = [2=>'Supervisor', 5=>'Jefe de centro', 6=>'Coordinación'];

        return view('auth.register', compact('buildings', 'supervisor', 'sup_types'));
    }

    public function update(Request $request, Supervisor $supervisor)
    {
        $this->validate($request, [
            'nombre' => 'required|string',
            'ap_paterno' => 'required|string',
            'ap_materno' => 'required|string',
            'num_trabajador' => 'required|string',
            'rfc' => 'required|string',
            'coordinacion' => 'required|string',
            'nombramiento' => 'required|string',
            'id_centro' => 'required|integer',
            'telefono' => 'required|string',
            'celular' => 'required|string'
        ]);

        $supervisor->update($request->all());

        return redirect()->route('supervisor.edit', $supervisor)->with('success', 'Información actualizada exitosamente');
    }

    public function destroy($id)
    {
        //
    }

    public function changePassword($supId, Request $request)
    {
        if (Auth::user()->type > 5 || Auth::user()->supervisor->id_supervisor == $supId) {
            $this->validate($request, [
                'newPass' => 'required|string',
            ]);
            $newPass = $request['newPass'];
            $user = User::whereHas('supervisor', function($q) use ($supId) {
                $q->where('id_supervisor', $supId);
            })
            ->first();
            $user->password = bcrypt($newPass);
            $user->save();
            return response(200);
        } else {
            return response(401);
        }
    }


}
 
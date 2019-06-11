<?php

namespace App\Http\Controllers;

use auth;
use App\Building;
use App\Supervisor;
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
        // $user_type = Auth::user()->type;
        // dd($user_type);

        // $supervisors = Supervisor::all();
        $stages = Building::all();
        $supervisors = DB::table('supervisores as s')
            // ->where('estatus', '=', 'Activa')
            ->join('centros as c', 's.id_centro', '=', 'c.id_centro')
            ->select('s.id_supervisor', 'c.nombre as centro', 's.estatus',
            DB::raw("CONCAT(s.nombre, ' ', s.ap_paterno, ' ', s.ap_materno) AS full_name"))
            ->orderBy('s.nombre', 'asc')
            ->get();
        $supervisors = $this->fixNames($supervisors);

        return view('supervisor.index', compact('supervisors', 'stages'));
    }

    // public function create() // se crean en register
    // {
    // }
    // public function store(Request $request)
    // {
    // }
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
}
 
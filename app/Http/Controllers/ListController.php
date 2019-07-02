<?php

namespace App\Http\Controllers;

use Auth;
use App\Building;
use App\Partaker;
use App\ProgramPartaker;
use App\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
    
    public function filter($stage, $sup, $per) // webservice
    {
        // if(Auth::user()->supervisor->id_centro == 10) {
        if(Auth::user()->type == 2) {
            $stage = 0;
        }

        $records = DB::table('practicas as p')
        ->when($stage > 0, function ($query) use ($stage) {
            return $query->where('p.id_centro', '=', $stage);
        })
        ->when($sup > 0, function ($query) use ($sup) {
            return $query->where('p.id_supervisor', '=', $sup);
        })
        ->when($per != 0, function ($query) use ($per) {
            // dd($per);
            return $query->where('p.semestre_activo', '=', $per);
        })
        ->join('centros as c', 'p.id_centro', '=', 'c.id_centro')
        ->join('supervisores as s', 'p.id_supervisor', '=', 's.id_supervisor')
        ->select('p.id_practica', 'p.programa', 'p.semestre_activo', 'c.nombre as centro', 'p.tipo',
            DB::raw("CONCAT(s.nombre, ' ', s.ap_paterno, ' ', s.ap_materno) AS full_name"))
            ->orderBy('p.semestre_activo', 'desc')
        ->get();

        return $this->fixNames($records);
    }

    public function index()
    {
        $data = [];

        if (Auth::user()->type == 3) { // participante (estudiante)

            if (password_verify(Auth::user()->partaker->num_cuenta, Auth::user()->password)) {
                return view('auth.passwords.update');
            }

            $enroll_programs = ProgramPartaker::where('id_participante', Auth::user()->partaker->num_cuenta)
            ->where('ciclo_activo', '2020-1')
            ->get();

            $programs = null;

            if (!count($enroll_programs)) {
                $programs = DB::table('practicas as p')
                ->where('semestre_activo', '2020-1')
                ->where('cupo_actual','>', '0')
                ->where('tipo', 'EXTRACURRICULAR')
                ->join('supervisores as s', 'p.id_supervisor', 's.id_supervisor')
                ->join('informacion_practicas as i', 'p.id_practica', 'i.id_practica')
                ->join('centros as c', 'p.id_centro', 'c.id_centro')
                ->select('programa', 'periodicidad', 'p.horario', 'p.id_practica', 'c.nombre', 'i.resumen', 's.id_supervisor', 'c.id_centro',
                    DB::raw("CONCAT(s.nombre, ' ', s.ap_paterno, ' ', s.ap_materno) AS full_name")
                )->orderBy('programa', 'asc')
                ->get();
            }

            $data = compact('enroll_programs', 'programs'); 

        } else {
            
            $id_centro = Auth::user()->supervisor->id_centro;

            $data['records'] = $this->filter(0, Auth::user()->supervisor->id_supervisor, '2020-1');
            $user_type = Auth::user()->type;

            if ($user_type == 5) { // jefe de centro
                $supervisors = DB::table('supervisores')
                ->where('estatus', '=', 'Activa')
                ->where('id_centro', '=', Auth::user()->supervisor->id_centro)
                ->orderBy('nombre', 'asc')->select('id_supervisor', 
                DB::raw("CONCAT(nombre, ' ', ap_paterno, ' ', ap_materno) AS full_name"))->get();
                $data['supervisors'] = $this->fixNames($supervisors);
            }

            if($user_type == 6) { // coordinación
                $stages = Building::whereNotIn('id_centro', [10])->get();
                $data['stages'] = $stages;

                $supervisors = DB::table('supervisores')->where('estatus', '=', 'Activa')
                ->orderBy('nombre', 'asc')->select('id_supervisor', 
                DB::raw("CONCAT(nombre, ' ', ap_paterno, ' ', ap_materno) AS full_name"))->get();
                $data['supervisors'] = $this->fixNames($supervisors);
            }
        }

        return view('list', $data);
    }

    public function changePass(Request $request)
    {
        $this->validate(request(), [
            'nueva_contraseña' => 'required|string|min:4',
            'repetir_contraseña' => 'required_with:password|string|min:4',
        ]);
    
        request()->user()->fill([
            'password' => bcrypt(request()->input('nueva_contraseña'))
        ])->save();
        request()->session()->flash('success', 'Contraseña actualizada exitosamente');
    
        return redirect()->route('home');
    }

    public function update(Request $request)
    {
        $appointment_id = $request->id;
        $appointment = Appointment::where('id_cita', $appointment_id)->first();
        $appointment['asistencia'] = !$appointment['asistencia'];
        $appointment->save();
        return response(200);
    }

    public function enrollmentProof($tramit_id)
    {
        $programPartaker = ProgramPartaker::where('id_tramite', $tramit_id)->first();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
            
        $pdf->loadView('home.enrollment_proof', compact('programPartaker'));
        return $pdf->stream('comprobante_registro.pdf', array("Attachment" => 0));

    }


}

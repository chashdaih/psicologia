<?php

namespace App\Http\Controllers;

use Auth;
use App\Partaker;
use App\ProgramPartaker;
use App\Appointment;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $appointments = Appointment::where('fecha', '2019-03-02')->orderBy('hora', 'asc')->get();

        $data = [];

        if (Auth::user()->type == 3) { // participante (estudiante)
            $tramites = Auth::user()->partaker->tramites;
            // dd($tramites->document);  

            $enroll_programs = ProgramPartaker::where('id_participante', Auth::user()->partaker->num_cuenta)
            ->where('ciclo_activo', '2020-1')
            ->get();
            // dd($enroll_programs);

            $data = compact('tramites', 'enroll_programs');  
        }


        return view('list', $data);
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
        return $pdf->download('comprobante_registro.pdf');

    }


}

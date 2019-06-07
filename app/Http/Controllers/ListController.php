<?php

namespace App\Http\Controllers;

use Auth;
use App\Partaker;
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
            $data = compact('tramites');
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
}

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
        $appointments = Appointment::where('fecha', '2019-03-02')->orderBy('hora', 'asc')->get();

        return view('list', compact('appointments'));
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

<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $sql = "select distinct sala from cita";
        $cubicules = DB::select($sql);
        $schedules = ['8:00', '9:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00'];
        $appointments = Appointment::where('fecha', '2019-03-02')->orderBy('hora', 'asc')->get();
        $data = [];
        foreach ($cubicules as $c_id =>$cubicule) {
            $space = [];
            foreach ($schedules as $schedule) {
                foreach ($appointments as $appointment) {
                    if ($appointment->sala == $cubicule->sala && $appointment->hora == $schedule.':00') {
                        // TODO fix
                        $space[$schedule] = "ocupado";
                    } else {
                        $space[$schedule] = null;
                    }
                }
            }
            $data[$cubicule->sala] = $space;
        }
        return view('calendar', compact('data', 'schedules'));
    }
}

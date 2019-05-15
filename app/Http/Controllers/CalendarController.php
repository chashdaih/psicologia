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
        // $cubicules = ['c1', 'c2', 'c3', 'c4', 'c5'];
        $schedules = ['8:00', '9:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00'];
        // $appointments = Appointment::with(['supervisor'=> function($query) {$query->select('nombre');}])->where('fecha', '2019-03-02')->orderBy('hora', 'asc')->get();
        // $app_sql = "select c.id_cita, c.fecha, c.hora, c.sala, 
        //             concat(s.nombre, ' ', s.ap_paterno, ' ', ap_materno) as supervisor,
        //             concat(t.nombre_t, ' ', t.ap_paterno_t, ' ', t.ap_materno_t) as student 
        //             from cita as c 
        //             inner join supervisores as s on c.id_supervisor = s.id_supervisor
        //             inner join terapeuta as t on c.id_terapeuta = t.id_usuario
        //             ";
        $app_sql = "SELECT cita.id_cita, cita.fecha, cita.hora, cita.asistencia, centros.nombre, cita.sala, cita.observaciones, 
                    concat(participante.nombre_part,' ',participante.ap_paterno,' ',participante.ap_materno) as 'Terapeuta', 
                    concat(supervisores.nombre,' ',supervisores.ap_paterno,' ', supervisores.ap_materno) as 'Supervisor' 
                    from ((cita inner join centros on centros.id_centro=cita.id_centro) 
                    inner join supervisores on supervisores.id_supervisor=cita.id_supervisor) 
                    inner join participante on participante.num_cuenta=cita.id_terapeuta 
                    where cita.id_centro='2' and fecha ='2019-03-02'";
        $appointments = DB::select($app_sql);
        $data = [];
        foreach ($cubicules as $c_id =>$cubicule) {
            $space = [];
            foreach ($schedules as $schedule) {
                foreach ($appointments as $appointment) {
                    if ($appointment->sala == $cubicule->sala && $appointment->hora == $schedule.':00') {
                        // TODO fix
                        $space[$schedule] = json_encode((array)$appointment);
                    } else {
                        $space[$schedule] = "";
                    }
                }
            }
            $data[$cubicule->sala] = $space;
        }
        return view('calendar', compact('data', 'schedules'));
    }
}

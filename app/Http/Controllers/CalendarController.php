<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($fecha = null)
    {
        if (!$fecha) {
            $fecha = date("Y-m-d");
        }

        $sql = "select distinct sala from cita";
        // $cubicules = ['1', '2', '3', '4', '17', '19', '20', '21', '22', 'C?mara 5-6', 'C?mara 7-8', 'C?mara 9-10', 'C?mara 14-15'];
        $cubicules = ['1', '2', '3', '4', '17', '19', '20', '21', '22', '23', '24', '25', 'Cámara 5-6', 'Cámara 7-8', 'Cámara 9-10', 'Cámara 14-15'];
        $schedules = ['8:00:00', '9:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00', '18:00:00', '19:00:00'];

        $schs = array_fill(0, count($schedules), null);
        $calendarData = array_fill(0, count($cubicules), $schs);

        $appointments = DB::table('cita as c')
        ->where('c.fecha', '=', $fecha)
        ->join('supervisores as s', 'c.id_supervisor', 's.id_supervisor')
        ->select('id_cita', 'hora', 'id_terapeuta', 'sala',
            DB::raw("CONCAT(s.nombre, ' ', s.ap_paterno, ' ', s.ap_materno) AS full_name")
        )->get();

        $appointments = $this->fixNames($appointments);

        $supervisors = DB::table('supervisores as s')
        ->where('estatus', 'Activa')
        ->where('id_centro', 2)
        ->select('id_supervisor', DB::raw("CONCAT(s.nombre, ' ', s.ap_paterno, ' ', s.ap_materno) AS full_name"))
        ->get();
        $supervisors = $this->fixNames($supervisors);

        foreach ($appointments as $appointment) {
            $cubicule = array_search($appointment->sala, $cubicules);
            $time = array_search($appointment->hora, $schedules);
            $calendarData[$cubicule][$time] = $appointment; 
        }

        // dd($calendarData);

        return view('calendar.index', compact('cubicules', 'schedules', 'calendarData', 'supervisors', 'fecha')); 

    }

    public function getStudents($sup_id)
    {
        $ciclo_activo = '2019-2';
        $ciclo_anterior = '2019-1';

        $query = "SELECT num_cuenta, concat(participante.nombre_part,' ',participante.ap_paterno,' ',participante.ap_materno) as 'full_name' FROM (participante INNER JOIN asigna_practica on asigna_practica.id_participante=participante.num_cuenta ) INNER JOIN practicas ON practicas.id_practica=asigna_practica.id_practica WHERE practicas.id_supervisor = '".$sup_id."' and asigna_practica.estado <> 'Necesita Documentacion' and ((practicas.periodicidad= 'SEMESTRAL'and practicas.semestre_activo='".$ciclo_activo."')or(practicas.periodicidad= 'ANUAL' and practicas.semestre_activo='".$ciclo_anterior."')) order by full_name, ap_paterno, ap_materno";

        $students = DB::select($query);
        $students = $this->fixNames($students);
        return $students;
    }

    public function makeAppo(Request $request)
    {
        $this->validate($request, [
            'fecha' => 'required', 
            'hora' => 'required',
            'id_centro' => 'required',
            'id_especialidad' => 'required',
            'id_terapeuta' => 'required',
            'id_paciente' => 'required',
            'sala' => 'required',
            'id_supervisor' => 'required',
            'observaciones' => 'required',
            'servicio' => 'required',
            'tipo_espacio' => 'required',
            'uso_espacio' => 'required',
            'tipo_publico' => 'required',
            'asistencia' => 'required'
        ]);
        Appointment::create(collect($request)->toArray());
        return 200;
    }

    public function cancelAppo($id)
    {
        if ($id != "0"){
            $query = "DELETE FROM cita WHERE id_cita=".$id;
            $ans = DB::delete($query);
            return $ans;
        } else {
            return response("Es necesaria la id de cita", 409);
        }
    }

    protected function fixNames($records)
    {
        if($records) {
            foreach ($records as $record) {
                $record->full_name = preg_replace('/\s+/', ' ',ucwords(mb_strtolower($record->full_name)));
            }
        }
        return $records;
    }
}
<?php

namespace App\Http\Controllers;

use Auth;
use App\Appointment;
use App\Building;
use App\Partaker;
use App\Program;
use App\ProgramPartaker;
use App\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($center_id, $fecha = null)
    {
        if (!$fecha) {
            $fecha = date("Y-m-d");
        }

        $center = Building::where('id_centro', $center_id)->first();

        // $center_id = Auth::user()->supervisor->id_centro;
        $cubicules = null;
        $schedules = null;

        switch ($center_id) {
            case 1: // ayala
                $cubicules = ['1', '2', '3', '4', '5', '6', '7', '8'];
                $schedules = ['09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00', '18:00:00', '19:00:00', '20:00:00'];
                break;
            
            case 2: // dávila
                $cubicules = ['1', '2', '3', '4', '17', '19', '20', '21', '22', '23', '24', '25', 'Cámara 5-6', 'Cámara 7-8', 'Cámara 9-10', 'Cámara 14-15'];
                $schedules = ['08:00:00', '09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00', '18:00:00', '19:00:00'];
                break;
            
            case 3: // macgregor
                $cubicules = ['1', '2', '3', '4', '5', '6', 'Cámara 1', 'Cámara 2', 'Cámara 3', 'Salón de usos múltiples 1', 'Salón de usos múltiples 2', 'Sala de juntas'];
                $schedules = ['09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00', '18:00:00', '19:00:00', '20:00:00'];
                break;
            
            case 4: // volcanes
                $cubicules = ['1', '2', '3', '4', '5'];
                $schedules = ['09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00'];
                break;
            
            case 6: // call
                $cubicules = ['Línea 1', 'Línea 2', 'Línea 3', 'Línea 4', 'Línea 5', 'Línea 6', 'Línea 7', 'Línea 8', 'Línea 9', 'Línea 10', 'Línea 11', 'Línea 12', 'Línea 13', 'Línea 14', 'Línea 15', 'Línea 16', 'Línea 17', 'Línea 18', 'Línea 19', 'Línea 20', 'Línea 21', 'Línea 22', 'Línea 23', 'Línea 24', 'Línea 25', 'Línea 26', 'Línea 27', 'Línea 28', 'Línea 29', 'Línea 30'];
                $schedules = ['08:00:00', '09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00', '18:00:00', '19:00:00'];
                break;
            case 8: // derecho
            default:// volcanes
                $cubicules = ['1', '2', '3', '4', '5'];
                $schedules = ['09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00'];
                // break;
        }

        $schs = array_fill(0, count($schedules), null);
        $calendarData = array_fill(0, count($cubicules), $schs);

        $appointments = DB::table('cita as c')
        ->where('c.fecha', '=', $fecha)
        ->where('c.id_centro', '=', $center_id)
        ->join('supervisores as s', 'c.id_supervisor', 's.id_supervisor')
        ->select('id_cita', 'hora', 'id_terapeuta', 'sala',
            DB::raw("CONCAT(s.nombre, ' ', s.ap_paterno, ' ', s.ap_materno) AS full_name")
        )->get();

        $appointments = $this->fixNames($appointments);

        $supervisors = DB::table('supervisores as s')
        ->where('estatus', 'Activa')
        ->where('id_centro', $center_id)
        ->select('id_supervisor', DB::raw("CONCAT(s.nombre, ' ', s.ap_paterno, ' ', s.ap_materno) AS full_name"))
        ->get();
        $supervisors = $this->fixNames($supervisors);

        foreach ($appointments as $appointment) {
            $cubicule = array_search($appointment->sala, $cubicules);
            $time = array_search($appointment->hora, $schedules);
            $calendarData[$cubicule][$time] = $appointment; 
        }

        $centers = Building::where('id_centro', '<', 12)->where('id_centro', '!=', 10)->get();

        return view('calendar.index', compact('cubicules', 'schedules', 'calendarData', 'supervisors', 'fecha', 'center', 'centers')); 

    }

    public function getStudents($date, $sup_id)
    {

        $programs = Program::where('id_supervisor', $sup_id)
            ->whereHas('car_ser', function($q)  use ($date){
                // $q->where('fecha_inicio', '<', $date)
                // ->where('fecha_fin', '>', $date);
            })
            ->pluck('id_practica')->toArray();
        ;

        $assigned = ProgramPartaker::whereIn('id_practica', $programs)->pluck('id_participante')->toArray();

        // $partakers = Partaker::whereHas('tramites', function ($q) use ($programs) {
        //         $q->whereIn('id_practica', $programs);
        //     })
        //     ->get(['num_cuenta', 'nombre_part', 'ap_paterno', 'ap_materno']);

        $partakers = Partaker::whereIn('num_cuenta', $assigned)->get(['num_cuenta', 'nombre_part', 'ap_paterno', 'ap_materno']);

        return $partakers;
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
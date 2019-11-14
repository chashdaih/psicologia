<?php

namespace App\Http\Controllers;

use App\Supervisor;
use App\FE3FDG;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function reception($centerId)
    {
        return DB::table('fe3fdg as f')
        ->select('file_number as No. de expediente', 'f.created_at as Fecha de entrevista', DB::raw("CONCAT(s.nombre, ' ', s.ap_paterno, ' ', s.ap_materno) AS Nombresupervisor"), DB::raw("CONCAT(p.nombre_part, ' ', p.ap_paterno, ' ', p.ap_materno) AS Nombre_estudiante"), DB::raw("CONCAT(f.name, ' ', f.last_name, ' ', f.mothers_name) AS 'Nombre del paciente'"), 'birthdate as Fecha de nacimiento', 'genero.valor as Genero', 'edo_civil.valor as Estado civil', 'tutor_name_1 as En caso de ser menor de edad nombre del responsable', 'neighborhood as Alcaldía o municipio', DB::raw("Concat(COALESCE(house_phone, '-'), ' / ', COALESCE(work_phone, '-'), ' / ', COALESCE(cell_phone, '-')) as Teléfonos"), 'f.email as E-mail', 'nivel_estudios.valor as Nivel de estudios', 'has_work as Trabaja', 'work_description as Ocupación', 'monthly_family_income as Ingreso familiar', 'number_people_depending as Dependientes económicos', 'household_members as Número de integrantes del hogar contando al px', 'consultation_cause as Motivo consulta referido por el paciente', 'problem_since as Tiempo transcurrido en que comenzó la problemática', 'has_recived_previous_treatment as Tratamientos anteriores', 'atencion_recibida.valor as Tipo de atención recibida', 'refer as Fue referido', 'refer_where as De que institución fur canalizado', 'refer_problem as Diagnóstico de la institución de referencia', 'health_issue as Otros problemas de salud', 'takes_medication as Toma medicamentos', 'medication as Nombre del medicamento', 'horarios.valor as Horario de preferencia', 'practicas.programa as Programa', 'patient_assigns.created_at as Fecha de asignación')
        ->join('users as u', 'f.user_id', 'u.id')
        ->leftJoin('supervisores as s', 'u.email', 's.correo')
        ->leftJoin('participante as p', 'u.email', 'p.correo')
        ->join('genero', 'f.gender', 'genero.id')
        ->join('edo_civil', 'f.marital_status', 'edo_civil.id')
        ->join('nivel_estudios', 'f.scholarship', 'nivel_estudios.id')
        ->leftJoin('atencion_recibida', 'f.type_previous_treatment', 'atencion_recibida.id')
        ->join('horarios', 'f.prefer_time', 'horarios.id')
        ->leftJoin('patients as pat', 'f.id', 'pat.fdg_id')
        ->leftJoin('patient_assigns', function($leftJoin) {
            $leftJoin->on('pat.id', '=', 'patient_assigns.patient_id')
            ->where('patient_assigns.id', '=', DB::raw("(select max(id) from patient_assigns where patient_assigns.patient_id=pat.id)"));
        })
        ->leftJoin('practicas', 'patient_assigns.program_id', 'practicas.id_practica')
        ->where('center_id', $centerId)
        ->get();
        // return  FE3FDG::where('center_id', $centerId)->get();
    }

    public function receive(Request $request, $centerId)
    {
        $patient = FE3FDG::where('file_number', $request->fileNumber)->first();
        if (!$patient) {
            $patient = new FE3FDG();
        }

        if ($request->name) {
            $patient->name = $request->name;
        }

        $patient->save();

        return $patient;
    }

    public function supervisors()
    {
        return Supervisor::all();
    }
}

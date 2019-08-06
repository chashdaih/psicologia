<?php

namespace App\Http\Controllers;

use Auth;
use App\Building;
use App\FE3FDG;
use App\Patient;
use App\Program;
use App\ProgramPartaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = [];
        if (Auth::user()->type > 4) { // jefe de centro y coordinación

            // Esto es para la asignación de usuarios
            $data['porAsignar'] = Patient::where('cdr_id', '!=', 0)->where('ps_program_id', 0)->get();

            $data['centers'] = Building::all();
    
            $supervisors = DB::table('supervisores')->where('estatus', '=', 'Activa')
            ->orderBy('nombre', 'asc')->select('id_supervisor', 'id_centro',
            DB::raw("CONCAT(nombre, ' ', ap_paterno, ' ', ap_materno) AS full_name"))->get();
            $data['supervisors'] = $this->fixNames($supervisors);

        // Esto es para los usuarios ya asignados
            if (Auth::user()->type == 5) { // jefe de centro
                $data['asignados'] = DB::table('patients')
                ->where('ps_program_id', '!=', 0)
                ->join('practicas as p', 'patients.ps_program_id', 'p.id_practica')
                ->where('p.semestre_activo', config('globales.semestre_activo'))
                ->where('p.id_centro', Auth::user()->supervisor->center->id_centro)
                ->get();

                
                $data['porCdr'] = Patient::where('fdg_id', '!=', 0)
                    ->where('cdr_id', 0)
                    ->join('fe3fdg as fdg', 'patients.fdg_id', 'fdg.id')
                    ->where('fdg.center_id', Auth::user()->supervisor->id_centro)
                    ->get();

            } else { // coordinación
                $data['asignados'] = Patient::where('ps_program_id', '!=', 0)->get();
                $data['porCdr'] = Patient::where('cdr_id', 0)->get();
            }
        } else { // supervisores y alumnos

            $misPracticas = [];
            if (Auth::user()->type == 2) { // supervisor
                $programs = Program::where('semestre_activo', config('globales.semestre_activo'))
                ->where('id_supervisor', Auth::user()->supervisor->id_supervisor)
                ->pluck('id_practica')
                ->toArray();

                $inSitu = DB::table('sup_in_situs as sup')
                ->where('reg_sup_id', Auth::user()->supervisor->id_supervisor)
                ->join('practicas as p', 'sup.program_id', '=', 'p.id_practica')
                ->where('p.semestre_activo', config('globales.semestre_activo'))
                ->whereNotIn('p.id_practica', $programs)
                ->pluck('p.id_practica')
                ->toArray();

                $misPracticas = array_merge($programs, $inSitu);

            } else { // partaker
                $misPracticas = ProgramPartaker::where('id_participante', Auth::user()->partaker->num_cuenta)
                    ->where('ciclo_activo', config('globales.semestre_activo'))
                    ->pluck('id_practica')->toArray();
            }

            $data['asignados'] = Patient::where('ps_program_id', '!=', 0)
            ->join('practicas as p', 'patients.ps_program_id', 'p.id_practica')
            ->where('p.semestre_activo', config('globales.semestre_activo'))
            ->whereIn('p.id_practica', $misPracticas)
            ->get();

            $data['porCdr'] =Patient::where('fdg_id', '!=', 0)
                    ->where('cdr_id', 0)
                    ->join('fe3fdg as fdg', 'patients.fdg_id', 'fdg.id')
                    ->where('fdg.user_id', Auth::user()->id)
                    ->get();
            }

        return view('usuario.index', $data);
    }

    public function filterByEtapa($center_id, $supervisor_id, $etapa) // WS
    {

        $records = DB::table('practicas as p')
        ->when($center_id > 0, function ($query) use ($center_id) {
            return $query->where('p.id_centro', '=', $center_id);
        })
        ->when($supervisor_id > 0, function ($query) use ($supervisor_id) {
            return $query->where('p.id_supervisor', '=', $supervisor_id);
        })
        ->where('semestre_activo', config('globales.semestre_activo'))
        ->join('caracteristicas_servicios as c', 'p.id_practica', '=', 'c.program_id')
        ->select('p.id_practica', 'p.programa')
        ->where('c.'.$etapa, 1)
        ->orderBy('p.semestre_activo', 'desc')
        ->get();
        return $records;
    }

    public function assign(Request $request) // WS
    {
        // $etapa = $request->etapa;
        $user_id = $request->user_id;
        $program_id = $request->program_id;
        // $code = null;
        // switch ($etapa) {
        //     case 'primer_contacto':
        //         $code = 'cdr_program_id';
        //         break;
        //     case 'admision':
        //         $code = 'ps_program_id';
        //         break;
        //     case 'evaluacion':
        //         $code = 're_program_id';
        //         break;
        //     case 'orientacion':
        //         $code = 'rs6_program_id';
        //         break;
        //     case 'intervencion':
        //         $code = 'rs7_program_id';
        //         break;
        //     case 'egreso':
        //         $code = 'he_program_id';
        //         break;
        // }
        // if($code) {
        //     return Patient::where('id', $user_id)->update([$code => $program_id]);
        // } else {
        //     return 404;
        // }
        return Patient::where('id', $user_id)->update(['ps_program_id' => $program_id, 're_program_id' => $program_id, 'rs6_program_id'=>$program_id, 'rs7_program_id'=>$program_id, 'he_program_id'=>$program_id, 'cssp_program_id'=>$program_id]);
    }


    public function create()
    {
        $centers = Building::all();
        $migajas = [route('home') => 'Inicio', '#' => 'Nueva ficha de datos generales'];
        return view('usuario.create', compact('migajas', 'centers'));
    }


    public function store(Request $request)
    {
        // dd($request);
        $this->validateForm();
        $parameters = collect($request)->toArray() + ['user_id' => auth()->id()];
        $fdg = FE3FDG::create($parameters);
        Patient::create(['fdg_id' => $fdg->id]);
        return redirect()->route('usuario.index')->with('success', 'Usuario registrado exitosamente');
    }


    public function show($id)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $doc = $this->formatFdg($id);+
        $full_code = "3-FE3-FDG";
        $pdf->loadView('usuario.show', compact('doc', 'full_code'));
        return $pdf->stream('fdg.pdf');
    }


    public function edit($id)
    {
        $fdg = FE3FDG::where('id', $id)->first();
        $centers = Building::all();
        $migajas = [route('home') => 'Inicio', '#' => 'Nueva ficha de datos generales'];
        return view('usuario.create', compact('migajas', 'fdg', 'centers'));
    }


    public function update(Request $request, $id)
    {
        $this->validateForm();
        $values = collect($request->except(['_token', '_method']))->toArray();
        FE3FDG::where('id', $id)->update($values);
        return redirect()->route('usuario.index')->with('success', 'Ficha de datos generales actualizada exitosamente');
    }


    public function destroy($id)
    {
        //
    }

    public function subirDocumento(Request $request)
    {
        $this->validate($request, [
            'tipo_documento' => 'required|string',
            'patient_id' => 'required|numeric|min:1',
            'document' => 'required|mimes:pdf|max:14000',
        ]);
        $request->file("document")->storeAs('public/patients/'.$request->patient_id, $request->tipo_documento.'.pdf');

        return redirect()->route($request->tipo_documento.'.index', $request->patient_id)->with('success', 'Documento subido exitosamente');
    }

    public function bajarDocumento($patient_id, $clave)
    {
        return response()->download(public_path() . '/storage/patients/'.$patient_id.'/'.$clave.'.pdf');
    }


    protected function validateForm()
    {
        return $this->validate(request(), [
            'center_id' => 'required|integer|min:1|max:255',
            'other_filler' => 'nullable|string|max:255',
            'file_number' => 'required|string|max:255',
            'created_at' => 'required|date',
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mothers_name' => 'required|string|max:255',
            'curp' => 'required|string|max:255',
            'gender' => 'required|boolean',
            'birthdate' => 'required|date',
            'marital_status' => 'required|boolean',
            'is_unam' => 'required|boolean',
            'academic_entity' => 'nullable|string|max:255',
            'position' => 'nullable|integer|min:0|max:255',
            'career' => 'nullable|string|max:255',
            'semester' => 'nullable|string|max:255',
            'person_requesting' => 'required|integer|max:255',
            'name_requester' => 'nullable|string|max:255',
            //
            'tutor_name_1' => 'nullable|string|max:255', // TODO required_if age < 18 
            'relationship_1' => 'nullable|integer|max:255',
            'tutor_birthdate_1' => 'nullable|date',
            'studies_level_1' => 'nullable|integer|max:255',
            'occupation_1' => 'nullable|string|max:255',
            'tutor_name_2' => 'nullable|string|max:255',
            'relationship_2' => 'nullable|integer|max:255',
            'tutor_birthdate_2' => 'nullable|date',
            'studies_level_2' => 'nullable|integer|max:255',
            // 
            'street_name' => 'required|string|max:255',
            'external_number' => 'required|string|max:255',
            'internal_number' => 'nullable|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'house_phone' => 'nullable|string|max:255',
            'cell_phone' => 'nullable|string|max:255',
            'work_phone' => 'nullable|string|max:255',
            'work_phone_ext' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            //
            'scholarship' => 'required|integer|max:255',
            'studied_years' => 'required|integer|max:255',
            'has_work' => 'required|boolean',
            'who_depends_on' => 'nullable||string|max:255',
            'has_salary' => 'nullable|boolean',
            'work_description' => 'nullable|string|max:255',
            'household_members' => 'required|integer|max:255',
            'monthly_family_income' => 'required|string|max:255',
            'number_people_contributing' => 'required|integer|max:255',
            'number_people_depending' => 'required|integer|max:255',
            'house_is' => 'required|integer|max:255',
            //
            'service_type' => 'required|integer|max:255',
            'service_modality' => 'required||integer|max:255',
            'consultation_cause' => 'required|string',
            'mhGAP_cause_classification' => 'nullable|integer|max:255',
            'problem_since' => 'required|string|max:255',
            'has_recived_previous_treatment' => 'required|boolean',
            'number_times_treatment' => 'nullable|integer|max:255',
            'type_previous_treatment' => 'nullable|integer|max:255',
            'refer' => 'required|integer|max:255',
            'refer_problem' => 'nullable|string|max:255',
            'unam_previous_treatment' => 'required|boolean',
            'unam_previous_treatment_program' => 'nullable|integer|max:255',
            'has_health_issue' => 'required|boolean',
            'health_issue' => 'nullable|string|max:255',
            'takes_medication' => 'nullable|boolean',
            'medication' => 'nullable|string|max:255',
            'medication_dose' => 'nullable',
            'prefer_time' => 'required|integer|max:255',
        ]);
    }

    protected $marital_status = ['Soltero', 'Casado', 'Unión libre', 'Viudo', 'Separado'];
    protected $position = ['Estudiante', 'Académico', 'Administrativo'];
    protected $person_requesting = ['La persona', 'Padres o tutores', 'Otro familiar', 'Otro'];
    protected $relationship = ['de la madre', 'del padre', 'del tutor'];
    protected $studies_level = ['No cuenta con escolaridad', 'Preescolar', 'Primaria', 'Secundaria', 'Preparatoria', 'Licenciatura', 'Posgrado'];
    protected $house_is = ['Otra', 'Propia', 'Propia, pero la está pagando', 'Rentada', 'Prestada', 'Intestada o en litigio'];
    protected $service_type = ['Orientación/Consejo breve', 'Evaluación', 'Intervención'];
    protected $service_modality = ['Individual/Grupal', 'Familiar/Pareja'];
    protected $mhGAP_cause_classification = ['Depresión', 'Psicosis', 'Epilepsia', 'Transtornos mentales y conductuales del niño y el adolescente', 'Demencia', 'Transtornos por el consumo de sustancias', 'Autolesión/Suicidio', 'Otros padecimientos de salud importantes'];
    protected $type_previous_treatment = ['Psicológica', 'Psiquiátrica', 'Médica', 'Neurológica', 'Otra'];
    protected $refer = ['No', 'Escuela', 'Trabajo', 'Hospital/Instituto', 'Dpto. de Psiquiatría y Salud Mental (Fac. Medicina)', 'Otra'];
    protected $prefer_time = ['Matutino', 'Vespertino', 'Indiferente'];

    protected function formatFdg($id) {
        $fdg = FE3FDG::where('id', $id)->first();
        // dd($fdg);
        $fdg->marital_status = $this->marital_status[$fdg->marital_status];
        if ($fdg->position) {
            $fdg->position = $this->position[$fdg->position];
        }
        $fdg->person_requesting = $this->person_requesting[$fdg->person_requesting];
        if ($fdg->relationship_1) {
            $fdg->relationship_1 = $this->relationship[$fdg->relationship_1];
        }
        if ($fdg->studies_level_1) {
            $fdg->studies_level_1 = $this->studies_level[$fdg->studies_level_1];
        }
        if ($fdg->relationship_2) {
            $fdg->relationship_2 = $this->relationship[$fdg->relationship_2];
        }
        if ($fdg->studies_level_2) {
            $fdg->studies_level_2 = $this->studies_level[$fdg->studies_level_2];
        }
        $fdg->scholarship = $this->studies_level[$fdg->scholarship];
        $fdg->house_is = $this->house_is[$fdg->house_is];
        $fdg->service_type = $this->service_type[$fdg->service_type];
        $fdg->service_modality = $this->service_modality[$fdg->service_modality];
        // $fdg->mhGAP_cause_classification = $this->mhGAP_cause_classification[$fdg->mhGAP_cause_classification];
        if ($fdg->type_previous_treatment) {
            $fdg->type_previous_treatment = $this->type_previous_treatment[$fdg->type_previous_treatment];
        }
        $fdg->refer = $this->refer[$fdg->refer];
        $fdg->prefer_time = $this->prefer_time[$fdg->prefer_time];
        return $fdg;
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
}

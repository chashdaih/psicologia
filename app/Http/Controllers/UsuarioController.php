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
                ->where('p.semestre_activo', '2020-1')
                ->where('p.id_centro', Auth::user()->supervisor->center->id_centro)
                ->get();

                
                $data['porCdr'] = Patient::where('fdg_id', '!=', 0)
                    ->where('cdr_id', 0)
                    ->join('fe3fdg as fdg', 'patients.fdg_id', 'fdg.id')
                    ->where('fdg.center_id', Auth::user()->supervisor->id_centro)
                    ->get();

            } else {
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
            ->where('p.semestre_activo', '2020-1')
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
        ->where('semestre_activo', '2020-1')
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
        $fdg = $this->formatFdg($id);
        $pdf->loadView('usuario.show', compact('fdg'));
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
            'center_id' => 'required|numeric|min:1',
            'other_filler' => 'nullable|string',
            'name' => 'required',
            'last_name' => 'required',
            'mothers_name' => 'required',
            'curp' => 'required',
            'gender' => 'required',
            'birthdate' => 'required',
            'marital_status' => 'required',
            'is_unam' => 'required',
            'academic_entity' => 'nullable',
            'position' => 'nullable',
            'career' => 'nullable',
            'semester' => 'nullable',
            'person_requesting' => 'required',
            'name_requester' => 'nullable',
            //
            'tutor_name_1' => 'nullable', // TODO required_if age < 18 
            'relationship_1' => 'nullable',
            'tutor_birthdate_1' => 'nullable',
            'studies_level_1' => 'nullable',
            'occupation_1' => 'nullable',
            'tutor_name_2' => 'nullable',
            'relationship_2' => 'nullable',
            'tutor_birthdate_2' => 'nullable',
            'email' => 'nullable|email',
            'studies_level_2' => 'nullable',
            // 
            'street_name' => 'required',
            'external_number' => 'required',
            'internal_number' => 'nullable',
            'neighborhood' => 'required',
            'postal_code' => 'required',
            'municipality' => 'required',
            'state' => 'required',
            'house_phone' => 'nullable',
            'cell_phone' => 'nullable',
            'work_phone' => 'nullable',
            'work_phone_ext' => 'nullable',
            //
            'scholarship' => 'required',
            'studied_years' => 'required',
            'has_work' => 'required',
            'has_salary' => 'nullable',
            'work_description' => 'nullable',
            'household_members' => 'required',
            'monthly_family_income' => 'required',
            'number_people_contributing' => 'required|numeric',
            'number_people_depending' => 'required|numeric',
            'house_is' => 'required|numeric',
            //
            'service_type' => 'required|numeric',
            'service_modality' => 'required|numeric',
            'consultation_cause' => 'required',
            'mhGAP_cause_classification' => 'nullable|numeric',
            'problem_since' => 'required',
            'has_recived_previous_treatment' => 'required|boolean',
            'number_times_treatment' => 'nullable|numeric',
            'type_previous_treatment' => 'nullable|numeric',
            'refer' => 'required|numeric',
            'refer_problem' => 'nullable',
            'unam_previous_treatment' => 'required|boolean',
            'unam_previous_treatment_program' => 'nullable|numeric',
            'has_health_issue' => 'required|boolean',
            'health_issue' => 'nullable',
            'takes_medication' => 'nullable|boolean',
            'medication' => 'nullable',
            'medication_dose' => 'nullable',
            'prefer_time' => 'required|numeric',
            //
            'appointment_date' => 'nullable|date',
            'appointment_time' => 'nullable',
            'supervisor' => 'nullable|numeric',
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
    protected $refer = ['No', 'Escuela', 'Trabajo', 'Hospital/Instituto', 'Dpto. de Psiquiatría y Salud Mental (Fac. Medicina)'];
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

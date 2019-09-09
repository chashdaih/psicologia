<?php

namespace App\Http\Controllers;

use Auth;
use Excel;
use App\Building;
use App\FE3FDG;
use App\Patient;
use App\PatientAssign;
use App\Program;
use App\ProgramPartaker;
use App\Supervisor;

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
        $asignados = [];
        if (Auth::user()->type > 4) { // jefe de centro y coordinación

            

            $data['centers'] = Building::all();
    
            $supervisors = DB::table('supervisores')->where('estatus', '=', 'Activa')
            ->orderBy('nombre', 'asc')->select('id_supervisor', 'id_centro',
            DB::raw("CONCAT(nombre, ' ', ap_paterno, ' ', ap_materno) AS full_name"))->get();
            $data['supervisors'] = $this->fixNames($supervisors);

            if (Auth::user()->type == 5) { // jefe de centro

                $patients = Patient::where('status', 3)
                ->whereHas('assigned', function($q) {
                    $q->whereHas('program', function($r) {
                        $r->where('id_centro', Auth::user()->supervisor->id_centro);
                    });
                })
                ->get();

                $data['porCdr'] = Patient::where('fdg_id', '!=', 0)
                    ->where('cdr_id', 0)
                    ->whereHas('fdg', function($q) {
                        $q->where('center_id', Auth::user()->supervisor->id_centro);
                    })->get();

                $data['porAsignar'] = Patient::where('status', 2) // status 2 = necesita asignación
                    ->whereHas('fdg', function($q) {
                        $q->where('center_id', Auth::user()->supervisor->id_centro);
                    })
                ->get(); 
                    
            } else { // coordinación
                // $data['asignados'] = 
                $patients = Patient::where('status', 3)->get();
                $data['porCdr'] = Patient::where('cdr_id', 0)->get();

                $data['porAsignar'] = Patient::where('status', 2)->get(); // status 2 = necesita asignación
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

            // $data['asignados'] = 
            
            $patients = Patient::where('status', 3)
            ->whereHas('assigned', function($q) use ($misPracticas) {
                $q->whereHas('program', function($r) use ($misPracticas) {
                    $r->whereIn('id_practica', $misPracticas);
                });
            })
            ->get();
            // Patient::where('ps_program_id', '!=', 0)
            // ->whereHas('program', function($query) use ($misPracticas) {
            //     $query->where('semestre_activo', config('globales.semestre_activo'))
            //     ->whereIn('id_practica', $misPracticas);
            // })
            // ->get();

            $data['porCdr'] = Patient::where('fdg_id', '!=', 0)
            ->where('cdr_id', 0)
            ->whereHas('fdg', function($q) {
                $q->where('user_id', Auth::user()->id);
            })->get();
        }

        foreach ($patients as $patient) {
            $id = $patient->id;
            $file_number = $patient->fdg->file_number;
            $curp = $patient->fdg->curp;
            $programs = [];
            $supervisors = [];
            $centers = [];
            foreach ($patient->assigned as $ass) {
                if (!array_key_exists($ass->program->id_practica, $programs)) {
                    $programs[$ass->program->id_practica] = $ass->program->programa;
                    $supervisors[$ass->program->id_supervisor] = $ass->program->supervisor->full_name;
                    $centers[$ass->program->id_centro] = $ass->program->center->nombre;
                }
            }
            $asignado = compact('id', 'file_number', 'curp',  'programs', 'supervisors', 'centers');
            array_push($asignados, $asignado);
        }

        $data['asignados'] = $asignados;

        return view('usuario.index', $data);
    }

    // public function create()
    // {
    //     $centers = Building::all();
    //     $preferedCenter = null;
    //     if (Auth::user()->type == 3) { // participante
    //         $partaker_id = Auth::user()->partaker->num_cuenta;
    //         $partPrograms = ProgramPartaker::where('id_participante', $partaker_id)->where('ciclo_activo', config('globales.semestre_activo'))->first();
    //         if ($partPrograms) {
    //             $preferedCenter = $partPrograms->program->id_centro;
    //         }
    //     } else {
    //         $preferedCenter = Auth::user()->supervisor->id_centro;
    //     }
    //     $migajas = [route('home') => 'Inicio', '#' => 'Nueva ficha de datos generales'];
    //     return view('usuario.create', compact('migajas', 'centers', 'preferedCenter'));
    // }


    // public function store(Request $request)
    // {
    //     // dd($request);
    //     $this->validateForm();
    //     $parameters = collect($request)->toArray() + ['user_id' => auth()->id()];
    //     $fdg = FE3FDG::create($parameters);
    //     Patient::create(['fdg_id' => $fdg->id]);
    //     return redirect()->route('usuario.index')->with('success', 'Usuario registrado exitosamente');
    // }


    public function show($id) 
    {
        $patient= Patient::where('id', $id)->first();
        $data['patient'] = $patient;
        $data['migajas'] = [route('home') => 'Inicio', route('usuario.index') => 'Personas atendidas', '#' => 'Procesos'];

        if (Auth::user()->type > 4) {
            $supervisors = DB::table('supervisores')->where('estatus', '=', 'Activa')
                ->orderBy('nombre', 'asc')->select('id_supervisor', 'id_centro',
                DB::raw("CONCAT(nombre, ' ', ap_paterno, ' ', ap_materno) AS full_name"))->get();
            $data['supervisors'] = $this->fixNames($supervisors);
            $data['centers'] = Building::all();
        }

        return view('usuario.show', $data);
    }


    public function edit($id)
    {
        $fdg = FE3FDG::where('id', $id)->first();
        $centers = Building::all();
        $migajas = [route('home') => 'Inicio', '#' => 'Nueva ficha de datos generales'];
        return view('usuario.create', compact('migajas', 'fdg', 'centers'));
    }


    // public function update(Request $request, $id)
    // {
    //     $this->validateForm();
    //     $values = collect($request->except(['_token', '_method']))->toArray();
    //     FE3FDG::where('id', $id)->update($values);
    //     return redirect()->route('usuario.index')->with('success', 'Ficha de datos generales actualizada exitosamente');
    // }


    public function destroy($id)
    {
        if(Auth::user()->type < 4) {
            return response('Unauthorized.', 401);
        }

        $patient = Patient::findOrFail($id);
        if ($patient->status == 3) {
            $patient->status = 99; // status 99 = dado de baja
            $patient->save();
        } else {
            $patient->delete();
        }
        return response (200);
    }

    public function search($searchTerm)
    {
        return DB::table('patients as p')->join('fe3fdg as d', 'p.fdg_id', 'd.id')
            ->select('p.id', 'd.file_number', DB::raw("CONCAT(d.name, ' ', d.last_name, ' ', d.mothers_name) AS full_name"))
            ->where('d.file_number', 'LIKE', "%{$searchTerm}%")
            ->orWhere('d.name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('d.last_name', 'LIKE', "%{$searchTerm}%")
            ->orWhere('d.mothers_name', 'LIKE', "%{$searchTerm}%")
            ->orderBy('d.last_name')
            ->limit(20)
            ->get();

    }

    public function filterByEtapa($center_id, $supervisor_id, $etapa) // WS
    {
        if ($etapa == 'ps') {
            $etapa = 'admision';
        } else if ($etapa == 're') {
            $etapa = 'evaluacion';
        } else if ($etapa = 'rs6') {
            $etapa = 'orientacion';
        } else if ($etapa  = 'rs7') {
            $etapa = 'intervencion';
        }

        // $records = DB::table('practicas as p')
        // ->when($center_id > 0, function ($query) use ($center_id) {
        //     return $query->where('p.id_centro', '=', $center_id);
        // })
        // ->when($supervisor_id > 0, function ($query) use ($supervisor_id) {
        //     return $query->where('p.id_supervisor', '=', $supervisor_id);
        // })
        // ->where('semestre_activo', config('globales.semestre_activo'))
        // ->join('caracteristicas_servicios as c', 'p.id_practica', '=', 'c.program_id')
        // ->select('p.id_practica', 'p.programa')
        // ->where('c.'.$etapa, 1)
        // ->orderBy('p.semestre_activo', 'desc')
        // ->get();

        $records = Program::where('semestre_activo', config('globales.semestre_activo'))
        // ->whereHas('car_ser', function($query) use ($etapa) { // TODO 
        //     $query->where($etapa, 1);
        // })
        ->when($center_id > 0, function ($query) use ($center_id) {
            return $query->where('id_centro', '=', $center_id);
        })
        ->when($supervisor_id > 0, function ($query) use ($supervisor_id) {
            return $query->where('id_supervisor', '=', $supervisor_id);
        })
        ->get();

        // dd($records);

        return $records;
    }
    
    public function assign(Request $request) // WS
    {
        $etapa = $request->etapa;
        $program_id = $request->program_id;
        $patient_id = $request->patient_id;
        $assigner_id = Auth::user()->supervisor->id_supervisor;
        switch ($etapa) {
            case 'admision': // debe asignar admision, evaluación, intervención y egreso
                PatientAssign::create(['patient_id'=>$patient_id, 'assigner_id'=>$assigner_id, 'program_id'=>$program_id, 'process_code'=>'ps']);
                PatientAssign::create(['patient_id'=>$patient_id, 'assigner_id'=>$assigner_id, 'program_id'=>$program_id, 'process_code'=> 're']);
                PatientAssign::create(['patient_id'=>$patient_id, 'assigner_id'=>$assigner_id, 'program_id'=>$program_id, 'process_code'=> 'rs7']);
                PatientAssign::create(['patient_id'=>$patient_id, 'assigner_id'=>$assigner_id, 'program_id'=>$program_id, 'process_code'=> 'he']);
                PatientAssign::create(['patient_id'=>$patient_id, 'assigner_id'=>$assigner_id, 'program_id'=>$program_id, 'process_code'=> 'cssp']);
                break;
            case 'orientacion': // asignar orientación y egreso
            PatientAssign::create(['patient_id'=>$patient_id, 'assigner_id'=>$assigner_id, 'program_id'=>$program_id, 'process_code'=> 'rs6']);
            PatientAssign::create(['patient_id'=>$patient_id, 'assigner_id'=>$assigner_id, 'program_id'=>$program_id, 'process_code'=> 'he']);
            PatientAssign::create(['patient_id'=>$patient_id, 'assigner_id'=>$assigner_id, 'program_id'=>$program_id, 'process_code'=> 'cssp']);
                break;
            case 'egreso': // solo egreso
            PatientAssign::create(['patient_id'=>$patient_id, 'assigner_id'=>$assigner_id, 'program_id'=>$program_id, 'process_code'=> 'he']);
            PatientAssign::create(['patient_id'=>$patient_id, 'assigner_id'=>$assigner_id, 'program_id'=>$program_id, 'process_code'=> 'cssp']);
                break;
            // para la reasignación individual
            case 'ps':
            PatientAssign::create(['patient_id'=>$patient_id, 'assigner_id'=>$assigner_id, 'program_id'=>$program_id, 'process_code'=>'ps']);
                break;
            case 're':
            PatientAssign::create(['patient_id'=>$patient_id, 'assigner_id'=>$assigner_id, 'program_id'=>$program_id, 'process_code'=>'re']);
                break;
            case 'rs6':
            PatientAssign::create(['patient_id'=>$patient_id, 'assigner_id'=>$assigner_id, 'program_id'=>$program_id, 'process_code'=>'rs6']);
                break;
            case 'rs7':
            PatientAssign::create(['patient_id'=>$patient_id, 'assigner_id'=>$assigner_id, 'program_id'=>$program_id, 'process_code'=>'rs7']);
                break;
            default: 
                return 400;
        }
        Patient::where('id', $patient_id)->update(['status'=>3]); // status 3 = primera asignación
        return 200;
        // if($code) {
        //     return Patient::where('id', $user_id)->update([$code => $program_id]);
        // } else {
        //     return 404;
        // }
        // return Patient::where('id', $user_id)->update(['ps_program_id' => $program_id, 're_program_id' => $program_id, 'rs6_program_id'=>$program_id, 'rs7_program_id'=>$program_id, 'he_program_id'=>$program_id, 'cssp_program_id'=>$program_id]);
    }

    public function subirDocumento(Request $request)
    {
        $this->validate($request, [
            'tipo_documento' => 'required|string',
            'patient_id' => 'required|numeric|min:1',
            'document' => 'required|mimes:jpeg,bmp,png,gif,svg,pdf|max:14000',
        ]);
        $request->file("document")->storeAs('public/patients/'.$request->patient_id, $request->tipo_documento.'.pdf');

        return redirect()->route($request->tipo_documento.'.index', $request->patient_id)->with('success', 'Documento subido exitosamente');
    }

    public function bajarDocumento($patient_id, $clave, $id, $extension)
    {
        return response()->download(public_path() . '/storage/patients/'.$patient_id.'/'.$clave.'/'.$id.'.'.$extension);
    }
    
    public function programsExcel() // Esta función solo es para jefes / coordinación
    {
        $stage = Auth::user()->type == 5 ? Auth::user()->supervisor->center->id_centro : 0;

        Excel::create('Listado', function($excel) use ($stage) {
            $programs = Program::where('semestre_activo', config('globales.semestre_activo'))
                ->when($stage > 0, function ($query) use ($stage) {
                    return $query->where('id_centro', '=', $stage);
                })->orderBy('id_centro', 'asc')->orderBy('programa')->get();
            
            $excel->sheet('Hoja 1', function($sheet) use ($programs) {
                $row = 1;
                $encabezado = ['Programa', 'Centro', 'Dirección', 'Tipo', 'Nombre del supervisor', 'Adscripción', 'Nombramiento', 'Correo', 'Objetivo general', 'Tipo de servicio', 'Problemática atendida', 'Enfoque del servicio'];
                $servicios = ['primer_contacto'=>'Primer contacto', 'admision'=> 'Admisión', 'evaluacion'=>'Evaluación', 'orientacion'=>'Orientación', 'intervencion'=>'Intervención', 'egreso'=>'Egreso'];
                $problematicas = ['depresion'=>'Depresión', 'duelo'=>'Duelo', 'psicosis'=>'Psicosis', 'demencia'=>'Demencia', 'emocionales_niños'=>'Trastornos emocionales niños', 'emocionales_ad'=>'Trastornos emocionales adolescentes', 'desarrollo_niños'=>'Trastornos del desarrollo niños', 'desarrollo_ad'=>'Trastornos del desarrollo adolescentes', 'conductuales_niños'=>'Trastornos conductuales niños', 'conductuales_ad'=>'Trastornos conductuales adolescentes', 'autolesion'=>'Autolesión / suicidio', 'ansiedad'=>'Ansiedad', 'estres'=>'Estrés', 'sexualidad'=>'Sexualidad', 'violencia'=>'Violencia', 'sustancias'=>'Trastornos por el consumo de sustancias', 'p_intervencion'=>'Intervención psicoeducativa'];
                $enfoqueServicio = ['Cognitivo-conductual', 'Conductual', 'Cognitivo', 'Sistémico', 'Psicodinámico', 'Humanista', 'Gestalt', 'Constructivista', 'Otro'];
                 

                $sheet->row($row, $encabezado);
                foreach ($programs as $program) {
                    $objetivo = $program->program_data?$program->program_data->objetivo_g:null;
                    $enfSer = $probAt = $servAt = null;
                    if ($program->car_ser) {
                        $servAt = $this->formatStringArray($program, $servicios);
                        $probAt = $this->formatStringArray($program, $problematicas);
                        $enfSer = $enfoqueServicio[$program->car_ser->enfoque_servicio];
                    }
                    $sheet->row(++$row, [
                        $program->programa,
                        $program->center->nombre,
                        $program->center->direccion,
                        $program->tipo,
                        $program->supervisor->full_name,
                        $program->supervisor->coordinacion,
                        $program->supervisor->nombramiento,
                        $program->supervisor->correo,
                        $objetivo,
                        $servAt,
                        $probAt,
                        $enfSer
                    ]);
                }
            });
        })->download('xlsx');
    }

    protected function formatStringArray($program, $fields)
    {
        $text = "";
        foreach ($fields as $key => $value) {
            $text .= $program->car_ser->{$key} ? $value.", ":"";
        }
        if ($text != "") {
            $text = substr($text, 0, -2);
        } 
        return $text;
    }

    protected function validateForm()
    {
        return $this->validate(request(), [
            'center_id' => 'required|integer|min:1|max:255',
            'other_filler' => 'nullable|string|max:255',
            'file_number' => 'nullable|string|max:255',
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

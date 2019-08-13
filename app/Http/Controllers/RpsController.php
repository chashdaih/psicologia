<?php

namespace App\Http\Controllers;

use Auth;
use Excel;
use Validator;
use App\Bread;
use App\Building;
use App\CaracteristicasServicio;
use App\CriteriosAcr;
use App\Document;
use App\EvaluateStudent;
use App\Notifications\ProgramRegistered;
use App\Partaker;
use App\Program;
use App\ProgramaSemana;
use App\ProgramData;
use App\ProgramPartaker;
use App\Rps as Doc;
// use App\Mail\RpsMail;
use App\Supervisor;
use App\SupInSitu;
use App\Http\Requests\StoreProgramData;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RpsController extends Controller
{
    protected $process = 'ie';
    protected $number = '1';
    protected $doc_code = 'rps';
    protected $base_url;
    protected $params;
    protected $user_id;
    
    protected $programFields = ['cupo', 'cupo_actual', 'id_centro', 'id_supervisor', 'periodicidad', 'programa', 'tipo'];

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::user()->type != 3) {
                $this->user_id = Auth::user()->supervisor->id_supervisor;
            }
            return $next($request);
        });
        $doc_code = $this->doc_code;
        $this->base_url = 'procedures.3.'.$this->process.'.'.$this->number.'.'.$doc_code;
        $mBread = new Bread($this->process, $this->process.$this->number, $this->doc_code);
        $bread = collect($mBread->bread_array);
        $this->params = compact('bread', 'doc_code');
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

    public function index()
    {
        $id_centro = Auth::user()->supervisor->id_centro;
        $user_type = Auth::user()->type;
        
        if ($user_type == 2) {
            $this->params['records'] = $this->filter(0, Auth::user()->supervisor->id_supervisor, config('globales.semestre_activo'));
        } else {
            $this->params['records'] = $this->filter($id_centro, Auth::user()->supervisor->id_supervisor, config('globales.semestre_activo'));
        }

        if ($user_type == 5) { // jefe de centro
            $supervisors = DB::table('supervisores')
            ->where('estatus', '=', 'Activa')
            ->where('id_centro', '=', Auth::user()->supervisor->id_centro)
            ->orderBy('nombre', 'asc')->select('id_supervisor', 
            DB::raw("CONCAT(nombre, ' ', ap_paterno, ' ', ap_materno) AS full_name"))->get();
            $this->params['supervisors'] = $this->fixNames($supervisors);
        }

        if($user_type == 6) { // coordinación
            $stages = Building::all();
            $this->params['stages'] = $stages;

            $supervisors = DB::table('supervisores')->where('estatus', '=', 'Activa')
            ->orderBy('nombre', 'asc')->select('id_supervisor', 
            DB::raw("CONCAT(nombre, ' ', ap_paterno, ' ', ap_materno) AS full_name"))->get();
            $this->params['supervisors'] = $this->fixNames($supervisors);
        }

        return view($this->base_url.'.index', $this->params);
    }

    protected function getBuildingIf() {
        // return Building::when(Auth::user()->supervisor->id_centro == 10, function($query) {
        //     return $query->where('id_centro', '>', 11);
        // }, function ($query) {
        //     return $query->where('id_centro', '<', 12)->whereNotIn('id_centro', [10]);
        // })
        // ->get();
        return Building::where('id_centro', '!=', 10)->get();
    }

    protected function getFormatedSupervisors()
    {
        $supervisors = DB::table('supervisores')->where('estatus', '=', 'Activa')
            ->orderBy('nombre', 'asc')->select('id_supervisor', 
            DB::raw("CONCAT(nombre, ' ', ap_paterno, ' ', ap_materno) AS full_name"))
            ->get();
        
        return $this->fixNames($supervisors);
    }

    public function create()
    {
        $buildings = $this->getBuildingIf();
        // dd($buildings);
        $this->params['buildings']= $buildings;

        // $supervisors = DB::table('supervisores')->where('estatus', '=', 'Activa')
        //     ->orderBy('nombre', 'asc')->select('id_supervisor', 
        //     DB::raw("CONCAT(nombre, ' ', ap_paterno, ' ', ap_materno) AS full_name"))->get();
        $this->params['supervisors'] = $this->getFormatedSupervisors();//$this->fixNames($supervisors);

        $this->params['user_id'] = $this->user_id;

        return view($this->base_url.'.create', $this->params);
    }

    public function store(StoreProgramData $request)
    {
        // dd($request);

        $request['cupo_actual'] = $request['cupo'];

        $program = Program::create( collect($request->only($this->programFields))
        ->filter(function($value) {
            return null !== $value;
        })->toArray());

        // dd($program);

        $program_id = $program->id_practica;

        $request['id_practica'] = $request['program_id'] = $program_id;

        $programData = ProgramData::create(collect($request->only(['resumen', 'justificacion', 'objetivo_g', 
        'objetivo_es', 'cont_tematico', 'requisitos',
        'referencias', 'estra_ev_imp', 'asig_emp', 'id_practica']))
        ->filter(function($value) {
            return null !== $value;
        })->toArray()
        );

        CaracteristicasServicio::create(
            collect($request->only([
                'fecha_inicio', 'fecha_fin', 'gen_horas_total', 'gen_l', 'gen_hora_l', 'gen_ma', 'pre_pos', //'pre', 'pos',
                'quinto', 'sexto', 'septimo', 'octavo', 'especialidad', 'maestria', 'doctorado',
                'gen_hora_ma', 'gen_mi', 'gen_hora_mi', 'gen_j', 'gen_hora_j', 'gen_v', 'gen_hora_v', 'gen_s',
                'gen_hora_s', 'serv_horas_total', 'serv_l', 'serv_hora_l', 'serv_ma', 'serv_hora_ma', 'serv_mi',
                'serv_hora_mi', 'serv_j', 'serv_hora_j', 'serv_v', 'serv_hora_v', 'serv_s', 'serv_hora_s',
                'pacientes_semana', 'minimo_pacientes_semestre', 'primer_contacto', 'admision', 'evaluacion', 'orientacion',
                'intervencion', 'egreso', 'otro_servicio', 'depresion', 'duelo', 'psicosis', 'epilepsia', 'demencia', 'emocionales_niños',
                'emocionales_ad', 'desarrollo_niños', 'desarrollo_ad', 'conductuales_niños', 'conductuales_ad', 'autolesion', 'ansiedad',
                'estres', 'sexualidad', 'violencia', 'sustancias', 'p_intervencion', 'otra_problematica', 'enfoque_servicio', 'otro_enfoque',
                'individual', 'grupal', 'colaborativa', 'indirecta', 'directa', 'supervision_otra', 'observacion',
                'juego_roles', 'modelamiento', 'moldeamiento', 'cascada', 'auto_supervision', 'equipo_reflexivo',
                'con_colegas', 'analisis_caso', 'ensenanza_otra', 'fundamentales', 'entrevista', 'c_evaluacion',
                'impresion_diagnostica', 'implementacion_intervenciones', 'integracion_expediente', 'elaboracion_documentos',
                'competencias_otra', 'formativa', 'integrativa', 'contextual', 'holistica', 'plural', 'reflexiva', 'program_id'
            ]))->filter(function($value) {
                return null !== $value;
            })->toArray()
        );

        // programa semana
        foreach ($request['semana'] as $key => $value) {
            if ($value != null) {
                $semana = $value;
                $actividad = $request['actividad'][$key];
                $competencias = $request['competencias'][$key];
                ProgramaSemana::create(compact('program_id', 'semana', 'actividad', 'competencias'));
            }
        }

        // criterios acreditación
        foreach ($request['criterio'] as $key => $value) {
            if ($value != null) {
                $criterio = $value;
                $cuando = $request['cuando'][$key];
                $como = $request['como'][$key];
                CriteriosAcr::create(compact('program_id', 'criterio', 'cuando', 'como'));
            }
        }

        // new in situ
        foreach ($request['full_name'] as $key => $value) {
            if ($value != null) { // tiene nombre, por tanto es nuevo
                $full_name = $value;
                $ascription = $request['ascription'][$key];
                $nomination = $request['nomination'][$key];
                $phone = $request['phone'][$key];
                $cellphone = $request['cellphone'][$key];
                $email = $request['email'][$key];
                $worker_number = $request['worker_number'][$key];
                SupInSitu::create(compact('program_id', 'full_name', 'ascription',
                 'nomination', 'phone', 'cellphone', 'email', 'worker_number'));
            } else { // no tiene nombre, ya está registrado
                $reg_sup_id =  $request['reg_sup_id'][$key];
                SupInSitu::create(compact('program_id', 'reg_sup_id'));
            }
        }

        // Auth::user()->notify(new ProgramRegistered($program_id));

        return redirect()->route('home')->with('success', 'El programa se registró exitosamente');//route($this->doc_code.'.index');
    }

    public function cloneProgram()
    {
        $id = request()->id_practica;

        if ($id) {
            $ogProgram = Program::where('id_practica', $id)->first();
            if ($ogProgram == null) {
                return 404;
            }
            $cloneProgram = $ogProgram->replicate();
            $cloneProgram->programa = $ogProgram->programa.' - Duplicado';
            $cloneProgram->save();

            $ogProgramData = ProgramData::where('id_practica', $id)->first();
            $cloneProgramData = $ogProgramData->replicate();
            $cloneProgramData->id_practica = $cloneProgram->id_practica;
            $cloneProgramData->save();

            $ogCarSer = CaracteristicasServicio::where('program_id', $id)->first();
            $cloneCarSer = $ogCarSer->replicate();
            $cloneCarSer->program_id = $cloneProgram->id_practica;
            $cloneCarSer->save();

            $sups = SupInSitu::where('program_id', $id)->get();
            foreach ($sups as $sup) {
                $cloneSup = $sup->replicate();
                $cloneSup->program_id = $cloneProgram->id_practica;
                $cloneSup->save();
            }

            $acts = ProgramaSemana::where('program_id', $id)->get();
            foreach ($acts as $sup) {
                $cloneSup = $sup->replicate();
                $cloneSup->program_id = $cloneProgram->id_practica;
                $cloneSup->save();
            }

            $crits = CriteriosAcr::where('program_id', $id)->get();
            foreach ($crits as $sup) {
                $cloneSup = $sup->replicate();
                $cloneSup->program_id = $cloneProgram->id_practica;
                $cloneSup->save();
            }

            return response()->json([
                'id_practica' => $cloneProgram->id_practica,
                'programa' => $cloneProgram->programa,
                'semestre_activo' => $cloneProgram->semestre_activo,
                'centro' => $cloneProgram->center->nombre,
                'tipo' => $cloneProgram->tipo,
                'full_name' => $cloneProgram->supervisor->full_name
            ]);

        } else {
            return 400;
        }
    }

    public function edit($id)
    {

        $program = Program::where('id_practica', $id)->first();
        if ($program->semestre_activo != '2020-1') { // TODO filtrar por string comienza con 20
            return redirect('http://test.psicologiaunam.com/intranet/modificar_programa.php?id='.$id);
        }
        $this->params['program'] = $program;

        $buildings = $this->getBuildingIf(); //Building::all();
        $this->params['buildings']= $buildings;

        // $supervisors = Supervisor::distinct('correo')
        // ->where('id_centro', Auth::user()->supervisor->id_centro)->orderBy('nombre', 'asc')->get();
        $this->params['supervisors'] =  $this->getFormatedSupervisors();//$supervisors;
        // dd($supervisors);

        $inf_prac = ProgramData::where('id_practica', $id)->first();
        $this->params['inf_prac'] = $inf_prac;

        $car_serv = CaracteristicasServicio::where('program_id', $id)->first();
        $this->params['car_serv'] = $car_serv;

        $sups = SupInSitu::where('program_id', $id)->get();
        $this->params['sups'] = $sups;

        $acts = ProgramaSemana::where('program_id', $id)->get();
        $this->params['acts'] = $acts;

        $crits = CriteriosAcr::where('program_id', $id)->get();
        $this->params['crits'] = $crits;

        $this->params['user_id'] = $this->user_id;

        return view($this->base_url.'.create', $this->params);

    }

    public function update(StoreProgramData $request, $id)
    {
        $program =  Program::where('id_practica', $id)->first();
        $old_cupo = $program->cupo;
        $old_actual = $program->cupo_actual;
        $new_cupo = $request['cupo'];
        $dif_cupo = $new_cupo - $old_cupo;
        $request['cupo_actual'] = $old_actual + $dif_cupo;

        $this->validateProgram($request);
        
        $program->fill(
            collect($request->only($this->programFields))
                ->filter(function($value) {
                    return null !== $value;
                })
                ->toArray()
        );

        $program->save();

        $programData = collect($request->only(['resumen', 'justificacion', 'objetivo_g', 
        'objetivo_es', 'cont_tematico', 'requisitos',
        'referencias', 'estra_ev_imp', 'asig_emp']))
        ->filter(function($value) {
            return null !== $value;
        })
        ->toArray();

        if (count($programData)) {
            ProgramData::where('id_practica', $id)->update($programData);
        }

        $carSer = collect($request->only([
            'fecha_inicio', 'fecha_fin', 'gen_horas_total', 'gen_l', 'gen_hora_l', 'gen_ma', 'pre_pos', //'pre', 'pos',
            'quinto', 'sexto', 'septimo', 'octavo', 'especialidad', 'maestria', 'doctorado',
            'gen_hora_ma', 'gen_mi', 'gen_hora_mi', 'gen_j', 'gen_hora_j', 'gen_v', 'gen_hora_v', 'gen_s',
            'gen_hora_s', 'serv_horas_total', 'serv_l', 'serv_hora_l', 'serv_ma', 'serv_hora_ma', 'serv_mi',
            'serv_hora_mi', 'serv_j', 'serv_hora_j', 'serv_v', 'serv_hora_v', 'serv_s', 'serv_hora_s',
            'pacientes_semana', 'minimo_pacientes_semestre', 'primer_contacto', 'admision', 'evaluacion', 'orientacion',
            'intervencion', 'egreso', 'otro_servicio', 'depresion', 'duelo', 'psicosis', 'epilepsia', 'demencia', 'emocionales_niños',
            'emocionales_ad', 'desarrollo_niños', 'desarrollo_ad', 'conductuales_niños', 'conductuales_ad', 'autolesion', 'ansiedad',
            'estres', 'sexualidad', 'violencia', 'sustancias', 'p_intervencion', 'otra_problematica', 'enfoque_servicio', 'otro_enfoque',
            'individual', 'grupal', 'colaborativa', 'indirecta', 'directa', 'supervision_otra', 'observacion',
            'juego_roles', 'modelamiento', 'moldeamiento', 'cascada', 'auto_supervision', 'equipo_reflexivo',
            'con_colegas', 'analisis_caso', 'ensenanza_otra', 'fundamentales', 'entrevista', 'c_evaluacion',
            'impresion_diagnostica', 'implementacion_intervenciones', 'integracion_expediente', 'elaboracion_documentos',
            'competencias_otra', 'formativa', 'integrativa', 'contextual', 'holistica', 'plural', 'reflexiva', 'program_id'
        ]))
        ->filter(function($value, $key) {
            return null !== $value;
        })
        ->toArray();

        foreach (['gen_hora_l','gen_hora_ma', 'gen_hora_mi', 'gen_hora_j', 'gen_hora_v', 'gen_hora_s', 'serv_hora_l', 'serv_hora_ma', 'serv_hora_mi', 'serv_hora_j', 'serv_hora_v', 'serv_hora_s', ] as $value) {
            if(!array_key_exists($value, $carSer)) {
                $carSer[$value] = null;
            }
        }
        foreach (['gen_l', 'gen_ma', 'gen_mi', 'gen_j', 'gen_v', 'gen_s', 'serv_l', 'serv_ma', 'serv_mi', 'serv_j', 'serv_v', 'serv_s',
        'primer_contacto', 'admision', 'evaluacion', 'orientacion','intervencion', 'egreso',
        'depresion', 'duelo', 'psicosis', 'epilepsia', 'demencia', 'emocionales_niños','emocionales_ad', 'desarrollo_niños', 'desarrollo_ad', 'conductuales_niños', 'conductuales_ad', 'autolesion', 'ansiedad', 'estres', 'sexualidad', 'violencia', 'sustancias', 'p_intervencion',
        'individual', 'grupal', 'colaborativa', 'indirecta', 'directa',
        'observacion', 'juego_roles', 'modelamiento', 'moldeamiento', 'cascada', 'auto_supervision', 'equipo_reflexivo', 'con_colegas', 'analisis_caso',
        'fundamentales', 'entrevista', 'c_evaluacion', 'impresion_diagnostica', 'implementacion_intervenciones', 'integracion_expediente', 'elaboracion_documentos',
        'formativa', 'integrativa', 'contextual', 'holistica', 'plural', 'reflexiva', 
        ] as $value) {
            if(!array_key_exists($value, $carSer)) {
                $carSer[$value] = 0;
            }
        }

        if (count($carSer)){
            CaracteristicasServicio::where('program_id', $id)->update($carSer);
        }


        //insitu
        if (isset($request['full_name'])) {
            foreach ($request['full_name'] as $key => $value) {
                $reg_sup_id =  $request['reg_sup_id'][$key];
                $full_name = $value;
                $ascription = $request['ascription'][$key];
                $nomination = $request['nomination'][$key];
                $phone = $request['phone'][$key];
                $cellphone = $request['cellphone'][$key];
                $email = $request['email'][$key];
                $worker_number = $request['worker_number'][$key];
                $program_id = $id;
                if(isset($request['insitu']) && count($request['insitu']) > $key) {
                    $oldid = $request['insitu'][$key];
                    SupInSitu::where('id', $oldid)->update(compact('reg_sup_id', 'full_name', 'ascription',
                    'nomination', 'phone', 'cellphone', 'email', 'worker_number'));
                } else {
                    SupInSitu::create(compact('program_id', 'reg_sup_id', 'full_name', 'ascription',
                    'nomination', 'phone', 'cellphone', 'email', 'worker_number'));
                }
            }
        }

        // programa semana
        if (isset($request['semana'])) {
            foreach($request['semana'] as $key => $value)
            {
                if ($value != null) {
                    $semana = $value;
                    $actividad = $request['actividad'][$key];
                    $competencias = $request['competencias'][$key];
                    $program_id = $id;
                    
                    if(isset($request['acts']) && count($request['acts']) > $key) {
                        $oldid = $request['acts'][$key];
                        ProgramaSemana::where('id', $oldid)->update(compact('semana', 'actividad', 'competencias'));
                    } else {
                        ProgramaSemana::create(compact('program_id', 'semana', 'actividad', 'competencias'));
                    }
                }
            }
        }

        // criterios acreditación
        if (isset($request['criterio'])) {
            foreach ($request['criterio'] as $key => $value) {
                if ($value != null) {
                    $criterio = $value;
                    $cuando = $request['cuando'][$key];
                    $como = $request['como'][$key];
                    $program_id = $id;

                    if(isset($request['crits']) && count($request['crits']) > $key) {
                        $oldid = $request['crits'][$key];
                        CriteriosAcr::where('id', $oldid)->update(compact('criterio', 'cuando', 'como'));
                    } else {
                        CriteriosAcr::create(compact('program_id', 'criterio', 'cuando', 'como'));
                    }
                }
            }
        }

        return redirect()->route('home')->with('success', 'El programa se actualizó exitosamente');//route($this->doc_code.'.index');
    }
    

    public function destroy($id) // api
    {
        Program::where('id_practica', $id)->delete();
        ProgramData::where('id_practica', $id)->delete();
        CaracteristicasServicio::where('program_id', $id)->delete();
        ProgramaSemana::where('program_id', $id)->delete();
        CriteriosAcr::where('program_id', $id)->delete();
        SupInSitu::where('program_id', $id)->delete();
        // registros de estudiantes inscritos al programa
        EvaluateStudent::where('program_id', $id)->delete();
        $tramites = ProgramPartaker::where('id_practica', $id)->get();
        foreach ($tramites as $tramite) {
            Document::where('id_tramite', $tramite->id_tramite)->delete();
            $tramite->delete();
        }

        // TODO: ajax
        // return 200;

        return redirect()->route('home');//route($this->doc_code.'.index')->with('success', 'Programa borrado exitosamente');

    }

    public function show($id)
    {
        $this->preparePdf($id);

        return view($this->base_url.'.show', $this->params);
    }

    public function validateProgram($request)
    {
        $this->validate($request, [
            'cupo'=> 'nullable|integer|min:0',
            'cupo_actual'=> 'nullable|integer|min:0',
            'id_supervisor'=> 'required|integer|min:0',
            'periodicidad'=> 'required|integer|min:1|max:4',
            'programa'=> 'nullable',
            'tipo'=> 'nullable'
        ]);
    }

    public function pdf($id)
    {
        $program = Program::where('id_practica', $id)->first();
        if ($program->semestre_activo != '2020-1') { // TODO filtrar bien
            return redirect('http://test.psicologiaunam.com/intranet/imprimir_programa_practicas.php?id='.$id);
        }

        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $this->preparePdf($id);

        $pdf->loadView($this->base_url.'.show', $this->params);
        return $pdf->stream($this->doc_code.'.pdf');
    }

    protected function preparePdf($id)
    {
        $pre_pos = ['Pregrado', 'Posgrado'];
        $pre = [5=>'5to', '6to', '7mo', '8vo'];
        $pos = ['Especialidad', 'Maestría', 'Doctorado'];
        $enfoque_servicio = ['Cognitivo-conductual', 'Conductual', 'Cognitivo', 'Sistémico', 'Psicodinámico', 'Humanista', 'Gestalt', 'Constructivista', 'Otro'];
        
        $doc = Program::where('id_practica', $id)->first();
        $this->params['doc'] = $doc;

        $datos = ProgramData::where('id_practica', $id)->first();
        $this->params['datos'] = $datos;

        $car = CaracteristicasServicio::where('program_id', $id)->first();
        $car['pre_pos'] = $pre_pos[$car['pre_pos']];
        if ($car['pre']) {
            $car['pre'] = $pre[$car['pre']];
        }
        if ($car['pos']) {
            $car['pos'] = $pre[$car['pos']];
        }
        $car['enfoque_servicio'] = $enfoque_servicio[$car['enfoque_servicio']];
        $this->params['car'] = $car;

        $semanas = ProgramaSemana::where('program_id', $id)->get();
        $this->params['semanas'] = $semanas;

        $criteriosAc = CriteriosAcr::where('program_id', $id)->get();
        $this->params['criteriosAc'] = $criteriosAc;

        $supsInSitu = SupInSitu::where('program_id', $id)->get();
        $this->params['supsInSitu'] = $supsInSitu;
    }
    
    public function filter($stage, $sup, $per) // webservice
    {
        if(Auth::user()->supervisor->id_centro == 10) {
            $stage = 0;
        }

        $records = DB::table('practicas as p')
        ->when($stage > 0, function ($query) use ($stage) {
            return $query->where('p.id_centro', '=', $stage);
        })
        ->when($sup > 0, function ($query) use ($sup) {
            return $query->where('p.id_supervisor', '=', $sup);
        })
        ->when($per != 0, function ($query) use ($per) {
            // dd($per);
            return $query->where('p.semestre_activo', '=', $per);
        })
        ->join('centros as c', 'p.id_centro', '=', 'c.id_centro')
        ->join('supervisores as s', 'p.id_supervisor', '=', 's.id_supervisor')
        ->select('p.id_practica', 'p.programa', 'p.semestre_activo', 'c.nombre as centro', 'p.tipo',
            DB::raw("CONCAT(s.nombre, ' ', s.ap_paterno, ' ', s.ap_materno) AS full_name"))
            ->orderBy('p.semestre_activo', 'desc')
        ->get();

        return $this->fixNames($records);
    }

    protected function getInSituPrograms($reg_sup_id, $per)
    {
        $records = DB::table('sup_in_situs as sup')
        ->join('practicas as p', 'sup.program_id', '=', 'p.id_practica')
        ->join('centros as c', 'p.id_centro', '=', 'c.id_centro')
        ->join('supervisores as s', 'p.id_supervisor', '=', 's.id_supervisor')
        ->where('sup.reg_sup_id', $reg_sup_id)
        ->where('p.semestre_activo', $per)
        ->select('p.id_practica', 'p.programa', 'p.semestre_activo', 'c.nombre as centro', 'p.tipo',
            DB::raw("CONCAT(s.nombre, ' ', s.ap_paterno, ' ', s.ap_materno) AS full_name"))
            ->orderBy('p.semestre_activo', 'desc')
        ->get();

        dd($records);

    }

    public function rps_excel($stage, $sup, $per)
    {
        Excel::create('Listado', function($excel) use ($stage, $sup, $per) {
            $records = $this->filter($stage, $sup, $per);
            
            $excel->sheet('Hoja 1', function($sheet) use ($records) {
                $row = 2;
                $sheet->row(1, ['Total de programas: '.count($records)]);
                $sheet->row($row, [null, 'Programa', 'Centro', 'Curricular / Extracurricular', 'Nombre del supervisor', 'Número de participantes', 'Participantes SUA', 'Participantes escolarizados', ]);
                foreach ($records as $rec) {
                    $pp = ProgramPartaker::where('id_practica', $rec->id_practica)->where('estado', 'Inscrito')->get();
                    $inscritos = count($pp);
                    $sua = 0;
                    foreach ($pp as $p) {
                        if($p->partaker->sistema == 'SUA') {
                            $sua++;
                        }
                    }
                    $sheet->row(++$row, [
                        null,
                        $rec->programa,
                        $rec->centro,
                        $rec->tipo,
                        $rec->full_name,
                        $inscritos,
                        $sua,
                        $inscritos - $sua
                    ]);
                }
            });
        })->download('xlsx');
    }

    public function deleteRow($type, $id)
    {
        switch ($type) {
            case "sup":
                SupInSitu::where('id', $id)->delete();
                break;
            case "act":
                ProgramaSemana::where('id', $id)->delete();
                break;
            case "crit":
                CriteriosAcr::where('id', $id)->delete();
                break;
        }
        
        return 200;
    }

    public function partakers($id)
    {
        $program = Program::where('id_practica', $id)->first();
        $this->params['program'] = $program;

        $migajas = [route('home')=>'Inicio', '#'=>$program->programa];
        $this->params['migajas'] = $migajas;

        $pps = ProgramPartaker::where('id_practica', $id)->get();
        $this->params['pps'] = $pps;


        return view($this->base_url.'.partakers', $this->params);
    }

    public function document($id_tramite, $doc)
    {
        // dd(storage_path('/'));
        // return response()->download(asset('storage/'.$id_tramite . '/seguro.pdf'));

        return response()->download(public_path() . '/storage/' .$id_tramite . '/' . $doc . '.pdf');
    }
}
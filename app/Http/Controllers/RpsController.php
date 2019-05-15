<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Bread;
use App\Building;
use App\CaracteristicasServicio;
use App\CriteriosAcr;
use App\Program;
use App\ProgramaSemana;
use App\ProgramData;
use App\Rps as Doc;
use App\Supervisor;
use App\Http\Requests\StoreProgramData;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class RpsController extends Controller
{
    protected $process = 'ie';
    protected $number = '1';
    protected $doc_code = 'rps';
    protected $base_url;
    protected $params;
    
    protected $programFields = ['cupo_actual', 'id_centro', 'id_supervisor', 'id_supervisord', 'periodicidad', 'programa', 'tipo'];

    public function __construct()
    {
        $doc_code = $this->doc_code;
        $this->base_url = 'procedures.3.'.$this->process.'.'.$this->number.'.'.$doc_code;
        $mBread = new Bread($this->process, $this->process.$this->number, $this->doc_code);
        $bread = collect($mBread->bread_array);
        $this->params = compact('bread', 'doc_code');
    }

    public function index()
    {
        $records = Program::where('id_supervisor', Auth::user()->supervisor->id_supervisor)
                    ->orderBy('semestre_activo', 'desc')
                    ->get();
        
        $stages = $records->unique();

        $this->params['records'] = $records;
        $this->params['stages'] = $stages;

        return view($this->base_url.'.index', $this->params);
    }

    public function create()
    {
        $buildings = Building::all();
        $this->params['buildings']= $buildings;

        $supervisors = Supervisor::all();
        $this->params['supervisors'] = $supervisors;

        return view($this->base_url.'.create', $this->params);
    }

    public function store(StoreProgramData $request)
    {
        $request['cupo'] = $request['cupo_actual'];

        $program = Program::create($request->only($this->programFields));

        $program_id = $program->id_practica;

        $request['id_practica'] = $request['program_id'] = $program_id;

        $programData = ProgramData::create($request->only(['resumen', 'justificacion', 'objetivo_g', 
        'objetivo_es', 'cont_tematico', 'requisitos',
        'referencias', 'estra_ev_imp', 'asig_emp', 'id_practica']));

        CaracteristicasServicio::create(
            collect($request->only([
                'fecha_inicio', 'fecha_fin', 'gen_horas_total', 'gen_l', 'gen_hora_l', 'gen_ma', 'pre_pos', 'pre', 'pos',
                'gen_hora_ma', 'gen_mi', 'gen_hora_mi', 'gen_j', 'gen_hora_j', 'gen_v', 'gen_hora_v', 'gen_s',
                'gen_hora_s', 'serv_horas_total', 'serv_l', 'serv_hora_l', 'serv_ma', 'serv_hora_ma', 'serv_mi',
                'serv_hora_mi', 'serv_j', 'serv_hora_j', 'serv_v', 'serv_hora_v', 'serv_s', 'serv_hora_s',
                'pacientes_semana', 'minimo_pacientes_semestre', 'primer_contacto', 'admision', 'evaluacion', 'orientacion',
                'intervencion', 'egreso', 'depresion', 'duelo', 'psicosis', 'epilepsia', 'demencia', 'emocionales_niños',
                'emocionales_ad', 'desarrollo_niños', 'conductuales_niños', 'conductuales_ad', 'autolesion', 'ansiedad',
                'estres', 'sexualidad', 'violencia', 'sustancias', 'p_intervencion', 'enfoque_servicio', 'otro_enfoque',
                'individual', 'grupal', 'colaborativa', 'indirecta', 'directa', 'supervision_otra', 'observacion',
                'juego_roles', 'modelamiento', 'moldeamiento', 'cascada', 'auto_supervision', 'equipo_reflexivo',
                'con_colegas', 'analisis_caso', 'ensenanza_otra', 'fundamentales', 'entrevista', 'c_evaluacion',
                'impresion_diagnostica', 'implementacion_intervenciones', 'elaboracion_documentos', 'competencias_otra',
                'formativa', 'integrativa', 'contextual', 'holistica', 'plural', 'reflexiva', 'program_id'
            ]))->filter(function($value) {
                return null !== $value;
            })->toArray()
        );

        // programa semana
        foreach ($request['semana'] as $key => $value) {
            $semana = $value;
            $actividad = $request['actividad'][$key];
            $competencias = $request['competencias'][$key];
            ProgramaSemana::create(compact('program_id', 'semana', 'actividad', 'competencias'));
        }

        // criterios acreditación
        foreach ($request['criterio'] as $key => $value) {
            $criterio = $value;
            $cuando = $request['cuando'][$key];
            $como = $request['como'][$key];
            CriteriosAcr::create(compact('program_id', 'criterio', 'cuando', 'como'));
        }

        return redirect()->route($this->doc_code.'.index');
    }

    public function show($id)
    {
        $this->preparePdf($id);

        return view($this->base_url.'.show', $this->params);
    }

    public function pdf($id)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $this->preparePdf($id);

        $pdf->loadView($this->base_url.'.show', $this->params);
        return $pdf->download($this->doc_code.'.pdf');
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
    }
    
    public function filter($stage)
    {
        if ($stage == "0") {
            $records = Program::where('id_supervisor', Auth::user()->supervisor->id_supervisor)
                    ->orderBy('semestre_activo', 'desc')
                    ->get();
        } else {
            $records = Program::where('id_supervisor', Auth::user()->supervisor->id_supervisor)
                        ->where('escenario', $stage)
                        ->orderBy('semestre_activo', 'desc')
                        ->get();
        }
        return $records;
    }
}

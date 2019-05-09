<?php

namespace App\Http\Controllers;

use Auth;
use App\Bread;
use App\Building;
use App\CaracteristicasServicio;
use App\Option;
use App\Program;
use App\ProgramaSemana;
use App\ProgramData;
use App\Rps as Doc;
use App\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class RpsController extends Controller
{
    protected $process = 'ie';
    protected $number = '1';
    protected $doc_code = 'rps';
    protected $base_url;
    protected $params;

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
        // TODO decide what to do with old records
        $records = Program::where('id_supervisor', Auth::user()->supervisor->id_supervisor)
                    // ->where('semestre_activo', '2019-2')
                    ->orderBy('semestre_activo', 'desc')
                    ->get();
        
        $stages = $records->unique();

        // $records = Doc::where('supervisor_id', Auth::user()->supervisor->id_supervisor)->get();
        $this->params['records'] = $records;
        $this->params['stages'] = $stages;

        return view($this->base_url.'.index', $this->params);
    }

    public function create()
    {
        // $this->params['sections'] = $this->getSections();
        // $values = new Doc();
        // $values->supervisor_id = Auth::user()->supervisor->id_supervisor;
        // $this->params['values'] = $values;

        $buildings = Building::all();
        $this->params['buildings']= $buildings;

        $supervisors = Supervisor::all();
        $this->params['supervisors'] = $supervisors;

        return view($this->base_url.'.create', $this->params);
    }

    protected function getSections()
    {
        $json = file_get_contents(dirname(__DIR__, 2).'/fields/'.$this->doc_code.'.json');
        $fields = json_decode($json, true);

        $fields[0]['fields']['periodicidad']['options'] = [new Option(0, "semestral"), new Option(1, "anual")];

        return $fields;
    }

    public function store(Request $request)
    {
        // dd($request);
        $valProgram = $this->validateProgram($request);
        $valProgramData = $this->validateProgramData($request);
        $valCarSer = $this->validateCarSer($request);
        $valProgramaSemana = $this->validateProgramaSemana($request);

        $program = Program::create($valProgram);
        
        $valProgramData['id_practica'] = $valCarSer['program_id'] = $valProgramaSemana['program_id'] = $program->id_practica;
        $programData = ProgramData::create($valProgramData);
        $carSer = CaracteristicasServicio::create($valCarSer);
        $programaSemana = ProgramaSemana::create($valProgramaSemana);

        return redirect()->route($this->doc_code.'.index');
    }

    protected function validateProgram($request)
    {
        $valProgram =  $request->validate([
            'cupo' => 'required',
            'id_centro' => 'required',
            'id_supervisor' => 'required',
            'id_supervisord' => 'required',
            'periodicidad' => 'required',
            'programa' => 'required',
            'tipo' => 'required',
        ]);

        $valProgram['coordinacion'] = '';
        $valProgram['cupo_actual'] = $valProgram['cupo'];
        $valProgram['descripcion'] = '';
        $valProgram['nombre_supervisor'] = '';
        $valProgram['Piloto'] = 0;
        $valProgram['problema'] = '';
        $valProgram['semestre_activo'] = '2019-2'; // TODO get global variable
        $valProgram['tipo_programa'] = ''; 
        $valProgram['titulacion'] = 0;
        $valProgram['convenio'] = '';
        $valProgram['num_convenio'] = '';
        $valProgram['horas_sem'] = '';
        $valProgram['horario'] = '';
        $valProgram['dias_pr'] = '';
        $valProgram['escenario'] = '';
        $valProgram['direccion'] = '';
        $valProgram['semestre'] = '';
        $valProgram['institucion'] = '';
        $valProgram['car_esc'] = '';
        return $valProgram;
    }

    protected function validateProgramData($request)
    {
        $valProgramData = $request->validate([
            'resumen' => 'required',
            'justificacion'=> 'required',
            'objetivo_g' => 'required',
            'objetivo_es' => 'required',
            'cont_tematico' => 'required',
            'criterios_eva' => 'required',
            'requisitos' => 'required',
            'referencias' => 'required',
            'estra_ev_imp' => 'required',
            'asig_emp' => 'required',
        ]);
        
        $valProgramData['metodologia'] = '';
        $valProgramData['recursos'] = '';
        $valProgramData['mec_int'] = '';
        $valProgramData['enfoque'] = '';
        $valProgramData['act_ac_sug'] = '';
        $valProgramData['rel_serv_psic'] = '';
        $valProgramData['lin_pract'] = '';
        $valProgramData['mod_sup'] = '';
        $valProgramData['competencias'] = '';
        $valProgramData['estra_ev_comp'] = '';
        return $valProgramData;
    }

    protected function validateCarSer($request)
    {
        $valCarSer = $request->validate([
            'dirigido_a' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'gen_horas_total' => 'required',
            'gen_l'=> 'nullable',
            'gen_hora_l'=> 'nullable',
            'gen_ma'=> 'nullable',
            'gen_hora_ma'=> 'nullable',
            'gen_mi'=> 'nullable',
            'gen_hora_mi'=> 'nullable',
            'gen_j'=> 'nullable',
            'gen_hora_j'=> 'nullable',
            'gen_v'=> 'nullable',
            'gen_hora_v'=> 'nullable',
            'gen_s'=> 'nullable',
            'gen_hora_s'=> 'nullable',
            'serv_horas_total' => 'required',
            'serv_l'=> 'nullable',
            'serv_hora_l'=> 'nullable',
            'serv_ma'=> 'nullable',
            'serv_hora_ma'=> 'nullable',
            'serv_mi'=> 'nullable',
            'serv_hora_mi'=> 'nullable',
            'serv_j'=> 'nullable',
            'serv_hora_j'=> 'nullable',
            'serv_v'=> 'nullable',
            'serv_hora_v'=> 'nullable',
            'serv_s'=> 'nullable',
            'serv_hora_s'=> 'nullable',
            'pacientes_semana' => 'required',
            'minimo_pacientes_semestre' => 'required',
            'primer_contacto'=> 'nullable',
            'admision'=> 'nullable',
            'evaluacion'=> 'nullable',
            'orientacion'=> 'nullable',
            'intervencion'=> 'nullable',
            'egreso'=> 'nullable',
            //problematica atendida
            'depresion'=> 'nullable',
            'duelo'=> 'nullable',
            'psicosis'=> 'nullable',
            'epilepsia'=> 'nullable',
            'demencia'=> 'nullable',
            'emocionales_niños'=> 'nullable',
            'emocionales_ad'=> 'nullable',
            'desarrollo_niños'=> 'nullable',
            'conductuales_niños'=> 'nullable',
            'conductuales_ad'=> 'nullable',
            'autolesion'=> 'nullable',
            'ansiedad'=> 'nullable',
            'estres'=> 'nullable',
            'sexualidad'=> 'nullable',
            'violencia'=> 'nullable',
            'sustancias'=> 'nullable',
            'p_intervencion'=> 'nullable',
            'enfoque_servicio' => 'required',
            'otro_enfoque'=> 'nullable',
            // caracteristicas de la supervisión y evaluación
            'individual'=> 'nullable',
            'grupal'=> 'nullable',
            'colaborativa'=> 'nullable',
            'indirecta'=> 'nullable',
            'directa'=> 'nullable',
            'supervision_otra'=> 'nullable',
            // estratedias de enseñanza y supervisión
            'observacion'=> 'nullable',
            'juego_roles'=> 'nullable',
            'modelamiento'=> 'nullable',
            'moldeamiento'=> 'nullable',
            'cascada'=> 'nullable',
            'auto_supervision'=> 'nullable',
            'equipo_reflexivo'=> 'nullable',
            'con_colegas'=> 'nullable',
            'analisis_caso'=> 'nullable',
            'ensenanza_otra'=> 'nullable',
            // competencias profesionales a desarrollar
            'fundamentales'=> 'nullable',
            'entrevista'=> 'nullable',
            'c_evaluacion'=> 'nullable',
            'impresion_diagnostica'=> 'nullable',
            'implementacion_intervenciones'=> 'nullable',
            'elaboracion_documentos'=> 'nullable',
            'competencias_otra'=> 'nullable',
            // estrategias de evaluación de competencias
            'formativa'=> 'nullable',
            'integrativa'=> 'nullable',
            'contextual'=> 'nullable',
            'holistica'=> 'nullable',
            'plural'=> 'nullable',
            'reflexiva'=> 'nullable',
            // acreditación
            'cuando_acreditacion' => 'required',
            'como_acreditacion' => 'required',
        ]);
        return $valCarSer;
    }

    protected function validateProgramaSemana($request)
    {
        return $request->validate([
            'semana' =>'required',
            'actividad' => 'required',
            'competencias' => 'required'
        ]);
    }

    public function show($id)
    {
        $dirigido_a = ['5to', '6to', '7mo', '8vo', 'Especialidad', 'Maestría', 'Doctorado'];
        $enfoque_servicio = ['Cognitivo-conductual', 'Conductual', 'Cognitivo', 'Sistémico', 'Psicodinámico', 'Humanista', 'Gestalt', 'Constructivista', 'Otro'];

        // $sections = $this->getSections();
        // $this->params['sections'] = $sections;
        
        $doc = Program::where('id_practica', $id)
                // ->join('informacion_practicas', 'informacion_practicas.id_practica', '=', 'practicas.id_practica')
                ->first();
        $this->params['doc'] = $doc;
        $datos = ProgramData::where('id_practica', $id)->first();
        $this->params['datos'] = $datos;
        $car = CaracteristicasServicio::where('program_id', $id)->first();
        $car['dirigido_a'] = $dirigido_a[$car['dirigido_a']];
        $car['enfoque_servicio'] = $enfoque_servicio[$car['enfoque_servicio']];
        $this->params['car'] = $car;

        return view($this->base_url.'.show', $this->params);
    }

    public function pdf($id)
    {
        $dirigido_a = ['5to', '6to', '7mo', '8vo', 'Especialidad', 'Maestría', 'Doctorado'];
        $enfoque_servicio = ['Cognitivo-conductual', 'Conductual', 'Cognitivo', 'Sistémico', 'Psicodinámico', 'Humanista', 'Gestalt', 'Constructivista', 'Otro'];

        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        // $this->params['sections'] = $this->getSections();;
        $doc = Program::where('id_practica', $id)
                // ->join('informacion_practicas', 'informacion_practicas.id_practica', '=', 'practicas.id_practica')
                ->first();
        $this->params['doc'] = $doc;
        $datos = ProgramData::where('id_practica', $id)->first();
        $this->params['datos'] = $datos;
        $car = CaracteristicasServicio::where('program_id', $id)->first();
        $car['dirigido_a'] = $dirigido_a[$car['dirigido_a']];
        $car['enfoque_servicio'] = $enfoque_servicio[$car['enfoque_servicio']];
        $this->params['car'] = $car;

        $pdf->loadView($this->base_url.'.show', $this->params);
        return $pdf->download($this->doc_code.'.pdf');
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

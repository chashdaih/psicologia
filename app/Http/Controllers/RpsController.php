<?php

namespace App\Http\Controllers;

use Auth;
use App\Bread;
use App\Building;
use App\Option;
use App\Program;
use App\ProgramData;
use App\Rps as Doc;
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
        dd($request);
        $valProgram = $this->validateProgram($request);
        $valProgram['id_supervisor'] = Auth::user()->supervisor->id_supervisor;
        $valProgram['coordinacion'] = 'CLINICA'; // TODO
        $valProgram['cupo_actual'] = 0;
        $valProgram['descripcion'] = '';
        $valProgram['nombre_supervisor'] = '';
        $valProgram['Piloto'] = 0;
        $valProgram['problema'] = '';
        $valProgram['semestre_activo'] = '2019-2'; // TODO get global variable
        $valProgram['tipo'] = 'EXTRACURRICULAR'; // TODO 
        $valProgram['tipo_programa'] = 'INTERNO'; // TODO 
        $valProgram['titulacion'] = 0;
        if (!Arr::exists($valProgram, 'convenio')) {
            $valProgram['convenio'] = 0;
        }
        // dd($valProgram);
        $program = Program::create($valProgram);
        $valProgramData = $this->validateProgramData($request);
        $valProgramData['id_practica'] = $program->id_practica;
        $valProgramData['cont_tematico'] = '';
        $valProgramData['metodologia'] = '';
        $valProgramData['recursos'] = '';
        $programData = ProgramData::create($valProgramData);
        return redirect()->route($this->doc_code.'.index');
    }

    // protected function validateDoc($request)
    // {
    //     foreach ($request->except('_token') as $data => $value) {
    //         $valids[$data] = "required";
    //     }

    //     return $request->validate($valids);
    // }

    protected function validateProgram($request)
    {
        return $request->validate([
            'car_esc' => 'required',
            // 'convenio' => 'required',
            // 'coordinacion' => 'required',
            'cupo' => 'required',
            // 'cupo_actual' => 'required',
            // 'descripcion' => 'required',
            'dias_pr' => 'required',
            'direccion' => 'required',
            'escenario' => 'required',
            'horario' => 'required',
            'horas_sem' => 'required',
            // 'id_centro' => 'required',
            // 'id_practica' => 'required',
            // 'id_supervisor' => 'nullable',
            'id_supervisord' => 'nullable',
            'institucion' => 'required',
            // 'nombre_supervisor' => 'required',
            'num_convenio' => 'required',
            'periodicidad' => 'required',
            // 'Piloto' => 'required',
            // 'problema' => 'required',
            'programa' => 'required',
            'semestre' => 'required',
            // 'semestre_activo' => 'required',
            // 'tipo' => 'required',
            // 'tipo_programa' => 'required',
            // 'titulacion' => 'required',
        ]);
    }

    protected function validateProgramData($request)
    {
        return $request->validate([
            'act_ac_sug' => 'required',
            'asig_emp' => 'required',
            'competencias' => 'required',
            // 'cont_tematico' => 'required', // old
            'criterios_eva' => 'required',
            'enfoque' => 'required',
            'estra_ev_comp' => 'required',
            'estra_ev_imp' => 'required',
            // 'id_practica' => 'required', // filled by controller
            'justificacion' => 'required',
            'lin_pract' => 'required',
            'mec_int' => 'required',
            // 'metodologia' => 'required', // old
            'mod_sup' => 'required',
            'objetivo_es' => 'required',
            'objetivo_g' => 'required',
            // 'recursos' => 'required', // old
            'referencias' => 'required',
            'rel_serv_psic' => 'required',
            'requisitos' => 'required',
            'resumen' => 'required',
        ]);
    }

    public function show($id)
    {
        $sections = $this->getSections();
        $this->params['sections'] = $sections;
        // dd($sections);
        
        $doc = Program::where('practicas.id_practica', $id)
                ->join('informacion_practicas', 'informacion_practicas.id_practica', '=', 'practicas.id_practica')
                ->first();
        $this->params['doc'] = $doc;

        return view($this->base_url.'.show', $this->params);
    }

    public function pdf($id)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $this->params['sections'] = $this->getSections();;
        $doc = Program::where('practicas.id_practica', $id)
                ->join('informacion_practicas', 'informacion_practicas.id_practica', '=', 'practicas.id_practica')
                ->first();
        $this->params['doc'] = $doc;

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

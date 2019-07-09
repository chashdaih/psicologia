<?php

namespace App\Http\Controllers;

use Auth;

use App\Building;
use App\Bread;
use App\FE3FDG;
use App\Option;
use App\Program;
use App\Student;
use App\Ps;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PsController extends Controller
{
    // protected $process = 'fe';
    // protected $number = '4';
    // protected $doc_code = 'ps';
    protected $interventions;
    protected $service_modality;

    public function __construct() {
        $this->interventions = [
            new Option(1, "Orientación/Consejo"),
            new Option(2, "Evaluación"),
            new Option(3, "Taller"),
            new Option(4, "Intervención breve"),
            new Option(5, "Psicoterapia"),
            new Option(6, "Intervención Psicoeducativa")
        ];
        $this->service_modality = [
            new Option(1, "Individual"),
            new Option(2, "Pareja"),
            new Option(3, "Familiar"),
            new Option(4, "A padres o cuidadores"),
            new Option(5, "Grupal")
        ];
    }

    // public function index()
    // {
    //     $records = Ps::all(); // TODO pagination
    //     // $json = file_get_contents(__DIR__.'/processes.json');
    //     // $titles = json_decode($json, true);
    //     $doc_code = 'ps';
    //     // $bread = collect([ // TODO write function that generates bread array
    //     //     [
    //     //         'title' => 'Procesos',
    //     //         'url' => [
    //     //             'base' => 'procedures',
    //     //             'par' => ''
    //     //         ]
    //     //     ],
    //     //     [
    //     //         'title' => $titles['fe']['process'],
    //     //         'url' => [
    //     //             'base' => 'procedures',
    //     //             'par' => 'fe'
    //     //         ]
    //     //     ],
    //     //     [
    //     //         'title' => $titles['fe']['procedures']['fe4']['name'],
    //     //         'url' => null
    //     //     ],
    //     //     [
    //     //         'title' => $titles['fe']['procedures']['fe4']['documents']['ps'],
    //     //         'url' => null
    //     //     ]
            
    //     // ]);
    //     $mBread = new Bread($this->process, $this->process.$this->number, $doc_code);
    //     $bread = collect($mBread->bread_array);
    //     $target = "paciente";
    //     return view('procedures.3.fe.list', compact('records', 'bread', 'doc_code','target'));
    // }

    public function create(Program $program, FE3FDG $patient)
    {
        $process_model = new Ps();
        // $patients = FE3FDG::select('id', DB::raw("CONCAT(name, ' ', last_name, ' ', mothers_name) AS name"))->get(); // TODO where supervisor or student match somewhere...
        // $buildings = Building::select('id_centro as id', 'nombre as name')->get();
        // $programs = Program::select('id_practica as id', 'programa as name')->where('id_supervisor', 1)->get();
        // $students = Student::select('id_usuario as id', DB::raw("CONCAT(nombre_t, ' ', ap_paterno_t, ' ', ap_materno_t) AS name"))->where('Sistema', 'Escolarizado')->get(); // TODO get supervisor's students
        
        $fields = include('ps_fields.php');
        // $fields['patient_id']['options'] = $patients;
        // $fields['center_id']['options'] = $buildings;
        // $fields['program_id']['options'] = $programs;
        // $fields['student_id']['options'] = $students;
        // $fields['intervention_type']['options'] = $this->interventions;
        // $fields['service_modality']['options'] = $this->service_modality;

        // $bread = collect([
        //     'Procedimientos',
        //     'Servicios psicológicos a través de la Formación Supervisada del Estudiante',
        //     'Admisión de las personas atendidas',
        //     'Plan de servicios'
        // ]);
        // $code = 'ps';

        // return view('procedures.3.fe.4.ps.create', compact('bread', 'fields', 'values', 'code'));
        return view('procedures.3.fe.4.ps.create', compact('fields', 'process_model', 'program', 'patient'));
    }

    public function store(Program $program, FE3FDG $patient, Request $request)
    {
        // foreach ($request->except('_token', 'other_intervention') as $data => $value) {
        //     $valids[$data] = "required";
        // }
        // $validated = $request->validate($valids);
        // Ps::create($validated);
        // return response(200);
        $this->validate($request, [
            'created_at' => 'required|date',
            'tipo_de_intervencion' => 'required|integer|min:0|max:255',
            'modelo_psicoterapia' => 'nullable|string|max:255',
            'modalidad_de_servicio' => 'required|integer|min:0|max:255',
            'sugerencias_de_intervencion' => 'required|string'
        ]);
        $fields = collect($request)->toArray();
        $fields['user_id'] = Auth::user()->id;
        $fields['FE3FDG_id'] = $patient->id;
        $fields['program_id'] = $program->id_practica;
        Ps::create($fields);
        return redirect()->route('fe.index', ['program_id'=>$program->id_practica, 'patient_id'=>$patient->id])->with('success', 'Plan de servicios registrado exitosamente');
    }

    public function show($id)
    {
        $doc = $this->getFormatedPs($id);
        return view('procedures.3.fe.4.ps.show', compact('doc'));
    }

    public function pdf($id)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $doc = $this->getFormatedPs($id);

        $pdf->loadView('procedures.3.fe.4.ps.show', compact('doc'));
        return $pdf->download('ps_'.$doc->student->nombre_t.'.pdf');
    }
    
    protected function getFormatedPs($id)
    {
        $ps = Ps::where('id', $id)->first();
        $ps->intervention_type = $this->interventions[$ps->intervention_type]->name;
        $ps->service_modality = $this->service_modality[$ps->service_modality]->name;
        return $ps;
    }


    public function edit(Ps $ps)
    {
        //
    }

    public function update(Request $request, Ps $ps)
    {
        //
    }

    public function destroy(Ps $ps)
    {
        //
    }
}

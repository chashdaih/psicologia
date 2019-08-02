<?php

namespace App\Http\Controllers;

use Auth;

use App\Building;
use App\Bread;
use App\FE3FDG;
use App\Option;
use App\Patient;
// use App\Program;
use App\Student;
use App\Ps;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function index($patient_id)
    {
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', '#' => 'PS'];

        $patient = Patient::where('id', $patient_id)->first();
        $ps = Ps::where('id', $patient->ps_id)->first();

        return view('usuario.ps.index', compact('patient_id', 'migajas', 'ps'));
    }

    public function create($patient_id)
    {
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', route('ps.index', $patient_id) => 'PS', '#' => 'Registrar PS'];

        $process_model = new Ps();
        
        $fields = include('ps_fields.php');
        return view('usuario.ps.create', compact('fields', 'process_model', 'patient_id', 'migajas'));
    }

    public function store($patient_id, Request $request)
    {
        $this->validate($request, [
            'created_at' => 'required|date',
            'file_number' => 'required|string',
            'tipo_de_intervencion' => 'required|integer|min:0|max:255',
            'modelo_psicoterapia' => 'nullable|string|max:255',
            'modalidad_de_servicio' => 'required|integer|min:0|max:255',
            'sugerencias_de_intervencion' => 'required|string'
        ]);
        $fields = collect($request)->toArray();
        $fields['user_id'] = Auth::user()->id;
        $ps = Ps::create($fields);
        Patient::where('id', $patient_id)->update(['ps_id'=>$ps->id]);
        return redirect()->route('ps.index', $patient_id)->with('success', 'Plan de servicios registrado exitosamente');
    }

    public function show($patient_id, $ps)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $doc = $this->getFormatedPs($ps);

        $pdf->loadView('usuario.ps.show', compact('doc'));
        return $pdf->stream('plan_de_servicio.pdf');
    }

    public function edit($patient_id, $ps)
    {
        $patient = Patient::where('id', $patient_id)->first();
        $process_model = Ps::where('id', $patient->ps_id)->first();
        $fields = include('ps_fields.php');
        return view('usuario.ps.create', compact('fields', 'process_model', 'patient_id'));
    }

    public function update($patient_id, Request $request, $ps)
    {
        $this->validate($request, [
            'created_at' => 'required|date',
            'file_number' => 'required|string',
            'tipo_de_intervencion' => 'required|integer|min:0|max:255',
            'modelo_psicoterapia' => 'nullable|string|max:255',
            'modalidad_de_servicio' => 'required|integer|min:0|max:255',
            'sugerencias_de_intervencion' => 'required|string'
        ]);
        $fields = collect($request->except(['_method', '_token']))->toArray();
        Ps::where('id', $ps)->update($fields);
        return redirect()->route('ps.index', $patient_id)->with('success', 'Plan de servicios actualizado exitosamente');
    }

    public function destroy(Ps $ps)
    {
        //
    }

    protected function getFormatedPs($id)
    {
        $ps = Ps::where('id', $id)->first();
        $fields = include('ps_fields.php');
        $ps->tipo_de_intervencion = $fields['tipo_de_intervencion']['options'][$ps->tipo_de_intervencion];
        $ps->modalidad_de_servicio = $fields['modalidad_de_servicio']['options'][$ps->modalidad_de_servicio];
        return $ps;
    }
}

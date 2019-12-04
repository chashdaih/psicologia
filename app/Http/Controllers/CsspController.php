<?php

namespace App\Http\Controllers;

use Auth;
// use App\Bread;
use App\Cssp;
use App\FE3FDG;
use App\Option;
use App\Patient;
use App\PatientAssign;
// use App\Program;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CsspController extends Controller
{
    protected $doc_code = 'cssp';
    protected $excelent;
    protected $definitely;
    protected $helped;
    protected $satisfied;

    protected $newQs = ["Comunicación", "Toma de decisiones", "Solución de problemas", "Interacción Social/Recreativa", "Manejo del enojo", "Manejo de la tristeza", "Manejo de la ansiedad/estrés", "Manejo de los celos", "Búsqueda y mantenimiento de empleo", "Mantenerse sin consumo de sustancias", "Prevención de recaídas en el consumo de sustancias", "Para mantener una mejor relación familiar", "Mantener una mejor relación de pareja", "Manejo de la conducta de los hijos", "Manejo de las emociones de los hijos", "Crianza Positiva para padres", "Manejo de problemas del desarrollo en los hijos (Problemas para leer o escribir, de comunicación, físicos, etc.)", "Manejo de duelo", "Estilos de vida saludable", "Otro:"];

    public function __construct()
    {
        $this->excelent = [
            new Option(4, 'Excelente'),
            new Option(3, 'Buena'),
            new Option(2, 'Regular'),
            new Option(1, 'Mala')
        ];
        $this->definitely = [
            new Option(4, 'Sí, definitivamente'),
            new Option(3, 'Sí, en general'),
            new Option(2, 'Muy poco'),
            new Option(1, 'Definitivamente no')
        ];
        $this->helped = [
            new Option(4, 'Sí, me ayudaron mucho'),
            new Option(3, 'Sí, me ayudaron algo'),
            new Option(2, 'No me ayudaron'),
            new Option(1, 'Definitivamente no me ayudaron')
        ];
        $this->satisfied = [
            new Option(4, 'Muy satisfecho/a'),
            new Option(3, 'Moderadamente satisfecho/a'),
            new Option(2, 'Algo insatisfecho/a'),
            new Option(1, 'Muy insatisfecho/a')
        ];
    }

    public function index($patient_id)
    {
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', '#' => 'CSSP'];

        // $patient = Patient::where('id', $patient_id)->first();
        // $cssp = Cssp::where('id', $patient->cssp_id)->first();
        
        $patient = Patient::where('id', $patient_id)->first();
        
        $assigned = PatientAssign::where('patient_id', $patient_id)->where('process_code', 'cssp')->pluck('id');

        $path = public_path().'/storage/patients/'.$patient->id.'/cssp/';

        $records = Cssp::whereIn('assign_id', $assigned)->get();
        $data = compact('patient', 'records', 'migajas', 'path');

        return view('usuario.cssp.index', $data);
    }


    public function create($patient_id)
    {
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', route('cssp.index', $patient_id) => 'CSSP', "#"=>"Registrar CSSP"];

        $fields = $this->getFields();
        $process_model = new Cssp();
        $newQs = $this->newQs;
        $data = compact('patient_id', 'fields', 'process_model', 'migajas', 'newQs');
        return view('usuario.cssp.create', $data);
    }

    public function store($patient_id, Request $request)
    {
        $this->validate($request, [
            'file_number' => 'nullable|string',
            'created_at' => 'nullable|date',
            'q1' => 'required|integer|min:0|max:3',
            'q2' => 'required|integer|min:0|max:3',
            'q3' => 'required|integer|min:0|max:3',
            'q4' => 'required|integer|min:0|max:3',
            'q5' => 'required|integer|min:0|max:3',
            'o1' => 'nullable|string',
            'o2' => 'nullable|string',
            'file' => 'nullable|mimes:jpg,jpeg,bmp,png,gif,svg,pdf|max:14000'
        ]);
        // $fields = collect($request->except(['_token', '_method']))->toArray();
        // $fields['user_id'] = Auth::user()->id;
        // $cssp = Cssp::create($fields);
        // Patient::where('id', $patient_id)->update(['cssp_id'=>$cssp->id]);
        
        $assign = PatientAssign::where('patient_id', $patient_id)->where('process_code', 'cssp')->orderBy('created_at', 'desc')->first();
        $assign_id = $assign->id;

        $fields = collect($request->except(['_token', '_method', 'file']))->toArray();

        $fields['user_id'] = Auth::user()->id;
        $fields['assign_id'] = $assign_id;
        $cssp = Cssp::create($fields);
        
        if ($request->file("file")) {
            $extension = $request->file("file")->extension();
            $file_folder = 'public/patients/'.$patient_id.'/cssp';
            $file_name = $cssp->id.'.'.$extension;
            $request->file("file")->storeAs($file_folder, $file_name);
        }

        return redirect()->route('cssp.index', $patient_id)->with('success', 'Cuestionario de satisfacción con el servicio psicológico registrado exitosamente');
    }

    public function show($parent_id, $cssp)
    {
        // $doc = $this->getFormattedDoc($id);
        // return view('procedures.3.fe.8.cssp.show', compact('doc'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $doc = $this->getFormattedDoc($cssp);
        $newQs = $this->newQs;

        $pdf->loadView('usuario.cssp.show', compact('doc', 'newQs'));
        return $pdf->stream('cssp.pdf');
    }

    // public function pdf(Program $program, FE3FDG $patient, $id)
    // {
    //     $pdf = \App::make('dompdf.wrapper');
    //     $pdf->getDomPDF()->set_option("enable_php", true);

    //     $doc = $this->getFormattedDoc($id);

    //     $pdf->loadView('procedures.3.fe.8.cssp.show', compact('doc'));
    //     return $pdf->stream('cssp.pdf');
    // }

    // public function edit(Program $program, FE3FDG $patient, $id)
    // {
    //     $process_model = Cssp::where('id', $id)->first();
    //     $fields = $this->getFields();
    //     $data = compact('fields', 'process_model', 'program', 'patient');
    //     return view('procedures.3.fe.8.cssp.create', $data);
    // }
    public function edit($patient_id, $cssp)
    {
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', route('cssp.index', $patient_id) => 'CSSP', "#"=>"Registrar CSSP"];
        $process_model = Cssp::where('id', $cssp)->first();
        $fields = $this->getFields();
        $newQs = $this->newQs;
        $data = compact('fields', 'process_model', 'patient_id', 'migajas', 'newQs');
        return view('usuario.cssp.create', $data);
    }

    public function update($patient_id, Request $request, $id)
    {
        $this->validate($request, [
            'file_number' => 'nullable|string',
            'created_at' => 'nullable|date',
            'q1' => 'required|integer|min:0|max:3',
            'q2' => 'required|integer|min:0|max:3',
            'q3' => 'required|integer|min:0|max:3',
            'q4' => 'required|integer|min:0|max:3',
            'q5' => 'required|integer|min:0|max:3',
            'o1' => 'nullable|string',
            'o2' => 'nullable|string',
            'file' => 'nullable|mimes:jpg,jpeg,bmp,png,gif,svg,pdf|max:14000'
        ]);
        // $values = collect($request->except(['_token', '_method']))->toArray();
        // Cssp::where('id', $cssp)->update($values);
        
        $fields = collect($request->except(['_token', '_method', 'file']))->toArray();
        $fields['user_id'] = Auth::user()->id;
        Cssp::where('id', $id)->update($fields);
        
        if ($request->file("file")) {
            $extension = $request->file("file")->extension();
            $file_folder = 'public/patients/'.$patient_id.'/cssp';
            $file_name = $id.'.'.$extension;
            $request->file("file")->storeAs($file_folder, $file_name);
        }

        return redirect()->route('cssp.index', $patient_id)->with('success', 'Cuestionario de satisfacción actualizado exitosamente');
    }

    public function destroy($patient_id, $cssp)
    {
        // TODO delete file, if exist
        Cssp::destroy($cssp);
        return 200;
    }

    protected function dirname_r($path, $count=1){
        if ($count > 1) {
           return dirname($this->dirname_r($path, --$count));
        } else {
           return dirname($path);
        }
    }

    protected function getFields()
    {
        $json = file_get_contents($this->dirname_r(__DIR__, 2).'/fields/'.$this->doc_code.'.json');
        $fields = json_decode($json, true);

        return $fields;
    }

    protected function getFormattedDoc($id)
    {
        $doc = Cssp::where('id', $id)->first();

        $doc['q1'] = $this->excelent[array_search($doc['q1'], array_column($this->excelent, 'id'))]->name;
        $doc['q2'] = $this->definitely[array_search($doc['q2'], array_column($this->definitely, 'id'))]->name;
        $doc['q3'] = $this->definitely[array_search($doc['q3'], array_column($this->definitely, 'id'))]->name;
        $doc['q4'] = $this->helped[array_search($doc['q4'], array_column($this->helped, 'id'))]->name;
        $doc['q5'] = $this->satisfied[array_search($doc['q5'], array_column($this->satisfied, 'id'))]->name;

        return $doc;
    }

    // protected function validateDoc($request)
    // {
    //     foreach ($request->except('_token') as $data => $value) {
    //         $valids[$data] = "required";
    //     }
    //     return $request->validate($valids);
    // }
}

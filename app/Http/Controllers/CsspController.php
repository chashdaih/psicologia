<?php

namespace App\Http\Controllers;

use Auth;
// use App\Bread;
use App\Cssp;
use App\FE3FDG;
use App\Option;
use App\Patient;
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

        $patient = Patient::where('id', $patient_id)->first();
        $cssp = Cssp::where('id', $patient->cssp_id)->first();

        return view('usuario.cssp.index', compact('patient_id', 'migajas', 'cssp'));
    }


    public function create($patient_id)
    {
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', route('cssp.index', $patient_id) => 'CSSP', "#"=>"Registrar CSSP"];

        $fields = $this->getFields();
        $process_model = new Cssp();
        $data = compact('patient_id', 'fields', 'process_model', 'migajas');
        return view('usuario.cssp.create', $data);
    }

    public function store($patient_id, Request $request)
    {
        $this->validate($request, [
            'file_number' => 'required|string',
            'created_at' => 'required|date',
            'q1' => 'required|integer|min:0|max:3',
            'q2' => 'required|integer|min:0|max:3',
            'q3' => 'required|integer|min:0|max:3',
            'q4' => 'required|integer|min:0|max:3',
            'q5' => 'required|integer|min:0|max:3',
            'o1' => 'nullable|string',
            'o2' => 'nullable|string' 
        ]);
        $fields = collect($request->except(['_token', '_method']))->toArray();
        $fields['user_id'] = Auth::user()->id;
        $cssp = Cssp::create($fields);
        Patient::where('id', $patient_id)->update(['cssp_id'=>$cssp->id]);
        return redirect()->route('cssp.index', $patient_id)->with('success', 'Cuestionario de satisfacción con el servicio psicológico registrado exitosamente');
    }

    public function show($parent_id, $cssp)
    {
        // $doc = $this->getFormattedDoc($id);
        // return view('procedures.3.fe.8.cssp.show', compact('doc'));
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $doc = $this->getFormattedDoc($cssp);

        $pdf->loadView('usuario.cssp.show', compact('doc'));
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
        $data = compact('fields', 'process_model', 'patient_id', 'migajas');
        return view('usuario.cssp.create', $data);
    }

    public function update($patient_id, Request $request, $cssp)
    {
        $this->validate($request, [
            'file_number' => 'required|string',
            'created_at' => 'required|date',
            'q1' => 'required|integer|min:0|max:3',
            'q2' => 'required|integer|min:0|max:3',
            'q3' => 'required|integer|min:0|max:3',
            'q4' => 'required|integer|min:0|max:3',
            'q5' => 'required|integer|min:0|max:3',
            'o1' => 'nullable|string',
            'o2' => 'nullable|string' 
        ]);
        $values = collect($request->except(['_token', '_method']))->toArray();
        Cssp::where('id', $cssp)->update($values);
        return redirect()->route('cssp.index', $patient_id)->with('success', 'Cuestionario de satisfacción actualizado exitosamente');
    }

    public function destroy(Cssp $cssp)
    {
        //
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

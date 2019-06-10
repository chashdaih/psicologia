<?php

namespace App\Http\Controllers;

use App\Bread;
use App\Cssp;
use App\FE3FDG;
use App\Option;

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

    public function index()
    {
        $doc_code = $this->doc_code;
        $mBread = new Bread('fe', 'fe8', $doc_code);
        $bread = collect($mBread->bread_array);
        $records = Cssp::all(); //TODO pagination
        $target = "paciente";
        return view('procedures.3.fe.list', compact('records', 'bread', 'doc_code','target'));
    }

    public function create()
    {
        $fields = $this->getFields();
        $values = new Cssp();
        $code = $this->doc_code;
        $mBread = new Bread('fe', 'fe8', $code);
        $bread = collect($mBread->bread_array);
        return view('procedures.3.fe.create', compact('bread', 'fields', 'values', 'code'));
    }

    protected function getFields()
    {
        $json = file_get_contents($this->dirname_r(__DIR__, 2).'/fields/'.$this->doc_code.'.json');
        $fields = json_decode($json, true);

        $patients = FE3FDG::select('id', DB::raw("CONCAT(name, ' ', last_name, ' ', mothers_name) AS name"))->get(); // TODO where supervisor or student match somewhere...
        
        $fields['patient_id']['options'] = $patients;
        $fields['q1']['options'] = $this->excelent;
        $fields['q2']['options'] = $this->definitely;
        $fields['q3']['options'] = $this->definitely;
        $fields['q4']['options'] = $this->helped;
        $fields['q5']['options'] = $this->satisfied;

        return $fields;
    }

    public function store(Request $request)
    {
        $validated = $this->validateDoc($request);
        Cssp::create($validated);
        return response(200);
    }

    protected function validateDoc($request)
    {
        foreach ($request->except('_token') as $data => $value) {
            $valids[$data] = "required";
        }
        return $request->validate($valids);
    }

    public function show($id)
    {
        $doc = $this->getFormattedDoc($id);
        return view('procedures.3.fe.8.cssp.show', compact('doc'));
    }

    public function pdf($id)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $doc = $this->getFormattedDoc($id);

        $pdf->loadView('procedures.3.fe.8.cssp.show', compact('doc'));
        return $pdf->download('cssp_'.$doc->patient->full_name.'.pdf');
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

    public function edit(Cssp $cssp)
    {
        //
    }

    public function update(Request $request, Cssp $cssp)
    {
        //
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
}

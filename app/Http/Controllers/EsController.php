<?php

namespace App\Http\Controllers;

use Auth;
use App\Bread;
use App\Es;
use App\EvaluateStudent;
use App\Partakers;
use App\Program;
use App\ProgramPartaker;
use Illuminate\Http\Request;

class EsController extends Controller
{
    public function create($assign_id)
    {
        $fields = $this->getFields();
        
        $inst = new Es();

        return view('assign.es.create', compact('assign_id', 'fields', 'inst'));
    }

    public function store($assign_id, Request $request)
    {
        $this->validateDoc($request);

        $fields = collect($request->except(['_token', '_method']))->toArray();

        $es = Es::create($fields);

        $pp = ProgramPartaker::where('id_tramite', $assign_id)->first();

        EvaluateStudent::where('program_id', $pp->id_practica)->where('partaker_id', $pp->id_participante)->update(['es_id' => $es->id]); // todo: hacer esto en un listener

        return redirect()->route('home')->with('success', 'Evaluación de satisfacción registrada correctamente');
    }

    public function show($assign_id, $es)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $es = Es::where('id', $es)->first();

        $doc = ProgramPartaker::where('id_tramite', $assign_id)->first();
        $full_code = "4-EE1-ES";

        // $doc = $this->getFormattedDoc($cssp);

        $pdf->loadView('assign.es.show', compact('doc', 'es', 'full_code'));
        return $pdf->stream('cssp.pdf');
    }

    public function edit($assign_id, $es)
    {
        $fields = $this->getFields();
        
        $inst = Es::where('id', $es)->first();

        return view('assign.es.create', compact('assign_id', 'fields', 'inst'));
    }

    public function update($assign_id, $es, Request $request)
    {
        $this->validateDoc($request);

        $fields = collect($request->except(['_token', '_method']))->toArray();

        $es = Es::where('id', $es)->update($fields);

        return redirect()->route('home')->with('success', 'Evaluación de satisfacción actualizada correctamente');
    }

    public function destroy(Es $es)
    {
        //
    }

    public function pdf($id)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $doc = $this->getFormatedDoc($id);
        $this->params['doc']= $doc;

        $json = file_get_contents($this->dirname_r(__DIR__, 2).'/fields/'.$this->doc_code.'.json');
        $questions = json_decode($json, true);
        $this->params['questions'] = $questions;

        $pdf->loadView($this->base_url.'.show', $this->params);
        return $pdf->download('es.pdf');
    }

    protected function getFields()
    {
        $json = file_get_contents($this->dirname_r(__DIR__, 2).'/fields/es.json');
        $fields = json_decode($json, true);

        return $fields;
    }

    protected function dirname_r($path, $count=1){
        if ($count > 1) {
           return dirname($this->dirname_r($path, --$count));
        } else {
           return dirname($path);
        }
    }
    
    protected function validateDoc($request)
    {
        $this->validate($request, [
            'q11' => 'required|integer|min:0|max:6',
            'q12' => 'required|integer|min:0|max:6',
            'q13' => 'required|integer|min:0|max:6',
            'q14' => 'required|integer|min:0|max:6',
            'q15' => 'required|integer|min:0|max:6',
            'q16' => 'required|integer|min:0|max:6',
            'q2' => 'required|integer|min:0|max:6',
            'q3' => 'required|integer|min:0|max:6',
            'q4' => 'required|integer|min:0|max:6',
            'q5' => 'required|integer|min:0|max:6',
            'q6' => 'required|integer|min:0|max:6',
            'comments' => 'nullable',
        ]);
    }

    // protected function getFormatedDoc($id)
    // {
    //     $program_type = ["Programa curricular", "Programa extracurricular", "Prestador de servicio social", "Posgrado"];

    //     $doc = Es::where('id', $id)->first();
    //     $doc['program_type'] = $program_type[$doc->program_type];
    //     return $doc;
    // }
}

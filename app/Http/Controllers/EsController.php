<?php

namespace App\Http\Controllers;

use Auth;
use App\Bread;
use App\Es;
use App\Partakers;
use App\Program;
use Illuminate\Http\Request;

class EsController extends Controller
{
    protected $process = 'ee';
    protected $number = '1';
    protected $doc_code = 'es';
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
        $records = Program::where('id_supervisor', Auth::user()->supervisor->id_supervisor)
                    ->where('semestre_activo', '2019-2')->get();
        $this->params['records'] = $records;

        return view($this->base_url.'.index', $this->params);
    }

    public function create()
    {
        $programs = Program::where('id_supervisor', Auth::user()->supervisor->id_supervisor)
                    ->where('semestre_activo', '2019-2')->get();
        $this->params['programs'] = $programs;

        $json = file_get_contents($this->dirname_r(__DIR__, 2).'/fields/'.$this->doc_code.'.json');
        $questions = json_decode($json, true);
        // dd($questions);
        $this->params['questions'] = $questions;

        return view($this->base_url.'.create', $this->params);
    }

    public function store(Request $request)
    {
        $validated = $this->validateDoc($request);
        Es::create($validated);
        return redirect()->route($this->doc_code.'.index');
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
        $doc = $this->getFormatedDoc($id);
        $this->params['doc']= $doc;

        $json = file_get_contents($this->dirname_r(__DIR__, 2).'/fields/'.$this->doc_code.'.json');
        $questions = json_decode($json, true);
        $this->params['questions'] = $questions;

        return view($this->base_url.'.show', $this->params);
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

    protected function getFormatedDoc($id)
    {
        $program_type = ["Programa curricular", "Programa extracurricular", "Prestador de servicio social", "Posgrado"];

        $doc = Es::where('id', $id)->first();
        $doc['program_type'] = $program_type[$doc->program_type];
        return $doc;
    }

    public function edit(Es $es)
    {
        //
    }

    public function update(Request $request, Es $es)
    {
        //
    }

    public function destroy(Es $es)
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

<?php

namespace App\Http\Controllers;

use App\Building;
use App\Bread;
use App\FE3FDG;
use App\Program;
use App\Re;
// use App\Student;
use App\Partaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReController extends Controller
{
    public function index()
    {
        $doc_code = 're';
        $mBread = new Bread('fe', 'fe5', $doc_code);
        $bread = collect($mBread->bread_array);
        $records = Re::all(); //TODO pagination
        $target = "paciente";
        return view('procedures.3.fe.list', compact('records', 'bread', 'doc_code','target'));

    }

    public function create()
    {
        $fields = $this->getFields();
        $values = new Re();
        $code = 're';
        $bread = $this->getBread('fe', 'fe5', $code);
        return view('procedures.3.fe.create', compact('bread', 'fields', 'values', 'code'));
    }

    protected function getFields()
    {
        $json = file_get_contents($this->dirname_r(__DIR__, 2).'/fields/re.json');
        $fields = json_decode($json, true);

        $patients = FE3FDG::select('id as primary_key', DB::raw("CONCAT(name, ' ', last_name, ' ', mothers_name) AS full_name"))->get(); // TODO where supervisor or student match somewhere...
        $buildings = Building::select('id_centro as primary_key', 'nombre as full_name')->get();
        $programs = Program::select('id_practica as primary_key', 'programa as full_name')->where('id_supervisor', 1)->get();
        // $students = Partaker::select('num_cuenta as id', DB::raw("CONCAT(nombre_part, ' ', ap_paterno, ' ', ap_materno) AS name"))
        // ->where('Sistema', 'Escolarizado')
        // ->get(); // TODO get supervisor's students
        
        $fields['patient_id']['options'] = $patients;
        $fields['building_id']['options'] = $buildings;
        $fields['program_id']['options'] = $programs;
        // $fields['student_id']['options'] = $students;

        return $fields;
    }

    protected function getBread($key, $proc, $doc)
    {
        $mBread = new Bread($key, $proc, $doc);
        return collect($mBread->bread_array);
    }

    public function store(Request $request)
    {
        $validated = $this->validateRe($request);
        Re::create($validated);
        return response(200);
    }

    protected function validateRe($request)
    {
        foreach ($request->except('_token', 'refer_place') as $data => $value) {
            $valids[$data] = "required";
        }
        $valids['refer_place'] = "nullable";
        return $request->validate($valids);
    }

    public function show($id)
    {
        $doc = Re::where('id', $id)->first();
        return view('procedures.3.fe.5.re.show', compact('doc'));
    }

    public function pdf($id)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $doc = Re::where('id', $id)->first();

        $pdf->loadView('procedures.3.fe.5.re.show', compact('doc'));
        return $pdf->download('ps_'.$doc->student->nombre_t.'.pdf');
    }

    public function edit(Re $re)
    {
        //
    }

    public function update(Request $request, Re $re)
    {
        //
    }

    public function destroy(Re $re)
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

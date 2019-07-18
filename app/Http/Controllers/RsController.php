<?php

namespace App\Http\Controllers;

use Auth;
// use App\Bread;
use App\FE3FDG;
use App\Program;
use App\Rs as Doc;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class RsController extends Controller
{
    protected $isIntervention = false;

    public function __construct()
    {
        if (strpos(Request::capture()->path(), 'breve') === false) {
            $this->isIntervention = true;
        } 
    }

    public function index(Program $program, FE3FDG $patient)
    {

        $isIntervention = $this->isIntervention;

        $records = Doc::where('program_id', $program->id_practica)->where('patient_id', $patient->id)->where('intervencion', $isIntervention)->get();
        $data = compact('program', 'patient', 'isIntervention', 'records');
        return view('procedures.3.fe.7.rs.index', $data);
    }

    public function create(Program $program, FE3FDG $patient)
    {
        $fields = $this->getFields();
        $process_model = new Doc();
        $isIntervention = $this->isIntervention;
        $data = compact('program', 'patient', 'fields', 'process_model', 'isIntervention');
        return view('procedures.3.fe.7.rs.create', $data);
    }

    public function store(Program $program, FE3FDG $patient, Request $request)
    {
        $this->validate($request, [
            'created_at' => 'required|date',
            'session_number' => 'required|integer|min:0|max:255|unique:rs,session_number',
            'file' => 'required|mimes:pdf|max:14000'
        ]);
        
        $fields = collect($request->except(['_token', '_method', 'file']))->toArray();

        $file_folder = 'public/program/'.$program->id_practica.'/patient/'.$patient->id;
        if ($this->isIntervention) {
            $file_folder = $file_folder.'/intervention';
        } else {
            $file_folder = $file_folder.'/breve';
        }
        $file_name = $fields['session_number'].'.pdf';
        $request->file("file")->storeAs($file_folder, $file_name);
        
        $fields['user_id'] = Auth::user()->id;
        $fields['patient_id'] = $patient->id;
        $fields['program_id'] = $program->id_practica;
        $fields['intervencion'] = $this->isIntervention;
        $fields['exist'] = true;
        Doc::create($fields);

        $route = 'breve.index';
        if ($this->isIntervention) {
            $route = 'intervencion.index';
        }

        return redirect()->route($route, compact('program', 'patient'))->with('success', 'Resumen de sesión registrado exitosamente');
    }

    public function show(Rs $rs)
    {
        //
    }

    public function edit(Rs $rs)
    {
        //
    }

    public function update(Request $request, Rs $rs)
    {
        //
    }

    public function destroy(Program $program, FE3FDG $patient, $id)
    {
        $deletedRows = Doc::where('intervencion', $this->isIntervention)->where('session_number', $id)->delete();
        // TODO error?

        $file_folder = 'public/program/'.$program->id_practica.'/patient/'.$patient->id;
        if ($this->isIntervention) {
            $file_folder = $file_folder.'/intervention/';
        } else {
            $file_folder = $file_folder.'/breve/';
        }
        $file_name = $id.'.pdf';

        Storage::delete($file_folder.$file_name);
        return 200;
    }

    public function pdf(Program $program, FE3FDG $patient, $id)
    {
        $file_folder = public_path().'/storage/program/'.$program->id_practica.'/patient/'.$patient->id;
        if ($this->isIntervention) {
            $file_folder = $file_folder.'/intervention/';
        } else {
            $file_folder = $file_folder.'/breve/';
        }
        $file_name = $id.'.pdf';
        return response()->file($file_folder.$file_name);
    }
    
    protected function getFields()
    {
        $json = file_get_contents($this->dirname_r(__DIR__, 2).'/fields/'.'rs.json');
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
        foreach ($request->except('_token', 'student_id') as $data => $value) {
            $valids[$data] = "required";
        }
        return $request->validate($valids);
    }
}

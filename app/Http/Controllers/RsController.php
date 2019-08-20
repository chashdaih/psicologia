<?php

namespace App\Http\Controllers;

use Auth;
use App\FE3FDG;
use App\PatientAssign;
use App\Program;
use App\Rs as Doc;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RsController extends Controller
{
    protected $isIntervention = false;

    public function __construct()
    {
        if (strpos(Request::capture()->path(), 'breve') === false) {
            $this->isIntervention = true;
        } 
    }

    public function index($patient_id)
    {
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', '#' => 'Resumen de sesión'];

        $isIntervention = $this->isIntervention;

        $process_code = $this->isIntervention ? 'rs7' : 'rs6';
        $code_name = $this->isIntervention ? 'intervencion' : 'breve';

        $path = public_path().'/storage/patients/'.$patient_id.'/'.$code_name.'/';

        $assigned = PatientAssign::where('patient_id', $patient_id)->where('process_code', $process_code)->pluck('id');

        $records = Doc::whereIn('assign_id', $assigned)->where('intervencion', $isIntervention)->get();
        $data = compact('patient_id', 'isIntervention', 'records', 'migajas', 'code_name', 'path');
        return view('usuario.rs.index', $data);
    }

    public function create($patient_id)
    {
        $path = '';
        if($this->isIntervention) {
            $path = 'intervencion';
        } else {
            $path = 'breve';
        }
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', route($path.'.index', $patient_id) => 'Resumen de sesión', '#'=>'Registrar resumen de sesión'];

        $fields = $this->getFields();
        $process_model = new Doc();
        $isIntervention = $this->isIntervention;
        $data = compact('patient_id', 'fields', 'process_model', 'isIntervention', 'migajas');
        return view('usuario.rs.create', $data);
    }

    public function store($patient_id, Request $request)
    {
        $process_code = $this->isIntervention ? 'rs7' : 'rs6';
        $assign = PatientAssign::where('patient_id', $patient_id)->where('process_code', $process_code)->orderBy('created_at', 'desc')->first();
        $assign_id = $assign->id;

        $isIntervention = $this->isIntervention;
        $this->validate(request(), [
            'created_at' => 'required|date',
            'session_number' => [
                'required',
                'min:0',
                'max:255',
                Rule::unique('rs')->where(function($query) use ($assign_id, $isIntervention) {
                    return $query->where('assign_id', $assign_id)->where('intervencion', $isIntervention);
                })
            ],
            'file' => 'required|mimes:jpeg,bmp,png,gif,svg,pdf|max:14000'
        ]);
        
        $fields = collect($request->except(['_token', '_method', 'file']))->toArray();
        
        $fields['user_id'] = Auth::user()->id;
        $fields['assign_id'] = $assign_id;
        $fields['intervencion'] = $this->isIntervention;
        $fields['exist'] = true;
        $rs = Doc::create($fields);

        $program_id = $assign->program->id_programa;

        if ($request->file("file")) {
            $extension = $request->file("file")->extension();
            $file_folder = 'public/patients/'.$patient_id;
            if ($this->isIntervention) {
                $file_folder = $file_folder.'/intervencion';
            } else {
                $file_folder = $file_folder.'/breve';
            }
            $file_name = $rs->id.'.'.$extension;
            $request->file("file")->storeAs($file_folder, $file_name);
        }

        $route = 'breve.index';
        if ($this->isIntervention) {
            $route = 'intervencion.index';
        }

        return redirect()->route($route, $patient_id)->with('success', 'Resumen de sesión registrado exitosamente');
    }

    // public function show($patient_id, $id)
    // {
    //     $file_folder = public_path().'/storage/patients/'.$patient_id;
    //     if ($this->isIntervention) {
    //         $file_folder = $file_folder.'/intervencion';
    //     } else {
    //         $file_folder = $file_folder.'/breve';
    //     }
    //     $file_name = $id.'.pdf';
    //     return response()->file($file_folder.$file_name);
    // }

    public function edit($patient_id, $id)
    {
        $path = '';
        if($this->isIntervention) {
            $path = 'intervencion';
        } else {
            $path = 'breve';
        }
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', route($path.'.index', $patient_id) => 'Resumen de sesión', '#'=>'Actualizar resumen de sesión'];

        $fields = $this->getFields();
        $process_model = Doc::where('id', $id)->first();
        $isIntervention = $this->isIntervention;
        $data = compact('patient_id', 'fields', 'process_model', 'isIntervention', 'migajas');
        return view('usuario.rs.create', $data);
        
    }

    public function update(Request $request, $patient_id, $id)
    {
        $process_code = $this->isIntervention ? 'rs7' : 'rs6';
        $isIntervention = $this->isIntervention;
        $this->validate(request(), [
            'created_at' => 'required|date',
            'session_number' => [
                'required',
                'min:0',
                'max:255'
            ],
            'file' => 'nullable|mimes:jpg,jpeg,bmp,png,gif,svg,pdf|max:14000'
        ]);
        
        $fields = collect($request->except(['_token', '_method', 'file']))->toArray();
        $fields['user_id'] = Auth::user()->id;
        Doc::where('id', $id)->update($fields);

        if ($request->file("file")) {
            $extension = $request->file("file")->extension();
            $file_folder = 'public/patients/'.$patient_id;
            if ($this->isIntervention) {
                $file_folder = $file_folder.'/intervencion';
            } else {
                $file_folder = $file_folder.'/breve';
            }
            $file_name = $id.'.'.$extension;
            $request->file("file")->storeAs($file_folder, $file_name);
        }

        $route = 'breve.index';
        if ($this->isIntervention) {
            $route = 'intervencion.index';
        }

        return redirect()->route($route, $patient_id)->with('success', 'Resumen de sesión actualizado exitosamente');
    }

    // public function destroy(Program $program, FE3FDG $patient, $id)
    // {
    //     $deletedRows = Doc::where('intervencion', $this->isIntervention)->where('session_number', $id)->delete();
    //     // TODO error?

    //     $file_folder = 'public/program/'.$program->id_practica.'/patient/'.$patient->id;
    //     if ($this->isIntervention) {
    //         $file_folder = $file_folder.'/intervention/';
    //     } else {
    //         $file_folder = $file_folder.'/breve/';
    //     }
    //     $file_name = $id.'.pdf';

    //     Storage::delete($file_folder.$file_name);
    //     return 200;
    // }

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

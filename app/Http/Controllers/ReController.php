<?php

namespace App\Http\Controllers;

use Auth;
use App\Building;
use App\Bread;
use App\FE3FDG;
use App\Patient;
use App\PatientAssign;
use App\Re;
use App\Partaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReController extends Controller
{
    public function index($patient_id)
    {
        $patient = Patient::where('id', $patient_id)->first();
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Personas atendidas', route('usuario.show', $patient_id)=>$patient->fdg->full_name, '#' => 'RE'];
        
        $assigned = PatientAssign::where('patient_id', $patient_id)->where('process_code', 're')->pluck('id');

        $path = public_path().'/storage/patients/'.$patient->id.'/re/';

        $records = Re::whereIn('assign_id', $assigned)->get();
        $data = compact('patient', 'records', 'migajas', 'path');

        return view('usuario.re.index', $data);

    }

    public function create($patient_id)
    {
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', route('re.index', $patient_id) => 'RE', '#'=>'Registrar RE'];
        $fields = $this->getFields();
        $process_model = new Re();
        $data = compact('fields', 'process_model', 'migajas', 'patient_id');
        return view('usuario.re.create', $data);
    }

    public function store($patient_id, Request $request)
    {
        $this->validate($request, [
            'created_at' => 'required|date',
            'file_number' => 'nullable|string',
            'referencia_necesaria' => 'required|boolean',
            'lugar_de_referencia' => 'nullable|string|max:255',
            'file' => 'nullable|mimes:jpg,jpeg,bmp,png,gif,svg,pdf|max:14000'
        ]);
        // $fields = collect($request->except(['_token', '_method']))->toArray();
        // $fields['user_id'] = Auth::user()->id;
        // $re = Re::create($fields);
        // Patient::where('id', $patient_id)->update(['re_id'=>$re->id]);
        
        $assign = PatientAssign::where('patient_id', $patient_id)->where('process_code', 're')->orderBy('created_at', 'desc')->first();
        $assign_id = $assign->id;

        $fields = collect($request->except(['_token', '_method', 'file']))->toArray();

        $fields['user_id'] = Auth::user()->id;
        $fields['assign_id'] = $assign_id;
        $re = Re::create($fields);
        
        if ($request->file("file")) {
            $extension = $request->file("file")->extension();
            $file_folder = 'public/patients/'.$patient_id.'/re';
            $file_name = $re->id.'.'.$extension;
            $request->file("file")->storeAs($file_folder, $file_name);
        }

        return redirect()->route('re.index', $patient_id)->with('success', 'Resultados de evaluación registrados exitosamente');
    }

    public function show($patient_id, $re)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $doc = Re::where('id', $re)->first();

        $pdf->loadView('usuario.re.show', compact('doc'));
        return $pdf->stream('fe5re.pdf');
    }

    public function edit($patient_id, $re)
    {
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', route('re.index', $patient_id) => 'RE', '#'=>'Registrar RE'];
        $fields = $this->getFields();
        $process_model = Re::where('id', $re)->first();
        $data = compact('fields', 'process_model', 'migajas', 'patient_id');
        return view('usuario.re.create', $data);
    }

    public function update($patient_id, Request $request, $id)
    {
        $this->validate($request, [
            'created_at' => 'required|date',
            'file_number' => 'nullable|string',
            'referencia_necesaria' => 'required|boolean',
            'lugar_de_referencia' => 'nullable|string|max:255',
            'file' => 'nullable|mimes:jpg,jpeg,bmp,png,gif,svg,pdf|max:14000'
        ]);
        // $values = collect($request->except(['_token', '_method']))->toArray();
        // Re::where('id', $re)->update($values);
        
        $fields = collect($request->except(['_token', '_method', 'file']))->toArray();
        $fields['user_id'] = Auth::user()->id;
        Re::where('id', $id)->update($fields);
        
        if ($request->file("file")) {
            $extension = $request->file("file")->extension();
            $file_folder = 'public/patients/'.$patient_id.'/re';
            $file_name = $id.'.'.$extension;
            $request->file("file")->storeAs($file_folder, $file_name);
        }

        return redirect()->route('re.index', $patient_id)->with('success', 'Resultados de evaluación actualizados exitosamente');
    }

    public function destroy($patient_id, $re)
    {
        // TODO delete file, if exist
        Re::destroy($re);
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
        $json = file_get_contents($this->dirname_r(__DIR__, 2).'/fields/re.json');
        $fields = json_decode($json, true);

        return $fields;
    }
}

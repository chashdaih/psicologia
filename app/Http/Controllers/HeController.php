<?php

namespace App\Http\Controllers;

use Auth;
use App\Building;
use App\FE3FDG;
use App\He;
use App\Option;
use App\Patient;
use App\PatientAssign;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HeController extends Controller
{
    protected $egress_type;

    public function __construct()
    {
        $this->egress_type = [
            new Option(1, 'Alta/Cierre'),
            new Option(2, 'Interrupción del tratamiento por mejoría'),
            new Option(3, 'Interrupción del tratamiento sin mejoría'),
            new Option(4, 'Alta con referencia'),
            new Option(5, 'Primer contacto sin asistencia')
        ];
    }

    public function index($patient_id)
    {
        $patient = Patient::where('id', $patient_id)->first();
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', route('usuario.show', $patient_id)=>$patient->fdg->full_name, '#' => 'Hoja de egreso'];

        $assigned = PatientAssign::where('patient_id', $patient_id)->where('process_code', 'he')->pluck('id');

        $path = public_path().'/storage/patients/'.$patient->id.'/he/';

        $records = He::whereIn('assign_id', $assigned)->get();
        $data = compact('patient', 'records', 'migajas', 'path');

        return view('usuario.he.index', $data);

    }

    public function create($patient_id)
    {
        $patient = Patient::where('id', $patient_id)->first();
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', route('usuario.show', $patient_id)=>$patient->fdg->full_name, route('he.index', $patient_id) => 'Hoja de egreso', "#"=>"Registrar"];

        $fields = $this->getFields();
        $process_model = new He();
        $data = compact('patient_id', 'fields', 'process_model', 'migajas');
        return view('usuario.he.create', $data);
    }

    public function store($patient_id, Request $request)
    {
        $this->validate($request, [
            'file_number' => 'nullable|string',
            'created_at' => 'required|date',
            'egress_type' => 'required|integer|min:0|max:5',
            'file' => 'nullable|mimes:jpg,jpeg,bmp,png,gif,svg,pdf|max:14000'
        ]);

        // $fields = collect($request->except(['_token', '_method']))->toArray();
        // $fields['user_id'] = Auth::user()->id;
        // $he = He::create($fields);
        // Patient::where('id', $patient_id)->update(['he_id'=>$he->id]);
        
        $assign = PatientAssign::where('patient_id', $patient_id)->where('process_code', 'he')->orderBy('created_at', 'desc')->first();
        $assign_id = $assign->id;

        $fields = collect($request->except(['_token', '_method', 'file']))->toArray();

        $fields['user_id'] = Auth::user()->id;
        $fields['assign_id'] = $assign_id;
        $he = He::create($fields);
        
        if ($request->file("file")) {
            $extension = $request->file("file")->extension();
            $file_folder = 'public/patients/'.$patient_id.'/he';
            $file_name = $he->id.'.'.$extension;
            $request->file("file")->storeAs($file_folder, $file_name);
        }

        return redirect()->route('he.index', $patient_id)->with('success', 'Hoja de egreso registrada exitosamente');
    }

    public function show($patient_id, $he)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $doc = $this->getFormattedHe($he);
        $fields = $this->getFields();
        $full_code = "3-FE8-HE_V4";

        $pdf->loadView('usuario.he.show', compact('doc', 'fields', 'full_code'));
        return $pdf->stream('he.pdf');

    }

    public function edit($patient_id, $he)
    {
        $patient = Patient::where('id', $patient_id)->first();
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', route('usuario.show', $patient_id)=>$patient->fdg->full_name, route('he.index', $patient_id) => 'Hoja de egreso', "#"=>"Editar"];
        $process_model = He::where('id', $he)->first();
        $fields = $this->getFields();
        $data = compact('fields', 'process_model', 'patient_id', 'migajas');
        return view('usuario.he.create', $data);
    }

    public function update($patient_id, Request $request, $id)
    {
        $this->validate($request, [
            'file_number' => 'nullable|string',
            'created_at' => 'required|date',
            'egress_type' => 'required|integer|min:0|max:5',
            'file' => 'nullable|mimes:jpg,jpeg,bmp,png,gif,svg,pdf|max:14000'
        ]);
        // $values = collect($request->except(['_token', '_method']))->toArray();
        // He::where('id', $he)->update($values);
        
        $fields = collect($request->except(['_token', '_method', 'file']))->toArray();
        $fields['user_id'] = Auth::user()->id;
        He::where('id', $id)->update($fields);
        
        if ($request->file("file")) {
            $extension = $request->file("file")->extension();
            $file_folder = 'public/patients/'.$patient_id.'/he';
            $file_name = $id.'.'.$extension;
            $request->file("file")->storeAs($file_folder, $file_name);
        }

        return redirect()->route('he.index', $patient_id)->with('success', 'Hoja de egreso actualizada exitosamente');
    }

    public function destroy($patient_id, $he)
    {
        // TODO delete file, if exist
        He::destroy($he);
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
        $json = file_get_contents($this->dirname_r(__DIR__, 2).'/fields/he.json');
        $fields = json_decode($json, true);

        return $fields;
    }

    // public function pdf(Program $program, FE3FDG $patient, $id)
    // {
    //     $pdf = \App::make('dompdf.wrapper');
    //     $pdf->getDomPDF()->set_option("enable_php", true);

    //     $doc = $this->getFormattedHe($id);

    //     $pdf->loadView('procedures.3.fe.8.he.show', compact('doc'));
    //     return $pdf->stream('he.pdf');
    // }

    protected function getFormattedHe($id)
    {
        $doc = He::where('id', $id)->first();
        // dd($doc);
        $doc['egress_type'] = $this->egress_type[$doc['egress_type']]->name;
        return $doc;
    }
}

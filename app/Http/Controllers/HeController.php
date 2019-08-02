<?php

namespace App\Http\Controllers;

use Auth;
use App\Building;
use App\FE3FDG;
use App\He;
use App\Option;
use App\Patient;

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
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', '#' => 'HE'];

        $patient = Patient::where('id', $patient_id)->first();
        $he = He::where('id', $patient->he_id)->first();

        return view('usuario.he.index', compact('patient_id', 'migajas', 'he'));

    }

    public function create($patient_id)
    {
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', route('he.index', $patient_id) => 'HE', "#"=>"Registrar HE"];

        $fields = $this->getFields();
        $process_model = new He();
        $data = compact('patient_id', 'fields', 'process_model', 'migajas');
        return view('usuario.he.create', $data);
    }

    public function store($patient_id, Request $request)
    {
        $this->validate($request, [
            'file_number' => 'required|string',
            'created_at' => 'required|date',
            'egress_type' => 'required|integer|min:0|max:5'
        ]);
        $fields = collect($request->except(['_token', '_method']))->toArray();
        $fields['user_id'] = Auth::user()->id;
        $he = He::create($fields);
        Patient::where('id', $patient_id)->update(['he_id'=>$he->id]);
        return redirect()->route('he.index', $patient_id)->with('success', 'Hoja de egreso registrada exitosamente');
    }

    public function show($patient_id, $he)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $doc = $this->getFormattedHe($he);

        $pdf->loadView('usuario.he.show', compact('doc'));
        return $pdf->stream('he.pdf');

    }

    public function edit($patient_id, $he)
    {
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', route('he.index', $patient_id) => 'HE', "#"=>"Registrar HE"];
        $process_model = He::where('id', $he)->first();
        $fields = $this->getFields();
        $data = compact('fields', 'process_model', 'patient_id', 'migajas');
        return view('usuario.he.create', $data);
    }

    public function update($patient_id, Request $request, $he)
    {
        $this->validate($request, [
            'file_number' => 'required|string',
            'created_at' => 'required|date',
            'egress_type' => 'required|integer|min:0|max:5'
        ]);
        $values = collect($request->except(['_token', '_method']))->toArray();
        He::where('id', $he)->update($values);
        return redirect()->route('he.index', $patient_id)->with('success', 'Hoja de egreso actualizada exitosamente');
    }

    public function destroy(He $he)
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

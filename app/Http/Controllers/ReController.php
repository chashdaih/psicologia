<?php

namespace App\Http\Controllers;

use Auth;
use App\Building;
use App\Bread;
use App\FE3FDG;
use App\Patient;
use App\Re;
use App\Partaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReController extends Controller
{
    public function index($patient_id)
    {
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', '#' => 'RE'];

        $patient = Patient::where('id', $patient_id)->first();
        $re = Re::where('id', $patient->re_id)->first();

        return view('usuario.re.index', compact('patient_id', 'migajas', 're'));

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
            'file_number' => 'required|string',
            'referencia_necesaria' => 'required|boolean',
            'lugar_de_referencia' => 'nullable|string|max:255'
        ]);
        $fields = collect($request->except(['_token', '_method']))->toArray();
        $fields['user_id'] = Auth::user()->id;
        $re = Re::create($fields);
        Patient::where('id', $patient_id)->update(['re_id'=>$re->id]);
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

    public function update($patient_id, Request $request, $re)
    {
        $this->validate($request, [
            'created_at' => 'required|date',
            'file_number' => 'required|string',
            'referencia_necesaria' => 'required|boolean',
            'lugar_de_referencia' => 'nullable|string|max:255'
        ]);
        $values = collect($request->except(['_token', '_method']))->toArray();
        Re::where('id', $re)->update($values);
        return redirect()->route('re.index', $patient_id)->with('success', 'Resultados de evaluación actualizados exitosamente');
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

    protected function getFields()
    {
        $json = file_get_contents($this->dirname_r(__DIR__, 2).'/fields/re.json');
        $fields = json_decode($json, true);

        return $fields;
    }
}

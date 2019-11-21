<?php

namespace App\Http\Controllers;

use Auth;
use App\Building;
use App\Fe3cdr;
use App\FE3FDG;
use App\Patient;
use App\Program;
use App\Http\Requests\StoreFe3cdr;
use Illuminate\Http\Request;

class Fe3cdrController extends Controller
{
    public function index($patient_id)
    {
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', '#' => 'CDR'];

        $patient = Patient::where('id', $patient_id)->first();
        $cdr = Fe3cdr::where('id', $patient->cdr_id)->first();

        return view('usuario.cdr.index', compact('migajas', 'cdr', 'patient_id'));
    }

    public function create($patient_id)
    {
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', route('cdr.index', $patient_id) => 'CDR', '#'=> 'Nuevo CDR'];

        $process_model = new Fe3cdr();
        $json = file_get_contents($this->dirname_r(__DIR__, 2).'/fields/'.'crp.json');
        $sections = json_decode($json, true);
        $data = compact('sections', 'process_model', 'patient_id', 'migajas');

        return view('usuario.cdr.create', $data);
    }

    public function store($patient_id, Request $request)
    {
        $this->validateCdr();
        
        $values = collect($request->except(['_token', '_method']))->toArray();
        $values['user_id'] = Auth::user()->id;
        $cdr = Fe3cdr::create($values);

        Patient::where('id', $patient_id)->update(['cdr_id' => $cdr->id, 'status'=>2]);
        
        return redirect()->route('usuario.index')->with('success', 'CDR registrado exitosamente');
    }

    public function show($patient_id, Fe3cdr $cdr)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $doc = Patient::where('id', $patient_id)->first();
        $process_model = $cdr;
        $json = file_get_contents($this->dirname_r(__DIR__, 2).'/fields/'.'crp.json');
        $sections = json_decode($json, true);
        $full_code="3 - FE3 - CDR";

        $results = $this->calculateResults($cdr);

        $sustancias = ['Tabaco', 'Alcohol', 'Cannabis', 'Cocaína', 'Anfetaminas', 'Inhalantes', 'Sedantes', 'Alucinógenos', 'Opiáceos', 'Otras drogas'];

        $pdf->loadView('usuario.cdr.show', compact('process_model', 'sections', 'doc', 'full_code', 'results', 'sustancias'));
        return $pdf->stream('cdr.pdf');
    }

    public function edit($patient_id, Fe3cdr $cdr)
    {
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', route('cdr.index', $patient_id) => 'CDR', '#'=> 'Editar CDR'];

        $process_model = $cdr;
        $json = file_get_contents($this->dirname_r(__DIR__, 2).'/fields/'.'crp.json');
        $sections = json_decode($json, true);
        // $age = Patient::where('id', $patient_id)->first()->fdg->birthdate->age;
        // if (is_numeric($age)) {

        // }
        $data = compact('sections', 'process_model', 'patient_id', 'migajas');
        return view('usuario.cdr.create', $data);
    }

    public function update($patient_id, Request $request, $id)
    {
        $this->validateCdr();
        $values = collect($request->except(['_token', '_method']))->toArray();
        $values['user_id'] = Auth::user()->id;
        Fe3cdr::where('id', $id)->update($values);
        return redirect()->route('cdr.index', $patient_id)->with('success', 'Cuestionario actualizado exitosamente');

    }

    public function destroy(Fe3cdr $fe3cdr)
    {
        //
    }

    protected function dirname_r($path, $count=1) 
    {
        if ($count > 1) {
           return dirname($this->dirname_r($path, --$count));
        } else {
           return dirname($path);
        }
    }

    protected function validateCdr()
    {
        return $this->validate(request(), [
            'other_filler' => 'nullable|string',
            'file_number' => 'nullable|string',
            'created_at' => 'required|date',
            // 'depa' => 'required|boolean',
            // 'depb' => 'required|boolean',
            // 'depc' => 'required|boolean',
            // 'dep1' => 'required|integer|min:0|max:10',
            // 'dep2' => 'required|integer|min:0|max:10',
            // 'dep3' => 'required|integer|min:0|max:10',
            // 'dep4' => 'required|integer|min:0|max:10',
            // 'dep5' => 'required|integer|min:0|max:10',
            // 'dep6' => 'required|integer|min:0|max:10',
            // 'dep7' => 'required|integer|min:0|max:10',
            // 'dep8' => 'required|integer|min:0|max:10',
            // 'dep9' => 'required|integer|min:0|max:10',
            // 'dep10' => 'required|integer|min:0|max:10',
            // 'dep11' => 'required|integer|min:0|max:10',
        ]);
    }

    protected function calculateResults(Fe3cdr $cdr)
    {
        $res1 = [];
        $res2 = [];
        $res3 = [];
        $values = [110, 80, 50, 50, 40, 40, 30, 50, 250, 70, 40, 70, 60, 70, 70, 60];
        $part1 = [array('dep'=> [1,11]), array('man' => [1,8]), array('psi' => [1,5]), array('epi' => [1,5]), array('dem' => [1,4]), array('tde'=>[1, 4]), array('tde'=>[5, 7]), array('tde'=>[8,12]), array('tc'=>[1,18]), array('te'=>[1,7]), array('te'=>[8,11]), array('te'=>[12,18]), array('sui'=>[1,5]), array('ans'=>[1,7]), array('sex'=>[1,4]), array('vio'=>[1,6])];
        foreach ($part1 as $key => $section) {
            foreach ($section as $code => $range) {
                $sum = 0;
                for ($i=$range[0]; $i <= end($range) ; $i++) { 
                   $sum = $sum + $cdr->{$code.$i};
                }
                array_push($res1, $sum);
                array_push($res2, round(($sum*100)/$values[$key]));
            }
        }

        $index2 = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'];
        foreach ($index2 as $letter) {
            $sum = 0;
            for ($i=2; $i < 8; $i++) {
                $sum = $sum + $cdr->{'sus'.$i.$letter};
            }
            array_push($res3, $sum);
        }
        return [$res1, $res2, $res3];
    }
}

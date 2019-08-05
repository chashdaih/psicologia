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

        Patient::where('id', $patient_id)->update(['cdr_id' => $cdr->id]);
        
        return redirect()->route('usuario.index')->with('success', 'CDR registrado exitosamente');
    }

    public function show($patient_id, Fe3cdr $cdr)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        // $cdr = Fe3cdr::where('id', $id)->first();
        // $sections = collect($this->sections);
        $json = file_get_contents($this->dirname_r(__DIR__, 2).'/fields/'.'crp.json');
        $sections = json_decode($json, true);
        // $sus = collect($this->sus);
        $pdf->loadView('pdf.cdr', compact('cdr', 'sections'));
        return $pdf->stream('invoice.pdf');
    }

    public function edit($patient_id, Fe3cdr $cdr)
    {
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', route('cdr.index', $patient_id) => 'CDR', '#'=> 'Editar CDR'];

        $process_model = $cdr;
        $json = file_get_contents($this->dirname_r(__DIR__, 2).'/fields/'.'crp.json');
        $sections = json_decode($json, true);
        $data = compact('sections', 'process_model', 'patient_id', 'migajas');
        return view('usuario.cdr.create', $data);
    }

    public function update($patient_id, Request $request, $id)
    {
        $this->validateCdr();
        $values = collect($request->except(['_token', '_method']))->toArray();
        $values['user_id'] = Auth::user()->id;
        Fe3cdr::where('id', $id)->update($values);
        // return response(200);
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
            'file_number' => 'required|string',
            'created_at' => 'required|date',
            'depa' => 'required|boolean',
            'depb' => 'required|boolean',
            'depc' => 'required|boolean',
            'dep1' => 'required|integer|min:0|max:10',
            'dep2' => 'required|integer|min:0|max:10',
            'dep3' => 'required|integer|min:0|max:10',
            'dep4' => 'required|integer|min:0|max:10',
            'dep5' => 'required|integer|min:0|max:10',
            'dep6' => 'required|integer|min:0|max:10',
            'dep7' => 'required|integer|min:0|max:10',
            'dep8' => 'required|integer|min:0|max:10',
            'dep9' => 'required|integer|min:0|max:10',
            'dep10' => 'required|integer|min:0|max:10',
            'dep11' => 'required|integer|min:0|max:10',
        ]);
    }
    
    // public function pdf(Program $program, FE3FDG $patient, $id)
    // {
    //     $pdf = \App::make('dompdf.wrapper');
    //     $pdf->getDomPDF()->set_option("enable_php", true);
    //     $cdr = Fe3cdr::where('id', $id)->first();
    //     $sections = collect($this->sections);
    //     $sus = collect($this->sus);
    //     $pdf->loadView('pdf.cdr', compact('cdr', 'sections', 'sus'));
    //     return $pdf->stream('invoice.pdf');
    // }
}

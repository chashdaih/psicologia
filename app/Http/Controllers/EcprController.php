<?php

namespace App\Http\Controllers;

use App\Ecpr;
use App\EvaluateStudent;
use App\Partaker;
use App\Program;
use Illuminate\Http\Request;

class EcprController extends Controller
{

    public function create($program_id, $partaker_id)
    {
        $program = Program::where('id_practica', $program_id)->first();
        $migajas = [route('home')=>'Inicio', route('users_list', $program_id) => $program->programa, '#'=>'Registrar Cuestionario ECPR'];
        $sections = collect(include('ecpr.php'));
        $ecpr = new Ecpr();
        return view('partaker.ecpr.create', compact('sections', 'ecpr', 'program_id', 'partaker_id', 'migajas'));
    }

    public function store($program_id, $partaker_id, Request $request)
    {
        $this->validateEcpr();
        $e_p = 'e'.$request->evaluation_phase;
        $ecpr = Ecpr::create($request->except('_token'));

        EvaluateStudent::where('partaker_id', $partaker_id)->where('program_id', $program_id)->update([$e_p=>$ecpr->id]);
        
        return redirect()->route('users_list', $program_id)->with('success', 'Evaluación registrada correctamente');
    }

    public function show($program_id, $partaker_id, $ecpr)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $doc = $this->getFormatedEcpr($ecpr);
        $sections = collect(include('ecpr.php'));

        $full_code = '3 - FE1 - ECPR';

        $partaker = Partaker::where('num_cuenta', $partaker_id)->first();
        $program = Program::where('id_practica', $program_id)->first();

        $pdf->loadView('partaker.ecpr.show', compact('doc', 'sections', 'full_code', 'partaker', 'program'));
        return $pdf->stream('ecpr.pdf');
    }


    protected function getFormatedEcpr($id)
    {
        $evaluation_phase = ['Inicial', 'Intermedia', 'Final'];

        $ecpr = Ecpr::where('id', $id)->first();
        $ecpr['evaluation_phase'] = $evaluation_phase[$ecpr->evaluation_phase - 1];
        return $ecpr;
    }

    public function edit($program_id, $partaker_id, $ecpr)
    {
        $program = Program::where('id_practica', $program_id)->first();
        $migajas = [route('home')=>'Inicio', route('users_list', $program_id) => $program->programa, '#'=>'Editar cuestionario ECPR'];
        $sections = collect(include('ecpr.php'));
        $ecpr = Ecpr::where('id', $ecpr)->first();
        return view('partaker.ecpr.create', compact('sections', 'ecpr', 'program_id', 'partaker_id', 'migajas'));
    }

    public function update($program_id, $partaker_id, Request $request, $ecpr)
    {
        $this->validateEcpr();
        Ecpr::where('id', $ecpr)->update($request->except('_token', '_method'));
        
        return redirect()->route('users_list', $program_id)->with('success', 'Evaluación actualizada correctamente');
    }

    public function destroy($id)
    {
        //
    }

    protected function validateEcpr()
    {
        $this->validate(request(), [
            'created_at'=> 'required|date',
            'semester'=> 'required|integer|min:5|max:8',
            'evaluation_phase'=>'required|integer|min:1|max:3',
            'q11'=>'required|integer|min:0|max:6' // TODO: validar el resto de las preguntas
        ]);
    }
}

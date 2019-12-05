<?php

namespace App\Http\Controllers;

use auth;
use App\Ecpo;
use App\EvaluateStudent;
use App\Program;
use App\Partaker;
// use App\Student;
use Illuminate\Http\Request;

class EcpoController extends Controller
{
    public function create($program_id, $partaker_id, $stage)
    {
        $program = Program::where('id_practica', $program_id)->first();
        $partaker = Partaker::where('num_cuenta', $partaker_id)->first();
        $migajas = [route('home')=>'Inicio', route('users_list', $program_id) => $program->programa, route('partaker.edit', $partaker_id) => $partaker->full_name, '#'=>'Registrar ECPO'];
        $sections = collect(include('ecpo.php')); // TODO move to another dir
        $ecpo = new Ecpo();
        $data = compact('sections', 'ecpo', 'program', 'partaker', 'migajas', 'stage');
        return view('partaker.ecpo.create', $data);
    }

    public function store($program_id, $partaker_id, $stage, Request $request)
    {
        $this->validateEcpo();
        $ecpo = new Ecpo($request->except('_token'));
        $ecpo->filler_id = Auth::user()->id;
        $ecpo->evaluation_phase = $stage;
        $ecpo->save();

        $es = EvaluateStudent::firstOrNew(['partaker_id' => $partaker_id, 'program_id' => $program_id]);
        $e_p = 'e'.$stage;
        $es[$e_p] = $ecpo->id;
        $es->save();
        
        return redirect()->route('users_list', $program_id)->with('success', 'Evaluación registrada correctamente');
    }

    public function show($program_id, $partaker_id, $stage, $id)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $doc = $this->getFormatedEcpo($id);
        $sections = collect(include('ecpo.php'));

        $partaker = Partaker::where('num_cuenta', $partaker_id)->first();

        $pdf->loadView('procedures.3.fe.1.ecpo.show', compact('doc', 'sections', 'partaker'));
        return $pdf->stream('ecpo_'.$partaker->full_name.'.pdf');
    }
    
    protected function getFormatedEcpo($id)
    {
        $evaluation_phase = ['','Inicial', 'Intermedia', 'Final'];

        $ecpo = Ecpo::where('id', $id)->first();
        $ecpo['evaluation_phase'] = $evaluation_phase[$ecpo->evaluation_phase];
        return $ecpo;
    }

    public function edit($program_id, $partaker_id, $stage, $ecpo)
    {
        $program = Program::where('id_practica', $program_id)->first();
        $partaker = Partaker::where('num_cuenta', $partaker_id)->first();
        $migajas = [route('home')=>'Inicio', route('users_list', $program_id) => $program->programa, route('partaker.edit', $partaker_id) => $partaker->full_name, '#'=>'Editar ECPO'];
        $sections = collect(include('ecpo.php')); // TODO move to another dir
        $ecpo =Ecpo::where('id', $ecpo)->first();
        $data = compact('sections', 'ecpo', 'program', 'partaker', 'migajas', 'stage');
        return view('partaker.ecpo.create', $data);
    }

    public function update(Request $request, $program_id, $partaker_id, $stage, $ecpo)
    {
        $this->validateEcpo();
        Ecpo::where('id', $ecpo)->update($request->except('_token', '_method'));
        
        return redirect()->route('users_list', $program_id)->with('success', 'Evaluación actualizada correctamente');
    }

    public function destroy(Ecpo $ecpo)
    {
        //
    }

    private function validateEcpo()
    {
        $this->validate(request(), [
            'created_at'=> 'nullable|date',
            'q11'=>'nullable|integer|min:0|max:5' // TODO: validar el resto de las preguntas
        ]);
    }
}

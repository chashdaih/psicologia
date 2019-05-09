<?php

namespace App\Http\Controllers;

use App\Ecpo;
// use App\Student;
use Illuminate\Http\Request;

class EcpoController extends Controller
{
    public function index()
    {
        $records = Ecpo::all(); // TODO pagination
        $doc_name = "Evaluación de competencias del estudiante de posgrado";
        $doc_code = "ecpo";
        return view('procedures.3.fe.1.ecpo.index', compact('records', 'doc_name', 'doc_code'));
    }

    public function create()
    {
        $students = Student::where('Sistema', 'Escolarizado')->get(); // TODO get supervisor's students
        $sections = collect(include('ecpo.php')); // TODO move to another dir
        $doc_code = 'ecpo';
        $doc = new Ecpo();
        $doc['active_sem'] = "2019-2"; // TODO set this value using the global variable
        $doc['supervisor'] = 1; // TODO set this with auth user
        return view('procedures.3.fe.1.ecpo.create', compact('sections', 'students', 'doc_code', 'doc'));
    }

    public function store(Request $request)
    {
        foreach ($request->except('_token') as $data => $value) {
            $valids[$data] = "required";
        }
        $validated = $request->validate($valids);
        Ecpo::create($validated);
        return response(200);
    }

    public function show($id)
    {
        $doc = $this->getFormatedEcpo($id);
        $sections = collect(include('ecpo.php'));
        return view('procedures.3.fe.1.ecpo.show', compact('doc', 'sections'));
    }

    public function pdf($id)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $doc = $this->getFormatedEcpo($id);
        $sections = collect(include('ecpo.php'));

        $pdf->loadView('procedures.3.fe.1.ecpo.show', compact('doc', 'sections'));
        return $pdf->download('ecpo_'.$doc->its_student->nombre_t.'.pdf');
    }
    
    protected function getFormatedEcpo($id)
    {
        $evaluation_phase = ['Inicial', 'Intermedia', 'Final'];

        $ecpr = Ecpo::where('id', $id)->first();
        $ecpr['evaluation_phase'] = $evaluation_phase[$ecpr->evaluation_phase];
        return $ecpr;
    }

    public function edit(Ecpo $ecpo)
    {
        //
    }

    public function update(Request $request, Ecpo $ecpo)
    {
        //
    }

    public function destroy(Ecpo $ecpo)
    {
        //
    }
}

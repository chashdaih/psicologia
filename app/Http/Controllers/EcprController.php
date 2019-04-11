<?php

namespace App\Http\Controllers;

use App\Ecpr;
use App\Student;
use Illuminate\Http\Request;

class EcprController extends Controller
{
    public function index()
    {
        $records = Ecpr::all(); // TODO pagination
        $doc_name = "Evaluación de competencias del estudiante de pregrado";
        return view('procedures.3.fe.1.ecpr.index', compact('records', 'doc_name'));
    }

    public function create()
    {
        $students = Student::where('Sistema', 'Escolarizado')->get();
        // dd($students);
        $sections = collect(include('ecpr.php'));
        $ecpr = new Ecpr();
        $ecpr['active_sem'] = "2019-2"; // TODO set this value using the global variable
        $ecpr['supervisor'] = 1; // TODO set this with auth user
        return view('procedures.3.fe.1.ecpr.create', compact('sections', 'ecpr', 'students'));
    }

    public function store(Request $request)
    {
        foreach ($request->except('_token') as $data => $value) {
            $valids[$data] = "required";
        }
        $validated = $request->validate($valids);
        // dd($validated);
        Ecpr::create($validated);
        return response(200);
    }

    public function show($id)
    {
        $doc = $this->getFormatedEcpr($id);
        $sections = collect(include('ecpr.php'));
        return view('procedures.3.fe.1.ecpr.show', compact('doc', 'sections'));
    }

    public function pdf($id)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $doc = $this->getFormatedEcpr($id);
        $sections = collect(include('ecpr.php'));

        $pdf->loadView('procedures.3.fe.1.ecpr.show', compact('doc', 'sections'));
        return $pdf->download('ecpr_'.$doc->its_student->nombre_t.'.pdf');
    }

    protected function getFormatedEcpr($id)
    {
        $evaluation_phase = ['Inicial', 'Intermedia', 'Final'];

        $ecpr = Ecpr::where('id', $id)->first();
        $ecpr['evaluation_phase'] = $evaluation_phase[$ecpr->evaluation_phase];
        return $ecpr;
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Building;
use App\Bread;
use App\FE3FDG;
use App\He;
use App\Option;
use App\Program;
use App\Student;

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

    public function index()
    {
        $doc_code = 'he';
        $mBread = new Bread('fe', 'fe8', $doc_code);
        $bread = collect($mBread->bread_array);
        $records = He::all(); //TODO pagination
        $target = "paciente";
        return view('procedures.3.fe.list', compact('records', 'bread', 'doc_code','target'));
    }

    public function create()
    {
        $fields = $this->getFields();
        $values = new He();
        $code = 'he';
        $mBread = new Bread('fe', 'fe8', $code);
        $bread = collect($mBread->bread_array);
        return view('procedures.3.fe.create', compact('bread', 'fields', 'values', 'code'));
    }

    protected function getFields()
    {
        $json = file_get_contents($this->dirname_r(__DIR__, 2).'/fields/he.json');
        $fields = json_decode($json, true);

        $patients = FE3FDG::select('id', DB::raw("CONCAT(name, ' ', last_name, ' ', mothers_name) AS name"))->get(); // TODO where supervisor or student match somewhere...
        $buildings = Building::select('id_centro as id', 'nombre as name')->get();
        $programs = Program::select('id_practica as id', 'programa as name')->where('id_supervisor', 1)->get();
        $students = Student::select('id_usuario as id', DB::raw("CONCAT(nombre_t, ' ', ap_paterno_t, ' ', ap_materno_t) AS name"))->where('Sistema', 'Escolarizado')->get(); // TODO get supervisor's students
        
        $fields['patient_id']['options'] = $patients;
        $fields['building_id']['options'] = $buildings;
        $fields['program_id']['options'] = $programs;
        $fields['student_id']['options'] = $students;
        $fields['egress_type']['options'] = $this->egress_type;

        return $fields;
    }

    public function store(Request $request)
    {
        $validated = $this->validateHe($request);
        He::create($validated);
        return response(200);
    }

    protected function validateHe($request)
    {
        foreach ($request->except('_token') as $data => $value) {
            $valids[$data] = "required";
        }
        return $request->validate($valids);
    }

    public function show($id)
    {
        $doc = $this->getFormattedHe($id);
        return view('procedures.3.fe.8.he.show', compact('doc'));
    }

    public function pdf($id)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $doc = $this->getFormattedHe($id);

        $pdf->loadView('procedures.3.fe.8.he.show', compact('doc'));
        return $pdf->download('he_'.$doc->student->nombre_t.'.pdf');
    }

    protected function getFormattedHe($id)
    {
        $doc = He::where('id', $id)->first();
        $doc['egress_type'] = $this->egress_type[$doc['egress_type']]->name;
        return $doc;
    }

    public function edit(He $he)
    {
        //
    }

    public function update(Request $request, He $he)
    {
        //
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
}

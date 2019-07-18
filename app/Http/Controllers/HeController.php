<?php

namespace App\Http\Controllers;

use Auth;
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

    // public function index()
    // {
    //     $doc_code = 'he';
    //     $mBread = new Bread('fe', 'fe8', $doc_code);
    //     $bread = collect($mBread->bread_array);
    //     $records = He::all(); //TODO pagination
    //     $target = "paciente";
    //     return view('procedures.3.fe.list', compact('records', 'bread', 'doc_code','target'));
    // }

    public function create(Program $program, FE3FDG $patient)
    {
        $fields = $this->getFields();
        $process_model = new He();
        // $values = new He();
        // $code = 'he';
        // $mBread = new Bread('fe', 'fe8', $code);
        // $bread = collect($mBread->bread_array);
        // return view('procedures.3.fe.8.he.create', compact('bread', 'fields', 'values', 'code'));
        $data = compact('program', 'patient', 'fields', 'process_model');
        return view('procedures.3.fe.8.he.create', $data);
    }

    protected function getFields()
    {
        $json = file_get_contents($this->dirname_r(__DIR__, 2).'/fields/he.json');
        $fields = json_decode($json, true);

        // $patients = FE3FDG::select('id', DB::raw("CONCAT(name, ' ', last_name, ' ', mothers_name) AS name"))->get(); // TODO where supervisor or student match somewhere...
        // $buildings = Building::select('id_centro as id', 'nombre as name')->get();
        // $programs = Program::select('id_practica as id', 'programa as name')->where('id_supervisor', 1)->get();
        // $students = Student::select('id_usuario as id', DB::raw("CONCAT(nombre_t, ' ', ap_paterno_t, ' ', ap_materno_t) AS name"))->where('Sistema', 'Escolarizado')->get(); // TODO get supervisor's students
        
        // $fields['patient_id']['options'] = $patients;
        // $fields['building_id']['options'] = $buildings;
        // $fields['program_id']['options'] = $programs;
        // $fields['student_id']['options'] = $students;
        // $fields['egress_type']['options'] = $this->egress_type;

        return $fields;
    }

    public function store(Program $program, FE3FDG $patient, Request $request)
    {
        // $validated = $this->validateHe($request);
        // He::create($validated);
        // return response(200);

        $this->validate($request, [
            'created_at' => 'required|date',
            'egress_type' => 'required|integer|min:0|max:5'
        ]);
        $fields = collect($request->except(['_token', '_method']))->toArray();
        $fields['user_id'] = Auth::user()->id;
        $fields['patient_id'] = $patient->id;
        $fields['program_id'] = $program->id_practica;
        He::create($fields);
        return redirect()->route('fe.index', ['program_id'=>$program->id_practica, 'patient_id'=>$patient->id])->with('success', 'Hoja de egreso registrada exitosamente');

    }

    // protected function validateHe($request)
    // {
    //     foreach ($request->except('_token') as $data => $value) {
    //         $valids[$data] = "required";
    //     }
    //     return $request->validate($valids);
    // }

    // public function show($id)
    // {
    //     $doc = $this->getFormattedHe($id);
    //     return view('procedures.3.fe.8.he.show', compact('doc'));
    // }

    public function pdf(Program $program, FE3FDG $patient, $id)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $doc = $this->getFormattedHe($id);

        $pdf->loadView('procedures.3.fe.8.he.show', compact('doc'));
        return $pdf->stream('he.pdf');
    }

    protected function getFormattedHe($id)
    {
        $doc = He::where('id', $id)->first();
        // dd($doc);
        $doc['egress_type'] = $this->egress_type[$doc['egress_type']]->name;
        return $doc;
    }

    public function edit(Program $program, FE3FDG $patient, $id)
    {
        $process_model = He::where('id', $id)->first();
        $fields = $this->getFields();
        $data = compact('fields', 'process_model', 'program', 'patient');
        return view('procedures.3.fe.8.he.create', $data);
    }

    public function update(Program $program, FE3FDG $patient, Request $request, $id)
    {
        $this->validate($request, [
            'created_at' => 'required|date',
            'egress_type' => 'required|integer|min:0|max:5'
        ]);
        $values = collect($request->except(['_token', '_method']))->toArray();
        He::where('id', $id)->update($values);
        return redirect()->route('fe.index', ['program_id'=>$program->id_practica, 'patient_id'=>$patient->id])->with('success', 'Hoja de egreso actualizada exitosamente');
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

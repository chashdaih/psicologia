<?php

namespace App\Http\Controllers;

// use App\Patient;
use App\Building;
use App\FE3FDG;
use App\Program;
use Illuminate\Http\Request;

class FE3FDGController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        $program = Program::where('id_practica', $id)->first();
        $patients = FE3FDG::where('program_id', $id)->get();
        $migajas = [route('home') => 'Inicio', '#' => $program->programa];

        return view('patients.index', compact('patients', 'program', 'migajas'));
    }
    
    public function create($id)
    {

        $program_id = $id;
        $program = Program::where('id_practica', $id)->first();
        $migajas = [route('home') => 'Inicio', route('patient.index', ['program_id' => $program_id]) => $program->programa, '#' => 'Nueva ficha de datos generales'];
        return view('procedures.3.fe.3.fdg.create', compact('program_id', 'migajas'));
    }

    public function store(Request $request, $id)
    {

        $this->validateForm();

        $fdg = FE3FDG::create(collect($request)->toArray() + ['user_id' => auth()->id(), 'program_id' => $id]);

        return redirect()->route('patient.index', ['id' => $id])->with('success', 'Usuario registrado exitosamente');
    }

    // public function show(FE3FDG $fe3fdg)
    // {
    //     //
    // }

    public function edit($id, $fdg)
    {
        $program_id = $id;
        $program = Program::where('id_practica', $id)->first();
        $fdg = FE3FDG::where('id', $fdg)->first();
        $migajas = [route('home') => 'Inicio', route('patient.index', ['program_id' => $program_id]) => $program->programa, '#' => $fdg->full_name];
        return view('procedures.3.fe.3.fdg.create', compact('program_id', 'fdg', 'migajas'));
    }

    public function update($program_id, $id, Request $request)
    {
        $this->validateForm();
        $values = collect($request->except(['_token', '_method']))->toArray();
        FE3FDG::where('id', $id)->update($values);
        return redirect()->route('fe.index', ['program_id'=>$program_id, 'patient_id'=>$id])->with('success', 'Resultados de evaluación actualizados exitosamente');
        
    }

    public function destroy(FE3FDG $fe3fdg)
    {
        //
    }

    protected function validateForm()
    {
        return $this->validate(request(), [
            'name' => 'required',
            'last_name' => 'required',
            'mothers_name' => 'required',
            'curp' => 'required',
            'gender' => 'required',
            'birthdate' => 'required',
            'marital_status' => 'required',
            'is_unam' => 'required',
            'academic_entity' => 'nullable',
            'position' => 'nullable',
            'career' => 'nullable',
            'semester' => 'nullable',
            'person_requesting' => 'required',
            'name_requester' => 'nullable',
            //
            'tutor_name_1' => 'nullable', // TODO required_if age < 18 
            'relationship_1' => 'nullable',
            'tutor_birthdate_1' => 'nullable',
            'studies_level_1' => 'nullable',
            'occupation_1' => 'nullable',
            'tutor_name_2' => 'nullable',
            'relationship_2' => 'nullable',
            'tutor_birthdate_2' => 'nullable',
            'email' => 'nullable|email',
            'studies_level_2' => 'nullable',
            // 
            'street_name' => 'required',
            'external_number' => 'required',
            'internal_number' => 'nullable',
            'neighborhood' => 'required',
            'postal_code' => 'required',
            'municipality' => 'required',
            'state' => 'required',
            'house_phone' => 'nullable',
            'cell_phone' => 'nullable',
            'work_phone' => 'nullable',
            'work_phone_ext' => 'nullable',
            //
            'scholarship' => 'required',
            'studied_years' => 'required',
            'has_work' => 'required',
            'has_salary' => 'required',
            'work_description' => 'nullable',
            'household_members' => 'required',
            'monthly_family_income' => 'required',
            'number_people_contributing' => 'required|numeric',
            'number_people_depending' => 'required|numeric',
            'house_is' => 'required|numeric',
            //
            'service_type' => 'required|numeric',
            'service_modality' => 'required|numeric',
            'consultation_cause' => 'required',
            'mhGAP_cause_classification' => 'required|numeric',
            'problem_since' => 'required',
            'has_recived_previous_treatment' => 'required|boolean',
            'number_times_treatment' => 'nullable|numeric',
            'type_previous_treatment' => 'nullable|numeric',
            'refer' => 'required|numeric',
            'refer_problem' => 'nullable',
            'unam_previous_treatment' => 'required|boolean',
            'unam_previous_treatment_program' => 'nullable|numeric',
            'has_health_issue' => 'required|boolean',
            'health_issue' => 'nullable',
            'takes_medication' => 'nullable|boolean',
            'medication' => 'nullable',
            'medication_dose' => 'nullable',
            'prefer_time' => 'required|numeric',
            //
            'appointment_date' => 'nullable|date',
            'appointment_time' => 'nullable',
            'supervisor' => 'nullable|numeric',
            // 'program' => 'required|numeric'
        ]);
    }
}

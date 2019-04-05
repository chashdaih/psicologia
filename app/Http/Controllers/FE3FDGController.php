<?php

namespace App\Http\Controllers;

// use App\Patient;
use App\Building;
use App\FE3FDG;
use Illuminate\Http\Request;

class FE3FDGController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $patients = Patient::all();
        $records = FE3FDG::all();
        return view('students.3.FE3.FDG.index', compact('records'));
    }

    public function create()
    {
        $programs = Building::all();
        return view('students.3.FE3.FDG.create', compact('programs'));
    }

    public function store()
    {
        $attributes = $this->validateForm();

        $fdg = FE3FDG::create($attributes + ['filler' => auth()->id()]);

        return response(200);
    }

    public function show(FE3FDG $fe3fdg)
    {
        //
    }

    public function edit(FE3FDG $fe3fdg)
    {
        //
    }

    public function update(FE3FDG $fe3fdg)
    {
        //
    }

    public function destroy(FE3FDG $fe3fdg)
    {
        //
    }

    protected function validateForm()
    {
        return request()->validate([
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
            'program' => 'required|numeric'
        ]);
    }
}

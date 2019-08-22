<?php

namespace App\Http\Controllers;

use Auth;
use App\Building;
use App\FE3FDG;
use App\Program;
use App\Patient;
use Illuminate\Http\Request;

class FE3FDGController extends Controller
{
    protected $marital_status = ['Soltero', 'Casado', 'Unión libre', 'Viudo', 'Separado'];
    protected $position = ['Estudiante', 'Académico', 'Administrativo'];
    protected $person_requesting = ['La persona', 'Padres o tutores', 'Otro familiar', 'Otro'];
    protected $relationship = ['de la madre', 'del padre', 'del tutor'];
    protected $studies_level = ['No cuenta con escolaridad', 'Preescolar', 'Primaria', 'Secundaria', 'Preparatoria', 'Licenciatura', 'Posgrado'];
    protected $house_is = ['Otra', 'Propia', 'Propia, pero la está pagando', 'Rentada', 'Prestada', 'Intestada o en litigio'];
    protected $service_type = ['Orientación/Consejo breve', 'Evaluación', 'Taller', 'Intervención'];
    protected $service_modality = ['Individual/Grupal', 'Familiar/Pareja'];
    protected $mhGAP_cause_classification = ['Depresión', 'Psicosis', 'Epilepsia', 'Transtornos mentales y conductuales del niño y el adolescente', 'Demencia', 'Transtornos por el consumo de sustancias', 'Autolesión/Suicidio', 'Otros padecimientos de salud importantes'];
    protected $type_previous_treatment = ['Psicológica', 'Psiquiátrica', 'Médica', 'Neurológica', 'Otra'];
    protected $refer = ['No', 'Escuela', 'Trabajo', 'Hospital/Instituto', 'Dpto. de Psiquiatría y Salud Mental (Fac. Medicina)', 'Otra'];
    protected $prefer_time = ['Matutino', 'Vespertino', 'Indiferente'];

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

        $centers = Building::all();
        $preferedCenter = null;
        if (Auth::user()->type == 3) { // participante
            $partaker_id = Auth::user()->partaker->num_cuenta;
            $partPrograms = ProgramPartaker::where('id_participante', $partaker_id)->where('ciclo_activo', config('globales.semestre_activo'))->first();
            if ($partPrograms) {
                $preferedCenter = $partPrograms->program->id_centro;
            }
        } else {
            $preferedCenter = Auth::user()->supervisor->id_centro;
        }
        $migajas = [route('home') => 'Inicio', route('usuario.index')=>'Personas atendidas','#' => 'Nueva ficha de datos generales'];
        return view('usuario.fdg.create', compact('migajas', 'centers', 'preferedCenter'));

        // $program_id = $id;
        // $program = Program::where('id_practica', $id)->first();
        // $migajas = [route('home') => 'Inicio', route('patient.index', ['program_id' => $program_id]) => $program->programa, '#' => 'Nueva ficha de datos generales'];
        // return view('procedures.3.fe.3.fdg.create', compact('program_id', 'migajas'));
    }

    public function store(Request $request, $id)
    {
        $this->validateForm();
        $parameters = collect($request)->toArray() + ['user_id' => auth()->id()];
        $fdg = FE3FDG::create($parameters);
        Patient::create(['fdg_id' => $fdg->id]);
        return redirect()->route('usuario.index')->with('success', 'Usuario registrado exitosamente');

        // $this->validateForm();

        // $fdg = FE3FDG::create(collect($request)->toArray() + ['user_id' => auth()->id(), 'program_id' => $id]);

        // return redirect()->route('patient.index', ['id' => $id])->with('success', 'Usuario registrado exitosamente');
    }

    public function show($patient_id, $id)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $doc = $this->formatFdg($id);
        $full_code = "3-FE3-FDG";
        $pdf->loadView('usuario.fdg.show', compact('doc', 'full_code'));
        return $pdf->stream('fdg.pdf');
    }

    public function edit($patient_id, $id)
    {
        $fdg = FE3FDG::where('id', $id)->first();
        $patient = Patient::where('id', $patient_id)->first();
        $centers = Building::all();
        $migajas = [route('home') => 'Inicio', route('usuario.index')=>'Personas atendidas', route('usuario.show', $patient_id)=>$patient->fdg->full_name,'#' => 'Editar ficha de datos generales'];
        return view('usuario.fdg.create', compact('migajas', 'fdg', 'centers'));

        // $program_id = $id;
        // $program = Program::where('id_practica', $id)->first();
        // $fdg = FE3FDG::where('id', $fdg)->first();
        // $migajas = [route('home') => 'Inicio', route('patient.index', ['program_id' => $program_id]) => $program->programa, '#' => $fdg->full_name];
        // return view('procedures.3.fe.3.fdg.create', compact('program_id', 'fdg', 'migajas'));
    }

    public function update($patient_id, $id, Request $request)
    {
        $this->validateForm();
        $values = collect($request->except(['_token', '_method']))->toArray();
        FE3FDG::where('id', $id)->update($values);
        return redirect()->route('usuario.index')->with('success', 'Ficha de datos generales actualizada exitosamente');

        // $this->validateForm();
        // $values = collect($request->except(['_token', '_method']))->toArray();
        // FE3FDG::where('id', $id)->update($values);
        // return redirect()->route('fe.index', ['program_id'=>$program_id, 'patient_id'=>$id])->with('success', 'Resultados de evaluación actualizados exitosamente');
        
    }

    public function destroy(FE3FDG $fe3fdg)
    {
        //
    }

    protected function validateForm()
    {
        return $this->validate(request(), [
            'center_id' => 'required|integer|min:1|max:255',
            'other_filler' => 'nullable|string|max:255',
            'file_number' => 'nullable|string|max:255',
            'created_at' => 'required|date',
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mothers_name' => 'required|string|max:255',
            'curp' => 'required|string|max:255',
            'gender' => 'required|boolean',
            'birthdate' => 'required|date',
            'marital_status' => 'required|boolean',
            'is_unam' => 'required|boolean',
            'academic_entity' => 'nullable|string|max:255',
            'position' => 'nullable|integer|min:0|max:255',
            'career' => 'nullable|string|max:255',
            'semester' => 'nullable|string|max:255',
            'person_requesting' => 'required|integer|max:255',
            'name_requester' => 'nullable|string|max:255',
            //
            'tutor_name_1' => 'nullable|string|max:255', // TODO required_if age < 18 
            'relationship_1' => 'nullable|integer|max:255',
            'tutor_birthdate_1' => 'nullable|date',
            'studies_level_1' => 'nullable|integer|max:255',
            'occupation_1' => 'nullable|string|max:255',
            'tutor_name_2' => 'nullable|string|max:255',
            'relationship_2' => 'nullable|integer|max:255',
            'tutor_birthdate_2' => 'nullable|date',
            'studies_level_2' => 'nullable|integer|max:255',
            // 
            'street_name' => 'required|string|max:255',
            'external_number' => 'required|string|max:255',
            'internal_number' => 'nullable|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'municipality' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'house_phone' => 'nullable|string|max:255',
            'cell_phone' => 'nullable|string|max:255',
            'work_phone' => 'nullable|string|max:255',
            'work_phone_ext' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            //
            'scholarship' => 'required|integer|max:255',
            'studied_years' => 'required|integer|max:255',
            'has_work' => 'required|boolean',
            'who_depends_on' => 'nullable||string|max:255',
            'has_salary' => 'nullable|boolean',
            'work_description' => 'nullable|string|max:255',
            'household_members' => 'required|integer|max:255',
            'monthly_family_income' => 'required|string|max:255',
            'number_people_contributing' => 'required|integer|max:255',
            'number_people_depending' => 'required|integer|max:255',
            'house_is' => 'required|integer|max:255',
            //
            'service_type' => 'required|integer|max:255',
            'service_modality' => 'required||integer|max:255',
            'consultation_cause' => 'required|string',
            'mhGAP_cause_classification' => 'nullable|integer|max:255',
            'problem_since' => 'required|string|max:255',
            'has_recived_previous_treatment' => 'required|boolean',
            'number_times_treatment' => 'nullable|integer|max:255',
            'type_previous_treatment' => 'nullable|integer|max:255',
            'refer' => 'required|integer|max:255',
            'refer_problem' => 'nullable|string|max:255',
            'unam_previous_treatment' => 'required|boolean',
            'unam_previous_treatment_program' => 'nullable|integer|max:255',
            'has_health_issue' => 'required|boolean',
            'health_issue' => 'nullable|string|max:255',
            'takes_medication' => 'nullable|boolean',
            'medication' => 'nullable|string|max:255',
            'medication_dose' => 'nullable',
            'prefer_time' => 'required|integer|max:255',
        ]);
    }

    protected function formatFdg($id) {
        $fdg = FE3FDG::where('id', $id)->first();
        // dd($fdg);
        $fdg->marital_status = $this->marital_status[$fdg->marital_status];
        if ($fdg->position) {
            $fdg->position = $this->position[$fdg->position];
        }
        $fdg->person_requesting = $this->person_requesting[$fdg->person_requesting];
        if ($fdg->relationship_1) {
            $fdg->relationship_1 = $this->relationship[$fdg->relationship_1];
        }
        if ($fdg->studies_level_1) {
            $fdg->studies_level_1 = $this->studies_level[$fdg->studies_level_1];
        }
        if ($fdg->relationship_2) {
            $fdg->relationship_2 = $this->relationship[$fdg->relationship_2];
        }
        if ($fdg->studies_level_2) {
            $fdg->studies_level_2 = $this->studies_level[$fdg->studies_level_2];
        }
        $fdg->scholarship = $this->studies_level[$fdg->scholarship];
        $fdg->house_is = $this->house_is[$fdg->house_is];
        $fdg->service_type = $this->service_type[$fdg->service_type];
        $fdg->service_modality = $this->service_modality[$fdg->service_modality];
        // $fdg->mhGAP_cause_classification = $this->mhGAP_cause_classification[$fdg->mhGAP_cause_classification];
        if ($fdg->type_previous_treatment) {
            $fdg->type_previous_treatment = $this->type_previous_treatment[$fdg->type_previous_treatment];
        }
        $fdg->refer = $this->refer[$fdg->refer];
        $fdg->prefer_time = $this->prefer_time[$fdg->prefer_time];
        return $fdg;
    }
}

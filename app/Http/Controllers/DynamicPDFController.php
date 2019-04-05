<?php

namespace App\Http\Controllers;

use App\FE3FDG;
use Illuminate\Http\Request;
use PDF;

class DynamicPDFController extends Controller
{
    protected $marital_status = ['Soltero', 'Casado', 'Unión libre', 'Viudo', 'Separado'];
    protected $position = ['Estudiante', 'Académico', 'Administrativo'];
    protected $person_requesting = ['La persona', 'Padres o tutores', 'Otro familiar', 'Otro'];
    protected $relationship = ['de la madre', 'del padre', 'del tutor'];
    protected $studies_level = ['No cuenta con escolaridad', 'Preescolar', 'Primaria', 'Secundaria', 'Preparatoria', 'Licenciatura', 'Posgrado'];
    protected $house_is = ['Otra', 'Propia', 'Propia, pero la está pagando', 'Rentada', 'Prestada', 'Intestada o en litigio'];
    protected $service_type = ['Orientación/Consejo breve', 'Evaluación', 'Intervención'];
    protected $service_modality = ['Individual/Grupal', 'Familiar/Pareja'];
    protected $mhGAP_cause_classification = ['Depresión', 'Psicosis', 'Epilepsia', 'Transtornos mentales y conductuales del niño y el adolescente', 'Demencia', 'Transtornos por el consumo de sustancias', 'Autolesión/Suicidio', 'Otros padecimientos de salud importantes'];
    protected $type_previous_treatment = ['Psicológica', 'Psiquiátrica', 'Médica', 'Neurológica', 'Otra'];
    protected $refer = ['No', 'Escuela', 'Trabajo', 'Hospital/Instituto', 'Dpto. de Psiquiatría y Salud Mental (Fac. Medicina)'];
    protected $prefer_time = ['Matutino', 'Vespertino', 'Indiferente'];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function fe3fdg($id)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $fdg = $this->getFdg($id);
        $pdf->loadView('pdf.test', compact('fdg'));
        return $pdf->download('invoice.pdf');
    }

    public function fe3fdg_html($id)
    {
        $fdg = $this->getFdg($id);
        return view('pdf.test', compact('fdg'));
    }

    public function fe3cdr($id)
    {
        $pdf = $this->getPdf();
        $cdr = $this->getCdr($id);
        $pdf->loadView('pdf.cdr', compact('cdr'));
        return $pdf->download('invoice.pdf');
    }
    public function fe3cdr_html($id)
    {
        $cdr = $this->getCdr($id);
        return view('pdf.cdr', compact('cdr'));
    }

    protected function getPdf()
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        return $pdf;
    }

    protected function getFdg($id) {
        $fdg = FE3FDG::where('id', $id)->first();
        $fdg->marital_status = $this->marital_status[$fdg->marital_status];
        $fdg->position = $this->position[$fdg->position];
        $fdg->person_requesting = $this->person_requesting[$fdg->person_requesting];
        $fdg->relationship_1 = $this->relationship[$fdg->relationship_1];
        $fdg->studies_level_1 = $this->studies_level[$fdg->studies_level_1];
        $fdg->relationship_2 = $this->relationship[$fdg->relationship_2];
        $fdg->studies_level_2 = $this->studies_level[$fdg->studies_level_2];
        $fdg->scholarship = $this->studies_level[$fdg->scholarship];
        $fdg->house_is = $this->house_is[$fdg->house_is];
        $fdg->service_type = $this->service_type[$fdg->service_type];
        $fdg->mhGAP_cause_classification = $this->mhGAP_cause_classification[$fdg->mhGAP_cause_classification];
        $fdg->type_previous_treatment = $this->type_previous_treatment[$fdg->type_previous_treatment];
        $fdg->refer = $this->refer[$fdg->refer];
        $fdg->prefer_time = $this->prefer_time[$fdg->prefer_time];
        return $fdg;
    }
}

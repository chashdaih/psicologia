<?php

namespace App\Http\Controllers;

use Excel;
use App\Patient;
use Illuminate\Http\Request;

class ExcelController extends Controller
{

    private $json;

    function __construct() {
        $this->json = file_get_contents($this->dirname_r(__DIR__, 2).'/fields/'.'excel_titles.json');
    }
    
    public function fdg($patientId)
    {
        $docTitle = "FE3-FDG";
        $patient = Patient::where('id', $patientId)->first();
        $fdg = $patient->fdg;
        // dd($patient->fdg->full_name);
        $data = [$fdg->file_number, $fdg->curp, $fdg->created_at->toDateString(), $fdg->full_name, $fdg->gender ? 'Hombre' : 'Mujer', $fdg->birthdate->toDateString(), $fdg->birthdate->age, $fdg->marital, $fdg->isUnam ? 'Si' : 'No', $fdg->academic_entity, $fdg->position, $fdg->career, $fdg->semester, $fdg->requester, $fdg->name_requester,
        // segunda sección
        $fdg->tutor_name_1, $fdg->rel1, $fdg->tutor_birthdate_1, $fdg->tutor_birthdate_1 ? $fdg->tutor_birthdate_1->age : null, $fdg->tStudies1, $fdg->occupation_1,
        $fdg->tutor_name_2, $fdg->rel2, $fdg->tutor_birthdate_2, $fdg->tutor_birthdate_2 ? $fdg->tutor_birthdate_2->age : null, $fdg->tStudies2, $fdg->occupation_2,
        // Dirección de la persona que requiere el servicio
        $fdg->street_name, $fdg->external_number, $fdg->internal_number, $fdg->neighborhood, $fdg->postal_code, $fdg->municipality, $fdg->state, $fdg->house_phone, $fdg->cell_phone, $fdg->work_phone, $fdg->work_phone_ext, $fdg->email,
        // Situación socioeconómica
        $fdg->studyLevel, $fdg->studied_years, $fdg->has_work ? 'Si' : 'No', $fdg->has_salary ? 'Si':'No', $fdg->work_description, $fdg->household_members, $fdg->monthly_family_income, $fdg->number_people_contributing, $fdg->number_people_depending, $fdg->housing,
        // Servicio solicitado
        $fdg->serType, $fdg->serMod, $fdg->consultation_cause, $fdg->mhGAP_cause_classification, $fdg->problem_since, $fdg->has_recived_previous_treatment ? 'Si':'No', $fdg->number_times_treatment, $fdg->type_previous_treatment, $fdg->refer ? 'Si':'No', $fdg->refer_problem, $fdg->unam_previous_treatment ? 'Si':'No', $fdg->unam_previous_treatment_program, $fdg->has_health_issue ? 'Si':'No', $fdg->health_issue, $fdg->takes_medication ? 'Si':'No', $fdg->medication, $fdg->medication_dose, $fdg->times, $fdg->user->type == 3 ? $fdg->user->partaker->full_name : $fdg->user->supervisor->full_name, null,
        //cita
        null, null, null,];

        Excel::create($docTitle, function($excel) use ($data, $docTitle) {
            $excel->sheet($docTitle, function($sheet) use ($data) {
                $titles = json_decode($this->json, true);
                $this->formatHeader($sheet, $titles, 0, 0);
                $sheet->row(5, $data);
            });
        })->download('xlsx');
    }

    private function formatHeader($sheet, $titles, $fNumber, $procNumber)
    {
        //Secciones
        $sections = $titles[$fNumber]['procedures'][$procNumber]['sections'];
        $initialCol = 0;
        $endCol = 0;
        $headers = [];
        foreach ($sections as $section) {
            $endCol = $initialCol + count($section['columns']);
            $initialLetter = \PHPExcel_Cell::stringFromColumnIndex($initialCol);
            $endLetter = \PHPExcel_Cell::stringFromColumnIndex($endCol - 1);
            $this->formatRow($sheet, $initialLetter.'3', $endLetter.'3', $section['title'], $section['color']);
            $initialCol = $endCol;
            //Encabezados
            $headers = array_merge($headers, $section['columns']);
        }
        $sheet->row(4, $headers);

        //Nombre del proceso
        $this->formatRow($sheet, 'A1', $endLetter.'1', $titles[$fNumber]['title'], $titles[$fNumber]['color'], true, 20);

        //Nombre del documento
        $this->formatRow($sheet, 'A2', $endLetter.'2', $titles[$fNumber]['procedures'][$procNumber]['title'], $titles[$fNumber]['procedures'][$procNumber]['color'], true);

    }

    private function formatRow($sheet, $start, $end, $text, $color, $bold = false, $fontSize = 16)
    {
        $sheet->mergeCells($start.':'.$end);
        $sheet->cell($start, function($cell) use ($text, $fontSize, $bold, $color) {
            $cell->setValue($text);
            $cell->setFont(array('size' => $fontSize,'bold' => $bold ));
            $cell->setBackground($color);
            $cell->setAlignment('center');
            //(top, right, bottom, left)
            $cell->setBorder('thin', 'thin', 'thin', 'thin');
        });

    }

    protected function dirname_r($path, $count=1) 
    {
        if ($count > 1) {
           return dirname($this->dirname_r($path, --$count));
        } else {
           return dirname($path);
        }
    }
}

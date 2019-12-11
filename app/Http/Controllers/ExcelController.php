<?php

namespace App\Http\Controllers;

use Excel;
use App\Patient;
use App\Ps;
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

    public function cdr($patientId)
    {
        $docTitle = "FE3-CDR";
        $patient = Patient::where('id', $patientId)->first();
        $cdr = $patient->cdr;
        $data = [
            // Identificación
            $patient->fdg->curp, $cdr->created_at->toDateString(), null, null, $cdr->other_filler ? $cdr->other_filler : ($cdr->user->type == 3 ? $cdr->user->partaker->full_name : null),  $cdr->user->type != 3 ? $cdr->user->supervisor->full_name : null, 
        ];
        $data = $this->addColumns($cdr, $data, 'dep', 8);
        $data = $this->addColumns($cdr, $data, 'psi', 5);
        $data = $this->addColumns($cdr, $data, 'epi', 5);
        $data = $this->addColumns($cdr, $data, 'dem', 3);
        $data = $this->addColumns($cdr, $data, 'tde', 4);
        $data = $this->addColumns($cdr, $data, 'tde', 7, 4);
        $data = $this->addColumns($cdr, $data, 'tde', 12, 7);
        $data = $this->addColumns($cdr, $data, 'tc', 11);
        $data = $this->addColumns($cdr, $data, 'tc', 25, 11);
        $data = $this->addColumns($cdr, $data, 'te', 7);
        $data = $this->addColumns($cdr, $data, 'te', 11, 7);
        $data = $this->addColumns($cdr, $data, 'te', 18, 11);
        $data = $this->addColumns($cdr, $data, 'sui', 3);
        $data = $this->addColumns($cdr, $data, 'ans', 7);
        $data = $this->addColumns($cdr, $data, 'sex', 7);
        $data = $this->addColumns($cdr, $data, 'vio', 6);

        $tempN = [];
        for($i = 0; $i < 7; $i++) {
            $letras = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'];
            $tempL = [];
            foreach ($letras as $key=>$letra) {
                $tempL[$key] = $cdr->{'sus'.($i + 1).($letra)};
            }
            $tempN = array_merge($tempN, $tempL);
        }
        $data = array_merge($data, $tempN);
        $data = array_merge($data, [$cdr->sus80, $cdr->sus81]);

        $results = $this->calculateResults($cdr);
        $numSections = 16;
        for ($j = 0; $j < $numSections; $j++) {
            array_push($data, $results[0][$j], $results[1][$j], null);
        }
        foreach ($results[2] as $key => $value) {
            array_push($data, $value);
        }

        Excel::create($docTitle, function($excel) use ($data, $docTitle) {
            $excel->sheet($docTitle, function($sheet) use ($data) {
                $titles = json_decode($this->json, true);
                $this->formatHeader($sheet, $titles, 0, 1);
                $sheet->row(5, $data);
            });
        })->download('xlsx');
    }

    public function ps($id)
    {
        $docTitle = "Plan de servicios";
        $ps = Ps::where('id', $id)->first();
        $data = [$ps->assign->patient->fdg->curp, $ps->created_at->toDateString(), $ps->assign->program->center->nombre, $ps->assign->program->programa, $ps->user->type == 3 ? $ps->user->partaker->full_name : $ps->user->supervisor->full_name, $ps->assign->program->supervisor->full_name, $ps->tipo, $ps->modalidad];

        Excel::create($docTitle, function($excel) use ($data, $docTitle) {
            $excel->sheet($docTitle, function($sheet) use ($data) {
                $titles = json_decode($this->json, true);
                $this->formatHeader($sheet, $titles, 1, 1);
                $sheet->row(5, $data);
            });
        })->download('xlsx');
    }

    private function calculateResults($cdr)
    {
        $res1 = [];
        $res2 = [];
        $res3 = [];
        $values = [110, 80, 50, 50, 40, 40, 30, 50, 250, 70, 40, 70, 60, 70, 70, 60];
        $part1 = [array('dep'=> [1,11]), array('man' => [1,8]), array('psi' => [1,5]), array('epi' => [1,5]), array('dem' => [1,4]), array('tde'=>[1, 4]), array('tde'=>[5, 7]), array('tde'=>[8,12]), array('tc'=>[1,18]), array('te'=>[1,7]), array('te'=>[8,11]), array('te'=>[12,18]), array('sui'=>[1,5]), array('ans'=>[1,7]), array('sex'=>[1,4]), array('vio'=>[1,6])];
        foreach ($part1 as $key => $section) {
            foreach ($section as $code => $range) {
                $sum = 0;
                for ($i=$range[0]; $i <= end($range) ; $i++) { 
                   $sum = $sum + $cdr->{$code.$i};
                }
                array_push($res1, $sum);
                array_push($res2, round(($sum*100)/$values[$key]));
            }
        }

        $index2 = ['a', 'b', 'c', 'd', 'e', 'g', 'h', 'i', 'j'];
        foreach ($index2 as $letter) {
            $sum = 0;
            for ($i=2; $i < 8; $i++) {
                $sum = $sum + $cdr->{'sus'.$i.$letter};
            }
            array_push($res3, $sum);
        }
        return [$res1, $res2, $res3];
    }

    private function addColumns($cdr, $data, $code, $total, $start = 0)
    {
        $temp = [];
        for($i = $start; $i < $total; $i++) {
            $temp[] = $cdr->{$code.($i + 1)};
        }
        return array_merge($data, $temp);
    }

    private function formatHeader($sheet, $titles, $fNumber, $procNumber)
    {
        //Secciones
        $sections = $titles[$fNumber]['procedures'][$procNumber]['sections'];
        $initialCol = 0;
        $endCol = 0;
        $headers = [];
        if (!is_string($sections[0])){ // si no hay sub secciones
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
        } else {
            $endCol = $initialCol + count($sections);
            $initialLetter = \PHPExcel_Cell::stringFromColumnIndex($initialCol);
            $endLetter = \PHPExcel_Cell::stringFromColumnIndex($endCol - 1);
            for ($i = $initialCol; $i < $endCol; $i++) {
                $letter = \PHPExcel_Cell::stringFromColumnIndex($i);
                $sheet->mergeCells($letter.'3:'.$letter.'4');
            }
            $sheet->row(3, $sections);
        }

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

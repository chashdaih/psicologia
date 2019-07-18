<?php

namespace App\Http\Controllers;

// use App\Bread;
use App\CaracteristicasServicio;
use App\Cssp;
use App\Fe3cdr;
use App\FE3FDG;
use App\He;
use App\Ps;
use App\Program;
use App\Re;

use Illuminate\Http\Request;

class ProceduresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($program_id, $patient_id)
    {
        // if ($procedure == null) 
        // {
        //     $mBread = new Bread();
        //     $bread = collect($mBread->bread_array);
        //     return view('procedures.index', compact('bread'));
        // }

        // $mBread = new Bread($procedure);
        // $bread = collect($mBread->bread_array);
        
        // $json = file_get_contents($this->dirname_r(__DIR__, 2).'/fields/processes.json');
        // $process = json_decode($json, true)[$procedure];

        // return view('procedures.3.index', compact('process', 'bread'));
        $program = Program::where('id_practica', $program_id)->first();
        // dd($program);
        $car_ser = CaracteristicasServicio::where('program_id', $program_id)->first();
        $patient = FE3FDG::where('id', $patient_id)->first();

        $migajas = [route('home') => 'Inicio', route('patient.index', ['program_id' => $program_id]) => $program->programa, '#' => $patient->full_name];

        $data = compact('program', 'patient', 'car_ser', 'migajas');

        $cdr = Fe3cdr::where('program_id', $program_id)->where('patient_id', $patient_id)->first();
        if ($cdr) {
            $data['cdr'] = $cdr;
        }

        $ps = Ps::where('FE3FDG_id', $patient_id)->where('program_id', $program_id)->first();
        if ($ps) {
            $data['ps'] = $ps;
        }

        $re = Re::where('program_id', $program_id)->where('patient_id', $patient_id)->first();
        if($re) {
            $data['re'] = $re;
        }

        $he = He::where('program_id', $program_id)->where('patient_id', $patient_id)->first();
        if($he) {
            $data['he'] = $he;  
        }

        $cssp = Cssp::where('program_id', $program_id)->where('patient_id', $patient_id)->first();
        if($cssp) {
            $data['cssp'] = $cssp;  
        }

        return view('procedures.3.fe.index', $data);
    }

    public function doc($procedure, $number)
    {
        $mBread = new Bread($procedure, $procedure.$number);
        $bread = collect($mBread->bread_array);

        $json = file_get_contents($this->dirname_r(__DIR__, 2).'/fields/processes.json');
        $procedure = json_decode($json, true)[$procedure]['procedures'][$procedure.$number];
        // dd($procedure);
        return view('procedures.3.procedure', compact('bread', 'procedure'));
    }

    protected function dirname_r($path, $count=1){
        if ($count > 1) {
           return dirname($this->dirname_r($path, --$count));
        } else {
           return dirname($path);
        }
    }
}

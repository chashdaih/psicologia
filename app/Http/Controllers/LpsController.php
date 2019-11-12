<?php

namespace App\Http\Controllers;

use Auth;
use App\Bread;
use App\Building;
use App\Lps;
use App\Program;
use App\ProgramPartaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LpsController extends Controller
{
    protected $process = 'ie';
    protected $number = '2';
    protected $doc_code = 'lps';
    protected $base_url;
    protected $params;

    public function __construct()
    {
        $doc_code = $this->doc_code;
        $this->base_url = 'procedures.3.'.$this->process.'.'.$this->number.'.'.$doc_code;
        $mBread = new Bread($this->process, $this->process.$this->number, $this->doc_code);
        $bread = collect($mBread->bread_array);
        $this->params = compact('bread', 'doc_code');
    }

    public function index()
    {
        $id_centro = Auth::user()->supervisor->id_centro;

        $this->params['records'] = $this->filter($id_centro, Auth::user()->supervisor->id_supervisor, config('globales.semestre_activo'));
        $user_type = Auth::user()->type;

        if ($user_type == 5) { // jefe de centro
            $supervisors = DB::table('supervisores')
            ->where('estatus', '=', 'Activa')
            ->where('id_centro', '=', Auth::user()->supervisor->id_centro)
            ->orderBy('nombre', 'asc')->select('id_supervisor', 
            DB::raw("CONCAT(nombre, ' ', ap_paterno, ' ', ap_materno) AS full_name"))->get();
            $this->params['supervisors'] = $this->fixNames($supervisors);
        }

        if($user_type == 6) { // coordinación
            $stages = Building::all();
            $this->params['stages'] = $stages;

            $supervisors = DB::table('supervisores')->where('estatus', '=', 'Activa')
            ->orderBy('nombre', 'asc')->select('id_supervisor', 
            DB::raw("CONCAT(nombre, ' ', ap_paterno, ' ', ap_materno) AS full_name"))->get();
            $this->params['supervisors'] = $this->fixNames($supervisors);
        }
        
        // dd($this->params);


        return view($this->base_url.'.index', $this->params);
    }

    public function show($id)
    {
        $this->params['program'] = Program::where('id_practica', $id)->first();
        return view($this->base_url.'.show', $this->params);
    }

    public function pdf($id)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $program = Program::where('id_practica', $id)->first();
        $this->params['program'] = $program;

        $programPartakers = ProgramPartaker::where('id_practica', $id)->where('estado', 'Inscrito')->get();
        $this->params['programPartakers'] = $programPartakers;
        

        $pdf->loadView($this->base_url.'.show', $this->params);
        return $pdf->stream('listaEstudiantesInscritos.pdf');
    }

    public function filter($stage, $sup, $per) // webservice
    {
        if(Auth::user()->supervisor->id_centro == 10) {
            $stage = 0;
        }

        $records = DB::table('practicas as p')
        ->where('tipo', 'CURRICULAR')
        ->when($stage > 0, function ($query) use ($stage) {
            return $query->where('p.id_centro', '=', $stage);
        })
        ->when($sup > 0, function ($query) use ($sup) {
            return $query->where('p.id_supervisor', '=', $sup);
        })
        ->when($per != 0, function ($query) use ($per) {
            // dd($per);
            return $query->where('p.semestre_activo', '=', $per);
        })
        ->join('centros as c', 'p.id_centro', '=', 'c.id_centro')
        ->join('supervisores as s', 'p.id_supervisor', '=', 's.id_supervisor')
        ->select('p.id_practica', 'p.programa', 'p.semestre_activo', 'c.nombre as centro', 'p.tipo',
            DB::raw("CONCAT(s.nombre, ' ', s.ap_paterno, ' ', s.ap_materno) AS full_name"))
            ->orderBy('p.semestre_activo', 'desc')
        ->get();

        return $this->fixNames($records);
    }

    protected function fixNames($records)
    {
        if($records) {
            foreach ($records as $record) {
                $record->full_name = ucwords(mb_strtolower($record->full_name));
                // $record->full_name = preg_replace('/\s+/', ' ',ucwords(mb_strtolower($record->full_name)));
            }
        }
        return $records;
    }

}

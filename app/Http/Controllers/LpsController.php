<?php

namespace App\Http\Controllers;

use Auth;
use App\Bread;
use App\Lps;
use App\Program;
use Illuminate\Http\Request;

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
        // TODO use new records when students can register
        $url = url()->current();
        $type = "EXTRACURRICULAR";
        if (substr($url, -1) == "s") {
            $type = "CURRICULAR";
        }
        $records = Program::where('id_supervisor', Auth::user()->supervisor->id_supervisor)
                    ->where('tipo', $type)
                    ->where('semestre_activo', '2019-2')->get();

        // $records = Doc::where('supervisor_id', Auth::user()->supervisor->id_supervisor)->get();
        $this->params['records'] = $records;

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

        $this->params['program'] = Program::where('id_practica', $id)->first();

        $pdf->loadView($this->base_url.'.show', $this->params);
        return $pdf->download('rps.pdf');
    }

}

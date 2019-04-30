<?php

namespace App\Http\Controllers;

use Auth;
use App\Bread;
use App\Option;
use App\Program;
use App\Rps as Doc;
use Illuminate\Http\Request;

class RpsController extends Controller
{
    protected $process = 'ie';
    protected $number = '1';
    protected $doc_code = 'rps';
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
        // TODO decide what to do with old records
        // $records = Program::where('id_supervisor', Auth::user()->supervisor->id_supervisor)
        //             ->where('semestre_activo', '2019-2')->get();
        $records = Doc::where('supervisor_id', Auth::user()->supervisor->id_supervisor)->get();
        $this->params['records'] = $records;

        return view($this->base_url.'.index', $this->params);
    }

    public function create()
    {
        $this->params['sections'] = $this->getSections();
        $values = new Doc();
        $values->supervisor_id = Auth::user()->supervisor->id_supervisor;
        $this->params['values'] = $values;

        return view($this->base_url.'.create', $this->params);
    }

    protected function getSections()
    {
        $json = file_get_contents(dirname(__DIR__, 2).'/fields/'.$this->doc_code.'.json');
        $fields = json_decode($json, true);

        $fields[0]['fields']['anual']['options'] = [new Option(0, "semestral"), new Option(1, "anual")];

        return $fields;
    }

    public function store(Request $request)
    {
        $validated = $this->validateDoc($request);
        Doc::create($validated);
        return response(200);
    }

    protected function validateDoc($request)
    {
        foreach ($request->except('_token', 'colaboration_number', 'insitu_sup_name', 'insitu_sup_phone', 'insitu_sup_cell', 'insitu_sup_email') as $data => $value) {
            $valids[$data] = "required";
        }
        return $request->validate($valids);
    }

    public function show($id)
    {
        $this->params['sections'] = $this->getSections();;
        $this->params['doc'] = Doc::where('id', $id)->first();
        return view($this->base_url.'.show', $this->params);
    }

    public function pdf($id)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $this->params['sections'] = $this->getSections();;
        $this->params['doc'] = Doc::where('id', $id)->first();

        $pdf->loadView($this->base_url.'.show', $this->params);
        return $pdf->download('rps.pdf');
    }
}

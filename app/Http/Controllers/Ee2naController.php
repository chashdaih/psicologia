<?php

namespace App\Http\Controllers;

use Auth;
use App\Bread;
use App\Na;
use App\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Ee2naController extends Controller
{
    protected $process = 'ee';
    protected $number = '2';
    protected $doc_code = 'na';
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
        $programs = Program::where('id_supervisor', Auth::user()->supervisor->id_supervisor)
                        ->where('semestre_activo', '2019-2')->get();
        $this->params['records'] = $programs;
        return view($this->base_url.'.index', $this->params);
    }

    public function create()
    {
        $programs = Program::where('id_supervisor', Auth::user()->supervisor->id_supervisor)
                        ->where('semestre_activo', '2019-2')->get();
        $this->params['programs'] = $programs;
        return view($this->base_url.'.create', $this->params);
    }

    public function store(Request $request)
    {
        $validated = $this->validateForm();
        // TODO fix validated
        $path = $request->file("upload_file")->storeAs($this->doc_code, $request->program_id."_".$request->provider_id);
        $doc = new Na();
        $doc->program_id = $request->program_id;
        $doc->provider_id = $request->provider_id;
        if ($path) {
            $doc->save();
        }
        // return view($this->base_url.'.index', $this->params);
        return redirect()->route($this->doc_code.'.index');
    }

    protected function validateForm()
    {
        return request()->validate([
            "program_id" => "required",
            "provider_id" => "required",
            "upload_file" => "required|mimes:pdf|max:14000"
        ]);
    }
    
    public function download($uri)
    {
        return Storage::download('/'.$this->doc_code.'/'.$uri);
    }

    // public function show(Na $na)
    // {
    //     //
    // }

    // public function edit(Na $na)
    // {
    //     //
    // }

    // public function update(Request $request, Na $na)
    // {
    //     //
    // }

    // public function destroy(Na $na)
    // {
    //     //
    // }
}

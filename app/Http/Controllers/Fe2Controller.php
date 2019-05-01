<?php

namespace App\Http\Controllers;

use Auth;
use App\Bread;
use App\Fe2;
use App\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Fe2Controller extends Controller
{
    protected $process = 'fe';
    protected $number = '2';
    protected $doc_code = 'e_d';
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
        if ($request->evaluation_stage == 0) {
            $record = new Fe2();
            $record->program_id = $request->program_id;
            $record->partaker_id = $request->partaker_id;
        } else {
            $record = Fe2::where('program_id', $request->program_id)->where('partaker_id', $request->partaker_id)->first();
        }
        $record->evaluation_stage = $request->evaluation_stage;
        $path = $request->file("upload_file")->storeAs($this->doc_code, $request->program_id."_".$request->partaker_id."_".$request->evaluation_stage);
        if($path) {
            $record->save();
        }
        // return view($this->base_url.'.index', $this->params);
        return redirect()->route($this->doc_code.'.index');
    }

    protected function validateForm()
    {
        return request()->validate([
            "program_id" => "required",
            "partaker_id" => "required",
            "evaluation_stage" => "required",
            "upload_file" => "required|mimes:pdf|max:14000"
        ]);
    }

    public function download($file_name)
    {
        return Storage::download('/'.$this->doc_code.'/'.$file_name);
    }

    // public function show(Fe2 $fe2)
    // {
    //     //
    // }

    // public function edit(Fe2 $fe2)
    // {
    //     //
    // }

    // public function update(Request $request, Fe2 $fe2)
    // {
    //     //
    // }

    // public function destroy(Fe2 $fe2)
    // {
    //     //
    // }

}

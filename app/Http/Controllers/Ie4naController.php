<?php

namespace App\Http\Controllers;

use Auth;
use App\Bread;
use App\Ie4;
use App\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Ie4naController extends Controller
{
    protected $process = 'ie';
    protected $number = '4';
    protected $doc_code = 'cr_ss';
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
        // dd($programs[0]->ie4s);
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
        $path = $request->file("upload_file")->storeAs($this->doc_code, $request->program_id."_".$request->partaker_id);
        $ie4 = new Ie4();
        $ie4->program_id = $request->program_id;
        $ie4->partaker_id = $request->partaker_id;
        if ($path) {
            $ie4->save();
        }
        // return view($this->base_url.'.index', $this->params);
        return redirect()->route($this->doc_code.'.index');
    }

    protected function validateForm()
    {
        return request()->validate([
            "program_id" => "required",
            "partaker_id" => "required",
            "upload_file" => "required|mimes:pdf|max:14000"
        ]);
    }

    public function download($uri)
    {
        return Storage::download('/'.$this->doc_code.'/'.$uri);
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

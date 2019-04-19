<?php

namespace App\Http\Controllers;

use App\Bread;
use App\Fe2;
use Illuminate\Http\Request;

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
        return view($this->base_url.'index', $this->params);
    }

    public function create()
    {
        return view($this->base_url.'.create', $this->params);
    }

    public function store(Request $request)
    {
        $validated = $this->validateForm();
        $path = $validated->file("upload_file")->store($this->doc_code);
        dd($path);
        return view($this->base_url.'.index', $this->params);
    }

    public function show(Fe2 $fe2)
    {
        //
    }

    public function edit(Fe2 $fe2)
    {
        //
    }

    public function update(Request $request, Fe2 $fe2)
    {
        //
    }

    public function destroy(Fe2 $fe2)
    {
        //
    }

    protected function validateForm()
    {
        return request()->validate([
            "upload_file" => "required|mimes:pdf|max:14000"
        ]);
    }
}

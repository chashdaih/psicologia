<?php

namespace App\Http\Controllers;

use App\Bread;

use Illuminate\Http\Request;

class ProceduresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($procedure = null)
    {
        if ($procedure == null) 
        {
            $mBread = new Bread();
            $bread = collect($mBread->bread_array);
            return view('procedures.index', compact('bread'));
        }

        $mBread = new Bread($procedure);
        $bread = collect($mBread->bread_array);
        
        $json = file_get_contents($this->dirname_r(__DIR__, 2).'/fields/processes.json');
        $process = json_decode($json, true)[$procedure];

        return view('procedures.3.index', compact('process', 'bread'));
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

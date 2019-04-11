<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProceduresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($procedure = null)
    {
        if ($procedure == null) {
            return view('procedures.index');
        }
        $data = include('procedures.php');
        $procedures = collect($data[$procedure]);
        $acronym = $procedure;
        return view('procedures.3.index', compact('acronym', 'procedures'));
    }
}

<?php

namespace App\Http\Controllers;

use Auth;
use App\EvaluateStudent;
use App\Program;
use Illuminate\Http\Request;

class EvaluateStudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $id = Auth::user()->supervisor->id_supervisor;

        $programs = Program::where('id_supervisor', $id)->get();

        return view('evaluate.index', compact('programs'));
    }

    // public function create()
    // {
    //     //
    // }

    public function store(Request $request)
    {
        //
    }

    public function show(EvaluateStudent $evaluateStudent)
    {
        //
    }

    // public function edit(EvaluateStudent $evaluateStudent)
    // {
    //     //
    // }

    // public function update(Request $request, EvaluateStudent $evaluateStudent)
    // {
    //     //
    // }

    // public function destroy(EvaluateStudent $evaluateStudent)
    // {
    //     //
    // }
}

<?php

namespace App\Http\Controllers;

use App\Building;
use App\Program;
use App\FE3FDG;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $program = Program::where('id_practica', $id)->first();
        $patients = FE3FDG::where('program_id', $id)->get();
        $migajas = [route('home') => 'Inicio', '#' => $program->programa];

        return view('patients.index', compact('patients', 'program', 'migajas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function create($id)
    {

        $program_id = $id;
        $program = Program::where('id_practica', $id)->first();
        $migajas = [route('home') => 'Inicio', route('patient.index', ['program_id' => $program_id]) => $program->programa, '#' => 'Nueva ficha de datos generales'];
        return view('procedures.3.fe.3.fdg.create', compact('program_id', 'migajas'));
    }
}

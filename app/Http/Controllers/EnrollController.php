<?php

namespace App\Http\Controllers;

use Auth;
use App\Document;
use App\EvaluateStudent;
use App\Program;
use App\ProgramData;
use App\ProgramPartaker;
use Illuminate\Http\Request;

class EnrollController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $programs = Program::where('semestre_activo', '2020-1')
        ->where('cupo_actual','>', '0')
        ->get();

        $enroll_programs = ProgramPartaker::where('id_participante', Auth::user()->partaker->num_cuenta)->get();
        // dd($enroll_programs);
        
        return view('enroll.index', compact('programs', 'enroll_programs'));
    }

    public function detail($id)
    {
        $program = Program::where('id_practica', $id)->first();
        $extra = ProgramData::where('id_practica', $id)->first();

        return view('enroll.detail', compact('program', 'extra'));
    }

    public function enroll($id)
    {
        $partaker_id = Auth::user()->partaker->num_cuenta;

        $rel = ProgramPartaker::create([
            'id_participante' => $partaker_id,
            'id_practica' => $id,
            'ciclo_activo' => '2019-2',
            'estado' => 'Necesita Documentacion'
        ]);

        $program = Program::where('id_practica', $id)->first();
        $program['cupo_actual'] = $program['cupo_actual'] - 1;
        $program->save();

        $document = Document::create([
            'id_participante' => $partaker_id,
            'seguro_imss' => 0,
            'carta_comp' => 0,
            'historial_ac' => 0,
            'constancia' => 0,
            'id_tramite' => $rel->id_tramite
        ]);

        $evaluation = EvaluateStudent::create([
            'program_id' => $id,
            'partaker_id' => $partaker_id
        ]);

        return redirect()->route('insc')->with('message', "¡Éxito! Registrado al programa");
    }

    public function docs(Request $request)
    {
        $partaker_id = Auth::user()->partaker->num_cuenta;

        $this->validate($request, [
            'id_tramite' => 'required',
            'seguro_imss' => 'nullable|mimes:pdf|max:14000',
            'carta_comp' => 'nullable|mimes:pdf|max:14000',
            'historial_ac' => 'nullable|mimes:pdf|max:14000'
        ]);

        $doc = Document::where('id_tramite', $request['id_tramite'])->first();

        if ($request->file('seguro_imss')) {
            $request->file("seguro_imss")->storeAs($partaker_id, 'seguro.pdf');
            $doc['seguro_imss'] = 1;
        }
        if ($request->file('carta_comp')) {
            $request->file("carta_comp")->storeAs($partaker_id, 'carta.pdf');
            $doc['carta_comp'] = 1;
        }
        if ($request->file('historial_ac')) {
            $request->file("historial_ac")->storeAs($partaker_id, 'historial.pdf');
            $doc['historial_ac'] = 1;
        }

        $doc->save();

        if ($doc['seguro_imss'] && $doc['carta_comp'] && $doc['historial_ac']) {
            $enrolled = ProgramPartaker::where('id_tramite', $request['id_tramite'])->first();
            $enrolled->estado = "Inscrito";
            $enrolled->save();
        }

        return redirect()->route('insc');
    }
}

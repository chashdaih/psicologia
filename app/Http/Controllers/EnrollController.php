<?php

namespace App\Http\Controllers;

use Auth;
use App\Document;
use App\EvaluateStudent;
use App\Program;
use App\ProgramData;
use App\ProgramPartaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EnrollController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $programs = DB::table('practicas as p')
        ->where('semestre_activo', config('globales.semestre_activo'))
        ->where('cupo_actual','>', '0')
        ->join('supervisores as s', 'p.id_supervisor', 's.id_supervisor')
        ->join('informacion_practicas as i', 'p.id_practica', 'i.id_practica')
        ->join('centros as c', 'p.id_centro', 'c.id_centro')
        ->select('programa', 'periodicidad', 'p.horario', 'p.id_practica', 'c.nombre', 'i.resumen', 's.id_supervisor', 'c.id_centro',
            DB::raw("CONCAT(s.nombre, ' ', s.ap_paterno, ' ', s.ap_materno) AS full_name")
        )->orderBy('programa', 'asc')
        ->get();

        $programs = $this->fixNames($programs);
        
        return view('enroll.index', compact('programs'));
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

        $this->baseEnroll($partaker_id, $id);

        return redirect()->route('home')->with('success', "¡Éxito! pre-registrado al programa");
    }

    public function enrolledBySup($program, Request $request)
    {
        $this->baseEnroll($request->partaker_id, $program);

        return 200;
    }

    protected function baseEnroll($partaker_id, $id)
    {

        $registered_programs = ProgramPartaker::where('id_participante', $partaker_id)
        ->where('ciclo_activo', config('globales.semestre_activo'))
        ->first();

        if ($registered_programs) {
            return redirect()->route('insc')->with('fail', "Hasta el periodo de altas y bajas, solo se permite un programa por participante");
        }

        $rel = ProgramPartaker::create([
            'id_participante' => $partaker_id,
            'id_practica' => $id,
            'ciclo_activo' => config('globales.semestre_activo'), // TODO enviar ciclo activo?
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

    }

    public function disenroll(ProgramPartaker $enr)
    {
        $program = Program::where('id_practica', $enr->id_practica)->first();
        if ($program->cupo_actual < $program->cupo) {
            $program['cupo_actual'] = $program['cupo_actual'] + 1;
            $program->save();
        }

        Document::where('id_tramite', $enr->id_tramite)->delete();

        EvaluateStudent::where('program_id', $enr->id_practica)->where('partaker_id', $enr->id_participante)->delete();

        Storage::deleteDirectory('public/'.$enr->id_tramite);

        $enr->delete();

        return redirect()->back()->with('success', "¡Éxito! Dado de baja del programa");
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
            $request->file("seguro_imss")->storeAs('public/'.$doc->id_tramite, 'seguro.pdf');
            $doc['seguro_imss'] = 1;
        }
        if ($request->file('carta_comp')) {
            $request->file("carta_comp")->storeAs('public/'.$doc->id_tramite, 'carta.pdf');
            $doc['carta_comp'] = 1;
        }
        if ($request->file('historial_ac')) {
            $request->file("historial_ac")->storeAs('public/'.$doc->id_tramite, 'historial.pdf');
            $doc['historial_ac'] = 1;
        }

        $doc->save();

        if ($doc['seguro_imss'] && $doc['carta_comp'] && $doc['historial_ac']) {
            $enrolled = ProgramPartaker::where('id_tramite', $request['id_tramite'])->first();
            $enrolled->estado = "Inscrito";
            $enrolled->save();
        }

        return redirect()->route('home');
    }

    public function cartaCompromiso($program_id)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);

        $program = Program::where('id_practica', $program_id)->first();

        if ($program->semestre_activo == config('globales.semestre_activo')) {

            $pdf->loadView('enroll.carta_compromiso_pre', compact('program'));
            return $pdf->download('carta_compromiso.pdf');

        }

        // TODO conectar con el viejo sistema
        return 404;

    }

    protected function fixNames($records)
    {
        if($records) {
            foreach ($records as $record) {
                $record->full_name = preg_replace('/\s+/', ' ',ucwords(mb_strtolower($record->full_name)));
            }
        }
        return $records;
    }
}

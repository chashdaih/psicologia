<?php

namespace App\Http\Controllers;

use App\Building;
use App\Fe3cdr;
// use App\FE3FDG;
use App\Patient;
use App\Http\Requests\StoreFe3cdr;
use Illuminate\Http\Request;

class Fe3cdrController extends Controller
{
    public function index()
    {
        $records = Fe3cdr::all();
        return view('procedures.3.fe.3.cdr.index', compact('records'));
    }

    public function create()
    {
        $sections = json_encode([[
                'title' => 'dep',
                'time' => 'En las últimas dos semanas...',
                'questions' => [
                    '1. Te has sentido triste frecuentemente',
                    '2. Lloras frecuentemente',
                    '3. Ha disminuido tu interés en realizar actividades que antes disfrutabas',
                    '4. Has pensado que tu futuro es poco prometedor',
                    '5. Duermes más o duermes menos de lo habitual',
                    '6. Has dejado de asistir a actividades, reuniones y/o compromisos sociales por falta de energía',
                    '7. Ha disminuido o aumentado tu apetito sin causa aparente',
                    '8. Te has sentido fatigado sin causa aparente'
                    ]
                ],
            [
                'title' => 'psi',
                'time' => 'En los últimos tres meses...',
                'questions' => [
                    '1. Has sospechado que las personas planean algo en tu contra',
                    '2. Has escuchado voces que los demás no perciben',
                    '3. Has visto cosas que los demás no perciben',
                    '4. Has tenido pensamientos persistentes que los demás no comparten contigo',
                    '5. Te han dicho que has descuidado tu aspecto personal'
                ]
            ], 
            [
                'title' => 'epi',
                'time' => 'Has presentado alguna de las siguientes condiciones',
                'questions' => [
                    '1. Crisis convulsivas',
                    '2. Has tenido pérdida de conciencia por varios minutos',
                    '3. Cuando perdiste la conciencia tuviste rigidez muscular',
                    '4. Cuando perdiste la conciencia se paralizó alguna parte del cuerpo',
                    '5. Cuando pierdes la conciencia te quedas en una postura fija por varios minutos'
            ]
                ],
            [
                'title' => 'dem',
                'time' => 'En los últimos seis meses (sección únicamente para edades de 55 años en adelante, responder las preguntas de la 1 a la 3)...',
                'questions' => [
                    '1. Tienes problemas de memoria (olvidos excesivos)',
                    '2. Te has sentido desorientado (no saber dónde estás o no reconocer a familiares cercanos)',
                    '3. Has caminado por un tiempo sin rumbo fijo ni objetivo claro',
                ]
            ]
        ]);
        // $fdgs = FE3FDG::select('id','curp', 'name', 'last_name', 'mothers_name')->get();
        $fdgs = Patient::all();
        $programs = Building::all();
        return view('procedures.3.fe.3.cdr.create', compact('sections', 'fdgs', 'programs'));
    }

    public function store(Request $request)
    {
        foreach ($request->except('_token') as $data => $value) {
            $valids[$data] = "required";
          }
          
          $validated = $request->validate($valids);
        // $validated = $request->validated();
        // dd($validated);
        Fe3cdr::create($validated);
        return response(200);
    }

    public function show(Fe3cdr $fe3cdr)
    {
        //
    }

    public function edit(Fe3cdr $fe3cdr)
    {
        //
    }

    public function update(Request $request, Fe3cdr $fe3cdr)
    {
        //
    }

    public function destroy(Fe3cdr $fe3cdr)
    {
        //
    }
}

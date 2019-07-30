<?php

namespace App\Http\Controllers;

use Auth;
use App\Building;
use App\Fe3cdr;
use App\FE3FDG;
use App\Patient;
use App\Program;
use App\Http\Requests\StoreFe3cdr;
use Illuminate\Http\Request;

class Fe3cdrController extends Controller
{
    public function index($patient_id)
    {
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', '#' => 'CDR'];
        $cdr = Fe3cdr::where('patient_id', $patient_id)->first();
        return view('usuario.cdr.index', compact('migajas', 'cdr', 'patient_id'));
    }


    protected $sections = //json_encode(
        [[
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
    ]
    //)
    ;
    protected $sus = [
        'fields' => [
            'a. Tabaco (cigarrillos, tabaco para mascar, puros, etc.)',
            'b. Bebidas alcohólicas (cervez, vinos, licores, etc.)',
            'c. Cannabis (marihuana, mota, hierba, hachís, etc.)',
            'd. Cocaína (coca, crack, etc.)',
            'e. Estimulantes de tipo anfetamina (speed, anfetaminas, éxtasis, ect.)',
            'f. Inhalantes (óxido nitroso, pegamento, gasolina, solvente para pintura, etc.)',
            'g. Sedantes o pastillas para dormir (diazepam, alprazolam, flunitrazepam, midazolam, etc.)',
            'h. Alucinógenos (LSD, morfina, metadona, bbuprenorfina, codeían, etc.)',
            'i. Opiáceos (heroína, morfina, metadona, buprenorfina, codeína, etc.)',
            'j. Otras, especifica:'
        ],
        '2opt' => [
            'No',
            'Si'
        ],
        '3opt' => [
            'No, nunca',
            'Sí, en los últimos tres meses',
            'Sí, pero no en los últimos tres meses'
        ],
        '5opt' => [
            'Nunca',
            'Una o dos veces',
            'Mensualmente',
            'Semanalmente',
            'Diariamente o casi diariamente'
        ],
        'sections' => [
            ['title' => '1. A lo largo de la vida, ¿cuál de las siguientes sustancias ha consumido alguna vez (sólo las que consumió sin receta médica)?',
            'type' => '2opt',
            'code' => 'sus1',
            'obs' => 'Si la respuesta es negativa para todas las preguntas, detener esta sección de preguntas. Si la respuesta es afirmativa a cualquiera de estas preguntas, hacer la pregunta 2 para cada sustancia que se haya consumido alguna vez.'
            ],
            ['title' => '2. En los últimos tres meses, ¿con qué frecuencia has consumido las sustancias que mencionó (primera droga, segunda droga, etc.)',
            'type' => '5opt',
            'code' => 'sus2',
            'obs' => 'Si la respuesta es “Nunca” a todas las secciones de la pregunta 2, pasar a la pregunta 6. Si se ha consumido alguna sustancia de la pregunta 2 en los últimos tres meses, continuar con las preguntas 3, 4 y 5 para cada sustancia consumida.'
            ],
            
        ]
    ];

    public function create($patient_id)
    {
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', route('cdr.index', $patient_id) => 'CDR', '#'=> 'Nuevo CDR'];
        $process_model = new Fe3cdr();
        $sections = $this->sections;
        $data = compact('sections', 'process_model', 'patient_id', 'migajas');
        return view('usuario.cdr.create', $data);
    }

    public function store($patient_id, Request $request)
    {
        foreach ($request->except(['_token', '_method']) as $data => $value) {
            $valids[$data] = "required|integer|min:0|max:10";
        }
          
        $this->validate($request, $valids);
        
        $values = collect($request->except(['_token', '_method']))->toArray();
        $values['program_id'] = 0;
        $values['user_id'] = Auth::user()->id;
        $values['patient_id'] = $patient_id;
        $cdr = Fe3cdr::create($values);

        Patient::where('id', $patient_id)->update(['cdr_id' => $cdr->id]);
        
        return redirect()->route('cdr.index', $patient_id)->with('success', 'CDR registrado exitosamente');
    }

    public function show($patient_id, Fe3cdr $cdr)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        // $cdr = Fe3cdr::where('id', $id)->first();
        $sections = collect($this->sections);
        $sus = collect($this->sus);
        $pdf->loadView('pdf.cdr', compact('cdr', 'sections', 'sus'));
        return $pdf->stream('invoice.pdf');
    }

    public function edit($patient_id, Fe3cdr $cdr)
    {
        $migajas = [route('home')=>'Inicio', route('usuario.index')=>'Usuarios', route('cdr.index', $patient_id) => 'CDR', '#'=> 'Editar CDR'];
        $process_model = $cdr;
        $sections = $this->sections;
        $data = compact('sections', 'process_model', 'patient_id', 'migajas');
        return view('usuario.cdr.create', $data);
    }

    public function update(Program $program, FE3FDG $patient, Request $request, $id)
    {
        foreach ($request->except(['_token', '_method']) as $data => $value) {
            $valids[$data] = "required|integer|min:0|max:10";
        }
          
        $this->validate($request, $valids);

        // dd($request);
        $values = collect($request->except(['_token', '_method']))->toArray();
        $values['user_id'] = Auth::user()->id;
        Fe3cdr::where('id', $id)->update($values);
        // return response(200);
        return redirect()->route('fe.index', ['program_id'=>$program->id_practica, 'patient_id'=>$patient->id])->with('success', 'Cuestionario actualizado exitosamente');

    }

    public function destroy(Fe3cdr $fe3cdr)
    {
        //
    }
    
    // public function pdf(Program $program, FE3FDG $patient, $id)
    // {
    //     $pdf = \App::make('dompdf.wrapper');
    //     $pdf->getDomPDF()->set_option("enable_php", true);
    //     $cdr = Fe3cdr::where('id', $id)->first();
    //     $sections = collect($this->sections);
    //     $sus = collect($this->sus);
    //     $pdf->loadView('pdf.cdr', compact('cdr', 'sections', 'sus'));
    //     return $pdf->stream('invoice.pdf');
    // }
}

<?php

namespace App\Http\Controllers;

use App\FE3FDG;
use App\Fe3cdr;
use Illuminate\Http\Request;
use PDF;

class DynamicPDFController extends Controller
{
    protected $marital_status = ['Soltero', 'Casado', 'Unión libre', 'Viudo', 'Separado'];
    protected $position = ['Estudiante', 'Académico', 'Administrativo'];
    protected $person_requesting = ['La persona', 'Padres o tutores', 'Otro familiar', 'Otro'];
    protected $relationship = ['de la madre', 'del padre', 'del tutor'];
    protected $studies_level = ['No cuenta con escolaridad', 'Preescolar', 'Primaria', 'Secundaria', 'Preparatoria', 'Licenciatura', 'Posgrado'];
    protected $house_is = ['Otra', 'Propia', 'Propia, pero la está pagando', 'Rentada', 'Prestada', 'Intestada o en litigio'];
    protected $service_type = ['Orientación/Consejo breve', 'Evaluación', 'Intervención'];
    protected $service_modality = ['Individual/Grupal', 'Familiar/Pareja'];
    protected $mhGAP_cause_classification = ['Depresión', 'Psicosis', 'Epilepsia', 'Transtornos mentales y conductuales del niño y el adolescente', 'Demencia', 'Transtornos por el consumo de sustancias', 'Autolesión/Suicidio', 'Otros padecimientos de salud importantes'];
    protected $type_previous_treatment = ['Psicológica', 'Psiquiátrica', 'Médica', 'Neurológica', 'Otra'];
    protected $refer = ['No', 'Escuela', 'Trabajo', 'Hospital/Instituto', 'Dpto. de Psiquiatría y Salud Mental (Fac. Medicina)'];
    protected $prefer_time = ['Matutino', 'Vespertino', 'Indiferente'];

    public function __construct()
    {
        $this->middleware('auth');
    }

    protected $sections = [[
            'title' => 'DEP',
            'code' => 'dep',
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
            'title' => 'PSI',
            'code' => 'psi',
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
            'title' => 'EPI',
            'code' => 'epi',
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
            'title' => 'DEM',
            'code' => 'dem',
            'time' => 'En los últimos seis meses (sección únicamente para edades de 55 años en adelante, responder las preguntas de la 1 a la 3)...',
            'questions' => [
                '1. Tienes problemas de memoria (olvidos excesivos)',
                '2. Te has sentido desorientado (no saber dónde estás o no reconocer a familiares cercanos)',
                '3. Has caminado por un tiempo sin rumbo fijo ni objetivo claro',
            ]
        ],
        [
            'title' => 'TDE SECCIÓN NIÑOS - ADOLESCENTES',
            'code' => 'tde',
            'time' => 'Señala el grado en que el menor ha presentado alguno de los siguientes problemas (< 5 años)',
            'questions' => [
                '1. Falta de apetito',
                '2. Poco crecimiento en comparación con otros niños',
                '3. Debilidad en los músculos',
                '4. No ha alcanzado las pautas del desarrollo en comparación con los niños de su edad (sonreír, sentarse, interactuar con otras personas, caminar, hablar o ir al baño)'
            ]
        ],
        [
            'title' => null,
            'code' => 'tde',
            'time' => 'Mediana infancia (6 a 12 años)',
            'questions' => [
                '5. Retraso en aprender a leer',
                '6. Retraso en aprender a escribir',
                '7. Retraso en el autocuidado (vestirse y bañarse solo, capillarse los dientes, etc.)'
            ]
        ],
        [
            'title' => null,
            'code' => 'tde',
            'time' => 'Adolescentes (13 a 18 años)',
            'questions' => [
                '8. Dificultad para leer',
                '9. Dificultad para escribir',
                '10. Deficiente rendimiento escolar',
                '11. Dificultad para la interacción social',
                '12. Dificultad para adaptarse a los cambios'
            ]
        ],
        [
            'title' => 'TC SECCIÓN NIÑOS - ADOLESCENTES',
            'code' => 'tc',
            'time' => 'Señala el grado en que el menor ha presentado alguno de los siguientes problemas (4 a 18 años) PAH',
            'questions' => [
                '1. Se mueve constantemente',
                '2. Tiene dificultad para permanecer sentado',
                '3. Habla en exceso',
                '4. Da respuestas antes de que terminen de preguntarle',
                '5. Tiene dificultades para esperar su turno',
                '6. Interrumpe o irrumpe a otros',
                '7. Fácilmente se distrae con estímulos extraños',
                '8. Interrumpe las tareas reiteradamente antes de finalizarlas',
                '9. Pierde cosas necesarias para tareas o actividades',
                '10. Falla en poner atención a detalles o comete errores por descuido',
                '11. Con frecuencia hace cosas sin reflexionar (es impulsivo(a))'
            ]
        ],
        [
            'title' => null,
            'code' => 'tc',
            'time' => 'Señala el grado en que el menor ha presentado alguno de los siguientes problemas (4 a 18 años) TC',
            'questions' => [
                '12. Presenta comportamiento repetido y continuo que perturba a otros',
                '13. Discute con adultos',
                '14. Frecuentemente se enoja',
                '15. Molesta a la genta',
                '16. Es vengativo',
                '17. Miente reiteradamente',
                '18. Hace berrinches con frecuencia',
                '19. Se opone o se niega a obbedecer a las peticiones o reglas dadas por los adultos',
                '20. Culpa a otros por sus propios errores o mala conducta',
                '21 Presenta comportamiento cruel',
                '22. Ha robado',
                '23. Se aísla',
                '24. Muestra agresión verbal',
                '25. Muestra conductas auto destructivas'
            ]
        ],
        [
            'title' => 'TE SECCIÓN NIÑOS - ADOLESCENTES',
            'code' => 'te',
            'time' => 'Señala el grado en que el menor ha presentado alguno de los siguientes problemas (< 5 años)',
            'questions' => [
                '1. Presenta llanto excesivo',
                '2. Tiene dificultades para separarse de su cuidador',
                '3. Tiene episodios en donde se mantiene inmóvil y en silencio',
                '4. Presenta timidez extrema',
                '5. Presenta conductas regresivas en comparación con los niños de su edad (hacerse pipí o popo, ensuciarse o chuparse el dedo)',
                '6. Juega poco',
                '7. Menor interacción social'
            ]
        ],
        [
            'title' => null,
            'code' => 'te',
            'time' => 'Mediana infancia (6 a 12 años)',
            'questions' => [
                '8. Presenta dolor de cabeza o estómago recurrente',
                '9.	Se niega a ir a la escuela ',
                '10. Timidez extrema',
                '11. Presenta conductas regresivas en comparación con los niños de su edad (hacerse pipí o popo, ensuciarse o chuparse el dedo)',
            ]
        ],
        [
            'title' => null,
            'code' => 'te',
            'time' => 'Adolescentes (13 a 18 años)',
            'questions' => [
                '1. Se irrita o molesta con facilidad',
                '2. Se deprime con frecuencia',
                '3. Se frustra',
                '4. Presenta cambios inesperados del estado de ánimo (explosiones emocionales)',
                '5. Tiene dificultad para concentrarse',
                '6. Presenta bajo desempeño escolar',
                '7. Con frecuencia desea estar solo'
            ]
        ],
        [
            'title' => 'SUI',
            'code' => 'sui',
            'time' => 'Presenta alguna de las siguientes situaciones...',
            'questions' => [
                '1. Tienes pensamientos o ideas de hacerte daño o de atentar contra tu vida',
                '2. Intentaste hacerte daño o atentar contra tu vida',
                '3. Has buscado los medios para hacerte daño o atentar contra tu vida'
            ]
        ],
        [
            'title' => 'ANS',
            'code' => 'ans',
            'time' => 'En las dos últimas semanas...',
            'questions' => [
                '1. Te has sentido preocupado constantemente de que algo malo pueda pasar (asalto, enfermedad, tener un accidente, "hacer el ridículo" frente a desconocidos, etc.)',
                '2. Te has sentido nervioso constantemente',
                '3. Has sentido tensión muscular',
                '4. Has sentido que tu corazón late más rápido de lo habitual',
                '5. Te has sentido tan nervioso que te ha impedido realizar tus actividades',
                '6. Te has alejado de situaciones que te hacen sentir nervioso',
                '7. Has sentido miedo sin razón aparente'
            ]
        ],
        [
            'title' => 'SEX',
            'code' => 'sex',
            'time' => 'En el último año...',
            'questions' => [
                '1. Mantuviste relaciones sexuales con más de una persona',
                '2. Has tenido relaciones sexuales sin usar condón',
                '3. Enviaste y recibiste imágenes o mensajes con contenido sexual a través de dispositivos tecnológicos',
                '4. Tienes dificultades en tu vida sexual (por ejemplo, inhibición en el deseo sexual, dificultad para mantener la erección, eyaculación precoz, dificultad en la lubricación, dificultad para tener orgasmos, etc.)'
            ]
        ],
        [
            'title' => null,
            'code' => 'ans',
            'time' => 'Presentas o presentaste...',
            'questions' => [
                '5. Infecciones de transmisión sexual (VIH/SIDA, VPH, clamidiasis, gonorrea, sífilis, tricomoniasis, etc.)',
                '6. Embarazo no deseado',
                '7. Dudas sobre tu orientación sexual'
            ]
        ],
        [
            'title' => 'VIO',
            'code' => 'vio',
            'time' => 'En el último año...',
            'questions' => [
                '1. Alguien te lastimó físicamente de forma intencional (por ejemplo, empujar, golpear, pellizcar, etc.)',
                '2. Alguien te lastimó emocionalmente de forma intencional (por ejemplo, humillarte, insultarte, amenazarte, ignorarte, prohibirte, celarte)',
                '3. Alguien sobbrepasó los límites en tu sexualidad (por ejemplo, acoso sexual, abuso sexual, violación)',
                '4. Lastimaste físicamente a otra persona con la intención de hacerlo (por ejemplo, empujar, golpear, pellizcar, etc.)',
                '5. Lastimaste emocionalmente a otra persona con la intención de hacerlo (por ejemplo, humillaste, insultaste, amenazaste, ignoraste, prohibiste, celaste)',
                '6. Sobrepasate los límites en la sexualidad de otra persona (por ejemplo, acoso sexual, abuso sexual, violación)'
            ]
        ]
    ];

    
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
    
    public function fe3fdg($id)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $fdg = $this->getFdg($id);
        $pdf->loadView('pdf.test', compact('fdg'));
        return $pdf->download('invoice.pdf');
    }

    public function fe3fdg_html($id)
    {
        $fdg = $this->getFdg($id);
        return view('pdf.test', compact('fdg'));
    }

    public function fe3cdr($id)
    {
        $pdf = $this->getPdf();
        $cdr = $this->getCdr($id);
        $sections = collect($this->sections);
        $sus = collect($this->sus);
        $pdf->loadView('pdf.cdr', compact('cdr', 'sections', 'sus'));
        return $pdf->download('invoice.pdf');
    }
    public function fe3cdr_html($id)
    {
        $cdr = $this->getCdr($id);
        $sections = collect($this->sections);
        $sus = collect($this->sus);
        // dd($section);
        return view('pdf.cdr', compact('cdr', 'sections', 'sus'));
    }

    protected function getPdf()
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        return $pdf;
    }

    protected function getFdg($id) {
        $fdg = FE3FDG::where('id', $id)->first();
        $fdg->marital_status = $this->marital_status[$fdg->marital_status];
        $fdg->position = $this->position[$fdg->position];
        $fdg->person_requesting = $this->person_requesting[$fdg->person_requesting];
        $fdg->relationship_1 = $this->relationship[$fdg->relationship_1];
        $fdg->studies_level_1 = $this->studies_level[$fdg->studies_level_1];
        $fdg->relationship_2 = $this->relationship[$fdg->relationship_2];
        $fdg->studies_level_2 = $this->studies_level[$fdg->studies_level_2];
        $fdg->scholarship = $this->studies_level[$fdg->scholarship];
        $fdg->house_is = $this->house_is[$fdg->house_is];
        $fdg->service_type = $this->service_type[$fdg->service_type];
        $fdg->mhGAP_cause_classification = $this->mhGAP_cause_classification[$fdg->mhGAP_cause_classification];
        $fdg->type_previous_treatment = $this->type_previous_treatment[$fdg->type_previous_treatment];
        $fdg->refer = $this->refer[$fdg->refer];
        $fdg->prefer_time = $this->prefer_time[$fdg->prefer_time];
        return $fdg;
    }

    protected function getCdr($id) {
        $cdr = Fe3cdr::where('id', $id)->first();
        return $cdr;
    }
    
}

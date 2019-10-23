@extends('layouts.pdf_base')

@section('content')
<section class="section">
    <h1 style="text-align:center;">Evaluación de la satisfacción del estudiante con la formación a través del servicio psicológico</h1>
    <div style="text-align:right;">
            <p><span style="font-weight:bold;">Fecha: </span>{{ $es->created_at->format('d/m/Y') }}</p>
            <p><span style="font-weight:bold;">No. de cuenta: </span>{{ $doc->id_participante }}</p>
            <p><span style="font-weight:bold;">Nombre del estudiante: </span>{{ $doc->partaker->full_name }}</p>
    </div>
    <br>
    <div>
        <p><span style="font-weight:bold;">¿Qué tan satisfecho te sientes con a supervisión que recibiste para adquirir competencias en relación con</span></p>
        <p><span style="font-weight:bold;">1.1 La entrevista:  </span> {{$es->q11}}</p>
        <p><span style="font-weight:bold;">1.1 La evaluación:  </span> {{$es->q12}}</p>
        <p><span style="font-weight:bold;">1.1 La elaboración del diagnóstico:  </span> {{$es->q13}}</p>
        <p><span style="font-weight:bold;">1.1 La integración del expediente:  </span> {{$es->q14}}</p>
        <p><span style="font-weight:bold;">1.1 El diseño e implementación de intervenciones:  </span> {{$es->q15}}</p>
        <p><span style="font-weight:bold;">1.1 Una conducta profesional y ética:  </span> {{$es->q16}}</p>
        <br>
        <p><span style="font-weight:bold;">2. La supervisión que recibiste en el programa:  </span> {{$es->q2}}</p>
        <br>
        <p><span style="font-weight:bold;">3. Las actividades que se te asignaron en el programa:  </span> {{$es->q3}}</p>
        <br>
        <p><span style="font-weight:bold;">4. La estrategia de enseñanza que siguió el programa:  </span> {{$es->q4}}</p>
        <br>
        <p><span style="font-weight:bold;">5. El nivel de alcance de los objetivos planteados al inicio del programa:  </span> {{$es->q5}}</p>
        <br>
        <p><span style="font-weight:bold;">6. La aplicación de los conocimientos teóricos en las actividades prácticas del programa:  </span> {{$es->q6}}</p>
        <br>
        <p><span style="font-weight:bold;">Comentarios y sugerencias</span></p>
        <p>{{$es->comments}}</p>

    </div>
</section>
@endsection
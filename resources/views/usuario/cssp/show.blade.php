@extends('layouts.pdf_base')

@section('content')
<section class="section">
    <h1 style="text-align:center;">Cuestionario de satisfacción con el servicio psicológico</h1>
    <div style="text-align:right;">
        <p><span style="font-weight:bold;">No. expediente: </span>{{ $doc->file_number }}</p>
        <p><span style="font-weight:bold;">Fecha: </span>{{ $doc->created_at->format('d/m/Y') }}</p>
    </div>
    <div>
        <p><span style="font-weight:bold;">Documento registrado por: </span>{{ $doc->user_id == 3 ? $doc->user->partaker->full_name : $doc->user->supervisor->full_name }}</p>
    </div>
    <br/>
    <div>
        <p>El propósito de este cuestionario es mejorar nuestros servicios de atención en cada uno de los Centros y Programas, motivo por el vual les solicitamos conteste este formato.</p>
        <p><span style="font-weight:bold;">Instrucciones: </span>A continuación, se encuentra una serie de afirmaciones relacionadas con la atención psicológica que recibió.</p>
        <p>Por favor, califique qué tan satisfecho se siente con cada afirmación.</p>
    </div>
    <br/>
    <div>
        <p style="font-weight:bold;">1. ¿Cómo evaluaría la calidad de los servicios que ha recibido?</p>
        <p>{{ $doc->q1 }}</p>
        <br />
        <p style="font-weight:bold;">2. ¿Le fue de utilidad el servicio recibido?</p>
        <p>{{ $doc->q2 }}</p>
        <br />
        <p style="font-weight:bold;">3. ¿Recomendaría nuestros servicios de atención psicológica?</p>
        <p>{{ $doc->q3 }}</p>
        <br />
        <p style="font-weight:bold;">4. ¿Los servicios que ha recibido el han ayudado a enfrentarse mejor a sus problemas?</p>
        <p>{{ $doc->q4 }}</p>
        <br />
        <p style="font-weight:bold;">5. En general, ¿qué tan satisfecho/a está usted con los servicios que ha recibido?</p>
        <p>{{ $doc->q5 }}</p>
        <br />
    </div>
    <div>
        <p style="font-weight:bold;">Comentarios y sugerencias:</p>
        <br/>
        <i>Lo que más me gustó de la atención que recibí fue:</i>
        <p>{{ $doc->o1 }}</p>
        <br/>
        <i>Lo que considero que se tendría que mejorar es:</i>
        <p>{{ $doc->o2 }}</p>
    </div>
    <div style="page-break-after: always;"></div>
    <div>
        <br>
        <p style="font-weight:bold;">Listado de habilidades manejadas previo y posterior al programa</p>
        <br>
        <table>
            <tr>
                <th>Habilidad de: </th>
                <th>Al iniciar la intervención</th>
                <th>Al terminar la intervención</th>
            </tr>
            @foreach ($newQs as $key => $q)
                <tr>
                    <td>{{$q}}</td>
                    <td align="center">{{$doc['n'.($key + 1).'i'] ? $doc['n'.($key + 1).'i'] : 'N/A'}}</td>
                    <td align="center">{{$doc['n'.($key + 1).'f'] ? $doc['n'.($key + 1).'f'] : 'N/A'}}</td>
                </tr>
            @endforeach
        </table>
    </div>
</section>
@endsection
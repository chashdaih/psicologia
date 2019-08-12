@if (count($enroll_programs))
    @foreach ($enroll_programs as $enr)
        @if ($enr->document && $enr->document->seguro_imss && $enr->document->carta_comp && $enr->document->historial_ac)
        <h1 class="title">{{ $enr->program->programa }}</h1>
        <p class="subtitle">¡Has completado la inscripción!</p>
        <a href="{{ route('e_proof', $enr->document->id_tramite) }}" class="button is-medium is-info">Descargar comprobante de inscripción</a>
        <br>
        <br>
        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>Nombre del programa</th>
                    <th>Datos del programa</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$enr->program->programa}}</td>
                    <td>
                        <a href="{{route('rps_pdf', $enr->program->id_practica)}}">
                            <fai icon="file-pdf" size="2x" />
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        @else
        @include('home.preregister')
        @endif
    @endforeach
{{-- @else
<h1 class="title">Aún no estás inscrita/o a ninguna práctica</h1>
<p class="subtitle">El periodo de inscripción es del 17 al 2 de agosto</p>
<br><br>
<h1 class="title">Programas disponibles para el semestre {{config('globales.semestre_activo')}} </h1>
<programs-list 
    :programs="{{ json_encode($programs) }}"
    pdf-url="{{ route('rps_pdf', 0) }}"
    en-url="{{ route('insc.enroll', 0) }}"
></programs-list> --}}
@endif

@if (count($enroll_programs) < 2 && Config::get('globales.altas_fin') > date_timestamp_get($todaysDate) && date_timestamp_get($todaysDate) > Config::get('globales.altas_inicio'))
<h1 class="title">Periodo de altas</h1>
<p class="subtitle">del 12 de agosto al 17 de agosto</p>
<programs-list 
    :programs="{{ json_encode($programs) }}"
    pdf-url="{{ route('rps_pdf', 0) }}"
    en-url="{{ route('insc.enroll', 0) }}"
></programs-list>
@endif
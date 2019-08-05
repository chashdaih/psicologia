@extends('layouts.pdf_base')

@section('content')
<section class="section">
    <h3 style="text-align:center;">Cuestionario de detección de riesgos en la salud física y mental</h3>
    <div style="text-align:right;">
        <p><span style="font-weight:bold;">No. expediente: </span>{{ $process_model->file_number }}</p>
        <p><span style="font-weight:bold;">No. Cuenta/No. Trabajador/CURP:</span> {{ $doc->fdg->curp }}</p>
        <p><span style="font-weight:bold;">Fecha de registro: </span>{{ $process_model->created_at->format('d/m/Y') }}</p>
        <br>
    </div>
    <div>
        @foreach ($sections as $section)
        <div>
            <h3 class="subtitle">{{$section['title']}}</h3>
            @if($section['title']=="TRASTORNOS POR CONSUMO DE SUSTANCIAS")
            
            @foreach ($section['subsection'] as $subsection)
            <table style="width:90%;">
                <thead>
                    <tr>
                        <th style="width:90%">{{$subsection['subtitle']}}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if ($subsection['scale'] == "boolean")
                        @foreach ($section['questions'] as $question)
                        <tr>
                            <td style="width:90%">{{$question}}</td>
                            <td>{{ $process_model->{$subsection['code'].strtok($question, '.')} ? 'Si' : 'No' }}</td>
                        </tr>
                        @endforeach
                    @elseif($subsection['scale'] == "other")
                    <tr>
                        <td></td>
                        <td>{{ $process_model->{$subsection['code']} }}</td>
                    </tr>
                    @else
                    @foreach ($section['questions'] as $question)
                    <tr>
                        <td style="width:90%">{{$question}}</td>
                        <td>{{ $process_model->{$subsection['code'].strtok($question, '.')} }}</td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <br>
            @endforeach

            @else
            <table style="width:90%;">
                @if(array_key_exists('medical', $section))
                <thead>
                    <tr>
                        <th style="width:90%">Descarte sintomatología física diagnosticada por un Médico</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($section['medical'] as $question)
                        <tr>
                            <td style="width:90%">{{$question}}</td>
                            <td>{{ $process_model->{$section['code'].strtok($question, '.')} ? 'Si' : 'No'}}</td>
                        </tr>
                    @endforeach
                </tbody>
                @endif
                @foreach ($section['main'] as $sub)
                @if (array_key_exists('period', $sub))
                <thead>
                    <tr>
                        <th>{{$sub['period']}}</th>
                        <th></th>
                    </tr>
                </thead>
                @endif
                <tbody>
                @if (array_key_exists('ten', $sub))
                    @foreach ($sub['ten'] as $question)
                    <tr>
                        <td style="width:90%">{{$question}}</td>
                        <td>{{ $process_model->{$section['code'].strtok($question, '.')} }}</td>
                    </tr>
                    @endforeach
                @endif
                @if (array_key_exists('boolean', $sub))
                    @foreach ($sub['boolean'] as $question)
                    <tr>
                        <td style="width:90%">{{$question}}</td>
                        <td>{{ $process_model->{$section['code'].strtok($question, '.')} ? 'Si' : 'No'}}</td>
                    </tr>
                    @endforeach
                @endif
                </tbody>
                @endforeach
                @endif 
            </table>
        </div>
        @endforeach
    </div>
    <div style="page-break-before: always;">
        <h2>Resultados</h2>
        <table style="width:100%" class="bordered-table">
            <thead>
                <tr>
                    <th></th>
                    <th>DEP</th>
                    <th>MAN</th>
                    <th>PSI</th>
                    <th>EPI</th>
                    <th>DEM</th>
                    <th colspan="3">TDE</th>
                    <th>TC</th>
                    <th colspan="3">TE</th>
                    <th>SUI</th>
                    <th>ANS</th>
                    <th>SEX</th>
                    <th>VIO</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Puntaje máximo (PM)</th>
                    <th>110</th>
                    <th>80</th>
                    <th>50</th>
                    <th>50</th>
                    <th>40</th>
                    <th>40</th>
                    <th>30 </th>
                    <th>50</th>
                    <th>250</th>
                    <th>70</th>
                    <th>40 </th>
                    <th>70</th>
                    <th>60</th>
                    <th>70</th>
                    <th>70</th>
                    <th>60</th>
                </tr>
                <tr>
                    <th>Puntaje obtenido (PO)</th>
                    @foreach ($results[0] as $res)
                    <td>{{$res}}</td>
                    @endforeach
                </tr>
                <tr>
                    <th>Porcentaje</th>
                    @foreach ($results[1] as $res)
                    <td>{{$res}}</td>
                    @endforeach
                </tr>
            </tbody>
        </table>
        <br>
        <table class="bordered-table">
            <thead>
                <tr>
                    <th></th>
                    <th>Registre la puntuación para sustancia específica</th>
                    <th>
                        <p>Sin intervención</p>
                        <p>(Consejo breve)</p>
                    </th>
                    <th>
                        <p>Intervención breve</p>
                    </th>
                    <th><p>Tratamiento más intensivo</p></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sustancias as $key => $sustancia)
                <tr>
                    <th>{{$sustancia}}</th>
                    <td>{{$results[2][$key]}}</td>
                    <td>(0 - 3)</td>
                    <td>(4 - 26)</td>
                    <td>(27+)</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
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
    {{-- <div>
        <h2>Resultados</h2>
        <table style="width:90%">
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
                    <td>110</td>
                    <td>80</td>
                    <td>50</td>
                    <td>50</td>
                    <td>40</td>
                    <td>40 (>5)</td>
                    <td>30 (6-12)</td>
                    <td>50 (13-18)</td>
                    <td>250</td>
                    <td>70 (>5)</td>
                    <td>40 (6-12)</td>
                    <td>70 (13-18)</td>
                    <td>60</td>
                    <td>70</td>
                    <td>70</td>
                    <td>60</td>
                </tr>
                <tr>
                    <th>Puntaje obtenido (PO)</th>
                    @foreach ($sections as $section)
                        @if ($section['title'] != "TRASTORNOS POR CONSUMO DE SUSTANCIAS")
                            <td></td>
                        @endif
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div> --}}
</section>
@endsection
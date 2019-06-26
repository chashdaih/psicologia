@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Nombre del programa</h1>
        <h2 class="subtitle">Nombre del paciente</h2>
        {{-- <div class="columns">
            <div class="column">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">FE3 Primer contacto</p>
                    </header>
                    <div class="card-content">
                        <div class="content">
                            <p>Ficha de datos generales (3-FE3-FDG)</p>
                            <ul>
                                <li>Editar</li>
                                <li>Descargar en pdf</li>
                            </ul>

                            <p>Cuestionario de detección de riestos en la salud física y mental (3-FE3-CDR)</p>
                            <ul>
                                <li><a href="{{ route('patient.edit', ['program_id'=>$program_id, 'patient'=>$patient_id]) }}">Editar</a></li>
                                <li>Descargar en pdf</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">FE4 Admisión</p>
                    </header>
                </div>
            </div>
            <div class="column">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">FE5 Evaluación</p>
                    </header>
                </div>
            </div>
            <div class="column">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">FE6 Orientación / consejo breve</p>
                    </header>
                </div>
            </div>
            <div class="column">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">FE7 Intervención</p>
                    </header>
                </div>
            </div>
            <div class="column">
                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">FE8 Egreso</p>
                    </header>
                </div>
            </div>
        </div> --}}

        <proc-toggle inline-template :array_size=6>
        <div>
            <div class="tabs is-centered is-toggle">
                <ul>
                    @foreach ($tabs as $key=>$value)
                    <li :class="{ 'is-active': vis[{{$key}}] }" @click="toggle({{$key}})"><a>{{$value}}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <table class="table is-fullwidth">
                    <thead>
                        <th>Procedimiento</th>
                        <th>Siglas</th>
                        <th>Registrar/Editar</th>
                        <th>Descargar pdf</th>
                        <th>Subir documento</th>
                        <th>Eliminar</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Ficha de datos generales</td>
                            <td>FDG</td>
                            <td>
                                <a href="{{ route('fdg.edit', ['program_id'=>$program_id, 'patient_id'=>$patient_id]) }}">
                                    <fai icon="file-code" size="2x" />
                                </a>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Cuestionario de detección de riesgos en la salud física y mental</td>
                            <td>CDR</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        </proc-toggle>

    </div>
</section>
@endsection
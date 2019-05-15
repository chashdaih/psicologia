@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <nav class="breadcrumb" aria-label="breadcrumbs">
            {{-- <ul>
                <li><a href="{{ route('procedures') }}">Procedimientos</a></li>
                <li class="is-active"><a href="#" aria-current="page">{{ $doc_name }}</a></li>
            </ul> --}}
        </nav>
        <h1 class="title">Evaluación de competencias del estudiante de posgrado</h1>
        <ecpr-form inline-template :fields={{ $doc }} url={{ route($doc_code.'.store') }}>
            <form @submit.prevent="onSubmit">
                <div class="field">
                    <label class="label">Estudiante</label>
                    <div class="control">
                        <div class="select">
                            <select v-model="form.student" required>
                                {{-- TODO fixed full name --}}
                                <option disabled value="0">Elija un estudiante...</option> 
                                @foreach ($students as $student)
                                <option value="{{ $student->id_usuario }}">{{ $student->nombre_t }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Semestre que cursa</label>
                    <div class="control">
                        <div class="select">
                            <select v-model="form.semester" required>
                                <option value=1>Primero</option> 
                                <option value=2>Segundo</option> 
                                <option value=3>Tercero</option> 
                                <option value=4>Cuarto</option> 
                            </select>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label class="label">Fase de evaluación</label>
                    <div class="control">
                        <div class="select">
                            <select v-model="form.evaluation_phase" required>
                                <option value=0>Inicial</option>
                                <option value=1>Intermedia</option>
                                <option value=2>Final</option>
                            </select>
                        </div>
                    </div>
                </div>

                <table class="table is-bordered" style="width: 100%; table-layout: fixed">
                    <tr>
                        <td style="width:60%">
                            <p class="has-text-weight-bold">Instrucciones al supervisor docente:</p>
                            <p>Determine el nivel de avance de las competencias consideradas en la siguiente lista, con base en la ejecución del estudiante en la semana previa al día de hoy.</p>
                            <br/>
                        </td>
                        <td style="white-space:nowrap; vertical-align:bottom;"><p style="transform:rotate(-90deg);">No lo domina</p></td>
                        <td colspan="4">En proceso</td>
                        <td style="white-space:nowrap; vertical-align:bottom;"><p style="transform:rotate(-90deg);">Lo domina</p></td>
                        <td style="white-space:nowrap; vertical-align:bottom;"><p style="transform:rotate(-90deg);">No aplica</p></td>
                    </tr>
                    <tr>
                        <td style="width:60%">Competencia</td>
                        <td>0</td>
                        <td>1</td>
                        <td>2</td>
                        <td>3</td>
                        <td>4</td>
                        <td>5</td>
                        <td>NA</td>
                    </tr>
                </table>
                @foreach ($sections as $index => $section)
                <p class="has-text-weight-bold">{{ $section['title'] }}</p>
                <table class="table is-hoverable is-bordered is-striped" style="width: 100%; table-layout: fixed">
                    @foreach ($section['questions'] as $key => $question)
                    <tr>
                        <td style="width:60%">{{ $question }}</td>
                        @for ($i = 0; $i < 7; $i++)
                        <td>
                            <input :value="{{ $i }}" v-model="form.q{{ ($index + 1).($key + 1) }}" type="radio">
                        </td>
                        @endfor
                    </tr>    
                    @endforeach
                </table>
                @endforeach
                <button class="button" type="submit">Registrar</button>
            </form>
        </ecpr-form>
    </div>
</section>
@endsection
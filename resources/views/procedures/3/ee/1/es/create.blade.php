@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        @include('layouts.breadcrumbs')
        <h1 class="title">{{ $bread->last()['title'] }}</h1>
        @if ($errors->any())
        <p>
            {{ $errors }}
        </p>
        @endif
        <form method="POST" action="{{ route($doc_code.'.store') }}" >
            {{ csrf_field() }}
            <div class="field">
                <label class="label">Tipo de programa</label>
                <div class="control">
                    <div class="select">
                        <select name="program_type">
                            <option value="0">Programa Curricular</option>
                            <option value="1">Programa Extracurricular</option>
                            <option value="2">Prestador de Servicio Social</option>
                            <option value="3">Posgrado</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="field">
                <label class="label">Estudiante</label>
                <div class="control">
                    <div class="select">
                        <select name="student_id">
                            @foreach ($programs as $program)
                            @foreach ($program->partakers as $student)
                            <option value="{{ $student->num_cuenta }}">{{ $student->full_name }}</option>
                            @endforeach
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <table class="table is-bordered" style="width: 100%; table-layout: fixed">
                <tr style="height: 150px;">
                    <td style="width:60%">
                        <p class="has-text-weight-bold">¿Qué tan satisfecho te sientes con...?</p>
                    </td>
                    <td style="white-space:nowrap; vertical-align:bottom;"><p style="transform:rotate(-90deg);">Muy satisfecho</p></td>
                    <td style="white-space:nowrap; vertical-align:bottom;"><p style="transform:rotate(-90deg);">Satisfecho</p></td>
                    <td style="white-space:nowrap; vertical-align:bottom;"><p style="transform:rotate(-90deg);">Ni satisfecho <br/> ni insatisfecho</p></td>
                    <td style="white-space:nowrap; vertical-align:bottom;"><p style="transform:rotate(-90deg);">Insatisfecho</p></td>
                    <td style="white-space:nowrap; vertical-align:bottom;"><p style="transform:rotate(-90deg);">Muy insatisfecho</p></td>
                    <td style="white-space:nowrap; vertical-align:bottom;"><p style="transform:rotate(-90deg);">No aplica</p></td>
                </tr>
                <tr>
                    <td style="width:60%">
                        <p>1. La supervisión que recibiste para adquirir competencias en relación con:</p>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @foreach ($questions as $key => $text)
                <tr>
                    <td style="width:60%">
                        <p>{{ $text }}</p>
                    </td>
                    @for ($i = 0; $i < 6; $i++)
                    <td>
                        <input name="{{ $key }}" value="{{ $i }}" type="radio" required>
                    </td>
                    @endfor
                </tr>
                @endforeach
            </table>
            <div class="field">
                <label class="label">Comentarios y sugerencias:</label>
                <div class="control">
                    <textarea name="comments" class="textarea" placeholder="Comentarios y sugerencias" required></textarea>
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <button class="button is-link">Enviar</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
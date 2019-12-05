@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Evaluación de competencias del estudiante de posgrado</h1>
        <p>Determine el nivel de avance de las competencias consideradas siguientes, con base en la ejecución del estudiante en la semana previa al día de hoy.</p>
        <p class="has-text-weight-bold">Escala:</p>
        <p class="has-text-weight-bold">0, no lo domina</p>
        <p class="has-text-weight-bold">1 - 4, en proceso</p>
        <p class="has-text-weight-bold">5, Lo domina</p>
        <br>
        <p class="has-text-weight-bold">*Si no aplica, dejar en blanco*</p>
        <br>
        <div class="field">
            <label class="label">Nombre del participante</label>
            <div class="control">
                <input type="text" class="input" disabled value="{{$partaker->full_name}}">
            </div>
        </div>
        <div class="field">
            <label class="label">Nombre del programa</label>
            <div class="control">
                <input type="text" class="input" disabled value="{{$program->programa}}">
            </div>
        </div>
        <div class="field">
            <label class="label">Fase de evaluación</label>
            <div class="control">
                <input type="text" class="input" disabled value="{{$stage}}">
            </div>
        </div>
        <form
        @if($ecpo->id)
        action="{{route('ecpo.update', ['program_id'=>$program->id_practica, 'partaker_id'=>$partaker->num_cuenta, 'stage'=>$stage, 'ecpo'=>$ecpo->id])}}" 
        @else
        action="{{route('ecpo.store', ['program_id'=>$program->id_practica, 'partaker_id'=>$partaker->num_cuenta, 'stage'=>$stage])}}" 
        @endif
        method="POST">
            {{ csrf_field() }}
            @if($ecpo->id) <input name="_method" type="hidden" value="PUT"> @endif
            <date-component
                label="Fecha en que se llenó el documento"
                name="created_at"
                old="{{old('created_at', $ecpo->created_at)}}"
                ></date-component>
            
            @foreach ($sections as $index => $section)
            <p class="has-text-weight-bold">{{ $section['title'] }}</p>
            <table class="table is-hoverable is-striped is-fullwidth">
                @foreach ($section['questions'] as $key => $question)
                <tr>
                    <td style="width:60%">{{ $question }}</td>
                    <td>
                        <numeric-input
                            name="{{'q'.($index + 1).($key + 1)}}"
                            value="{{old('q'.($index + 1).($key + 1), $ecpo['q'.($index + 1).($key + 1)])}}"
                            clazz="input {{$errors->has('q'.($index + 1).($key + 1)) ? ' is-danger':'' }}"
                            max=5
                        />
                    </td>
                </tr>    
                @endforeach
            </table>
            @endforeach
            <button class="button is-link" type="submit">@if($ecpo->id) Actualizar @else Registrar @endif</button>
        </form>
    </div>
</section>
@endsection
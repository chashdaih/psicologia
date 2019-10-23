@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Evaluación de la satisfacción del estudiante con la formación a través del servicio psicológico</h1>
        <p>Esta evaluación tiene como finalidad conocer el nivel de satisfacción que tiene el estudiante/prestador de servicio social con respecto a la formación profesional supervisada recibida en el programa.</p>
        <br>
        <p class="is-italic">Lea con atención cada afirmación y otorgue con un valor númerico correspondiente a la escala mostrada la opción de respuesta que mejor describa su nivel de satisfacción en cada uno de los reactivos.</p>
        <table class="table">
            <thead>
                <tr>
                    <th>Valor numérico</th>
                    <th>5</th>
                    <th>4</th>
                    <th>3</th>
                    <th>2</th>
                    <th>1</th>
                    <th>0</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="has-text-centered">Escala</th>
                    <td>Muy satisfecho</td>
                    <td>Satisfecho</td>
                    <td>Ni satisfecho, ni insatisfecho</td>
                    <td>Insatisfecho</td>
                    <td>Muy insatisfecho</td>
                    <td>No aplica</td>
                </tr>
            </tbody>
        </table>
        <form action="{{ $inst->id ? route('es.update', ['assign_id' => $assign_id, 'es' => $inst->id]) : route('es.store', $assign_id) }}" method="POST">
            {{ csrf_field() }}
            @if($inst->id) <input name="_method" type="hidden" value="PUT"> @endif
            <table class="table is-fullwidth">
                <thead>
                    <tr>
                        <th>¿Qué tan satisfecho te sientes con...</th>
                        <th></th>
                    </tr>
                </thead>
                <tr>
                    <th>1. La supervisión que recibiste para adquirir competencias en relación con:</th>
                    <td></td>
                </tr>
                @foreach ($fields as $field => $title)
                <tr>
                    @component('components.form-row', compact('field', 'title', 'errors', 'inst'))@endcomponent
                </tr>
                @endforeach
            </table>
            <div class="field">
                <label class="label">Comentarios y/o sugerencias</label>
                <div class="control">
                    <textarea name="comments"class="textarea" placeholder="Comentarios y/o sugerencias">{{old('comments', $inst['comments'])}}</textarea>
                </div>
            </div>
            @if ($inst->id)
            <button class="button is-info" type="submit">Actualizar evaluación</button>
            @else
            <button class="button is-info" type="submit">Registrar evaluación</button>
            @endif
        </form>
    </div>
</section>
@endsection
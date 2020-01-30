@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">{{ $process_model->id ? 'Editar' : 'Registrar' }} Resultados de evaluación</h1>
        <form
            @if($process_model->id)
            action="{{ route('re.update',  ['patient_id'=>$patient_id, 're'=>$process_model->id]) }}"
            @else
            action="{{ route('re.store',  $patient_id) }}"
            @endif
            method="POST" enctype="multipart/form-data">
            @if($process_model->id) <input name="_method" type="hidden" value="PUT"> @endif
            {{ csrf_field() }}
            <div class="field">
                <label class="label">Número de expediente</label>
                <div class="control">
                    <input type="text" class="input" value="{{$file_number}}" disabled>
                </div>
            </div>
            <date-component
                label="Fecha en que se llenó el formato"
                name="created_at"
                old="{{old('created_at', $process_model->created_at)}}"
            ></date-component>
            <br>
            <table class="table is-fullwidth">
                <thead>
                    <tr>
                        <th>Instrumentos / Técnicas de evaluación aplicadas</th>
                        <th>Resultados obtenidos</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width: 50%;">
                            <textarea class="textarea" name="tecnicas_evaluacion">{{ old('tecnicas_evaluacion', $process_model->tecnicas_evaluacion) }}</textarea>
                        </td>
                        <td>
                            <textarea class="textarea" name="resultados_obtenidos">{{ old('resultados_obtenidos', $process_model->resultados_obtenidos) }}</textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="field">
                <label class="label">Indicadores de evolución</label>
                <div class="control">
                    <textarea class="textarea" name="indicadores_evolucion" placeholder="Indicadores de evolución">{{ old('indicadores_evolucion', $process_model->resultados_obtenidos) }}</textarea>
                </div>
            </div>
            <div class="field">
                <label class="label">¿Fue necesario hacer referencia?</label>
                <div class="control">
                  <div class="select">
                    <select name="referencia_necesaria">
                      <option value="0" {{ old('referencia_necesaria', $process_model->referencia_necesaria) == 0 ? 'selected' : '' }} >No</option>
                      <option value="1" {{ old('referencia_necesaria', $process_model->referencia_necesaria) == 1 ? 'selected' : '' }} >Si</option>
                    </select>
                  </div>
                </div>
            </div>
            <div class="field">
                <label class="label">Impresión diagnóstica o tipo de problemática</label>
                <div class="control">
                    <textarea class="textarea" name="tipo_problematica" placeholder="Impresión diagnóstica o tipo de problemática">{{ old('tipo_problematica', $process_model->tipo_problematica) }}</textarea>
                </div>
            </div>
            <small-file
                name="file"
                serv_error="{{ $errors->has('file') ? $errors->first('file') : '' }}"
                ></small-file>
            <button class="button is-info" type="submit">@if($process_model->id) Actualizar @else Registrar @endif </button>
        </form>
    </div>
</section>
@endsection
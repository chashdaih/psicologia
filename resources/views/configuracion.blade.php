@extends('layouts.base')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">Configuración</h1>
        <form action="{{route('configuracion.update')}}" method="post">
            {{ csrf_field() }}
            <div class="field">
                <label class="label">Semestres</label>
                <div class="control">
                    <input class="input" name="semestres" type="text" value={{json_encode(config('globales.semestres'))}}>
                    <p class="help">Mantener el formato ["", "", ...]</p>
                </div>
            </div>
            <div class="field">
                <label class="label">Semestre activo</label>
                <div class="control">
                    <input class="input" name="semestre_activo" type="text" value={{config('globales.semestre_activo')}}>
                </div>
            </div>
            <date-component label="Inicio de altas y bajas" name="altas_inicio" old={{config('globales.altas_inicio')}}></date-component>
            <date-component label="Fin de altas y bajas" name="altas_fin" old={{config('globales.altas_fin')}}></date-component>
            <button class="button is-success">Actualizar</button>
        </form>
    </div>
</section>
@endsection
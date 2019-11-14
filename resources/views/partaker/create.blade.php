@extends('layouts.base')
@section('content')
<section class="section">
    <div class="container">
        <div class="columns">
            <div class="column">
                @if(session('success'))
                <div class="notification is-primary">
                    <button class="delete"></button>
                    {{session('success')}}
                </div>
                @elseif ($errors->any())
                <div class="notification is-danger">
                    <p>El formulario contiene errores:</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if(isset($partaker))
                <h1 class="title">{{$partaker->full_name}}</h1>
                @if(count($partaker->tramites))
                <usuario-coll nombre="Programas inscritos">
                    <table class="table is-fullwidth is-hoverable is-striped">
                        <thead>
                            <tr>
                                <th>Nombre del programa</th>
                                <th>Centro</th>
                                <th>Semestre activo</th>
                                <th>Estatus</th>
                                <th>Más...</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($partaker->tramites as $tramite)
                                <tr>
                                    <td>{{$tramite->program->programa}}</td>
                                    <td>{{$tramite->program->center->nombre}}</td>
                                    <td>{{$tramite->program->semestre_activo}}</td>
                                    <td>{{$tramite->estado}}</td>
                                    <td>
                                        <a href="{{route('users_list', $tramite->program->id_practica)}}"><fai icon="arrow-circle-right" size="2x" /></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </usuario-coll>
                <div><br></div>
                @endif
                @endif
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-title">
                            @if (isset($partaker))
                            Editar estudiante
                            @else
                            Registrar nuevo estudiante
                            @endif
                        </div>
                    </div>
                    <div class="card-content">
                        <form class="control" 
                        method="POST" 
                        action="{{ isset($partaker) ? route('partaker.update', $partaker->num_cuenta) : route('partaker.store') }}">
                        {{ csrf_field() }}
                        @if(isset($partaker)) <input name="_method" type="hidden" value="PUT"> @endif
                        @if(!isset($partaker))
                            @component('components.text-input', [
                                'title'=>'Número de cuenta',
                                'field'=>'num_cuenta',
                                'errors'=>$errors,
                                'type'=> 'text',
                                'required' => true,
                                'maxlength' =>15
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'Contraseña',
                                'field'=>'password',
                                'errors'=>$errors,
                                'type'=> 'password',
                                'required' => true
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'Confirmar contraseña',
                                'field'=>'password_confirmation',
                                'errors'=>$errors,
                                'type'=> 'password',
                                'required' => true
                                ])@endcomponent
                        @else
                        <div class="field">
                            <label class="label">Número de cuenta</label>
                            <div class="control">
                              <input class="input" type="text" disabled value="{{$partaker->num_cuenta}}">
                            </div>
                          </div>
                          @component('components.text-input', [
                              'title'=>'Nueva Contraseña',
                              'field'=>'password',
                              'errors'=>$errors,
                              'type'=> 'password'
                              ])@endcomponent
                          @component('components.text-input', [
                              'title'=>'Confirmar nueva contraseña',
                              'field'=>'password_confirmation',
                              'errors'=>$errors,
                              'type'=> 'password'
                              ])@endcomponent
                        @endif
                            @component('components.text-input', [
                                'title'=>'Nombre',
                                'field'=>'nombre_part',
                                'errors'=>$errors,
                                'type'=> 'text',
                                'prev' => isset($partaker) ? $partaker->nombre_part : null,
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'Apellido paterno',
                                'field'=>'ap_paterno',
                                'errors'=>$errors,
                                'type'=> 'text',
                                'prev' => isset($partaker) ? $partaker->ap_paterno : null,
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'Apellido materno',
                                'field'=>'ap_materno',
                                'errors'=>$errors,
                                'type'=> 'text',
                                'prev' => isset($partaker) ? $partaker->ap_materno : null,
                                ])@endcomponent
                            <date-component
                                label="Fecha de nacimiento"
                                name="f_nac"
                                old=@if(old('f_nac')) {{old('f_nac')}} @elseif(isset($partaker->f_nac)){{ $partaker->f_nac ? $partaker->f_nac : null }} @else {{null}} @endif
                            ></date-component>
                            @component('components.text-input', [
                                'title'=>'Teléfono',
                                'field'=>'telefono',
                                'errors'=>$errors,
                                'type'=> 'text',
                                'prev' => isset($partaker) ? $partaker->telefono : null,
                                ])@endcomponent

                            @component('components.text-input', [
                                'title'=>'Correo electrónico',
                                'field'=>'correo',
                                'errors'=>$errors,
                                'type'=> 'email',
                                'prev' => isset($partaker) ? $partaker->correo : null,
                                ])@endcomponent
                            @component('components.text-input', [
                                'title'=>'Semestre',
                                'field'=>'semestre',
                                'errors'=>$errors,
                                'type'=> 'text',
                                'prev' => isset($partaker) ? $partaker->semestre : null,
                                'maxlength' => 50
                                ])@endcomponent
                            <div class="field">
                                <label class="label">Sistema</label>
                                <div class="control">
                                    <div class="select">
                                    <select name="sistema">
                                        <option value="esc" @if(old('sistema', isset($partaker->sistema)?$partaker->sistema:null)=="esc") selected="selected" @endif >Escolarizado</option>
                                        <option value="sua" @if(old('sistema', isset($partaker->sistema)?$partaker->sistema:null)=="sua") selected="selected" @endif >SUA</option>
                                        <option value="posgrado" @if(old('sistema', isset($partaker->sistema)?$partaker->sistema:null)=="posgrado") selected="selected" @endif >Posgrado</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Sexo</label>
                                <div class="control">
                                    <div class="select">
                                    <select name="sexo">
                                        <option value="F" @if(old('sexo', isset($partaker->sexo)?$partaker->sexo:null)=="F") selected="selected" @endif >Mujer</option>
                                        <option value="M" @if(old('sexo', isset($partaker->sexo)?$partaker->sexo:null)=="M") selected="selected" @endif >Hombre</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <p class="control">
                                    <button class="button is-success">
                                        @if (isset($partaker))
                                        Actualizar
                                        @else
                                        Registrar
                                        @endif
                                    </button>
                                </p>
                             </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

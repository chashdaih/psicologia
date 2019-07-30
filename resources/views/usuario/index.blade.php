@extends('layouts.base')
@section('content')
<section class="section">
    <div class="container">
        <div class="has-text-centered">
            <a href="{{route('usuario.create')}}" class="button is-success is-centered">Registrar usuario</a>
        </div>
        @if(Auth::user()->type > 4)
        <h1 class="title">Usuarios sin programa asignado @if(Auth::user()->type == 5) de mi centro @endif</h1>
        <p class="is-italic">Usuarios para cuestionario de detección de riesgos</p>
        @if(count($paraCdr))
        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>Nombre del usuario</th>
                    <th>Registrado por</th>
                    @if(Auth::user()->type == 6) 
                    <th>Registrado en centro</th>
                    @endif
                    <th>FDG</th>
                    <th>Asignar a programa</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($paraCdr as $usuario)
                <tr>
                    <td>{{$usuario->fdg->full_name}}</td>
                    <td>
                        @if ($usuario->fdg->user->type==3)
                        {{$usuario->fdg->user->partaker->full_name}}
                        @elseif($usuario->fdg->other_filler)
                        {{$usuario->fdg->other_filler}}
                        @else
                        {{$usuario->fdg->user->supervisor->full_name}}
                        @endif
                    </td>
                    @if(Auth::user()->type == 6)
                    <td>{{$usuario->fdg->center->nombre}}</td>
                    @endif
                    <td><a href="#">Editar</a> / <a href="#">Ver pdf</a></td>
                    <td>
                        <assign-program
                            :stages="{{json_encode($centers)}}"
                            :supervisors="{{$supervisors}}"
                            etapa="primer_contacto"
                            base_url="{{URL::to('/')}}"
                            user_id="{{$usuario->id}}"
                        ></assign-program>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @else
        <p class="is-italic">No hay usuarios que requieran de esta asignación</p>
        @endif
        @endif
        <h1 class="title">Usuarios asignados a programas</h1>
        <br>
        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th></th>
                    <th class="has-text-centered" colspan="2">FE3</th>
                    <th class="has-text-centered" >FE4</th>
                    <th class="has-text-centered" >FE5</th>
                    <th class="has-text-centered" >FE6</th>
                    <th class="has-text-centered" >FE7</th>
                    <th class="has-text-centered"  colspan="2">FE8</th>
                </tr>
                <tr>
                    <th>Nombre del usuario</th>
                    <th class="has-text-centered" >FDG</th>
                    <th class="has-text-centered" >CDR</th>
                    <th class="has-text-centered" >PS</th>
                    <th class="has-text-centered" >RE</th>
                    <th class="has-text-centered" >RS</th>
                    <th class="has-text-centered" >RS</th>
                    <th class="has-text-centered" >HE</th>
                    <th class="has-text-centered" >CSSP</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($asignados as $usuario)
                <tr>
                    <td>{{$usuario->fdg->full_name}}</td>
                    <td class="has-text-centered" ><a href="{{route('usuario.edit', $usuario->fdg->id)}}">Editar</a> / <a href="{{route('usuario.show', $usuario->fdg->id)}}">Ver pdf</a></td>
                    <td class="has-text-centered" ><a href="{{route('cdr.index', ['usuario_id'=>$usuario->id])}}">Ir a proceso</a></td>
                    <td class="has-text-centered" ><a href="{{route('ps.index', ['usuario_id'=>$usuario->id])}}">Ir a proceso</a></td>
                    <td class="has-text-centered" ><a href="{{route('re.index', ['usuario_id'=>$usuario->id])}}">Ir a proceso</a></td>
                    <td class="has-text-centered" ><a href="{{route('breve.index', ['usuario_id'=>$usuario->id])}}">Ir a proceso</a></td>
                    <td class="has-text-centered" ><a href="{{route('intervencion.index', ['usuario_id'=>$usuario->id])}}">Ir a proceso</a></td>
                    <td class="has-text-centered" ><a href="{{route('he.index', ['usuario_id'=>$usuario->id])}}">Ir a proceso</a></td>
                    <td class="has-text-centered" ><a href="{{route('cssp.index', ['usuario_id'=>$usuario->id])}}">Ir a proceso</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection

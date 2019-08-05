@if(count($porCdr)>0)
<h1 class="title">Finaliza el primer contacto de los usuarios</h1>
<h2 class="subtitle">Realizar el cuestionario de detección de riesgos (CDR)</h2>
<table class="table is-fullwidth">
    <thead>
        <tr>
            <th>Nombre del usuario</th>
            <th>Editar ficha de datos generales</th>
            <th>Descargar ficha de datos generales</th>
            @if(Auth::user()->type > 4)
            <th>Registrado por</th>
                @if(Auth::user()->type == 6)
                <th>Registrado en</th>
                @endif
            @endif
            <th>Realizar CDR</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($porCdr as $usuario)
        <tr>
            <td>{{$usuario->fdg->full_name}}</td>
            <td class="has-text-centered" >
                <a href="{{ route('usuario.edit', $usuario->fdg_id) }}">
                    <fai icon="edit" size="2x" />
                </a>
            </td>
            <td class="has-text-centered" >
                <a href="{{ route('usuario.show', $usuario->fdg_id) }}">
                    <fai icon="file-pdf" size="2x" />
                </a>
            </td>
            @if(Auth::user()->type > 4)
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
            @endif
            <td class="has-text-centered" >
                <a href="{{route('cdr.create', $usuario->id)}}">
                    <fai icon="plus-circle" size="2x" />
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
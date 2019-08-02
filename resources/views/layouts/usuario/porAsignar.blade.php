<h1 class="title">Usuarios sin programa asignado @if(Auth::user()->type == 5) de {{ Auth::user()->supervisor->center->nombre }} @endif</h1>
<h2 class="subtitle">Usuarios que requiren asignación para servicio</h2>
@if(count($porAsignar))
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
        @foreach ($porAsignar as $usuario)
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
                <td><a href="{{route('usuario.show', $usuario->fdg->id)}}">Ver pdf</a></td>
                <td>
                    <assign-program
                        :stages="{{json_encode($centers)}}"
                        :supervisors="{{$supervisors}}"
                        etapa="admision"
                        base_url="{{URL::to('/')}}"
                        user_id="{{$usuario->id}}"
                    ></assign-program>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@else
<p class="is-italic">No hay usuarios que requieran de asignación.</p>
<br>
<br>
@endif
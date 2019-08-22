<h1 class="title">Personas atendidas sin programa asignado @if(Auth::user()->type == 5) de {{ Auth::user()->supervisor->center->nombre }} @endif</h1>
<h2 class="subtitle">Personas atendidas que requiren asignación para servicio</h2>
@if(count($porAsignar))
    <table class="table is-fullwidth">
        <thead>
            <tr>
                <th>No. expediente</th>
                <th>No. cuenta / No. trabajador / CURP</th>
                <th>Nombre de la persona atendida</th>
                <th>Registrado por</th>
                @if(Auth::user()->type == 6) 
                <th>Registrado en centro</th>
                @endif
                <th colspan="2" style="text-align: center">FDG</th>
                <th colspan="2" style="text-align: center">CDR</th>
                <th>Asignar a programa</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($porAsignar as $usuario)
            <tr>
                <td>{{$usuario->fdg->file_number}}</td>
                <td>{{$usuario->fdg->curp}}</td>
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
                <td><a href="{{route('fdg.edit', ['patient_id'=>$usuario->id, 'fdg'=>$usuario->fdg_id])}}"><span><fai icon="edit" size="2x" /></span></a></td>
                <td><a href="{{route('fdg.show', ['patient_id'=>$usuario->id, 'fdg'=>$usuario->fdg_id])}}"><span><fai icon="file-pdf" size="2x" /></span></a></td>
                <td><a href="{{route('cdr.edit', ['patient_id'=>$usuario->id, 'cdr'=>$usuario->cdr_id])}}"><span><fai icon="edit" size="2x" /></span></a></td>
                <td><a href="{{route('cdr.show', ['patient_id'=>$usuario->id, 'cdr'=>$usuario->cdr_id])}}"><span><fai icon="file-pdf" size="2x" /></span></a></td>
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
<p class="is-italic">No hay personas atendidas que requieran de asignación.</p>
<br>
<br>
@endif
<h1 class="title">Personas atendidas asignadas a programas</h1>
@if(count($asignados) > 0)

<filter-patients
    type="{{Auth::user()->type}}"
    :patients="{{json_encode($asignados)}}"
    base-url="{{route('usuario.index')}}"
></filter-patients>

@else
<p class="is-italic">No hay personas atendidas asignados a ningún programa @if(Auth::user()->type == 5) del centro @endif</p>
@endif
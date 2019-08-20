<h1 class="title">Personas atendidas asignadas a programas</h1>
@if(count($asignados) > 0)



@else
<p class="is-italic">No hay personas atendidas asignados a ningún programa @if(Auth::user()->type == 5) del centro @endif</p>
@endif
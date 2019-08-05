        <h1 class="title">Personas atendidas asignadas a programas</h1>
        @if(count($asignados) > 0)
        @foreach ($asignados as $key => $usuario)
        <usuario-coll content-id="{{$key}}" 
        nombre="{{$usuario->fdg->full_name}}" 
        programa="{{$usuario->program->programa}}"
        base_url="{{URL::to('/')}}"
        patient_id="{{$usuario->id}}"
        fdg_id="{{$usuario->fdg_id}}"
        ></usuario-coll>
        @endforeach
        @else
        <p class="is-italic">No hay personas atendidas asignados a ningún programa @if(Auth::user()->type == 5) del centro @endif</p>
        @endif
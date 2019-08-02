        <h1 class="title">Usuarios asignados a programas</h1>
        @if(count($asignados) > 0)
        {{-- <table class="table is-fullwidth">
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
        </table> --}}
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
        <p class="is-italic">No hay usuarios asignados a ningún programa @if(Auth::user()->type == 5) del centro @endif</p>
        @endif
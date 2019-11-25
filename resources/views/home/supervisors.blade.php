@if(Auth::user()->type == 2)
<h1 class="title">Mis programas</h1>
@elseif(Auth::user()->type == 5)
<h1 class="title">Programas de {{Auth::user()->supervisor->center->nombre}}</h1>
@else 
<h1 class="title">Programas registrados</h1>
@endif
<div class="container has-text-centered">
    <a class="button is-info" href="{{ route('rps.create') }}">Registrar programa (2-IE1-RPS)</a>
    <br/>
</div>
<div ><br></div>
<sortable-table
    url="{{ route("rps.index") }}"
    lps="{{ route('lps_pdf', 0) }}"
    type="{{Auth::user()->type}}"
    :records="{{ $records }}" 
    @if(isset($stages)):stages="{{ $stages }}"@endif
    @if(isset($supervisors)):supervisors="{{ $supervisors }}"@endif
    :supervisor={{ Auth::user()->supervisor->id_supervisor }}
    :stage={{ Auth::user()->type == 2 ? 0 : Auth::user()->supervisor->id_centro }}
    base_url={{URL::to('/')}}
    :semestres="{{json_encode(config('globales.semestres'))}}"
    sel-sem="{{config('globales.semestre_activo')}}"
    @if (session('success'))
    :needs-refresh="true"
    @else
    :needs-refresh="false"
    @endif

    ></sortable-table>

    <div ><br><br></div>
@if (isset($otherCenters))
<h1 class="title">Mis programas</h1>
<sortable-table
    url="{{ route("rps.index") }}"
    type=2
    :records="{{ $otherCenters }}" 
    :supervisor={{ Auth::user()->supervisor->id_supervisor }}
    stage=0
    base_url={{URL::to('/')}}
    :semestres="{{json_encode(config('globales.semestres'))}}"
    sel-sem="{{config('globales.semestre_activo')}}"
    @if (session('success'))
    :needs-refresh="true"
    @else
    :needs-refresh="false"
    @endif
    ></sortable-table>
@endif

@if (isset($insitu) && count($insitu))
<br><br>
<h1 class="title">Programas en los que soy supervisor in situ</h1>
<table class="table">
    <thead>
        <tr>
            <th>Nombre del programa</th>
            <th>Supervisor</th>
            <th>Centro</th>
            <th>Descargar en pdf</th>
            <th>Estudiantes</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($insitu as $in)
            <tr>
                <td>{{ $in->programa }}</td>
                <td>{{ $in->full_name }}</td>
                <td>{{ $in->centro }}</td>
                <td>
                    <a href="{{ route('rps_pdf', $in->id_practica) }}">
                        <fai icon="file-pdf" size="2x" />
                    </a>
                </td>
                <td>
                    <a href="{{ route('users_list',['id' => $in->id_practica]) }}">
                        <fai icon="chalkboard-teacher" size="2x" />
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
    
@endif
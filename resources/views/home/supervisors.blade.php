<h1 class="title">Programas</h1>
<div class="container has-text-centered">
    <a class="button is-info" href="{{ route('rps.create') }}">Registrar programa (3-IE1-RPS)</a>
    <br/>
</div>
<div ><br></div>
<sortable-table
    url="{{ route("rps.index") }}"
    lps="{{ route('lps_pdf', 0) }}"
    :records="{{ $records }}" 
    @if(isset($stages)):stages="{{ $stages }}"@endif
    @if(isset($supervisors)):supervisors="{{ $supervisors }}"@endif
    :supervisor={{ Auth::user()->supervisor->id_supervisor }}
    :stage={{ Auth::user()->supervisor->id_centro }}
    base_url={{URL::to('/')}}
    ></sortable-table>

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
            <th>Participantes</th>
            <th>Usuarios</th>
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
                <td>
                    <a href="{{ route('patient.index', $in->id_practica) }}">
                        <fai icon="user-friends" size="2x" />
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
    
@endif
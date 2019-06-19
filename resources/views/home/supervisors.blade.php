<h1 class="title">Programas</h1>
@if(session('success'))
<div class="notification is-primary">
    {{ session('success') }}
</div>
@endif
<div class="container has-text-centered">
    <button class="button"><a href="{{ route('rps.create') }}">Registrar programa (3-IE1-RPS)</a></button>
    <br/>
</div>
<div ><br></div>
{{-- <p>{{ $supervisors }}</p> --}}
<sortable-table
    url="{{ route("rps.index") }}"
    lps="{{ route('lps_pdf', 0) }}"
    :records="{{ $records }}" 
    @if(isset($stages)):stages="{{ $stages }}"@endif
    @if(isset($supervisors)):supervisors="{{ $supervisors }}"@endif
    :supervisor={{ Auth::user()->supervisor->id_supervisor }}
    :stage={{ Auth::user()->supervisor->id_centro }}
    ></sortable-table>
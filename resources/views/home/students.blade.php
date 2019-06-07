<div>
    @if (count($tramites))
        {{-- @foreach ($tramites as $tramite) --}}
            <p class="subtitle">Práctica inscrita:</p>
            <p>{{ $tramites->program->programa }}</p>
            @if ($tramites->document && $tramites->document->seguro_imss && $tramites->document->carta_comp && $tramites->document->historial_ac)
            <p>Tu registro está completo</p>
            @else
            <a href="{{ route('insc') }}">Subir documentación faltante</a>
            @endif
        {{-- @endforeach --}}
    @else
        <a href="{{ route('insc') }}">Inscribirse a un programa</a>
    @endif
</div>
<h1 class="title">{{ $title }}</h1>
<table class="table is-fullwidth">
    <thead>
        <tr>
            <th style="width: 40%;">Procedimiento</th>
            <th>Siglas</th>
            <th>Registrar/Editar</th>
            <th>Ver pdf</th>
            {{-- <th>Subir documento</th> --}}
            <th>Eliminar</th>
        </tr>
    </thead>
    <tbody>
        {{ $slot }}
    </tbody>
</table>
@extends('layouts.pdf_base')

@section('content')
<section class="section">
    <h1 style="text-align:center;">Lista de estudiantes inscritos a los programas de servicios psicológicos a través de la formación supervisada</h1>
    <div>
        <h2>Programa {{ $program->tipo }}</h2>
    </div>
    <div>
        <h2>PRESENTE</h2>
    <p>
        Por medio de la presente le envío un cordial saludo y aprovecho la oportunidad 
        de enviarle la relación de los alumnos inscritos en su programa de servicios 
        psicológicos a través de la formación supervisada <strong>{{ $program->programa }}</strong>,
        que tiene registrado en la Coordinación.
    </p>
    <p>
        Como le notificamos por correo electrónico los estudiantes se presentaran en su sede la semana y horario
        que usted estableció.
    </p>
    <p>
        El procedimiento a seguir una vez que reciba a los estudiantes es el siguiente:<br/>
        Valorar junto con ellos si cubren los requisitos y necesidades de la práctica y que usted lleve a cabo la
        conclusión del registro de los estudiantes de la siguiente manera:
        <ul><li>Informando a los alumnos las actividades, responsabilidades y  compromisos que adquiere en su 
            sede. Con ello, daremos por concluido el registro de todos los alumnos que estarán con usted en 
            los horarios y periodos estipulados por la institución.</li></ul>
    </p>
    <p>
        Hacemos de su conocimiento que los estudiantes cuentan con un periodo de altas y bajas de las
        materias/prácticas en la semana del <strong>TODO</strong>, por lo que posterior a ese periodo,
        le haremos llegar un nuevo listado de estudiantes inscritos si fuera el caso.
    </p>
    </div>
    <div>
        <table>
            <tr class="t-header">
                <td>No. de cuenta</td>
                <td>Nombre</td>
                <td>Teléfono</td>
                <td>Correo</td>
            </tr>
            @foreach ($program->partakers as $student)
            <tr>
                <td>{{ $student->num_cuenta }}</td>
                <td>{{ $student->full_name }}</td>
                <td>{{ $student->phone }}</td>
                <td>{{ $student->email }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <div>
        <p>
            Sin más por el momento, me es grato reiterar a usted las seguridades de mi más distinguida
            consideración académica.
        </p>
    </div>
    <div class="firma">
        <p>ATENTAMENTE</p>
        <p>"POR MI RAZA, HABLARÁ EL ESPÍRITU"</p>
        <p>CD. UNIVERSITARIA, CD. DE MÉXICO</p>
        <p>LA COORDINADORA</p>
        <br/>
        <p>DRA. SILVIA MORALES CHAINÉ</p>
        <p>COORDINACIÓN DE CENTROS DE FORMACIÓN Y SERVICIOS PSICOLÓGICOS</p>
    </div>
</section>
@endsection
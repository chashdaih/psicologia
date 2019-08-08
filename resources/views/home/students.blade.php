@if (count($enroll_programs))
    @foreach ($enroll_programs as $enr)
        @if ($enr->document && $enr->document->seguro_imss && $enr->document->carta_comp && $enr->document->historial_ac)
        <h1 class="title">{{ $enr->program->programa }}</h1>
        <p class="subtitle">¡Has completado la inscripción!</p>
        <a href="{{ route('e_proof', $enr->document->id_tramite) }}" class="button is-medium is-info">Descargar comprobante de inscripción</a>
        <br>
        <br>
        <table class="table is-fullwidth">
            <thead>
                <tr>
                    <th>Nombre del programa</th>
                    <th>Datos del programa</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$enr->program->programa}}</td>
                    <td>
                        <a href="{{route('rps_pdf', $enr->program->id_practica)}}">
                            <fai icon="file-pdf" size="2x" />
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        @else
        <h1 class="title">{{ $enr->program->programa }}</h1>
        <p class="subtitle">Estás pre-registrado al programa</p>
        <div class="container">
            <diss-noti>
                Recuerda que debes subir todos tus documentos antes de dos semanas o tu inscripción no será válida.
            </diss-noti>
            <br>
            <div class="box has-text-centered">
            <p class="has-text-weight-bold">Para completar tu registro, necesitas subir tres documentos:</p>
            <div>
                <p>1. Un comprobante de que tienes seguro médico</p>
                {{-- <a href="" class="button is-info">Ir a la página del seguro social</a> --}}
            </div>
            <br>
            <div>
                <p>2. La carta compromiso, por favor imprímela, firmala y sube un solo archivo que contenga las dos páginas</p>
                <a class="button is-info" href="{{ route('insc.carta', $enr->program->id_practica) }}">Generar carta compromiso</a>
            </div>
            <br>
            <div>
                <p>3. Tu historial académico</p>
                {{-- <a class="button is-info" href="">Ir a la página del historial</a> --}}
            </div>
            <br>
            <p class="is-italic">Puedes subir los documentos en diferentes momentos, solo recuerda subirlos antes de la fecha límite</p>
            <br>
            <form action="{{ route('insc.docs') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" value="{{$enr->id_tramite}}" name="id_tramite">
                <div class="columns">
                    <div class="column">
                        <p class="has-text-weight-bold">Seguro</p>
                        <small-file
                        name="seguro_imss"
                        serv_error="{{ $errors->has('seguro_imss') ? $errors->first('seguro_imss') : '' }}"
                        @if ($enr->document->seguro_imss)
                        color="is-primary"
                        text="seguro.pdf"
                        :disable=true
                        @endif
                        ></small-file>
                    </div>
                    <div class="column">
                        <p class="has-text-weight-bold">Carta compromiso</p>
                        <small-file
                        name="carta_comp"
                        serv_error="{{ $errors->has('carta_comp') ? $errors->first('carta_comp') : '' }}"
                        @if ($enr->document->carta_comp)
                        color="is-primary"
                        text="carta_compromiso.pdf"
                        :disable=true
                        @endif
                        ></small-file>
                    </div>
                    <div class="column">
                        <p class="has-text-weight-bold">Historial académico</p>
                        <small-file
                        name="historial_ac"
                        serv_error="{{ $errors->has('historial_ac') ? $errors->first('historial_ac') : '' }}"
                        @if ($enr->document->historial_ac)
                        color="is-primary"
                        text="Historial.pdf"
                        :disable=true
                        @endif
                        ></small-file>
                    </div>
                </div>
                <button class="button is-success is-large" type="submit">Enviar Documentos</button>
                </div>
            </form>
            <div>
                <p class="is-italic">¿Te pre-registraste a este programa por error?</p>
                <form action="{{route('insc.disenroll', $enr)}}" method="POST">
                    {!! method_field('delete') !!}
                    {!! csrf_field() !!}
                    <button class="button is-outlined is-danger">Dar de baja</button>
                </form>
            </div>
            @endif
        @endforeach
        </div>
    </div>
@else
<h1 class="title">Aún no estás inscrita/o a ninguna práctica</h1>
<p class="subtitle">El periodo de inscripción es del 17 al 2 de agosto</p>
{{-- <a href="{{ route('insc') }}">Ver oferta de programas</a> --}}
<br><br>
<h1 class="title">Programas disponibles para el semestre {{config('globales.semestre_activo')}} </h1>
<programs-list 
    :programs="{{ json_encode($programs) }}"
    pdf-url="{{ route('rps_pdf', 0) }}"
    en-url="{{ route('insc.enroll', 0) }}"
></programs-list>
@endif
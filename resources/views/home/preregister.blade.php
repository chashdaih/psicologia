
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
        </div>
    </div>
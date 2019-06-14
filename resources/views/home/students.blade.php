@if ($tramites)
    {{-- @foreach ($tramites as $tramite) --}}
        @if ($tramites->document && $tramites->document->seguro_imss && $tramites->document->carta_comp && $tramites->document->historial_ac)
        <p class="subtitle">Estás registrado al programa: {{ $tramites->program->programa }}</p>
        <a href="{{ route('e_proof', $tramites->document->id_tramite) }}">Descargar comprobante de inscripción</a>
        @else
        <p class="subtitle">Estás pre-registrado al programa: {{ $tramites->program->programa }}</p>
        <div class="container">
            <diss-noti>
                Recuerda que debes subir todos tus documentos antes del 28 mayo o tu inscripción no será válida.
            </diss-noti>
            <br>
            <div class="box has-text-centered">
                <p class="has-text-weight-bold">Para completar tu registro, necesitas subir tres documentos:</p>
                <div>
                    <p>Un comprobante de que tienes seguro médico</p>
                    <a href="" class="button is-info">Ir a la página del seguro social</a>
                </div>
                <br>
                <div>
                    <p>La carta compromiso, por favor imprímela, firmala y sube un solo archivo que contenga las dos páginas</p>
                    <a class="button is-info" href="{{ route('insc.carta', $tramites->program->id_practica) }}">Generar carta compromiso</a>
                </div>
                <br>
                <div>
                    <p>Tu historial académico</p>
                    <a class="button is-info" href="">Ir a la página del historial</a>
                </div>
                <br>
                <p class="is-italic">Puedes subir los documentos en diferentes momentos, solo recuerda subirlos antes de la fecha límite</p>
                <br>
            @foreach ($enroll_programs as $enr)
                <form action="{{ route('insc.docs') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{$enr->id_tramite}}" name="id_tramite">
                    <div class="columns">
                        {{-- <div class="column">
                            <p class="has-text-weight-bold">Programa</p>
                            <p>{{ $enr->program->programa}}</p>
                        </div> --}}
                        {{-- @if ($enr->document->seguro_imss && $enr->document->carta_comp && $enr->document->historial_ac)
                        <div class="column">
                            <p class="subtitle">Ya has subido todos los documentos</p>
                        </div>
                        @else --}}
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
                        {{-- <div class="column">
                            
                        </div> --}}
                        {{-- @endif --}}
                    </div>
                    <button class="button" type="submit">Enviar Documentos</button>
                    </div>
                </form>
            @endforeach
            </div>
        </div>
        @endif
    {{-- @endforeach --}}
@else
<p class="subtitle">El periodo de inscripción es del 17 al 28 de junio</p>
<a href="{{ route('insc') }}">Ver oferta de programas</a>
@endif
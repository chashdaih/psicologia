@extends('layouts.base')
@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">{{$patient->fdg->full_name}}</h1>
        <a href="{{route('patientExcel', $patient->id)}}" class="button is-success">
                <span class="icon"><fai icon="file-excel" size="1x" /></span>
                <span>Generar excel</span>
        </a>
        <br><br>
        <div class="card">
        <div class="tile">
                <div class="tile is-parent is-9">
                        <article class="tile is-child notification has-text-centered">
                        <p class="title">FE3 - Primer contacto</p>
                        <div class="field id-grouped">
                                <a href={{ route('fdg.edit', ['patient_id'=>$patient->id, 'fdg'=>$patient->fdg_id]) }} 
                                        class="button is-info is-medium">
                                        <span class="icon"><fai icon="edit" size="2x" /></span>
                                        <span>FDG - Ficha de datos generales</span>
                                </a>
                                <a href={{ route('fdg.show', ['patient_id'=>$patient->id, 'fdg'=>$patient->fdg_id]) }} 
                                        class="button is-info is-medium">
                                        <span class="icon"><fai icon="file-pdf" size="2x" /></span>
                                        <span>FDG - Ficha de datos generales</span>
                                </a>
                        </div>
                        <div><br></div>
                        @if ($patient->cdr_id)
                        <div class="field id-grouped">
                                <a href={{ route('cdr.edit', ['patient_id'=>$patient->id, 'cdr'=>$patient->cdr_id]) }} 
                                        class="button is-info is-medium">
                                        <span class="icon"><fai icon="edit" size="2x" /></span>
                                        <span>CDR - Cuest. de detección de riesgos</span>
                                </a>
                                <a href={{ route('cdr.show', ['patient_id'=>$patient->id, 'cdr'=>$patient->cdr_id]) }} 
                                        class="button is-info is-medium">
                                        <span class="icon"><fai icon="file-pdf" size="2x" /></span>
                                        <span>CDR - Cuest. de detección de riesgos</span>
                                </a>
                        </div>
                        @else
                        <div class="field id-grouped">
                                <a href={{ route('cdr.create', ['patient_id'=>$patient->id]) }} 
                                        class="button is-info is-medium">
                                        <span class="icon"><fai icon="plus-circle" size="2x" /></span>
                                        <span>CDR - Cuest. de detección de riesgos</span>
                                </a>
                        </div>
                        @endif
                        {{-- <a href={{ route('cdr.show', ['patient_id'=>$patient->id, 'cdr'=>$patient->cdr_id]) }} class="button is-info is-fullwidth is-medium"></a> --}}
                        </article>
                </div>
                <div class="tile is-parent">
                        <article class="tile is-child notification">
                                @if (!count($patient->assigned) && $patient->cdr_id)
                                <p class="title">Programa</p>
                                <p class="subtitle">Sin programa asignado</p>
                                        @if(Auth::user()->type > 4)
                                        <show-assign
                                                :supervisors="{{$supervisors}}"
                                                stage="admision"
                                                base-url="{{URL::to('/')}}"
                                                user-id="{{$patient->id}}"
                                        ></show-assign>
                                        @endif
                                @endif
                        </article>
                </div>
        </div>
        @if(count($patient->assigned))
        <div class="tile">
                @if(count($patient->assigned->where('process_code', 'ps'))>0)
                <div class="tile is-parent is-9">
                        <article class="tile is-child notification has-text-centered">
                        <p class="title">FE4 - Admisión</p>
                        <a href={{ route('ps.index', $patient->id) }} class="button is-info is-fullwidth is-medium">PS - Plan de servicios</a>
                        </article>
                </div>
                <div class="tile is-parent">
                        <article class="tile is-child notification  has-text-centered">
                        <p class="title">Programa</p>
                        <p class="subtitle">{{ $patient->assigned->where('process_code', 'ps')->last()->program->programa }}</p>
                        @if(Auth::user()->type > 4)
                        {{-- <assign-program
                                :stages="{{json_encode($centers)}}"
                                :supervisors="{{$supervisors}}"
                                etapa="ps"
                                base_url="{{URL::to('/')}}"
                                user_id="{{$patient->id}}"
                        ></assign-program> --}}
                        <show-assign
                        :supervisors="{{$supervisors}}"
                        stage="ps"
                        base-url="{{URL::to('/')}}"
                        user-id="{{$patient->id}}"
                        ></show-assign>
                        @endif
                        </article>
                </div>
                @else
                <div class="tile is-parent is-9">
                        <article class="tile is-child notification has-text-centered">
                        <p class="title">FE4 - Admisión</p>
                        <p class="is-italic">Sin programa asignado</p>
                        </article>
                </div>
                <div class="tile is-parent">
                        <article class="tile is-child notification">
                        <p class="title">Programa</p>
                        <p class="subtitle">Sin programa asignado</p>
                        @if(Auth::user()->type > 4)
                        {{-- <assign-program
                                :stages="{{json_encode($centers)}}"
                                :supervisors="{{$supervisors}}"
                                etapa="ps"
                                base_url="{{URL::to('/')}}"
                                user_id="{{$patient->id}}"
                        ></assign-program> --}}
                        <show-assign
                        :supervisors="{{$supervisors}}"
                        stage="ps"
                        base-url="{{URL::to('/')}}"
                        user-id="{{$patient->id}}"
                        ></show-assign>
                        @endif
                        </article>
                </div>
                @endif
        </div>
        <div class="tile">
                @if(count($patient->assigned->where('process_code', 're'))>0)
                <div class="tile is-parent is-9">
                        <article class="tile is-child notification has-text-centered">
                        <p class="title">FE5 - Evaluación</p>
                        <a href={{ route('re.index', $patient->id) }} class="button is-info is-fullwidth is-medium">RE - Resultados de evaluación</a>
                        </article>
                </div>
                <div class="tile is-parent">
                        <article class="tile is-child notification  has-text-centered">
                        <p class="title">Programa</p>
                        <p class="subtitle">{{ $patient->assigned->where('process_code', 're')->last()->program->programa }}</p>
                        @if(Auth::user()->type > 4)
                        {{-- <assign-program
                                :stages="{{json_encode($centers)}}"
                                :supervisors="{{$supervisors}}"
                                etapa="re"
                                base_url="{{URL::to('/')}}"
                                user_id="{{$patient->id}}"
                        ></assign-program> --}}
                        <show-assign
                        :supervisors="{{$supervisors}}"
                        stage="re"
                        base-url="{{URL::to('/')}}"
                        user-id="{{$patient->id}}"
                        ></show-assign>
                        @endif
                        </article>
                </div>
                @else
                <div class="tile is-parent is-9">
                        <article class="tile is-child notification has-text-centered">
                        <p class="title">FE5 - Evaluación</p>
                        <p class="is-italic">Sin programa asignado</p>
                        </article>
                </div>
                <div class="tile is-parent">
                        <article class="tile is-child notification">
                        <p class="title">Programa</p>
                        <p class="subtitle">Sin programa asignado</p>
                        @if(Auth::user()->type > 4)
                        {{-- <assign-program
                                :stages="{{json_encode($centers)}}"
                                :supervisors="{{$supervisors}}"
                                etapa="re"
                                base_url="{{URL::to('/')}}"
                                user_id="{{$patient->id}}"
                        ></assign-program> --}}
                        <show-assign
                        :supervisors="{{$supervisors}}"
                        stage="re"
                        base-url="{{URL::to('/')}}"
                        user-id="{{$patient->id}}"
                        ></show-assign>
                        @endif
                        </article>
                </div>
                @endif
        </div>
        <div class="tile">
                @if(count($patient->assigned->where('process_code', 'rs6'))>0)
                <div class="tile is-parent is-9">
                        <article class="tile is-child notification has-text-centered">
                                <p class="title">FE6 - Orientación / consejo breve</p>
                                <a href={{ route('breve.index', $patient->id) }} class="button is-info is-fullwidth is-medium">RS - Resumen de sesión</a>
                        </article>
                </div>
                <div class="tile is-parent">
                        <article  class="tile is-child notification has-text-centered">
                                <p class="title">Programa</p>
                                <p class="subtitle">{{ $patient->assigned->where('process_code', 'rs6')->last()->program->programa }}</p>
                                @if(Auth::user()->type > 4)
                                {{-- <assign-program
                                        :stages="{{json_encode($centers)}}"
                                        :supervisors="{{$supervisors}}"
                                        etapa="rs6"
                                        base_url="{{URL::to('/')}}"
                                        user_id="{{$patient->id}}"
                                ></assign-program> --}}
                                <show-assign
                                :supervisors="{{$supervisors}}"
                                stage="rs6"
                                base-url="{{URL::to('/')}}"
                                user-id="{{$patient->id}}"
                                ></show-assign>
                                @endif
                        </article>
                </div>
                @else
                <div class="tile is-parent is-9">
                        <article class="tile is-child notification has-text-centered">
                                <p class="title">FE6 - Orientación / consejo breve</p>
                                <p class="is-italic">Sin programa asignado</p>
                        </article>
                </div>
                <div class="tile is-parent">
                        <article class="tile is-child notification has-text-centered">
                                <p class="title">Programa</p>
                                <p class="is-italic">Sin programa asignado</p>
                                @if(Auth::user()->type > 4)
                                {{-- <assign-program
                                        :stages="{{json_encode($centers)}}"
                                        :supervisors="{{$supervisors}}"
                                        etapa="rs6"
                                        base_url="{{URL::to('/')}}"
                                        user_id="{{$patient->id}}"
                                ></assign-program> --}}
                                <show-assign
                                :supervisors="{{$supervisors}}"
                                stage="rs6"
                                base-url="{{URL::to('/')}}"
                                user-id="{{$patient->id}}"
                                ></show-assign>
                                @endif
                        </article>
                </div>
                @endif
        </div>
        <div class="tile">
                @if(count($patient->assigned->where('process_code', 'rs7'))>0)
                <div class="tile is-parent is-9">
                        <article class="tile is-child notification has-text-centered">
                                <p class="title">FE7 - Intervención</p>
                                <a href={{ route('intervencion.index', $patient->id) }} class="button is-info is-fullwidth is-medium">RS - Resumen de sesión</a>
                        </article>
                </div>
                <div class="tile is-parent">
                        <article class="tile is-child notification has-text-centered">
                                <p class="title">Programa</p>
                                <p class="subtitle">{{ $patient->assigned->where('process_code', 'rs7')->last()->program->programa }}</p>
                                @if(Auth::user()->type > 4)
                                {{-- <assign-program
                                        :stages="{{json_encode($centers)}}"
                                        :supervisors="{{$supervisors}}"
                                        etapa="rs7"
                                        base_url="{{URL::to('/')}}"
                                        user_id="{{$patient->id}}"
                                ></assign-program> --}}
                                <show-assign
                                :supervisors="{{$supervisors}}"
                                stage="rs7"
                                base-url="{{URL::to('/')}}"
                                user-id="{{$patient->id}}"
                                ></show-assign>
                                @endif
                        </article>
                </div>
                @else
                <div class="tile is-parent is-9">
                        <article class="tile is-child notification has-text-centered">
                                <p class="title">FE7 - Intervención</p>
                                <p class="is-italic">Sin programa asignado</p>
                        </article>
                </div>
                <div class="tile is-parent">
                        <article class="tile is-child notification">
                                <p class="title">Programa</p>
                                <p class="subtitle">Sin programa asignado</p>
                                @if(Auth::user()->type > 4)
                                {{-- <assign-program
                                        :stages="{{json_encode($centers)}}"
                                        :supervisors="{{$supervisors}}"
                                        etapa="rs7"
                                        base_url="{{URL::to('/')}}"
                                        user_id="{{$patient->id}}"
                                ></assign-program> --}}
                                <show-assign
                                :supervisors="{{$supervisors}}"
                                stage="rs7"
                                base-url="{{URL::to('/')}}"
                                user-id="{{$patient->id}}"
                                ></show-assign>
                                @endif
                        </article>
                </div>
                @endif
        </div>
        <div class="tile">
                @if(count($patient->assigned->where('process_code', 'he'))>0)
                <div class="tile is-parent is-9">
                        <article class="tile is-child notification has-text-centered">
                                <p class="title">FE8 - Egreso</p>
                                <a href={{route('he.index', $patient->id)}} class="button is-info  is-fullwidth is-medium">HE - Hoja de egreso</a>
                                <div><br></div>
                                <a href={{ route('cssp.index', $patient->id) }} class="button is-info  is-fullwidth is-medium">CSSP - Cuestionario de satisfacción</a>
                        </article>
                </div>
                <div class="tile is-parent">
                        <article class="tile is-child notification has-text-centered">
                                <p class="title">Programa</p>
                                <p class="subtitle">{{ $patient->assigned->where('process_code', 'he')->last()->program->programa }}</p>
                                @if(Auth::user()->type > 4)
                                {{-- <assign-program
                                        :stages="{{json_encode($centers)}}"
                                        :supervisors="{{$supervisors}}"
                                        etapa="egreso"
                                        base_url="{{URL::to('/')}}"
                                        user_id="{{$patient->id}}"
                                ></assign-program> --}}
                                <show-assign
                                :supervisors="{{$supervisors}}"
                                stage="egreso"
                                base-url="{{URL::to('/')}}"
                                user-id="{{$patient->id}}"
                                ></show-assign>
                                @endif
                        </article>
                </div>
                @else
                <div class="tile is-parent is-9">
                        <article class="tile is-child notification has-text-centered">
                                <p class="title">FE8 - Egreso</p>
                                <p class="is-italic">Sin programa asignado</p>
                        </article>
                </div>
                <div class="tile is-parent">
                        <article class="tile is-child notification has-text-centered">
                                <p class="title">Programa</p>
                                <p class="is-italic">Sin programa asignado</p>
                                @if(Auth::user()->type > 4)
                                {{-- <assign-program
                                        :stages="{{json_encode($centers)}}"
                                        :supervisors="{{$supervisors}}"
                                        etapa="egreso"
                                        base_url="{{URL::to('/')}}"
                                        user_id="{{$patient->id}}"
                                ></assign-program> --}}
                                <show-assign
                                :supervisors="{{$supervisors}}"
                                stage="egreso"
                                base-url="{{URL::to('/')}}"
                                user-id="{{$patient->id}}"
                                ></show-assign>
                                @endif
                        </article>
                </div>
                @endif
        </div>
        @endif
    </div>
    </div>
</section>
@endsection

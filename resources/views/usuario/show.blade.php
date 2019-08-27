@extends('layouts.base')
@section('content')
<section class="section">
    <div class="container">
        <h1 class="title">{{$patient->fdg->full_name}}</h1>
        <div class="card">
        <div class="tile">
                <div class="tile is-parent is-9">
                        <article class="tile is-child notification has-text-centered">
                        <p class="title">FE3 - Primer contacto</p>
                        <a href={{ route('fdg.show', ['patient_id'=>$patient->id, 'fdg'=>$patient->fdg_id]) }} class="button is-info is-fullwidth is-medium">FDG - Ficha de datos generales</a>
                        <div><br></div>
                        <a href={{ route('cdr.show', ['patient_id'=>$patient->id, 'cdr'=>$patient->cdr_id]) }} class="button is-info is-fullwidth is-medium">CDR - Cuestionario de detección de riesgos</a>
                        </article>
                </div>
                <div class="tile is-parent">
                        <article class="tile is-child notification">
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
                        <assign-program
                                :stages="{{json_encode($centers)}}"
                                :supervisors="{{$supervisors}}"
                                etapa="ps"
                                base_url="{{URL::to('/')}}"
                                user_id="{{$patient->id}}"
                        ></assign-program>
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
                        <assign-program
                                :stages="{{json_encode($centers)}}"
                                :supervisors="{{$supervisors}}"
                                etapa="ps"
                                base_url="{{URL::to('/')}}"
                                user_id="{{$patient->id}}"
                        ></assign-program>
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
                        <assign-program
                                :stages="{{json_encode($centers)}}"
                                :supervisors="{{$supervisors}}"
                                etapa="re"
                                base_url="{{URL::to('/')}}"
                                user_id="{{$patient->id}}"
                        ></assign-program>
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
                        <assign-program
                                :stages="{{json_encode($centers)}}"
                                :supervisors="{{$supervisors}}"
                                etapa="re"
                                base_url="{{URL::to('/')}}"
                                user_id="{{$patient->id}}"
                        ></assign-program>
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
                                <assign-program
                                        :stages="{{json_encode($centers)}}"
                                        :supervisors="{{$supervisors}}"
                                        etapa="rs6"
                                        base_url="{{URL::to('/')}}"
                                        user_id="{{$patient->id}}"
                                ></assign-program>
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
                                <assign-program
                                        :stages="{{json_encode($centers)}}"
                                        :supervisors="{{$supervisors}}"
                                        etapa="rs6"
                                        base_url="{{URL::to('/')}}"
                                        user_id="{{$patient->id}}"
                                ></assign-program>
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
                                <assign-program
                                        :stages="{{json_encode($centers)}}"
                                        :supervisors="{{$supervisors}}"
                                        etapa="rs7"
                                        base_url="{{URL::to('/')}}"
                                        user_id="{{$patient->id}}"
                                ></assign-program>
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
                                <assign-program
                                        :stages="{{json_encode($centers)}}"
                                        :supervisors="{{$supervisors}}"
                                        etapa="rs7"
                                        base_url="{{URL::to('/')}}"
                                        user_id="{{$patient->id}}"
                                ></assign-program>
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
                                <assign-program
                                        :stages="{{json_encode($centers)}}"
                                        :supervisors="{{$supervisors}}"
                                        etapa="egreso"
                                        base_url="{{URL::to('/')}}"
                                        user_id="{{$patient->id}}"
                                ></assign-program>
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
                                <assign-program
                                        :stages="{{json_encode($centers)}}"
                                        :supervisors="{{$supervisors}}"
                                        etapa="egreso"
                                        base_url="{{URL::to('/')}}"
                                        user_id="{{$patient->id}}"
                                ></assign-program>
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

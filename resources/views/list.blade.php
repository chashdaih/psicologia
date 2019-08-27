@extends('layouts.base')

@section('content')
<section class="section" style="flex: 1">
    <div class="container">
        @if(Auth::user()->type != 3)
        @include('home.supervisors')
        @else
        @include('home.students')
        @endif
    </div>
</section>
<section class="section">
    <div class="container">
        <b>AVISO DE PRIVACIDAD</b>
        <p>Los datos personales recabados estarán protegidos conforme a lo dispuesto por la Ley General de Transparencia y Acceso a la Información Pública, la Ley Federal de Transparencia y Acceso a la Información Pública Gubernamental (LFTAIPG), su Reglamento, los Lineamientos de Protección de Datos Personales publicados en el D.O.F. el 30 de septiembre de 2005 y demás normativa aplicable.</p>
        <p>Estos datos serán incorporados y tratados en el sistema de datos personales denominado “Sistema de Gestión de Calidad de los Centros de Formación y Servicios Psicológicos” el cual se creó con fundamento en las atribuciones que otorgan al Instituto Nacional de Transparencia, Acceso a la Información y Protección de Datos Personales (INAI) los artículos 33 y 37 fracción XIII de la LFTAIPG. Tal sistema fue registrado en el listado de sistemas de datos personales que administra el INAI (<a href="www.inai.mx">www.inai.mx</a> <a href="http://persona.ifai.org.mx/persona/welcome.do">http://persona.ifai.org.mx/persona/welcome.do</a> ).</p>
    </div>
</section>
@endsection
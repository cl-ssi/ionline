@extends('layouts.guest')

@section('title', 'Información sobre vacunación para funcionarios')

@section('content')
<h3 class="mb-3">Información sobre vacunación para funcionarios</h3>

<ul>
    <li>Esta dirigida solo a funcionarios del HETG y de la DSSI.</li>
    <li>Los funcionarios de la red de salud mental extrahospitalaria tendrán
        otros puntos de vacunación los que serán informados por sus
        Directores de Establecimiento.</li>
    <li>El lugar de vacunación es el domo en el estacionamiento atrás del HETG.</li>
    <li>Todos deben presentar su credencial al momento de su vacunación.</li>
    <li>Si no te registraste y quieres vacunarte, tienes plazo hasta el 01-03-2021:
        <ul>
            <li>Funcionarios del HETG deben tomar contacto con su jefatura o
                supervisor/a de servicio y/o el Encargado de Vacunas del HETG
                <a href="mailto:coordinacionvacunashetg@gmail.com">coordinacionvacunashetg@gmail.com</a></li>
            <li>Funcionarios de la DSSI deben tomar contacto con la jefatura
                de Calidad de Vida del SSI, Vanessa Sepúlveda, anexo
                576443 - desde teléfonos externos al 572406443
                <a href="mailto:vanessa.sepulvedam@redsalud.gov.cl">vanessa.sepulvedam@redsalud.gov.cl</a></li>
        </ul>
    </li>
    <li>Si te registraste y no apareces, entonces ponte en contacto con OIRS
        (los datos aparecen al final) para corroborar tu inscripción.</li>
    <li>Si tienes dificultades respecto al día y hora asignado, toma contacto con tu
        jefatura o supervisor/a de servicio, si eres de la DSSI con Calidad de Vida.</li>
    <li>Debes considerar que posterior a la vacunación debes quedarte
        30 minutos en el lugar para observación post vacunación.</li>
    <li>De presentar una reacción post vacunación leve a moderada,
        preséntate en el lugar de vacunación con el Enfermera de Salud del Trabajador
        (María Edith Vílchez) para tu notificación al ISP y seguimiento
        por parte de la unidad de salud.
        Si es algo importante dirigente a un sistema de urgencia,
        donde de igual manera deben reportar el evento.</li>
</ul>

<div class="alert alert-secondary mt-3 text-center" role="alert">
    <h4 class="alert-heading">Consultar fecha de vacunación </h4>
    <!-- Código para visualizar botón oficial iniciar sesión con ClaveÚnica-->
    <div class="row justify-content-center">
        <a class="btn-cu btn-m btn-color-estandar" title="Este es el botón Iniciar sesión de ClaveÚnica"
            href="{{ route('claveunica.autenticar') }}?redirect=L3ZhY2NpbmF0aW9uL2xvZ2lu">
            <span class="cl-claveunica"></span>
            <span class="texto">Iniciar sesión</span>
        </a>
    <!--./ fin botón-->
    </div>
</div>



<div class="alert alert-info mt-3" role="alert">
    Si no tienes clave única, contáctate con OIRS al correo
    <a href="mailto:mireyasoto.f@redsalud.gob.cl">mireyasoto.f@redsalud.gob.cl</a>
    o llamando a los anexos 579501 / 579532 y
    solicita información sobre tu fecha y hora de vacunación.
</div>

@endsection

@section('custom_js')

@endsection

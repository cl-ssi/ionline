@extends('layouts.app')

@section('title', 'Información sobre vacunación para funcionarios')

@section('content')
<h3 class="mb-3">Información sobre vacunación para funcionarios</h3>

<ul>
    <li>Esta dirigida solo a funcionarios del HETG y de la DSSI (no red de salud mental extrahospitalaria).</li>
    <li>El lugar de vacunación es el domo en el estacionamiento atrás del HETG.</li>
    <li>Todos deben presentar su credencial al momento de su vacunación.</li>
    <li>Si no apareces registrado y quieres vacunarte:
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

<a href="{{ route('claveunica.autenticar') }}?redirect=L3ZhY2NpbmF0aW9uL2xvZ2lu" class="btn btn-lg btn-outline-primary">
    Consultar fecha y hora de vacunación <img src="{{ asset('images/btn_claveunica_119px.png') }}" alt="Logo Clave única">
</a>

<div class="alert alert-info mt-3" role="alert">
  Si no tienes clave única, contáctate con OIRS de tu establecimeinto y
  solicita información sobre tu fecha y hora de vacunación.
</div>

@endsection

@section('custom_js')

@endsection

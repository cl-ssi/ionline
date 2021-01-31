@extends('layouts.app')

@section('title', 'Información sobre vacunación para funcionarios')

@section('content')
<h3 class="mb-3">Información sobre vacunación para funcionarios</h3>

<ul>
    <li>Esta dirigida solo a funcionarios del HETG y de la DSSI
        (no red de salud mental extrahospitalaria).</li>
    <li>Todos deben presentar su credencial.</li>
    <li>Si no aparecen en el listado y quieres vacunarte, toma contacto con
        tu jefatura o supervisor/a de servicio y/o el Encargado de Vacunas
        del HETG <a href="mailto:coordinacionvacunashetg@gmail.com">coordinacionvacunashetg@gmail.com</a>.</li>
    <li>El lugar de vacunación es el domo en el estacionamiento atrás del HETG.</li>
    <li>Debes considerar que posterior a la vacunación debes quedarte
        30 minutos en el lugar para observación post vacunación.</li>
    <li>De presentar  una reacción post vacunación leve a moderada,
        preséntate en el lugar de vacunación con el enfermera de
        Salud del Trabajador para tu notificación al ISP y
        seguimiento por parte de la unidad de salud del trabajador.
        Si es algo importante dirigente a un sistema de urgencia.</li>
    <li>Si tienes dificultades respecto al día y hora asignado, toma contacto con tu
        jefatura o supervisor/a de servicio.</li>
</ul>

<a href="{{ route('claveunica.autenticar') }}?redirect=L3ZhY2NpbmF0aW9uL2xvZ2lu" class="btn btn-lg btn-outline-primary">
    Consultar fecha y hora de vacunación <img src="{{ asset('images/btn_claveunica_119px.png') }}" alt="Logo Clave única">
</a>

<div class="alert alert-info mt-3" role="alert">
  Si no tienes clave única, envía un correo indicando tu nombre y rut a:
  <a href="mailto:coordinacionvacunashetg@gmail.com">coordinacionvacunashetg@gmail.com</a>
  solicitando información sobre tu fecha y hora de vacunación.
</div>

@endsection

@section('custom_js')

@endsection

@extends('layouts.guest')

@section('title', 'Información sobre vacunación para funcionarios')

@section('content')
<h3 class="mb-3">Información sobre vacunación para funcionarios</h3>

<ul>
    <li>Está dirigida solo a funcionarios del HETG, Red de Salud Mental y de la DSSI</li>
    <li>El lugar de vacunación es el domo en el estacionamiento detrás del HETG.</li>
    <li>Todos deben presentar su credencial al momento de su vacunación.</li>
    <li>Si no te registraste y quieres vacunarte, tienes plazo hasta el 01-03-2021:</li>
        <ul>
            <li>Funcionario que ingresa a registro por su primera dosis, y no puede acceder 
                debe tomar contacto con OIRS del Servicio de Salud</li>
            <li>Funcionarios que tengan que inmunizarse con segunda dosis, 
                sólo deben agendar hora, ya que el día está fijado dentro 
                de su carnet de vacunación (28 días posterior a su primera dosis).</li>
        </ul>
    </li>
    <li>Debes considerar que posterior a la vacunación debes quedarte 30 minutos 
        en el lugar para observación post vacunación.</li>
    <li>De presentar una reacción post vacunación leve a moderada, 
        preséntate en el lugar de vacunación con el Enfermera de 
        Salud del Trabajador (María Edith Vílches) para tu 
        notificación al ISP y seguimiento por parte de la unidad de salud. 
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
    <a href="mailto:teresa.stuardo@redsalud.gob.cl">teresa.stuardo@redsalud.gob.cl</a>
    o llamando a los anexos 579501 / 579516/ 579532 y
    solicita información sobre tu fecha y hora de vacunación.
</div>

@endsection

@section('custom_js')

@endsection

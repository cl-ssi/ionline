@extends('layouts.bt4.guest')

@section('title', 'Información sobre vacunación para funcionarios')

@section('content')

<div class="alert alert-warning" role="alert">
  Si eres Mujer Mayor de 40 años, y no te has realizado la mamografía hace 1 año. Inscríbete!!!!
</div>

<div class="card">
    <h5 class="card-header"><i class="fas fa-info-circle"></i> Información</strong></h5>
    <div class="card-body">
        <h5>Indicaciones:</h5>
        <ul>
            <li>No debe estar embarazada.</li>
            <li>Avisar si está amamantando.</li>
            <li>Venir sin desodorante, sin talco, ni cremas.</li>
            <li>No traer joyas, (Aros, Cadenas y/o gargantilla).</li>
            <li>De preferencia no usar vestido, privilegiar el uso de vestimenta de dos piezas.</li>
            <li>Es recomendable tomarse el examen después de su periodo menstrual.</li>
        </ul>
    </div>
</div>


<div class="alert alert-secondary mt-3 text-center" role="alert">
    <h4 class="alert-heading">Agenda o Consulta tu hora de examen aquí.</h4>
    <!-- Código para visualizar botón oficial iniciar sesión con ClaveÚnica-->
    <div class="row justify-content-center">
        <a class="btn-cu btn-m btn-color-estandar" title="Este es el botón Iniciar sesión de ClaveÚnica"
            href="{{ route('claveunica.autenticar') }}?redirect=L21hbW1vZ3JhcGh5L2xvZ2lu">
            <span class="cl-claveunica"></span>
            <span class="texto">Iniciar sesión</span>
        </a>
    <!--./ fin botón-->
    </div>
</div>



<!-- <div class="alert alert-info mt-3" role="alert">
    Si no tienes clave única, contáctate con OIRS al correo
    <a href="mailto:teresa.stuardo@redsalud.gob.cl">teresa.stuardo@redsalud.gob.cl</a>
    o llamando a los anexos 579501 / 579516/ 579532 y
    solicita información sobre tu fecha y hora de vacunación.
</div> -->

@endsection

@section('custom_js')

@endsection

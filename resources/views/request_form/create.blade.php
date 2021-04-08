@extends('layouts.app')

@section('title', '- Formulario de Requerimientos')

@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>

<h3 class="mb-3">Formulario de Requerimiento - Bienes y/o Servicios (Ejecución Inmediata)</h3>

@include('request_form.nav')

<!-- FORM DE INGRESO DE TICKET -->
<!--<form method="POST" class="form-horizontal" action="{{ route('request_forms.store') }}" enctype="multipart/form-data">-->


<div class="container-fluid"><!-- CONTENEDOR -->

<div class="card bg-light">
  <div class="card-body">
     <h5 class="card-title mb-2 text-muted">Datos del Solicitante:</h5>
     <div class="row justify-content-md-center"><!-- FILA 1 -->
       <div class="my-2 col-3">
           <label for="forRut" class="form-label">Rut:</label>
           <input class="form-control form-control-sm" type="text" name="" id="rut" name="rut" value="13.414.559-5" readonly>
       </div>
        <div class="my-2 col-3">
            <label for="forNombres" class="form-label">Nombres:</label>
            <input class="form-control form-control-sm" type="text" name="" id="nombres" name="nombres" value="Oscar Jesús" readonly>
        </div>
        <div class="my-2 col-3">
            <label for="forApellido_p" class="form-label">Apellido Paterno:</label>
            <input class="form-control form-control-sm" type="text" name="" id="apellido_p" name="apellido_p" value="Zavala" readonly>
        </div>
        <div class="my-2 col-3">
            <label for="forApellido_m" class="form-label">Apellido Materno:</label>
            <input class="form-control form-control-sm" type="text" name="" id="apellido_m" name="apellido_m" value="Cortés" readonly>
        </div>
      </div><!-- FILA 1 -->

      <div class="row justify-content-md-center"><!-- FILA 2 -->
        <div class="my-3 col-3">
            <label for="forCorreo">Correo:</label>
            <input class="form-control form-control-sm" type="text" name="" id="correo" name="correo" value="oscar.zavala@redsalud.gob.cl" readonly>
        </div>
         <div class="my-3 col-3">
             <label for="forTelefono">Teléfono:</label>
             <input class="form-control form-control-sm" type="text" name="" id="telefono" name="telefono" value="+56 9 97877170" readonly>
         </div>
         <div class="my-3 col-3">
             <label for="forCargo">Cargo:</label>
             <input class="form-control form-control-sm" type="text" name="" id="cargo" name="cargo" value="Informático" readonly>
         </div>
         <div class="my-3 col-3">
             <label for="forUnidad">Unidad:</label>
             <input class="form-control form-control-sm" type="text" name="" id="unidad" name="unidad" value="TIC" readonly>
         </div>
       </div><!-- FILA 2 -->
    </div><!-- CARD BODY -->
</div><!-- CARD -->
<br>
<livewire:items.request-type />
</div><!-- CONTENEDOR -->

@endsection

@section('custom_js_head')

@endsection

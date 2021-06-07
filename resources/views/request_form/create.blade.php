@extends('layouts.app')

@section('title', '- Formulario de Requerimientos')

@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>

<h4 class="mb-3">Formulario de Requerimiento - Bienes y/o Servicios (Ejecución Inmediata)</h4>

@include('request_form.nav')

<div class="container-fluid"><!-- CONTENEDOR -->

<div class="card bg-light">
  <div class="card-body">
     <h6 class="card-title mb-2 text-primary"><i class="far fa-user"></i> Datos del Solicitante:</h6>
     <div class="row justify-content-md-center"><!-- FILA 1 -->
       <div class="my-2 col-3">
           <label for="forRut" class="form-label">Rut:</label>
           <input class="form-control form-control-sm" type="text" id="rut" name="rut" value="{{ auth()->user()->runFormat() }}" readonly>
       </div>
        <div class="my-2 col-3">
            <label for="forNombres" class="form-label">Nombres:</label>
            <input class="form-control form-control-sm" type="text" name="" id="nombres" name="nombres" value="{{ auth()->user()->name }}" readonly>
        </div>
        <div class="my-2 col-3">
            <label for="forApellido_p" class="form-label">Apellido Paterno:</label>
            <input class="form-control form-control-sm" type="text" name="" id="apellido_p" name="apellido_p" value="{{ auth()->user()->fathers_family }}" readonly>
        </div>
        <div class="my-2 col-3">
            <label for="forApellido_m" class="form-label">Apellido Materno:</label>
            <input class="form-control form-control-sm" type="text" name="" id="apellido_m" name="apellido_m" value="{{ auth()->user()->mothers_family }}" readonly>
        </div>
      </div><!-- FILA 1 -->

      <div class="row justify-content-md-center"><!-- FILA 2 -->
        <div class="my-3 col-3">
            <label for="forCorreo">Correo:</label>
            <input class="form-control form-control-sm" type="text" name="" id="correo" name="correo" value="{{ auth()->user()->email }}" readonly>
        </div>
         <div class="my-3 col-3">
             <label for="forTelefono">Teléfono:</label>
             <input class="form-control form-control-sm" type="text" name="" id="telefono" name="telefono" value="{{ auth()->user()->phone_number }}" readonly>
         </div>
         <div class="my-3 col-3">
             <label for="forCargo">Cargo:</label>
             <input class="form-control form-control-sm" type="text" name="" id="cargo" name="cargo" value="{{ auth()->user()->position }}" readonly>
         </div>
         <div class="my-3 col-3">
             <label for="forUnidad">Unidad:</label>
             <input class="form-control form-control-sm" type="text" name="" id="unidad" name="unidad" value="{{ auth()->user()->organizationalUnit->name }}" readonly>
         </div>
       </div><!-- FILA 2 -->
    </div><!-- CARD BODY -->
</div><!-- CARD -->
<br>

<livewire:request-form.request-form-create :requestForm="$requestForm">

</div><!-- CONTENEDOR -->

@endsection
@section('custom_js_head')
@endsection

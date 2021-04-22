@extends('layouts.app')

@section('title', '- Formulario de Requerimientos')

@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>

<h3 class="mb-3">Solicitud de Cotización - Pasajes Aéreos</h3>

@include('request_form.nav')

<div class="container-fluid"><!-- CONTENEDOR -->

      <div class="card bg-light">
        <div class="card-body">
           <h5 class="card-title mb-2 text-muted">Datos del Solicitante:</h5>
           <div class="row justify-content-md-center"><!-- FILA 1 -->
             <div class="my-2 col-3">
                 <label for="forRut" class="form-label">Rut:</label>
                 <input class="form-control form-control-sm" type="text" id="rut" name="rut" value="{{$user->first()->runFormat()}}" readonly>
             </div>
              <div class="my-2 col-3">
                  <label for="forNombres" class="form-label">Nombres:</label>
                  <input class="form-control form-control-sm" type="text" id="nombres" name="nombres" value="{{$user->first()->name}}" readonly>
              </div>
              <div class="my-2 col-3">
                  <label for="forApellido_p" class="form-label">Apellido Paterno:</label>
                  <input class="form-control form-control-sm" type="text" id="apellido_p" name="apellido_p" value="{{$user->first()->fathers_family}}" readonly>
              </div>
              <div class="my-2 col-3">
                  <label for="forApellido_m" class="form-label">Apellido Materno:</label>
                  <input class="form-control form-control-sm" type="text" id="apellido_m" name="apellido_m" value="{{$user->first()->mothers_family}}" readonly>
              </div>
            </div><!-- FILA 1 -->

            <div class="row justify-content-md-center"><!-- FILA 2 -->
              <div class="my-3 col-3">
                  <label for="forCorreo">Correo:</label>
                  <input class="form-control form-control-sm" type="text" id="correo" name="correo" value="{{$user->first()->email}}" readonly>
              </div>
               <div class="my-3 col-3">
                   <label for="forTelefono">Teléfono:</label>
                   <input class="form-control form-control-sm" type="text" name="" id="telefono" name="telefono" value="{{$user->first()->phone_number}}" readonly>
               </div>
               <div class="my-3 col-3">
                   <label for="forCargo">Cargo:</label>
                   <input class="form-control form-control-sm" type="text" id="cargo" name="cargo" value="{{$user->first()->position}}" readonly>
               </div>
               <div class="my-3 col-3">
                   <label for="forUnidad">Unidad:</label>
                   <input class="form-control form-control-sm" type="text" id="unidad" name="unidad" value="{{$user->first()->organizationalUnit->name}}" readonly>
               </div>
             </div><!-- FILA 2 -->
          </div><!-- CARD BODY -->
      </div><!-- CARD -->
        <br>
        <livewire:request-form.passage.ticket-request />

</div>


@endsection

@section('custom_js_head')

@endsection

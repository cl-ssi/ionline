@extends('layouts.bt4.app')

@section('title', '- Formulario de Requerimientos')

@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>

<h3 class="mb-3">Solicitud de Cotización - Pasajes Aéreos</h3>

@include('request_form.partials.nav')

<div class="card">
    <div class="card-header">
        <i class="fas fa-user"></i> Datos del Solicitante:</h6>
    </div>
    <div class="card-body">
        <div class="form-row">
            <fieldset class="form-group col-sm-2">
                <label for="forRut" class="form-label">Rut:</label>
                <input class="form-control form-control-sm" type="text" id="rut" name="rut" value="{{ auth()->user()->runFormat() }}" readonly>
            </fieldset>

            <fieldset class="form-group col-sm-4">
                <label for="forNombres" class="form-label">Nombre:</label>
                <input class="form-control form-control-sm" type="text" name="" id="nombres" name="nombres" value="{{ auth()->user()->fullName }}" readonly>
            </fieldset>

            <fieldset class="form-group col-sm-3">
                <label for="forCorreo">Correo:</label>
                <input class="form-control form-control-sm" type="text" name="" id="correo" name="correo" value="{{ auth()->user()->email }}" readonly>
            </fieldset>

            <fieldset class="form-group col-sm-3">
                <label for="forUnidad">Unidad:</label>
                <input class="form-control form-control-sm" type="text" name="" id="unidad" name="unidad" value="{{ auth()->user()->organizationalUnit->name }}" readonly>
            </fieldset>
        </div>
    </div>
</div>

<br>

@livewire('request-form.passenger.passenger-request')

@endsection

@section('custom_js_head')

@endsection

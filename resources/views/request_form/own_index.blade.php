@extends('layouts.bt4.app')
@section('title', 'Formulario de requerimiento')
@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />

<div class="alert alert-info alert-sm" role="alert">
    <div class="row">
        <div class="col-sm">
            <i class="fas fa-info-circle"></i> <b>Fecha límite para la emisión de formularios de requerimientos para nuevos procesos de compra</b>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8 text-justify">
            <br />
            Todos los formularios de requerimientos para nuevos procesos de compra deberán emitirse a más 
            tardar el <b>30 de septiembre de 2024</b>. Es importante destacar que los formularios de requerimientos 
            de suministro mensual no están sujetos a esta fecha límite, de igual que los formularios de requerimientos 
            de presupuestos de programas o proyectos asignados posterior al 30-09-2024.
        </div>
        <div class="col-sm-4">
            <br />
            <a class="btn btn-light btn-sm float-right" href="{{ route('request_forms.circular_3650_2024') }}"
                target="blank">
                <i class="far fa-file-pdf"></i> Descargar circular aquí
            </a>
        </div>
    </div>
</div>

<h4 class="mb-3"><i class="fas fa-fw fa-inbox"></i> Mis Formularios</h4>
<p>Incluye Formularios de Compras de mi Unidad Organizacional: <b>{{ auth()->user()->organizationalUnit->name }}</b>.</p>

@include('request_form.partials.nav')

</div>

<div class="col-sm">
    @livewire('request-form.search-requests', [
      'inbox' => 'own'
    ])
</div>

@endsection

@section('custom_js_head')
<style>
  table {
    border-collapse: collapse;
  }

  .brd-l {
    border-left: solid 1px #D6DBDF;
  }

  .brd-r {
    border-right: solid 1px #D6DBDF;
  }

  .brd-b {
    border-bottom: solid 1px #D6DBDF;
  }

  .brd-t {
    border-top: solid 1px #D6DBDF;
  }

  oz {
    color: red;
    font-size: 60px;
    background-color: yellow;
    font-family: time new roman;
  }
</style>
@endsection
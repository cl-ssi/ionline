@extends('layouts.bt4.app')
@section('title', 'Formulario de requerimiento')
@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />
<h4 class="mb-3"><i class="fas fa-fw fa-inbox"></i> Formularios de Requerimiento asignados como administrador de contrato - Bandeja de Entrada</h4>

@include('request_form.partials.nav')

</div>

<div class="col-sm">
    @livewire('request-form.search-requests', [
      'inbox' => 'contract manager'
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
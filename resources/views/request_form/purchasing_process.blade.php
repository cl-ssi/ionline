@extends('layouts.app')

@section('title', 'Formulario de Requerimientos')

@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/steps.css') }}" rel="stylesheet" type="text/css"/>

<h4 class="mb-3">Formulario de Requerimiento - Proceso de Compra</h4>

@include('request_form.nav')

<div class="card mx-0">
  <h6 class="card-header text-primary"><i class="fas fa-shopping-cart"></i></a> Formulario de Requerimiento N° {{ $requestForm->id }}</h6>
  <div class="card-body mx-4 px-0">

    <livewire:request-form.purchasing-process :requestForm="$requestForm" :eventType="$eventType" >

  </div><!-- card-body -->
</div><!-- card-principal -->

@endsection
@section('custom_js')

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

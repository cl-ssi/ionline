@extends('layouts.bt4.app')
@section('title', 'Formulario de Requerimientos')
@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/steps.css') }}" rel="stylesheet" type="text/css"/>
<h4 class="mb-3">Formulario de Requerimiento - Edición de Formularios</h4>

@include('request_form.partials.nav')

<div class="table-responsive">
    <h6><i class="fas fa-info-circle"></i> Información General</h6>
    <table class="table table-sm table-striped table-bordered">
        <!-- <thead>
            <tr class="table-active">
                <th colspan="2">Formulario Contratación de Personal </th>
            </tr>
        </thead> -->
        <tbody class="small">
            <tr>
                <th class="table-active" style="width: 33%">Nombre del Solicitante</th>
                <td>{{ $requestForm->user->fullName }}</td>
            </tr>
            <tr>
                <th class="table-active" style="width: 33%">Unidad Organizacional</th>
                <td class="align-middle">{{ $requestForm->userOrganizationalUnit->name}}</td>
            </tr>
            <tr>
                <th class="table-active" style="width: 33%">Fecha de Creación</th>
                <td class="align-middle">{{ $requestForm->created_at->format('d-m-Y H:i:s') }}</td>
            </tr>
            <tr>
                <th class="table-active" style="width: 33%">Archivos Asociados</th>
                <td class="align-middle">FILE01 - FILE02 - FILE03 - FILE04</td>
            </tr>
        </tbody>
    </table>
</div>

<livewire:request-form.request-form-create :requestForm="$requestForm">

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

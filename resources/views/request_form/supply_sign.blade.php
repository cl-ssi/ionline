@extends('layouts.app')

@section('title', 'Formulario de Requerimientos')

@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/steps.css') }}" rel="stylesheet" type="text/css"/>

<h4 class="mb-3">Formulario de Requerimiento - Autorización Abastecimiento</h4>

@include('request_form.nav')

<div class="row">
    <div class="col-sm-8">
        <div class="table-responsive">
            <h6><i class="fas fa-info-circle"></i> Detalle Formulario</h6>
            <table class="table table-sm table-striped table-bordered">
                <!-- <thead>
                    <tr class="table-active">
                        <th colspan="2">Formulario Contratación de Personal </th>
                    </tr>
                </thead> -->
                <tbody class="small">
                    <tr>
                        <th class="table-active" scope="row">Fecha de Creación</th>
                        <td>{{ $requestForm->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" style="width: 33%">Nombre</th>
                        <td>{{ $requestForm->name }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" style="width: 33%">Gasto Estimado</th>
                        <td>${{ number_format($requestForm->estimated_expense,0,",",".") }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Nombre del Solicitante</th>
                        <td>{{ $requestForm->creator ? $requestForm->creator->FullName : 'Usuario eliminado' }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Unidad Organizacional</th>
                        <td>{{ $requestForm->creator ? $requestForm->organizationalUnit->name : 'Usuario eliminado' }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Adminitrador de Contrato</th>
                        <td>{{ $requestForm->contractManager ? $requestForm->contractManager->FullName : 'Usuario eliminado' }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Mecanismo de Compra</th>
                        <td>{{ $requestForm->getPurchaseMechanism()}}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Programa Asociado</th>
                        <td>{{ $requestForm->program }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Folio SIGFE</th>
                        <td>{{ $requestForm->sigfe }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Justificación de Adquisición</th>
                        <td>{{ $requestForm->justification }}</td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
    <div class="col-sm-4">
        <h6><i class="fas fa-paperclip"></i> Adjuntos</h6>
        <div class="list-group">
            @foreach($requestForm->requestFormFiles as $requestFormFile)
              <a href="{{ route('request_forms.show_file', $requestFormFile) }}" class="list-group-item list-group-item-action py-2 small" target="_blank">
                <i class="fas fa-file"></i> {{ $requestFormFile->name }} -
                <i class="fas fa-calendar-day"></i> {{ $requestFormFile->created_at->format('d-m-Y H:i') }}</a>
            @endforeach
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm">
        <div class="table-responsive">
            <h6 class="card-subtitle mt-0 mb-2 text-primary">Lista de Bienes y/o Servicios:</h6>
            <table class="table table-sm table-striped table-bordered small">
                <thead class="text-center">
                    <tr>
                        <th>Item</th>
                        <th>ID</th>
                        <th>Cod.Presup.</th>
                        <th>Artículo</th>
                        <th>UM</th>
                        <th>Especificaciones Técnicas</th>
                        <th>Archivo</th>
                        <th>Cantidad</th>
                        <th>Valor U.</th>
                        <th>Impuestos</th>
                        <th>Total Item</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requestForm->itemRequestForms as $key => $item)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$item->id}}</td>
                        <td>{{$item->budgetItem()->first()->fullName()}}</td>
                        <td>{{$item->article}}</td>
                        <td>{{$item->unit_of_measurement}}</td>
                        <td>{{$item->specification}}</td>
                        <td align="center">
                            <a href="{{ route('request_forms.show_item_file', $item) }}" target="_blank">
                              <i class="fas fa-file"></i>
                        </td>
                        <td align="right">{{$item->quantity}}</td>
                        <td align="right">${{ number_format($item->unit_value,0,",",".") }}</td>
                        <td>{{$item->tax}}</td>
                        <td align="right">${{ number_format($item->expense,0,",",".") }}</td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                    <tr>
                      <td colspan="9"></td>
                      <th class="text-right">Valor Total</td>
                      <th class="text-right">${{ number_format($requestForm->estimated_expense,0,",",".") }}</td>
                    </tr>

                </tfoot>
            </table>
        </div>
    </div>
</div>

<livewire:request-form.authorization :requestForm="$requestForm" :eventType="$eventType" >

@endsection

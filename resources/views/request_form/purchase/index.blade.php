@extends('layouts.app')
@section('title', 'Formulario de requerimiento')
@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<h4 class="mb-3">Formularios de Requerimiento - Bandeja de Entrada Abastecimiento</h4>

@include('request_form.partials.nav')

</div>
<div class="col">
    <div class="table-responsive">
        <h6><i class="fas fa-inbox"></i> Formularios En Espera</h6>
        <table class="table table-sm table-striped table-bordered small">
            <thead>
                <tr>
                    <th>ID</th>
                    <th style="width: 7%">Fecha Creación</th>
                    <th>Descripción</th>
                    <th>Usuario Gestor</th>
                    <th>Mecanismo de Compra</th>
                    <th>Items</th>
                    <th>Espera</th>
                    <th>Estado</th>
                    <th scope="col" class="text-center" colspan="2">Opciones</th>
                </tr>
            </thead>
          <tbody>
              @foreach($purchaser->requestForms as $requestForm)
                    <tr>
                        <td>{{ $requestForm->id }}</td>
                        <td>{{ $requestForm->created_at->format('d-m-Y H:i') }}</td>
                        <td>{{ $requestForm->name }}</td>
                        <td>{{-- $requestForm->creator ? $requestForm->creator->FullName : 'Usuario eliminado' --}}<br>
                            {{-- $requestForm->creator ? $requestForm->organizationalUnit->name : 'Usuario eliminado' --}}
                        </td>
                        <td>{{ $requestForm->purchaseMechanism->name }}</td>
                        <td>{{ $requestForm->quantityOfItems() }}</td>
                        <td>{{ $requestForm->getElapsedTime() }}</td>
                        <!-- <td class="align-middle text-center">{!! $requestForm->eventSign('leader_ship_event') !!}</td>
                        <td class="align-middle text-center">{!! $requestForm->eventSign('pre_finance_event') !!}</td>
                        <td class="align-middle text-center">{!! $requestForm->eventSign('finance_event') !!}</td>
                        <td class="align-middle text-center">{!! $requestForm->eventSign('supply_event') !!}</td> -->
                        <td></td>
                        <td>
                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                            <a href=""
                                  class="btn btn-outline-secondary btn-sm"><i class="fas fa-edit"></i></a>
                            </span>
                        </td>
                    </tr>
              @endforeach
          </tbody>
        </table>
    </div>
</div>

@endsection

@section('custom_js')

@endsection

@section('custom_js_head')

@endsection

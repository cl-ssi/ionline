@extends('layouts.app')
@section('title', 'Formulario de requerimiento')
@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<h4 class="mb-3">Formularios de Requerimiento - Bandeja de Entrada Abastecimiento</h4>

@include('request_form.partials.nav')

@if(!$requestForms->isEmpty())
</div>
<div class="col">
    <div class="table-responsive">
        <h6><i class="fas fa-inbox"></i> Formularios En Espera</h6>
        <table class="table table-sm table-striped table-bordered small">
            <thead>
                <tr class="text-center">
                    <th>ID</th>
                    <th style="width: 7%">Fecha Creación</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Usuario Gestor</th>
                    <th>Mecanismo de Compra</th>
                    <th>Items</th>
                    <th>Espera</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
          <tbody>
                @foreach($requestForms as $requestForm)
                        <tr>
                            <td>{{ $requestForm->id }}</td>
                            <td style="width: 7%">{{ $requestForm->created_at->format('d-m-Y H:i') }}</td>
                            <td>{{ $requestForm->type_form }}<br>{{$requestForm->subtype}}</td>
                            <td>{{ $requestForm->name }}</td>
                            <td>{{ $requestForm->user ? $requestForm->user->FullName : 'Usuario eliminado' }}<br>
                                {{ $requestForm->user ? $requestForm->userOrganizationalUnit->name : 'Usuario eliminado' }}
                            </td>
                            <td>{{ $requestForm->purchaseMechanism->name }}</td>
                            <td>{{ $requestForm->quantityOfItems() }}</td>
                            <td>{{ $requestForm->created_at->diffForHumans() }}</td>
                            <td>
                            @foreach($requestForm->eventRequestForms as $sign)
                                @if($sign->status == 'pending')
                                    <i class="fas fa-clock fa-2x" title="{{ $sign->signerOrganizationalUnit->name }}"></i>
                                @endif
                                @if($sign->status == 'approved')
                                    <span style="color: green;">
                                        <i class="fas fa-check-circle fa-2x" title="{{ $sign->signerOrganizationalUnit->name }}"></i>
                                    </span>
                                @endif
                                @if($sign->status == 'rejected')
                                    <span style="color: Tomato;">
                                        <i class="fas fa-times-circle fa-2x" title="{{ $sign->signerOrganizationalUnit->name }}"></i>
                                    </span>
                                @endif
                            @endforeach
                            </td>
                            <td>
                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="">
                                <a href="{{ route('request_forms.supply.purchase', $requestForm) }}"
                                    class="btn btn-outline-secondary btn-sm"><i class="fas fa-shopping-cart"></i></a>
                                </span>
                            </td>
                        </tr>
                @endforeach
          </tbody>
        </table>
    </div>
</div>
@else
        <div class="card">
          <div class="card-body">
            No hay formularios de requerimiento para mostrar.
          </div>
        </div>
@endif

@endsection

@section('custom_js')

@endsection

@section('custom_js_head')

@endsection

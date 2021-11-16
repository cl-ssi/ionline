@extends('layouts.app')
@section('title', 'Formulario de requerimiento')
@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<h4 class="mb-3">Formularios de Requerimiento - Bandeja de Entrada Refrendación Presupuestaria</h4>

@include('request_form.nav')

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
              <th scope="col" class="text-center">J</th>
              <th scope="col" class="text-center">RP</th>
              <th scope="col" class="text-center">F</th>
              <th scope="col" class="text-center">A</th>
              <th scope="col" class="text-center">Opciones</th>
            </tr>
          </thead>
          <tbody>
              @foreach($waitingRequestForms as $requestForm)
                    <tr>
                      <td>{{ $requestForm->id }}</td>
                      <td>{{ $requestForm->created_at->format('d-m-Y H:i') }}</td>
                      <td>{{ $requestForm->name }}</td>
                      <td>{{ $requestForm->creator ? $requestForm->creator->FullName : 'Usuario eliminado' }}<br>
                          {{ $requestForm->creator ? $requestForm->organizationalUnit->name : 'Usuario eliminado' }}
                      </td>
                      <td>{{ $requestForm->purchaseMechanism->name }}</td>
                      <td>{{ $requestForm->quantityOfItems() }}</td>
                      <td>{{ $requestForm->getElapsedTime() }}</td>
                        <td class="align-middle text-center">{!! $requestForm->eventSign('leader_ship_event') !!}</td>
                        <td class="align-middle text-center">{!! $requestForm->eventSign('pre_finance_event') !!}</td>
                        <td class="align-middle text-center">{!! $requestForm->eventSign('finance_event') !!}</td>
                        <td class="align-middle text-center">{!! $requestForm->eventSign('supply_event') !!}</td>
                        <td class="text-center align-middle">
                          <a href="{{ route('request_forms.prefinance_sign', $requestForm->id) }}" class="text-primary" title="Aceptar o Rechazar">
                          <i class="fas fa-signature"></i></a>
                        </td>
                    </tr>
              @endforeach
          </tbody>
        </table>
    </div>
</div>

<br>

<div class="col">
    <div class="table-responsive">
        <h6><i class="fas fa-inbox"></i> Formularios con Refrendación Presupuestaria</h6>
        <table class="table table-sm table-striped table-bordered small">
          <thead class="text-center">
              <tr>
                  <th>ID</th>
                  <th style="width: 7%">Fecha Creación</th>
                  <th>Descripción</th>
                  <th>Usuario Gestor</th>
                  <th>Mecanismo de Compra</th>
                  <th>Items</th>
                  <th>Espera</th>
                  <!-- <th scope="col">Última Actualziación</th> -->
                  <th scope="col" class="text-center">J</th>
                  <th scope="col" class="text-center">RP</th>
                  <th scope="col" class="text-center">F</th>
                  <th scope="col" class="text-center">A</th>
              </tr>
          </thead>
          <tbody>
              @foreach($approvedRequestForms as $requestForm)
                    <tr>
                        <td>{{ $requestForm->id }}</td>
                        <td>{{ $requestForm->created_at->format('d-m-Y H:i') }}</td>
                        <td>{{ $requestForm->name }}</td>
                        <td>{{ $requestForm->creator ? $requestForm->creator->FullName : 'Usuario eliminado' }}<br>
                            {{ $requestForm->creator ? $requestForm->organizationalUnit->name : 'Usuario eliminado' }}
                        </td>
                        <td>{{ $requestForm->purchaseMechanism->name }}</td>
                        <td align="center">{{ $requestForm->quantityOfItems() }}</td>
                        <td align="center">{{ $requestForm->getElapsedTime() }}</td>
                        <!-- <td class="align-middle">{{ $requestForm->updated_at }}</td> -->
                        <td class="align-middle text-center">{!! $requestForm->eventSign('leader_ship_event') !!}</td>
                        <td class="align-middle text-center">{!! $requestForm->eventSign('pre_finance_event') !!}</td>
                        <td class="align-middle text-center">{!! $requestForm->eventSign('finance_event') !!}</td>
                        <td class="align-middle text-center">{!! $requestForm->eventSign('supply_event') !!}</td>
                    </tr>
              @endforeach
          </tbody>
        </table>
    </div>
</div>

<br>

<div class="col">
    <div class="table-responsive">
        <h6><i class="fas fa-inbox"></i> Formularios en Finalizados o Rechazados</h6>
        <table class="table table-sm table-striped table-bordered small">
          <thead class="text-center">
            <tr>
              <th scope="col">Id</th>
              <th scope="col">Usuario Gestor</th>
              <th scope="col">Justificación</th>
              <th scope="col">Creación</th>
              <th scope="col">Rechazo</th>
              <th scope="col">Rechazado por</th>
              <th scope="col">Comentario</th>
              <th scope="col" class="text-center">J</th>
              <th scope="col" class="text-center">RP</th>
              <th scope="col" class="text-center">F</th>
              <th scope="col" class="text-center">A</th>
            </tr>
          </thead>
          <tbody>
              @foreach($rejectedRequestForms as $requestForm)
                    <tr>
                        <th class="align-middle" scope="row">{{ $requestForm->id }}</td>
                        <td class="align-middle">{{ $requestForm->creator ? $requestForm->creator->tinnyName() : 'Usuario eliminado' }}</td>
                        <td class="align-middle">{{ $requestForm->justification }}</td>
                        <td class="align-middle">{{ $requestForm->createdDate() }}</td>
                        <td class="align-middle">{{ $requestForm->rejectedTime() }}</td>
                        <td class="align-middle">{{ $requestForm->rejectedName() }}</td>
                        <td class="align-middle">{{ $requestForm->rejectedComment() }}</td>
                        <td class="align-middle text-center">{!! $requestForm->eventSign('leader_ship_event') !!}</td>
                        <td class="align-middle text-center">{!! $requestForm->eventSign('pre_finance_event') !!}</td>
                        <td class="align-middle text-center">{!! $requestForm->eventSign('finance_event') !!}</td>
                        <td class="align-middle text-center">{!! $requestForm->eventSign('supply_event') !!}</td>
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

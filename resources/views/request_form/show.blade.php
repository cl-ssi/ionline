@extends('layouts.app')
@section('title', 'Formulario de requerimiento')
@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<h4 class="mb-3">Formulario de Requerimiento - Visualizador</h4>

@include('request_form.nav')

        <div class="card mx-0">
          <h6 class="card-header text-primary"><i class="fas fa-file-signature"></i> Formulario de Requerimiento</h6>
          <div class="card-body mx-4 px-0">

            <div class="container-fluid row mx-0 mb-3 mt-3 pt-0"> <!-- DIV para TABLA-->

              <table class="table table-condensed table-sm small">

                <tr class="d-flex">
                    <th class="text-muted col-3" scope="row">ID</th>
                    <td class="col-3 font-weight-bold">{{ $requestForm->id}}</td>
                    <th class="text-muted col-3" scope="row">Estado</th>
                    <td class="col-3">{!! $requestForm->getStatus() !!}</td>
                </tr>

                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">Nombre del Solicitante</th>
                      <td class="col-3">{{ $requestForm->creator->tinnyName()}}</td>
                      <th class="text-muted col-3" scope="row">Unidad Organizacional</th>
                      <td class="col-3">{{ $requestForm->organizationalUnit->getInitialsAttribute() }}</td>
                  </tr>

                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">Gasto Estimado</th>
                      <td class="col-3">{{ $requestForm->estimatedExpense() }}</td>
                      <th class="text-muted col-3" scope="row">Fecha de Creación</th>
                      <td class="col-3">{{ $requestForm->createdDate() }}</td>
                  </tr>

                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">Archivos</th>
                      <td class="col-3">FILE01 - FILE02 - FILE03 - FILE04</td>
                      <th class="text-muted col-3" scope="row">Tiempo transcurrido</th>
                      <td class="col-3">{{ $requestForm->getElapsedTime() }}</td>
                  </tr>

                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">Programa Asociado</th>
                      <td class="col-3">{{ $requestForm->program }}</td>
                      <th class="text-muted col-3" scope="row">Mecanismo de Compra</th>
                      <td class="col-3">{{ $requestForm->getPurchaseMechanism()}}</td>
                  </tr>

                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">Justificación de Adquisición</th>
                      <td class="col-3">{{ $requestForm->justification }}</td>
                      <th class="text-muted col-3" scope="row">Folio Requerimiento SIGFE</th>
                      <td class="col-3">{{ $requestForm->sigfe }}</td>
                  </tr>

                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">Tipo de Compra</th>
                      <td class="col-3">{{ $requestForm->purchaseType ? $requestForm->purchaseType->getName() : ' ' }}</td>
                      <th class="text-muted col-3" scope="row">Unidad de Compra</th>
                      <td class="col-3">{{ $requestForm->purchaseUnit ? $requestForm->purchaseUnit->getName() : ' ' }}</td>
                  </tr>

                  @if($requestForm->eventSingStatus('leader_ship_event')=='approved')
                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">{!!$requestForm->eventSign('leader_ship_event')!!}Aprobación Jefatura</th>
                      <td class="col-3">{{ $requestForm->eventSignatureDate('leader_ship_event', 'approved') }}</td>
                      <th class="text-muted col-3" scope="row">Visador Jefatura</th>
                      <td class="col-3">{{ $requestForm->eventSignerName('leader_ship_event', 'approved') }}</td>
                  </tr>
                  @endif

                  @if($requestForm->eventSingStatus('pre_finance_event')=='approved')
                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">{!!$requestForm->eventSign('pre_finance_event')!!}Aprobación Refrendación Pres.</th>
                      <td class="col-3">{{ $requestForm->eventSignatureDate('pre_finance_event', 'approved') }}</td>
                      <th class="text-muted col-3" scope="row">Visador Refrendación Pres.</th>
                      <td class="col-3">{{ $requestForm->eventSignerName('pre_finance_event', 'approved') }}</td>
                  </tr>
                  @endif

                  @if($requestForm->eventSingStatus('finance_event')=='approved')
                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">{!!$requestForm->eventSign('finance_event')!!}Aprobación Finanzas</th>
                      <td class="col-3">{{ $requestForm->eventSignatureDate('finance_event', 'approved') }}</td>
                      <th class="text-muted col-3" scope="row">Visador Finanzas</th>
                      <td class="col-3">{{ $requestForm->eventSignerName('finance_event', 'approved') }}</td>
                  </tr>
                  @endif

                  @if($requestForm->eventSingStatus('supply_event')=='approved')
                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">{!!$requestForm->eventSign('supply_event')!!}Aprobación Abastecimiento</th>
                      <td class="col-3">{{ $requestForm->eventSignatureDate('supply_event', 'approved') }}</td>
                      <th class="text-muted col-3" scope="row">Visador Abastecimiento</th>
                      <td class="col-3">{{ $requestForm->eventSignerName('supply_event', 'approved') }}</td>
                  </tr>
                  @endif


                  @if($requestForm->eventSingStatus('leader_ship_event')=='rejected')
                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">{!!$requestForm->eventSign('leader_ship_event')!!}Rechazado por Jefatura</th>
                      <td class="col-3">{{ $requestForm->eventSignatureDate('leader_ship_event', 'rejected') }}</td>
                      <th class="text-muted col-3" scope="row">Visador Jefatura</th>
                      <td class="col-3">{{ $requestForm->eventSignerName('leader_ship_event', 'rejected') }}</td>
                  </tr>
                  @endif

                  @if($requestForm->eventSingStatus('pre_finance_event')=='rejected')
                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">{!!$requestForm->eventSign('pre_finance_event')!!}Rechazado por Refrendación Pres.</th>
                      <td class="col-3">{{ $requestForm->eventSignatureDate('pre_finance_event', 'rejected') }}</td>
                      <th class="text-muted col-3" scope="row">Visador Refrendación Pres.</th>
                      <td class="col-3">{{ $requestForm->eventSignerName('pre_finance_event', 'rejected') }}</td>
                  </tr>
                  @endif

                  @if($requestForm->eventSingStatus('finance_event')=='rejected')
                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">{!!$requestForm->eventSign('finance_event')!!}Rechazado por Finanzas</th>
                      <td class="col-3">{{ $requestForm->eventSignatureDate('finance_event', 'rejected') }}</td>
                      <th class="text-muted col-3" scope="row">Visador Finanzas</th>
                      <td class="col-3">{{ $requestForm->eventSignerName('finance_event', 'rejected') }}</td>
                  </tr>
                  @endif

                  @if($requestForm->eventSingStatus('supply_event')=='rejected')
                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">{!!$requestForm->eventSign('supply_event')!!}Rechazado por Abastecimiento</th>
                      <td class="col-3">{{ $requestForm->eventSignatureDate('supply_event', 'rejected') }}</td>
                      <th class="text-muted col-3" scope="row">Visador Abastecimiento</th>
                      <td class="col-3">{{ $requestForm->eventSignerName('supply_event', 'rejected') }}</td>
                  </tr>
                  @endif


                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row"></th>
                      <td class="col-3"></td>
                      <th class="text-muted col-3" scope="row"></th>
                      <td class="col-3"></td>
                  </tr>
              </table>
            </div><!-- div para TABLA -->

            <div class="row mx-3 mb-3 mt-3 pt-0"> <!-- DIV para TABLA-->
              <h6 class="card-subtitle mt-0 mb-2 text-primary">Lista de Bienes y/o Servicios:</h6>
              <table class="table table-condensed table-hover table-bordered table-sm small">
                <thead>
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
                              <td>{{ $key+1 }}</td>
                              <td>{{ $item->id }}</td>
                              <td>{{ $item->budgetItem ? $item->budgetItem()->first()->fullName() : ' -- ' }}</td>
                              <td>{{ $item->article }}</td>
                              <td>{{ $item->unit_of_measurement }}</td>
                              <td>{{ $item->specification }}</td>
                              <td>FILE</td>
                              <td align='right'>{{ $item->quantity }}</td>
                              <td align='right'>{{ $item->unit_value }}</td>
                              <td>{{ $item->tax }}</td>
                              <td align='right'>{{ $item->formatExpense() }}</td>
                          </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="7" rowspan="2"></td>
                    <td colspan="2" align='right'>Cantidad de Items</td>
                    <td colspan="2" align='right'>{{count($requestForm->itemRequestForms)}}</td>
                  </tr>
                  <tr>
                    <td colspan="2" align='right'>Valor Total</td>
                    <td colspan="2" align='right'>{{$requestForm->estimatedExpense()}}</td>
                  </tr>
                </tfoot>
              </table>
            </div><!-- DIV para TABLA-->



          </div><!-- card-body -->
        </div><!-- card-principal -->



        <!-- Button trigger modal -->
        <button type="button" class="btn btn-link" data-toggle="modal" data-target="#exampleModalCenter">
          <i class="far fa-trash-alt"></i>
        </button>

        <a class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" href="http://127.0.0.1:8000/request_forms/28/edit" role="button">Editar</a>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                ...Hola mundo
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>



@endsection
@section('custom_js')
@endsection
@section('custom_js_head')
@endsection

@extends('layouts.app')

@section('title', 'Formulario de requerimiento')

@section('content')

@include('request_form.partials.nav')

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
                        <td>{{ $requestForm->user ? $requestForm->user->FullName : 'Usuario eliminado' }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Unidad Organizacional</th>
                        <td>{{ $requestForm->user ? $requestForm->userOrganizationalUnit->name : 'Usuario eliminado' }}</td>
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
                        <th class="table-active" scope="row">Tipo de Compra</th>
                        <td>{{ $requestForm->purchaseType->name }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Unidad de Compra</th>
                        <td>{{ $requestForm->purchaseUnit->name  }}</td>
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

        <div class="card mx-0">
          <h6 class="card-header text-primary"><i class="fas fa-file-signature"></i> Formulario de Requerimiento</h6>
          <div class="card-body mx-4 px-0">

            <div class="container-fluid row mx-0 mb-3 mt-3 pt-0"> <!-- DIV para TABLA-->

              <table class="table table-condensed table-hover table-sm small">

                <tr class="d-flex">
                    <th class="text-muted col-3" scope="row">ID</th>
                    <td class="col-3 font-weight-bold">{{ $requestForm->id}}</td>
                    <th class="text-muted col-3" scope="row">Estado</th>
                    <td class="col-3">{!! $requestForm->getStatus() !!}</td>
                </tr>

                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">Nombre del Solicitante</th>
                      <td class="col-3">{{ $requestForm->user->tinnyName()}}</td>
                      <th class="text-muted col-3" scope="row">Unidad Organizacional</th>
                      <td class="col-3">{{ $requestForm->userorganizationalUnit->getInitialsAttribute() }}</td>
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
                      <th class="text-muted col-3" scope="row">{!!$requestForm->eventSign('leader_ship_event')!!} Aprobación Jefatura</th>
                      <td class="col-3">{{ $requestForm->eventSignatureDate('leader_ship_event', 'approved') }}</td>
                      <th class="text-muted col-3" scope="row">Visador Jefatura</th>
                      <td class="col-3">{{ $requestForm->eventSignerName('leader_ship_event', 'approved') }}</td>
                  </tr>
                  @endif

                  @if($requestForm->eventSingStatus('pre_finance_event')=='approved')
                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">{!!$requestForm->eventSign('pre_finance_event')!!} Aprobación Refrendación Pres.</th>
                      <td class="col-3">{{ $requestForm->eventSignatureDate('pre_finance_event', 'approved') }}</td>
                      <th class="text-muted col-3" scope="row">Visador Refrendación Pres.</th>
                      <td class="col-3">{{ $requestForm->eventSignerName('pre_finance_event', 'approved') }}</td>
                  </tr>
                  @endif

                  @if($requestForm->eventSingStatus('finance_event')=='approved')
                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">{!!$requestForm->eventSign('finance_event')!!} Aprobación Finanzas</th>
                      <td class="col-3">{{ $requestForm->eventSignatureDate('finance_event', 'approved') }}</td>
                      <th class="text-muted col-3" scope="row">Visador Finanzas</th>
                      <td class="col-3">{{ $requestForm->eventSignerName('finance_event', 'approved') }}</td>
                  </tr>
                  @endif

                  @if($requestForm->eventSingStatus('supply_event')=='approved')
                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">{!!$requestForm->eventSign('supply_event')!!} Aprobación Abastecimiento</th>
                      <td class="col-3">{{ $requestForm->eventSignatureDate('supply_event', 'approved') }}</td>
                      <th class="text-muted col-3" scope="row">Visador Abastecimiento</th>
                      <td class="col-3">{{ $requestForm->eventSignerName('supply_event', 'approved') }}</td>
                  </tr>
                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">Comprador Asignado</th>
                      <td class="col-9 font-weight-bold text-primary">{{ $requestForm->supervisor->fullName ?? '' }}</td>
                  </tr>
                  @endif

                  @if($requestForm->eventSingStatus('leader_ship_event')=='rejected')
                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">{!!$requestForm->eventSign('leader_ship_event')!!} Rechazado por Jefatura</th>
                      <td class="col-3">{{ $requestForm->eventSignatureDate('leader_ship_event', 'rejected') }}</td>
                      <th class="text-muted col-3" scope="row">Visador Jefatura</th>
                      <td class="col-3">{{ $requestForm->eventSignerName('leader_ship_event', 'rejected') }}</td>
                  </tr>
                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">Comentario</th>
                      <td class="col-9">{{ $requestForm->rejectedComment() }}</td>
                  </tr>
                  @endif

                  @if($requestForm->eventSingStatus('pre_finance_event')=='rejected')
                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">{!!$requestForm->eventSign('pre_finance_event')!!} Rechazado por Refrendación Pres.</th>
                      <td class="col-3">{{ $requestForm->eventSignatureDate('pre_finance_event', 'rejected') }}</td>
                      <th class="text-muted col-3" scope="row">Visador Refrendación Pres.</th>
                      <td class="col-3">{{ $requestForm->eventSignerName('pre_finance_event', 'rejected') }}</td>
                  </tr>
                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">Comentario</th>
                      <td class="col-9">{{ $requestForm->rejectedComment() }}</td>
                  </tr>
                  @endif

                  @if($requestForm->eventSingStatus('finance_event')=='rejected')
                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">{!!$requestForm->eventSign('finance_event')!!} Rechazado por Finanzas</th>
                      <td class="col-3">{{ $requestForm->eventSignatureDate('finance_event', 'rejected') }}</td>
                      <th class="text-muted col-3" scope="row">Visador Finanzas</th>
                      <td class="col-3">{{ $requestForm->eventSignerName('finance_event', 'rejected') }}</td>
                  </tr>
                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">Comentario</th>
                      <td class="col-9">{{ $requestForm->rejectedComment() }}</td>
                  </tr>
                  @endif

                  @if($requestForm->eventSingStatus('supply_event')=='rejected')
                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">{!!$requestForm->eventSign('supply_event')!!} Rechazado por Abastecimiento</th>
                      <td class="col-3">{{ $requestForm->eventSignatureDate('supply_event', 'rejected') }}</td>
                      <th class="text-muted col-3" scope="row">Visador Abastecimiento</th>
                      <td class="col-3">{{ $requestForm->eventSignerName('supply_event', 'rejected') }}</td>
                  </tr>
                  <tr class="d-flex">
                      <th class="text-muted col-3" scope="row">Comentario</th>
                      <td class="col-9">{{ $requestForm->rejectedComment() }}</td>
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

@endsection
@section('custom_js')
@endsection
@section('custom_js_head')
@endsection

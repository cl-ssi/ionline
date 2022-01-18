@extends('layouts.app')

@section('title', 'Formulario de requerimiento')

@section('content')

@include('request_form.partials.nav')

<div class="row">
    <div class="col-sm-8">
        <div class="table-responsive">
            <h6><i class="fas fa-info-circle"></i> Detalle Formulario</h6>
            <table class="table table-sm table-striped table-bordered">                
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
                        <td>{{ $requestForm->purchaseType->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <th class="table-active" scope="row">Unidad de Compra</th>
                        <td>{{ $requestForm->purchaseUnit->name ?? '' }}</td>
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


    <div class="table-responsive">
    <h6><i class="fas fa-signature"></i> Proceso de Firmas</h6>
    <table class="table table-sm table-striped table-bordered">
        <tbody class="text-center small">
            <tr>
              @foreach($requestForm->eventRequestForms as $event)
                <th>{{ $event->signerOrganizationalUnit->name }}</th>
              @endforeach
            </tr>
            <tr>
              @foreach($requestForm->eventRequestForms as $event)
                <td>
                  @if($event->StatusValue == 'Pendiente')
                    <span>
                      <i class="fas fa-clock"></i> {{ $event->StatusValue }} <br>
                    </span>
                  @endif
                  @if($event->StatusValue == 'Aprobado')
                    <span style="color: green;">
                      <i class="fas fa-check-circle"></i> {{ $event->StatusValue }} <br>
                    </span>
                    <i class="fas fa-user"></i> {{ $event->signerUser->FullName }}<br>
                    <i class="fas fa-calendar-alt"></i> {{ Carbon\Carbon::parse($event->signature_date)->format('d-m-Y H:i:s') }}<br>
                  @endif
                  @if($event->StatusValue == 'Rechazado')
                    <span style="color: Tomato;">
                      <i class="fas fa-times-circle"></i> {{ $event->StatusValue }} <br>
                    </span>
                    <i class="fas fa-user"></i> {{ $event->signerUser->FullName }}<br>
                    <i class="fas fa-calendar-alt"></i> {{ Carbon\Carbon::parse($event->signature_date)->format('d-m-Y H:i:s') }}<br>
                  @endif
                </td>
              @endforeach
            </tr>
        </tbody>
    </table>
</div>



    @if($requestForm->purchase_mechanism_id == 1 && $requestForm->purchase_type_id == 1)
    <form method="POST" class="form-horizontal" action="{{ route('request_forms.supply.create_petty_cash', $requestForm) }}" enctype="multipart/form-data">
        @endif
        @if($requestForm->purchase_mechanism_id == 1 && $requestForm->purchase_type_id == 2)
        <form method="POST" class="form-horizontal" action="{{ route('request_forms.supply.create_internal_oc', $requestForm) }}">
            @endif
            @if($requestForm->purchase_mechanism_id == 1 && $requestForm->purchase_type_id == 3)
            <form method="POST" class="form-horizontal" action="{{ route('request_forms.supply.create_fund_to_be_settled', $requestForm) }}">
                @endif
                @csrf
                @method('POST')

                <table class="table table-sm table-striped table-bordered small">
                    <thead class="text-center">
                        <tr>
                            <th>Item</th>
                            <th>Estado</th>
                            <th>Cod.Presup.</th>
                            <th>Artículo</th>
                            <th>UM</th>
                            <th>Especificaciones Técnicas</th>
                            <th>Archivo</th>
                            <th>Cantidad</th>
                            <th>Valor U.</th>
                            <th>Impuestos</th>
                            <th>Total Item</th>
                            <th colspan="2"></th>
                            <!-- <th></th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requestForm->itemRequestForms as $key => $item)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $item->status }}</td>
                            <td>{{ $item->budgetItem()->first()->fullName() }}</td>
                            <td>{{ $item->article }}</td>
                            <td>{{ $item->unit_of_measurement }}</td>
                            <td>{{ $item->specification }}</td>
                            <td align="center">
                                @if($item->article_file)
                                <a href="{{ route('request_forms.show_item_file', $item) }}" target="_blank">
                                    <i class="fas fa-file"></i></a>
                                @endif
                            </td>
                            <td align="right">
                                <input type="number" class="form-control form-control-sm text-right" step="0.01" min="0.1" id="for_quantity" name="quantity[]" value="{{ $item->quantity }}">
                            </td>
                            <td align="right">
                                <input type="number" class="form-control form-control-sm text-right" step="0.01" min="1" id="for_unit_value" name="unit_value[]" value="{{ $item->unit_value }}">
                            </td>
                            <td align="right">
                                <input type="text" class="form-control form-control-sm text-right" id="for_tax" name="tax[]" value="{{ $item->tax }}" readonly>
                            </td>
                            <td align="right">
                                <input type="number" class="form-control form-control-sm text-right" step="0.01" min="1" id="for_item_total" name="item_total[]" value="{{ $item->expense }}" readonly>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="9"></td>
                            <td class="text-right">Valor Total</td>
                            <td align="right">
                                <input type="number" step="0.01" min="1" class="form-control form-control-sm text-right" id="total_amount" value="{{$requestForm->estimated_expense}}" name="total_amount" readonly>
                            </td>
                        </tr>
                    </tfoot>
                </table>





</div><!-- DIV para TABLA-->



</div> -->

<!-- card-body -->
</div>
<!-- card-principal -->

@endsection
@section('custom_js')
@endsection
@section('custom_js_head')
@endsection
@extends('layouts.app')
@section('title', 'Formulario de requerimiento')
@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<h4 class="mb-3">Compra</h4>

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

<br>

<div class="row">
    <div class="col-sm">
        <div class="table-responsive">
            <h6><i class="fas fa-shopping-cart"></i> Lista de Bienes y/o Servicios:</h6>
            <table class="table table-sm table-striped table-bordered small">
                <thead class="text-center">
                    <tr>
                        <th>Item</th>
                        <!-- <th>ID</th> -->
                        <th>Cod.Presup.</th>
                        <th>Artículo</th>
                        <th>UM</th>
                        <th>Especificaciones Técnicas</th>
                        <th>Archivo</th>
                        <th>Cantidad</th>
                        <th>Valor U.</th>
                        <th>Impuestos</th>
                        <th>Total Item</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requestForm->itemRequestForms as $key => $item)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <!-- <td>{{$item->id}}</td> -->
                        <td>{{ $item->budgetItem()->first()->fullName() }}</td>
                        <td>{{ $item->article }}</td>
                        <td>{{ $item->unit_of_measurement }}</td>
                        <td>{{ $item->specification }}</td>
                        <td align="center">
                            <a href="{{ route('request_forms.show_item_file', $item) }}" target="_blank">
                              <i class="fas fa-file"></i>
                        </td>
                        <td align="right">{{ $item->quantity }}</td>
                        <td align="right">${{ number_format($item->unit_value,0,",",".") }}</td>
                        <td>{{ $item->tax }}</td>
                        <td align="right">${{ number_format($item->expense,0,",",".") }}</td>
                        <td align="center">
                            <fieldset class="form-group">
                              <div class="form-check">
                                  <input class="form-check-input" type="checkbox" name="item_id[]" onclick="myFunction()" id="for_applicant_id"
                                    value="{{ $item->id }}">
                              </div>
                            </fieldset>
                        </td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                    <tr>
                      <td colspan="8"></td>
                      <th class="text-right">Valor Total</td>
                      <th class="text-right">${{ number_format($requestForm->estimated_expense,0,",",".") }}</td>
                    </tr>

                </tfoot>
            </table>
        </div>
    </div>
</div>

<br>

@if($requestForm->purchase_mechanism_id == 1 && $requestForm->purchase_type_id == 2)

<div class="card">
    <div class="card-header">
        Orden de Compra Interna
    </div>
    <div class="card-body">
      <div class="form-row">
          <!-- <fieldset class="form-group col-3">
              <label for="for_name">Nombres</label>
              <input type="text" class="form-control" name="name" id="for_name" value="{{-- $userexternal->name --}}" readonly>
          </fieldset> -->

          <fieldset class="form-group col-sm-3">
              <label for="for_date">Fecha Nacimiento</label>
              <input type="date" class="form-control" id="for_date" name="date" value="{{ Carbon\Carbon::now() }}" required>
          </fieldset>

          <fieldset class="form-group col-3">
              <label for="for_gender" >Género</label>
              <select name="gender" id="for_gender" class="form-control" required>
                  <option value="">Seleccione...</option>
                  <option value="1">Proveedor 1</option>
                  <option value="2">Proveedor 2</option>
                  <option value="3">Proveedor 3</option>
                  <option value="4">Proveedor 4</option>
              </select>
          </fieldset>
      </div>

    </div>
</div>

@endif


@endsection

@section('custom_js')

@endsection

@section('custom_js_head')

@endsection

@extends('layouts.app')
@section('title', 'Formulario de requerimiento')
@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<h4 class="mb-3">Formularios de Requerimiento - Bandeja de Entrada</h4>

@include('request_form.partials.nav')

@if(count($my_forms_signed) > 0 || count($approved_forms_pending_to_sign) || count($my_pending_forms_to_signs) > 0 || count($new_budget_pending_to_sign) > 0)

    <fieldset class="form-group">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
            </div>
            <input type="text" class="form-control" id="forsearch" onkeyup="filter(1)" placeholder="Buscar un número de formulario" name="search" required="">
            <div class="input-group-append">
                <a class="btn btn-primary" href="{{ route('request_forms.create') }}"><i class="fas fa-plus"></i> Nuevo Formulario</a>
            </div>
        </div>
    </fieldset>

    @if(count($my_pending_forms_to_signs) > 0)
    </div>
        <div class="col">
            <h6><i class="fas fa-inbox"></i> Formularios pendientes de firma</h6>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered">
                  <thead class="small">
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
                  <tbody class="small">
                      @foreach($my_pending_forms_to_signs as $requestForm)
                            <tr>
                                <td>{{ $requestForm->id }}
                                    @switch($requestForm->getStatus())
                                        @case('Pendiente')
                                            <i class="fas fa-clock"></i>
                                            @break

                                        {{--@case('complete')
                                            <span style="color: green;">
                                              <i class="fas fa-check-circle"></i>
                                            </span>
                                            @break --}}

                                    @endswitch
                                </td>
                                <td>{{ $requestForm->created_at->format('d-m-Y H:i') }}</td>
                                <td>{{ $requestForm->type_form }}</td>
                                <td>{{ $requestForm->name }}</td>
                                <td>{{ $requestForm->user->FullName }}<br>
                                    {{ $requestForm->userOrganizationalUnit->name }}
                                </td>
                                <td>{{ $requestForm->purchaseMechanism->name }}</td>
                                <td align="center">{{ $requestForm->quantityOfItems() }}</td>
                                <td align="center">{{ $requestForm->created_at->diffForHumans() }}</td>
                                <td class="text-center">
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
                                <a href="{{ route('request_forms.sign', [$requestForm, $event_type]) }}" class="btn btn-outline-primary btn-sm" title="Aceptar o Rechazar">
                                  <i class="fas fa-signature"></i>
                                </a>
                              </td>
                            </tr>
                      @endforeach
                  </tbody>
                </table>
            </div>
        </div>
    @else
        </div>
        <div class="col">
            <h6><i class="fas fa-inbox"></i> Formularios pendientes de firma</h6>
            <div class="card mb-3 bg-light">
              <div class="card-body">
                No hay formularios de requerimiento pendientes de firma.
              </div>
            </div>
        </div>
    @endif

    @if($event_type == 'finance_event')

    @if(count($approved_forms_pending_to_sign) > 0)
    </div>
        <div class="col">
            <h6><i class="fas fa-inbox"></i> Formularios aprobados pendiente de firma digital</h6>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered">
                  <thead class="small">
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
                  <tbody class="small">
                      @foreach($approved_forms_pending_to_sign as $requestForm)
                            <tr>
                                <td>{{ $requestForm->id }}</td>
                                <td>{{ $requestForm->created_at->format('d-m-Y H:i') }}</td>
                                <td>{{ $requestForm->type_form }}</td>
                                <td>{{ $requestForm->name }}</td>
                                <td>{{ $requestForm->user->FullName }}<br>
                                    {{ $requestForm->userOrganizationalUnit->name }}
                                </td>
                                <td>{{ $requestForm->purchaseMechanism->name }}</td>
                                <td align="center">{{ $requestForm->quantityOfItems() }}</td>
                                <td align="center">{{ $requestForm->created_at->diffForHumans() }}</td>
                                <td class="text-center">
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
                                    {{--modal firmador--}}
                                    @php $idModelModal = $requestForm->id;
                                				$routePdfSignModal = "/request_forms/create_form_document/$idModelModal/";
                                				$routeCallbackSignModal = 'request_forms.callbackSign';
                                    @endphp

                                    @include('documents.signatures.partials.sign_file')

                                    <button type="button" data-toggle="modal" class="btn btn-outline-info btn-sm"
                                        title="Firmar Certificado de Disponibilidad Presupuestaria"
                                        data-target="#signPdfModal{{$idModelModal}}" title="Firmar">
                                          Firmar Form. <i class="fas fa-signature"></i>
                                    </button>
                              </td>
                            </tr>
                      @endforeach
                  </tbody>
                </table>
            </div>
        </div>
    @else
        </div>
        <div class="col">
            <h6><i class="fas fa-inbox"></i> Formularios aprobados pendiente de firma digital</h6>
            <div class="card mb-3 bg-light">
              <div class="card-body">
                No hay formularios de requerimiento aprobados pendientes de firma digital.
              </div>
            </div>
        </div>
    @endif                                      

    @if(count($new_budget_pending_to_sign) > 0)
    </div>
        <div class="col">
            <h6><i class="fas fa-inbox"></i> Formularios con nuevo presupuesto pendiente de firma</h6>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-bordered">
                  <thead class="small">
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
                  <tbody class="small">
                      @foreach($new_budget_pending_to_sign as $requestForm)
                            <tr>
                                <td>{{ $requestForm->id }}</td>
                                <td>{{ $requestForm->created_at->format('d-m-Y H:i') }}</td>
                                <td>{{ $requestForm->type_form }}</td>
                                <td>{{ $requestForm->name }}</td>
                                <td>{{ $requestForm->user->FullName }}<br>
                                    {{ $requestForm->userOrganizationalUnit->name }}
                                </td>
                                <td>{{ $requestForm->purchaseMechanism->name }}</td>
                                <td align="center">{{ $requestForm->quantityOfItems() }}</td>
                                <td align="center">{{ $requestForm->created_at->diffForHumans() }}</td>
                                <td class="text-center">
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
                                <a href="{{ route('request_forms.sign', [$requestForm, 'budget_event']) }}" class="btn btn-outline-primary btn-sm" title="Aceptar o Rechazar">
                                  <i class="fas fa-signature"></i>
                                </a>
                              </td>
                            </tr>
                      @endforeach
                  </tbody>
                </table>
            </div>
        </div>
    @else
        </div>
        <div class="col">
            <h6><i class="fas fa-inbox"></i> Formularios con nuevo presupuesto pendiente de firma</h6>
            <div class="card mb-3 bg-light">
              <div class="card-body">
                No hay formularios de requerimiento con nuevo presupuesto pendientes de firma.
              </div>
            </div>
        </div>
    @endif


    @endif

    @if(count($my_forms_signed) > 0)
    </div>
        <div class="col">
            <h6><i class="fas fa-archive"></i> Formularios aprobados, cerrados o rechazados</h6>
            <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered">
              <thead class="small">
                <tr>
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
              <tbody class="small">
                  @foreach($my_forms_signed as $requestForm)
                        <tr>
                            <th>{{ $requestForm->id }} <br>
                                @switch($requestForm->getStatus())
                                    @case('Pendiente')
                                        <i class="fas fa-clock"></i>
                                        @break

                                    @case('Aprobado')
                                        <span style="color: green;">
                                          <i class="fas fa-check-circle" title="{{ $requestForm->getStatus() }}"></i>
                                        </span>
                                        @break

                                    @case('Rechazado')
                                        <a href="">
                                            <span style="color: Tomato;">
                                                <i class="fas fa-times-circle" title="{{ $requestForm->getStatus() }}"></i>
                                            </span>
                                        </a>
                                        @break

                                @endswitch
                            </th>
                            <td>{{ $requestForm->created_at->format('d-m-Y H:i') }}</td>
                            <td>{{ $requestForm->type_form }}</td>
                            <td>{{ $requestForm->name }}</td>
                            <td>{{ $requestForm->user ? $requestForm->user->FullName : 'Usuario eliminado' }}<br>
                                {{ $requestForm->userOrganizationalUnit ? $requestForm->userOrganizationalUnit->name : 'Usuario eliminado' }}
                            </td>
                            <td>{{ $requestForm->purchaseMechanism->name }}</td>
                            <td align="center">{{ $requestForm->quantityOfItems() }}</td>
                            <td align="center">{{ $requestForm->created_at->diffForHumans() }}</td>
                            <td class="text-center">
                                @foreach($requestForm->eventRequestForms as $sign)
                                    @if($sign->status == 'pending' || $sign->status == NULL)
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
                                <a href="{{ route('request_forms.show', $requestForm->id) }}"
                                    class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-eye"></i></a>

                                @if($requestForm->signatures_file_id)
                                    <a class="btn btn-info btn-sm"
                                        title="Ver Formulario de Requerimiento firmado"
                                        href="{{ route('request_forms.signedRequestFormPDF', $requestForm) }}"
                                        target="_blank" title="Certificado">
                                          <i class="fas fa-file-contract"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>
    @else
        </div>
        <div class="col">
            <h6><i class="fas fa-inbox"></i> Formularios firmados o rechazados</h6>
            <div class="card mb-3 bg-light">
                <div class="card-body">
                  No hay formularios de requerimiento firmados o rechazados.
                </div>
            </div>
        </div>
    @endif

@else
        <div class="card">
          <div class="card-body">
            No hay formularios de requerimiento para mostrar.
          </div>
        </div>
@endif

<!-- Modal -->
<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger" id="exampleModalLongTitle"><i class="fas fa-exclamation-triangle"></i> Eliminar Registro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <p>Estás por eliminar un Formulario, este proceso es irreversible.</p>
        <p>Quieres continuar?</p>
        <p class="debug-url"></p>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <a class="btn btn-danger btn-ok">Eliminar</a>
      </div>
    </div>
  </div>
</div>
<!-- Fin Modal -->

@endsection
@section('custom_js')
<script>
    $('#confirm').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));

        $('.debug-url').html('<strong>Eliminar Formulario de Requerimiento ID ' + $(e.relatedTarget).data('id') + '</strong>');
    });
</script>
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

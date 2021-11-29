@extends('layouts.app')
@section('title', 'Formulario de requerimiento')
@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<h4 class="mb-3">Formularios de Requerimiento - Bandeja de Entrada</h4>

@include('request_form.partials.nav')

@if(count($my_requests) > 0 || count($my_pending_requests) > 0)

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

    @if(count($my_pending_requests) > 0)
    </div>
        <div class="col">
            <h6><i class="fas fa-inbox"></i> Formularios pendientes de aprobación</h6>
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
                      @foreach($my_pending_requests as $requestForm)
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
                                <td align="center">{{ $requestForm->getElapsedTime() }}</td>
                                {{--<td class="align-middle text-center brd-b brd-l">{!! $requestForm->eventSign('leader_ship_event') !!}</td>
                                <td class="align-middle text-center brd-b">{!! $requestForm->eventSign('finance_event') !!}</td>
                                <td class="align-middle text-center brd-b">{!! $requestForm->eventSign('pre_finance_event') !!}</td>
                                <td class="align-middle text-center brd-b brd-r">{!! $requestForm->eventSign('supply_event') !!}</td>--}}
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
                                <!-- <td class="text-center align-middle brd-b">
                                  <a href="{{ route('request_forms.edit', $requestForm->id) }}"  class="text-primary" title="Editar">
                                  <i class="far fa-edit"></i></a>
                                </td>

                                <td class="text-center align-middle brd-b">
                                  <a href="{{ route('request_forms.show', $requestForm->id) }}" class="text-info" title="Visualizar">
                                  <i class="fas fa-binoculars"></i></a>
                                </td>

                                <td class="text-center align-middle brd-r brd-b">
                                  <a href="#" data-href="{{ route('request_forms.destroy', $requestForm->id) }}" data-id="{{ $requestForm->id }}" class="text-danger" title="Eliminar" data-toggle="modal" data-target="#confirm" role="button">
                                  <i class="far fa-trash-alt"></i></a>
                                </td> -->
                                <td>
                                @if($requestForm->eventRequestForms->first()->status == 'pending')
                                <a href="{{ route('request_forms.edit', $requestForm->id) }}"
                                    class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-edit"></i></a>
                                <a href="#" data-href="{{ route('request_forms.destroy', $requestForm->id) }}" data-id="{{ $requestForm->id }}" class="btn btn-outline-secondary btn-sm text-danger" title="Eliminar" data-toggle="modal" data-target="#confirm" role="button">
                                  <i class="fas fa-trash"></i></a>
                                @else
                                <a href="{{ route('request_forms.show', $requestForm->id) }}"
                                    class="btn btn-outline-secondary btn-sm" title="Selección"><i class="fas fa-eye"></i></a>
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
            <h6><i class="fas fa-inbox"></i> Formularios en Progreso</h6>
            <div class="card mb-3 bg-light">
              <div class="card-body">
                No hay formularios de requerimiento en progreso.
              </div>
            </div>
        </div>
    @endif

    @if(count($my_requests) > 0)
    </div>
        <div class="col">
            <h6><i class="fas fa-archive"></i> Formularios aprobados, cerrados o rechazados</h6>
            <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered">
              <thead class="small">
                <tr>
                  <th scope="col">Id</th>
                  <th scope="col">Usuario Gestor</th>
                  <th scope="col">Justificación</th>
                  <th scope="col">Creación</th>
                  <th scope="col">Rechazo</th>
                  <th scope="col">Usuario Rechazo</th>
                  <th scope="col">Comentario</th>
                  <th>Estado</th>
                </tr>
              </thead>
              <tbody class="small">
                  @foreach($my_requests as $requestForm)
                        <tr>
                            <th class="align-middle" scope="row">{{ $requestForm->id }}</td>
                            <td class="align-middle">{{ $requestForm->user ? $requestForm->user->tinnyName() : 'Usuario eliminado' }}</td>
                            <td class="align-middle">{{ $requestForm->justification }}</td>
                            <td class="align-middle">{{ $requestForm->createdDate() }}</td>
                            <td class="align-middle">{{ $requestForm->rejectedTime() }}</td>
                            <td class="align-middle">{{ $requestForm->rejectedName() }}</td>
                            <td class="align-middle">{{ $requestForm->rejectedComment() }}</td>
                            {{--<td class="align-middle text-center">{!! $requestForm->eventSign('leader_ship_event') !!}</td>
                            <td class="align-middle text-center">{!! $requestForm->eventSign('pre_finance_event') !!}</td>
                            <td class="align-middle text-center">{!! $requestForm->eventSign('finance_event') !!}</td>
                            <td class="align-middle text-center">{!! $requestForm->eventSign('supply_event') !!}</td>--}}
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
                        </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>
    @else
        </div>
        <div class="col">
            <h6><i class="fas fa-inbox"></i> Formularios aprobados, cerrados o rechazados</h6>
            <div class="card mb-3 bg-light">
                <div class="card-body">
                  No hay formularios de requerimiento aprobados, finalizados o rechazados.
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

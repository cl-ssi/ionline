@extends('layouts.app')

@section('title', 'Formulario')

@section('content')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('css/steps.css') }}" rel="stylesheet" type="text/css"/>

<h3 class="mb-3">Formulario de Requerimiento.</h3>

@include('request_form.nav')

<!-- <h5>Folio Depto. Abastecimiento: {{ $requestForm->FormRequestNumber }}</h5> -->

<table class="table table-sm table-bordered">
    <tr>
        <th colspan="6" class="table-active">Formulario Requerimiento N° {{ $requestForm->FormRequestNumber }}</th>
    </tr>
    <tr>
        <th>Gasto Estimado</th>
        <td colspan="5">${{ $requestForm->EstimatedExpenseFormat }}</td>
    </tr>
    <tr>
        <th>Nombre Administrador de Contrato</th>
        <td>{{ $requestForm->admin->FullName }}</td>
    </tr>
    <tr>
        <th>Programa Asociado</th>
        <td colspan="5">{{ $requestForm->program }}</td>
    </tr>
    <tr>
        <th>Justificación en Breve</th>
        <td colspan="5">{{ $requestForm->justification }}</td>
    </tr>
</table>

<!-- completed, completedLast, current, end -->
<div class="steps">
  <ul class="blue 5steps">
      <li class=""><em>Paso 1</em><span>Nueva solicitud</span></li>
      <li class=""><em>Paso 2</em><span>Aprob. solicitante</span></li>
      <li class=""><em>Paso 3</em><span>Aprob. Jefatura</span></li>
      <li class=""><em>Paso 4</em><span>Aprob. Finanzas</span></li>
      <li class=""><em>Paso 5</em><span>Aprob. Abastecimiento</span></li>
      <li class=""><em>Paso 6</em><span>Generación OC</span></li>
      <li class=""><em>Paso 6</em><span>Solicitud Cerrada</span></li>
      <li class=""><em>valor del Flag: </em><span>{{$flag_finance}}</span></li>
      <li class=""><em>Tipo Form Request: </em><span>{{$requestForm->type_form}}</span></li>
  </ul>
</div>
<!-- *********************************************************************** -->
<br>
<!-- ************************* FORMULARIO DE ARTICULOS ********************* -->
@if($requestForm->type_form === 'item')
    @foreach($requestForm->requestformevents as $key => $event)
        @if($event->type == 'message' && $event->status == 'create')
          @if($loop->last)
              @include('request_form.item.create', $requestForm)
              <br>
              <table class="table table-condensed table-hover table-bordered table-sm small" id="TableFilter">
                <thead>
                  <tr>
                    <th></td>
                    <th>Artículo</th>
                    <th>Cantidad</th>
                    <th>Especificaciones Técnicas</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($requestForm->items as $key => $item)
                      <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $item->item }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->specification }}</td>
                        <td>
                          @if($requestForm->StatusName === 'Nulo')
                          <form method="POST" action="{{ route('request_forms.items.destroy', $item) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar este artículo?');">
                    					<span class="fas fa-trash-alt" aria-hidden="true"></span>
                    				</button>
                          </form>
                          @else
                            <a href="" class="btn btn-outline-danger btn-sm disabled" title="Eliminar">
                              <i class="far fa-trash-alt"></i></a>
                          @endif
                        </td>
                      </tr>
                      @endforeach
                  </tbody>
                </table>
            @endif
        @endif
        @if($event->type == 'status' && ($event->status == 'new' ||  $event->status == 'approved_petitioner'  ||
              $event->status == 'approved_chief' || $event->status == 'approved_finance') ||
              $event->type == 'message' && $event->status == 'item_record' || $event->type == 'message' && $event->status == 'crp_record')
          @if($loop->last)
            <form method="POST" class="form-horizontal" action="{{ route('request_forms.add_item_form', $requestForm) }}">
            @csrf
            @method('PUT')
            <table class="table table-condensed table-hover table-bordered table-sm small" id="TableFilter">
              <thead>
                <tr>
                  <th></th>
                  <th style="display:none;"></th>
                  <th>Artículo</th>
                  <th>Cantidad</th>
                  <th>Especificaciones Técnicas</th>
                  <th>Item</th>
                </tr>
              </thead>
              <tbody>
                @foreach($requestForm->items as $key => $item)
                  <tr>
                    <td>{{ ++$key }}</td>
                    <th style="display:none;"><input type="text" class="form-control form-control-sm" id="forid" name="ids[]" value="{{ $item->id }}"></th>
                    <td>{{ $item->item }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->specification }}</td>
                    <td>
                      <select class="form-control form-control-sm selectpicker" id="forrequest_form_items_code_id" name="request_form_items_code_ids[]"
                        title="Seleccione..." data-live-search="true" data-size="5" @foreach($requestForm->requestformevents as $event) @if(($event->type == "message" && $event->status == "item_record")  || Auth::user()->cannot('Request Forms: Finance add item code')) disabled @endif @endforeach required>
                          @foreach($item_codes as $item_code)
                              <option value="{{ $item_code->id }}" data-max-options=""  @if($item_code->id === $item->request_form_item_codes_id && $item != null) selected="selected" @endif>{{ $item_code->item_code }} {{ $item_code->name }}</option>
                          @endforeach
                      </select>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>

            @if(Auth::user()->can('Request Forms: Finance add item code') && $flag_finance == 1)
                    <div class="form-row">
                    <div class="form-group col">
                        <button class="btn btn-primary btn-sm float-right mr-3" type="submit">
                            <i class="fas fa-save"></i> Enviar
                        </button>
                    </div>
                    </div>
            @elseif(Auth::user()->can('Request Forms: Finance add item code') && $flag_finance == 2)
                    <div class="form-row">
                    <div class="form-group col">
                        <button class="btn btn-primary btn-sm float-right mr-3" type="submit" disabled>
                            <i class="fas fa-save"></i> Enviar
                        </button>
                    </div>
                    </div>
            @endif
            </form>
          @endif
        @endif
    @endforeach
@endif
<!-- *********************************************************************** -->

<!-- ************************* FORMULARIO DE PASAJE ************************ -->
@if($requestForm->type_form === 'passage')
  @foreach($requestForm->requestformevents as $key => $event)
    @if($event->type == 'message' && $event->status == 'create')
      @if($loop->last)
        @include('request_form.passage.create', $requestForm)
      @endif
    @endif
    @if(($event->type == 'message' && $event->StatusName == 'Creado') ||
        ($event->type == 'status' && ($event->StatusName == 'Creado' || $event->StatusName == 'Nuevo' ||
                                      $event->StatusName == 'Aprobado por solicitante' || $event->StatusName == 'Aprobado por jefatura' ||
                                      $event->StatusName == 'Aprobado por finanzas')))
      @if($loop->last)
        <br>
        <table class="table table-condensed table-hover table-bordered table-sm small">
          <thead>
            <tr>
              <th></td>
              <th>Run</th>
              <th>Nombre</th>
              <th>Fecha-Hora Ida</th>
              <th>Fecha-Hora Vuelta</th>
              <th>Equipaje</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach($requestForm->passages as $key => $passage)
                <tr>
                  <td>{{ ++$key }}</td>
                  <td>{{ $passage->RunFormat }}</td>
                  <td>{{ $passage->FullName }}</td>
                  <td>{{ $passage->DepartureDateFormat }}</td>
                  <td>{{ $passage->FromDateFormat }}</td>
                  <td>{{ $passage->BaggageName }}</td>
                  <td>
                    @if($event->StatusName === 'Creado' )
                        <form method="POST" action="{{ route('request_forms.passages.destroy', $passage) }}" class="d-inline">
                						@csrf
                						@method('DELETE')
                						<button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar este artículo?');">
                							<span class="fas fa-trash-alt" aria-hidden="true"></span>
                						</button>
              					</form>
                    @else
                        <a href="" class="btn btn-outline-danger btn-sm disabled" title="Eliminar">
                        <i class="far fa-trash-alt"></i></a>
                    @endif
                  </td>
                </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    @endif
  @endforeach
@endif
<!-- *********************************************************************** -->

<!-- *************************** ARCHIVOS ADJUNTOS ************************* -->
@if($requestForm->StatusName != 'closed')
<div class="form-row">
    <div class="form-group col-6">
      @include('request_form.file.create', $requestForm)
    </div>
    <div class="form-group col-6">
      <div class="card mt-4 d-print-none">
          <div class="card-body scroll">
              @foreach($requestForm->requestformfiles as $key => $file)
                  <p class="card-text">
                      <a href="{{ route('tickets.download', $file->id) }}"><i class="fas fa-paperclip"></i> {{ $file->name }} </a>
                      por: <i class="fas fa-user"></i> {{ $file->user->FullName }} <i class="fas fa-calendar"></i> {{ $file->CreationDate }}
                  </p>
              @endforeach
          </div>
      </div>
    </div>
</div>
@endif
<!-- *********************************************************************** -->

<!-- ************************* AGREGAR SOLICITANTE ************************* -->
@foreach($requestForm->requestformevents as $key => $event)
    @if($event->type == 'message' && $event->status == 'create')
      @if($loop->last)
        <div class="card mt-4 d-print-none">
            <div class="card-body">
                <h5 class="card-title">Agregar Solicitante</h5>

                <form method="POST" class="form-horizontal" action="{{ route('request_forms.update', $requestForm) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-row">
                        <div class="form-group col-6">
                            <select class="form-control form-control-sm selectpicker" id="forwhorequest_id" name="whorequest_id" title="Seleccione..." data-live-search="true" data-size="5">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} {{ $user->fathers_family }} {{ $user->mothers_family }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <button class="btn btn-primary btn-sm float-left mr-3" type="submit">
                                <i class="fas fa-save"></i> Enviar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      @endif
    @endif
@endforeach
<!-- *********************************************************************** -->
<br>
<!-- ************************* CUADRO DE FIRMAS **************************** -->
<div class="form-row">
    <div class="form-group col-6">
        <table class="table table-sm table-bordered">
            <tr>
                <th colspan="2" class="table-active">Solicita</th>
            </tr>
            <tr>
                <th>Nombre</th>
                <td>{{ $requestForm->whorequest->FullName ?? '' }}</td>
            </tr>
            <tr>
                <th>Cargo</th>
                <td>{{ $requestForm->whorequest_position ?? '' }}</td>
            </tr>
            <tr>
                <th>Firma</th>
                <td>
                @foreach($requestForm->requestformevents as $event)
                    @if($event->type == "status" && $event->StatusName == "Aprobado por solicitante")
                        <i class="fas fa-check-square"></i>
                    @endif
                @endforeach
                </td>
            </tr>
            <tr>
                <th>Aprobado</th>
                <td>
                @foreach($requestForm->requestformevents as $event)
                  @if($loop->last)
                    @if(($event->type == "status" && $event->StatusName === 'Nuevo') && $requestForm->whorequest_id == Auth::user()->id)
                        <form method="POST" class="form-horizontal" action="{{ route('request_forms.store_approved_request', $requestForm) }}">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-primary btn-sm float-left mr-3" type="submit" onclick="return confirm('¿Está seguro de aprobar este formulario?');">
                                <i class="fas fa-vote-yea"></i> Aprobar
                            </button>
                        </form>
                    @endif
                  @endif
                    @if($event->type == "status" && $event->StatusName == "Aprobado por solicitante")
                      {{ $event->CreationDate }}
                    @endif
                @endforeach
                </td>
            </tr>
        </table>
    </div>
    <div class="form-group col-6">
        <table class="table table-sm table-bordered">
            <tr>
                <th colspan="2" class="table-active">Autoriza</th>
            </tr>
            <tr>
                <th>Nombre</th>
                <td>{{ $requestForm->whoauthorize->FullName ?? '' }}</td>
            </tr>
            <tr>
                <th>Cargo</th>
                <td>{{ $requestForm->whoauthorize_position ?? '' }}</td>
            </tr>
            <tr>
                <th>Firma</th>
                <td>
                    @foreach($requestForm->requestformevents as $event)
                        @if($event->type == "status" && $event->StatusName == "Aprobado por jefatura")
                            <i class="fas fa-check-square"></i>
                        @endif
                    @endforeach

                </td>
            </tr>
            <th>Aprobado</th>
            <td>
                @foreach($requestForm->requestformevents as $event)
                  @if($loop->last)
                    @if(($event->type == "status" && $event->StatusName === 'Aprobado por solicitante') &&
                        in_array($requestForm->whoauthorize_unit_id, App\Utilities::getPermissionSignaureAuthorize()))
                        <form method="POST" class="form-horizontal" action="{{ route('request_forms.store_approved_chief', $requestForm) }}">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-primary btn-sm float-left mr-3" type="submit" onclick="return confirm('¿Está seguro de aprobar este formulario?');">
                                <i class="fas fa-vote-yea"></i> Aprobar
                            </button>
                        </form>
                    @endif
                  @endif
                    @if($event->type == "status" && $event->StatusName == "Aprobado por jefatura")
                      {{ $event->CreationDate }}
                    @endif
                @endforeach
            </td>
        </table>
      </div>
</div>

<h5>Exclusivo Departamento de Gestión Financiera</h5>
<h6>Certificado Refrendación Presupuestaria</h6>
<hr>
<div class="form-row">
  <div class="form-group col-6">
    <!-- ITEM -->
    @if($requestForm->type_form === 'item')
    @foreach($requestForm->requestformevents as $event)
      @if($loop->last)
        @if($event->type == "message" && $event->status == "item_record" && Auth::user()->can('Request Forms: Finance add item code'))
          <form method="POST" class="form-horizontal" action="{{ route('request_forms.store_finance_data', $requestForm) }}" enctype="multipart/form-data">
              {{ csrf_field() }} <!-- input hidden contra ataques CSRF -->
              {{ method_field('PUT') }}

              <div class="form-row">
                  <div class="form-group col-4" hidden>
                      <label for="forfinance_program" class="small">Programa Asociado:</label>
                      <input type="text" class="form-control form-control-sm" id="forfinance_program" placeholder="Escriba..." name="finance_program" value="{{ $requestForm->program }}" readonly>
                  </div>
                  <div class="form-group col-4">
                      <label for="forfolio_sigfe" class="small">Folio requerimiento - SIGFE:</label>
                      <input type="text" class="form-control form-control-sm" id="forfolio_sigfe" placeholder="Escriba..." name="folio_sigfe" value="{{ $requestForm->folio_sigfe ? $requestForm->folio_sigfe : '' }}"
                          @foreach($requestForm->requestformevents as $event) @if($event->type == "message" && $event->status == "crp_record") readonly @endif @endforeach required>
                  </div>
                  <div class="form-group col-4" hidden>
                      <label for="forfolio_sigfe_id_oc" class="small">Folio SIGFE-ID-OC:</label>
                      <input type="text" class="form-control form-control-sm" id="forfolio_sigfe_id_oc" placeholder="Escriba..." name="folio_sigfe_id_oc" value="{{ $requestForm->folio_sigfe_id_oc ? $requestForm->folio_sigfe_id_oc : '' }}"
                            @foreach($requestForm->requestformevents as $event) @if($event->type == "message" && $event->status == "crp_record") readonly @endif @endforeach>
                  </div>
              </div>
              <div class="form-row">
                <table class="table table-sm table-bordered">
                  <tr class="small">
                    <td class="table-active" style="width: 180px;">Item Presupuestario:</td>
                    <td>@foreach($requestForm->items as $item)
                          @if($item->request_form_item_codes_id == null)
                            -
                          @else
                            {{ $item->request_form_item_codes->ItemCodes }},
                          @endif
                        @endforeach
                    </td>
                  </tr>
                </table>
              </div>

              <div class="form-row">
                  <div class="form-group col-4">
                      <label for="forfinance_expense" class="small">Monto $:</label>
                      <input type="number" class="form-control form-control-sm" id="forfinance_expense" placeholder="Escriba..." name="finance_expense" value="{{ $requestForm->estimated_expense ? $requestForm->estimated_expense : '' }}" onchange="restar(this.value);" readonly>
                  </div>
                  <div class="form-group col-4">
                      <label for="foravailable balance" class="small">Saldo programa:</label>
                      <input type="number" class="form-control form-control-sm" id="foravailable balance" placeholder="Escriba..." name="available_balance" value="{{ $requestForm->available_balance ? $requestForm->available_balance : '' }}" onchange="restar(this.value);"
                        @foreach($requestForm->requestformevents as $event) @if($event->type == "message" && $event->status == "crp_record") readonly @endif @endforeach required>
                  </div>
                  <div class="form-group col-4">
                      <label for="forprogram_balance" class="small">Saldo programa (Resto):</label>
                      <input type="number" class="form-control form-control-sm" id="forprogram_balance" placeholder="Escriba..." name="program_balance" value="{{ $requestForm->program_balance ? $requestForm->program_balance : '' }}"
                        @foreach($requestForm->requestformevents as $event) @if($event->type == "message" && $event->status == "crp_record") readonly @endif @endforeach onchange="restar(this.value);" required>
                  </div>
              </div>

              <button class="btn btn-primary btn-sm float-right mr-3" type="submit">
                  <i class="fas fa-save"></i> Enviar
              </button>
            </form>
          @endif
        @endif
        @if($event->type == "message" && $event->status == "crp_record")
          <table class="table table-sm table-bordered">
              <tr>
                  <th colspan="3" class="table-active">Certificado Refrendación Presupuestaria</th>
              </tr>
              <tr>
                  <th>Programa Asociado</th>
                  <td colspan="2">{{ $requestForm->program }}</td>
              </tr>
              <tr>
                  <th nowrap>Folio Requerimiento - SIGFE</th>
                  <td colspan="2">{{ $requestForm->folio_sigfe }}</td>
              </tr>
              <tr>
                  <th>Folio Compromiso - SIGFE</th>
                  <td colspan="2">{{ $requestForm->forfolio_sigfe_id_oc }}</td>
              </tr>
              <tr>
                  <th>Item Presupuestario</th>
                  <td colspan="2">@foreach($requestForm->items as $item)
                        @if($item->request_form_item_codes_id == null)
                          -
                        @else
                          {{ $item->request_form_item_codes->ItemCodes }},
                        @endif
                      @endforeach
                  </td>
              </tr>
              <tr>
                  <th>Monto $</th>
                  <td colspan="2">{{ $requestForm->EstimatedFinanceExpenseFormat }}</td>
              </tr>
              <tr>
                  <th>Saldo Programa $</th>
                  <td>{{ $requestForm->AvailableBalanceFormat }}</td>
                  <td>{{ $requestForm->ProgramBalanceFormat }}</td>
              </tr>
          </table>
        @endif
    @endforeach
    @endif
    <!-- PASSAGE -->
    @if($requestForm->type_form === 'passage')
    @foreach($requestForm->requestformevents as $event)
      @if($loop->last)
        @if($event->type == "status" && $event->StatusName == "Aprobado por jefatura" && Auth::user()->can('Request Forms: Finance add item code'))
          <form method="POST" class="form-horizontal" action="{{ route('request_forms.store_finance_data', $requestForm) }}" enctype="multipart/form-data">
              {{ csrf_field() }} <!-- input hidden contra ataques CSRF -->
              {{ method_field('PUT') }}

              <div class="form-row">
                  <div class="form-group col-4" hidden>
                      <label for="forfinance_program" class="small">Programa Asociado:</label>
                      <input type="text" class="form-control form-control-sm" id="forfinance_program" placeholder="Escriba..." name="finance_program" value="{{ $requestForm->program }}" readonly>
                  </div>
                  <div class="form-group col-4">
                      <label for="forfolio_sigfe" class="small">Folio requerimiento - SIGFE:</label>
                      <input type="text" class="form-control form-control-sm" id="forfolio_sigfe" placeholder="Escriba..." name="folio_sigfe" value="{{ $requestForm->folio_sigfe ? $requestForm->folio_sigfe : '' }}"
                          @foreach($requestForm->requestformevents as $event) @if($event->type == "message" && $event->status == "crp_record") readonly @endif @endforeach required>
                  </div>
                  <div class="form-group col-4" hidden>
                      <label for="forfolio_sigfe_id_oc" class="small">Folio SIGFE-ID-OC:</label>
                      <input type="text" class="form-control form-control-sm" id="forfolio_sigfe_id_oc" placeholder="Escriba..." name="folio_sigfe_id_oc" value="{{ $requestForm->folio_sigfe_id_oc ? $requestForm->folio_sigfe_id_oc : '' }}"
                            @foreach($requestForm->requestformevents as $event) @if($event->type == "message" && $event->status == "crp_record") readonly @endif @endforeach>
                  </div>
              </div>
              <div class="form-row">
                <table class="table table-sm table-bordered">
                  <tr class="small">
                    <td class="table-active" style="width: 180px;">Item Presupuestario:</td>
                    <td>@foreach($requestForm->passages as $passage)
                          @if($passage->request_form_item_codes_id == null)
                            -
                          @else
                            @php
                              $label = array();
                              $label['pasagge'] = $passage->request_form_item_codes->ItemCodes;
                              $item_code = array_unique($label);
                            @endphp
                            {{ $passage->request_form_item_codes->ItemCodes }},
                          @endif
                        @endforeach
                    </td>
                  </tr>
                </table>
              </div>

              <div class="form-row">
                  <div class="form-group col-4">
                      <label for="forfinance_expense" class="small">Monto $:</label>
                      <input type="number" class="form-control form-control-sm" id="forfinance_expense" placeholder="Escriba..." name="finance_expense" value="{{ $requestForm->estimated_expense ? $requestForm->estimated_expense : '' }}" onchange="restar(this.value);" readonly>
                  </div>
                  <div class="form-group col-4">
                      <label for="foravailable balance" class="small">Saldo programa:</label>
                      <input type="number" class="form-control form-control-sm" id="foravailable balance" placeholder="Escriba..." name="available_balance" value="{{ $requestForm->available_balance ? $requestForm->available_balance : '' }}" onchange="restar(this.value);"
                        @foreach($requestForm->requestformevents as $event) @if($event->type == "message" && $event->status == "crp_record") readonly @endif @endforeach required>
                  </div>
                  <div class="form-group col-4">
                      <label for="forprogram_balance" class="small">Saldo programa (Resto):</label>
                      <input type="number" class="form-control form-control-sm" id="forprogram_balance" placeholder="Escriba..." name="program_balance" value="{{ $requestForm->program_balance ? $requestForm->program_balance : '' }}"
                        @foreach($requestForm->requestformevents as $event) @if($event->type == "message" && $event->status == "crp_record") readonly @endif @endforeach onchange="restar(this.value);" required>
                  </div>
              </div>

              <button class="btn btn-primary btn-sm float-right mr-3" type="submit">
                  <i class="fas fa-save"></i> Enviar
              </button>
            </form>
          @endif
        @endif
        @if($event->type == "message" && $event->status == "crp_record")
          <table class="table table-sm table-bordered">
              <tr>
                  <th colspan="3" class="table-active">Certificado Refrendación Presupuestaria</th>
              </tr>
              <tr>
                  <th>Programa Asociado</th>
                  <td colspan="2">{{ $requestForm->program }}</td>
              </tr>
              <tr>
                  <th nowrap>Folio Requerimiento - SIGFE</th>
                  <td colspan="2">{{ $requestForm->folio_sigfe }}</td>
              </tr>
              <tr>
                  <th>Folio Compromiso - SIGFE</th>
                  <td colspan="2">{{ $requestForm->forfolio_sigfe_id_oc }}</td>
              </tr>
              <tr>
                  <th>Item Presupuestario</th>
                  <td colspan="2">@foreach($requestForm->passages as $passage)
                        @if($passage->request_form_item_codes_id == null)
                          -
                        @else
                          {{ $passage->request_form_item_codes->ItemCodes }},
                        @endif
                      @endforeach
                  </td>
              </tr>
              <tr>
                  <th>Monto $</th>
                  <td colspan="2">{{ $requestForm->EstimatedFinanceExpenseFormat }}</td>
              </tr>
              <tr>
                  <th>Saldo Programa $</th>
                  <td>{{ $requestForm->AvailableBalanceFormat }}</td>
                  <td>{{ $requestForm->ProgramBalanceFormat }}</td>
              </tr>
          </table>
        @endif
    @endforeach
    @endif

  </div>
  <div class="form-group col-6">
      <table class="table table-sm table-bordered">
          <tr>
              <th colspan="2" class="table-active">Autoriza</th>
          </tr>
          <tr>
              <th>Nombre</th>
              <td>{{ $requestForm->whoauthorize_finance->FullName ?? '' }}</td>
          </tr>
          <tr>
              <th>Cargo</th>
              <td>{{ $requestForm->finance_position ?? '' }}</td>
          </tr>
          <tr>
              <th>Firma</th>
              <td>
                  @foreach($requestForm->requestformevents as $event)
                      @if($event->type == "status" && $event->StatusName == "Aprobado por finanzas")
                          <i class="fas fa-check-square"></i>
                      @endif
                      @if($event->type == "status" && $event->StatusName == "Rechazado")
                          <i class="fas fa-window-close"></i>
                      @endif
                  @endforeach
              </td>
          </tr>
          <th>Aprobado</th>
          <td>
            @foreach($requestForm->requestformevents as $event)
              @if($loop->last)
                @if($event->status === 'crp_record' &&
                  in_array($requestForm->finance_unit_id, App\Utilities::getPermissionSignaureAuthorize()))
                    <form method="POST" class="form-horizontal" action="{{ route('request_forms.store_approved_finance', $requestForm) }}">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-primary btn-sm float-left mr-3" type="submit" onclick="return confirm('¿Está seguro de aprobar este formulario?');">
                            <i class="fas fa-vote-yea"></i> Aprobar
                        </button>
                    </form>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-danger btn-sm float-left mr-3" data-toggle="modal" data-target="#exampleModalCenter">
                      <i class="fas fa-window-close"></i> Rechazar
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Rechazar Solicitud</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form method="POST" class="form-horizontal" action="{{ route('request_forms.store_reject', $requestForm) }}" enctype="multipart/form-data">
                          <div class="modal-body">
                                @csrf <!-- input hidden contra ataques CSRF -->
                                @method('PUT')
                                <div class="form-row">
                                    <div class="form-group col-12">
                                      <label for="forcomment">Ingrese el motivo del rechazo</label>
                                      <textarea class="form-control form-control-sm" id="forcomment" name="comment" rows="2" required></textarea>
                                    </div>
                                </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancalar</button>

                            <button class="btn btn-danger" type="submit">
                                <i class="fas fa-window-close"></i> Rechazar
                            </button>
                          </div>
                        </form>
                        </div>
                      </div>
                    </div>
                @else
                    @foreach($requestForm->requestformevents as $event)
                        @if($event->type == "status" && $event->StatusName == "Aprobado por finanzas")
                          {{ $event->CreationDate }}
                        @endif
                        @if($event->type == "status" && $event->StatusName == "Rechazado")
                          {{ $event->CreationDate }}
                        @endif
                    @endforeach
                @endif
              @endif
            @endforeach
          </td>
      </table>
    </div>
</div>
<hr>
<!-- *********************************************************************** -->

<!-- *************************** HISTORIAL DE EVENTOS ********************** -->
<div class="row">
    <div class="col">
        <p class="float-right">
            <a class="btn btn-primary btn-sm" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fas fa-history"></i> Respuesta</a>
            <a class="btn btn-primary btn-sm" data-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample2"><i class="fas fa-history"></i> Ver Historial</a>
        </p>
    </div>
</div>
<br>
<!-- ******************************* Finanzas ****************************** -->


<!-- ******************************* RESPUESTAS **************************** -->
<div class="row">
    <div class="col">
        <div class="collapse multi-collapse" id="multiCollapseExample1">
            <div class="card card-body">
                <form method="POST" class="form-horizontal" action="" enctype="multipart/form-data">
                  {{ csrf_field() }} <!-- input hidden contra ataques CSRF -->
                  {{ method_field('PUT') }}
                  <fieldset class="form-group">
                    <label for="forcomment">Respuesta:</label>
                    <textarea class="form-control" class="form-control" id="forcomment" placeholder="Ingrese aquí su respuesta." name="comment" required=""></textarea>
                  </fieldset>

                  <!-- <fieldset class="form-group">
                    <label for="forFile">Adjuntar</label>
                    <input type="file" class="form-control-file" id="forfile" name="forfile[]" multiple>
                  </fieldset> -->

                  <fieldset class="form-group" hidden>
                    <label for="forstate">Estado</label>
                    <input type="text" class="form-control" id="forstate" name="status" required="" value="pending">
                  </fieldset>

                  <div class="float-right">
                    <button type="submit" class="btn btn-primary btn-sm">
                      <i class="fas fa-save"></i> Enviar
                    </button>
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>
<br>
<!-- ********************************* EVENTOS ***************************** -->
<div class="row">
  <div class="col">
    <div class="collapse multi-collapse" id="multiCollapseExample2">
      <div class="card card-body">
        @foreach($requestForm->requestformevents as $key => $event)
            @if($event->type != 'message' && $event->status != 'create' )
                <ul class="fa-ul">
                  <li>@if($event->type === 'status' && $event->StatusName === 'Nuevo')
                          <span class="fa-li"><i class="fas fa-plus"></i></span>
                      @endif
                      @if($event->type === 'status' && ($event->StatusName === 'Aprobado por solicitante' || $event->StatusName === 'Aprobado por jefatura' ||
                                                        $event->StatusName === 'Aprobado por finanzas'))
                          <span class="fa-li"><i class="fas fa-check-square"></i></span>
                      @endif
                      @if($event->type === 'status' && $event->StatusName === 'Rechazado')
                          <span class="fa-li"><i class="fas fa-window-close"></i></span>
                      @endif
                      @if($event->type === 'message')
                          <span class="fa-li"><i class="fas fa-comment-dots"></i></span>
                      @endif

                      <i class="far fa-calendar-alt"></i> <strong>Fecha</strong>: {{ $event->CreationDate }} -
                      @if ($event->user_id == null)
                          <i class="fas fa-desktop"></i> <strong>Creado Por</strong>: Sistema - <br>
                      @else
                          <i class="fas fa-desktop"></i> <strong>Creado Por</strong>: {{ $event->user ? $event->user->FullName : 'Usuario eliminado' }} <br>
                      @endif
                      <i class="fas fa-comment-dots"></i> <strong>Comentario</strong>: {{ $event->comment }}
                  </li>
                </ul>
            @endif
        @endforeach
      </div>
    </div>
  </div>
</div>
<!-- *********************************************************************** -->

@endsection

@section('custom_js')

<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/steps/steps.js') }}"></script>

<script>

  $(document).ready(function() {
    //$('.steps').steps('start');
    @foreach($requestForm->requestformevents as $event)
      @if($event->type == "status")
        $('.steps').steps('next');
      @endif
    @endforeach
  });
</script>

<script>
  function restar (valor) {
      var estimated_expense = document.getElementById('forfinance_expense').value;
      var available_balance = document.getElementById('foravailable balance').value;

      if(available_balance==null || available_balance=="" || available_balance==0) dd = 0;

      var program_balance = parseInt(available_balance) - parseInt(estimated_expense);

      // Colocar el resultado de la suma en el control "span".
      document.getElementById('forprogram_balance').value = program_balance;
  }
</script>

@endsection

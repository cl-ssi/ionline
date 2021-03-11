@extends('layouts.app')

@section('title', 'Cumplimiento de solicitud')

@section('content')

<h3>Cumplimiento de solicitud</h3>

<div class="form-row">

  <fieldset class="form-group col-6 col-md-6">
      <label for="for_request_date">Responsable</label>
      <input type="text" class="form-control" value="{{$serviceRequest->SignatureFlows->where('sign_position',1)->first()->user->getFullNameAttribute()}}" disabled>
  </fieldset>

  <fieldset class="form-group col-6 col-md-6">
      <label for="for_start_date">Supervisor</label>
      <input type="text" class="form-control" value="{{$serviceRequest->SignatureFlows->where('sign_position',2)->first()->user->getFullNameAttribute()}}" disabled>
  </fieldset>

</div>

<div class="form-row">

  <fieldset class="form-group col-3 col-md-3">
      <label for="for_request_date">ID Solicitud</label>
      <input type="text" class="form-control" value="{{$serviceRequest->id}}" disabled>
  </fieldset>

  <fieldset class="form-group col-3 col-md-3">
      <label for="for_start_date">Fecha de Inicio</label>
      <input type="text" class="form-control" value="{{\Carbon\Carbon::parse($serviceRequest->start_date)->format('Y-m-d')}}" disabled>
  </fieldset>

  <fieldset class="form-group col-3 col-md-3">
      <label for="for_end_date">Fecha de Término</label>
      <input type="text" class="form-control" value="{{\Carbon\Carbon::parse($serviceRequest->end_date)->format('Y-m-d')}}" disabled>
  </fieldset>

  <fieldset class="form-group col-3 col-md-3">
      <label for="for_end_date">Tipo de contrato</label>
      <input type="text" class="form-control" value="{{$serviceRequest->program_contract_type}}" disabled>
  </fieldset>

</div>

<div class="form-row">

  <fieldset class="form-group col-3 col-md-3">
      <label for="for_request_date">Rut</label>
      <input type="text" class="form-control" value="{{$serviceRequest->rut}}" disabled>
  </fieldset>

  <fieldset class="form-group col-3 col-md-3">
      <label for="for_start_date">Funcionario</label>
      <input type="text" class="form-control" value="{{$serviceRequest->name}}" disabled>
  </fieldset>

  <fieldset class="form-group col-3 col-md-3">
      <label for="for_end_date">Estamento</label>
      <input type="text" class="form-control" value="{{$serviceRequest->estate}}" disabled>
  </fieldset>

  <fieldset class="form-group col-3 col-md-3">
      <label for="for_end_date">Jornada de trabajo</label>
      <input type="text" class="form-control" value="{{$serviceRequest->working_day_type}}" disabled>
  </fieldset>

</div>

<hr>

@if($serviceRequest->program_contract_type == "Mensual")

@foreach($periods as $key => $period)

<div class="card border-dark">
  <div class="card-header">
    Período <b>{{$period->format("m-Y")}}</b>
  </div>
  <div class="card-body">

    <h4>Información del período</h4>

    @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->count() == 0)

      <form method="POST" action="{{ route('rrhh.fulfillments.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="row">

        <input type="hidden" name="year" value="{{$period->format("Y")}}">
        <input type="hidden" name="month" value="{{$period->format("m")}}">
        <input type="hidden" name="service_request_id" value="{{$serviceRequest->id}}">

        <fieldset class="form-group col">
    		    <label for="for_type">Período</label>
    		    <select name="type" class="form-control" required>
              <option value=""></option>
    					<option value="Mensual" >Mensual</option>
              <option value="Parcial" >Parcial</option>
            </select>
    		</fieldset>

        @if($key == 0)
          <fieldset class="form-group col-3">
              <label for="for_estate">Inicio</label>
              <input type="date" class="form-control" name="start_date" value="{{\Carbon\Carbon::parse($serviceRequest->start_date)->format('Y-m-d')}}" required>
          </fieldset>
        @else
          <fieldset class="form-group col-3">
              <label for="for_estate">Inicio</label>
              <input type="date" class="form-control" name="start_date" required>
          </fieldset>
        @endif

        <fieldset class="form-group col-3">
            <label for="for_estate">Término</label>
            <input type="date" class="form-control" name="end_date" required>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_estate">Observación</label>
            <input type="text" class="form-control" name="observation">
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_estate"><br/></label>
            <button type="submit" class="btn btn-primary form-control">Guardar</button>
        </fieldset>
      </div>

      </form>

    @else

      <form method="POST" action="{{ route('rrhh.fulfillments.update',$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="row">

        <fieldset class="form-group col">
            <label for="for_type">Período</label>
            <select name="type" class="form-control" required>
              <option value=""></option>
              <option value="Mensual" @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->type == "Mensual") selected @endif>Mensual</option>
              <option value="Parcial" @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->type == "Parcial") selected @endif>Parcial</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="for_estate">Inicio</label>
            <input type="date" class="form-control" name="start_date" value="{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->start_date->format('Y-m-d')}}" required>
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="for_estate">Término</label>
            <input type="date" class="form-control" name="end_date" value="{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->end_date->format('Y-m-d')}}" required>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_estate">Observación</label>
            <input type="text" class="form-control" name="observation" value="{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->observation}}">
        </fieldset>

        @can('Service Request: fulfillments responsable')
          @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->responsable_approver_id == NULL)
            <fieldset class="form-group col">
                <label for="for_estate"><br/></label>
                <button type="submit" class="btn btn-primary form-control">Guardar</button>
            </fieldset>
          @else
            <fieldset class="form-group col">
                <label for="for_estate"><br/></label>
                <button type="submit" class="btn btn-primary form-control" disabled>Guardar</button>
            </fieldset>
          @endif
        @endcan

        @can('Service Request: fulfillments rrhh')
          @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->rrhh_approver_id == NULL)
            <fieldset class="form-group col">
                <label for="for_estate"><br/></label>
                <button type="submit" class="btn btn-primary form-control">Guardar</button>
            </fieldset>
          @else
            <fieldset class="form-group col">
                <label for="for_estate"><br/></label>
                <button type="submit" class="btn btn-primary form-control" disabled>Guardar</button>
            </fieldset>
          @endif
        @endcan

        @can('Service Request: fulfillments finance')
          @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->finances_approver_id == NULL)
            <fieldset class="form-group col">
                <label for="for_estate"><br/></label>
                <button type="submit" class="btn btn-primary form-control">Guardar</button>
            </fieldset>
          @else
            <fieldset class="form-group col">
                <label for="for_estate"><br/></label>
                <button type="submit" class="btn btn-primary form-control" disabled>Guardar</button>
            </fieldset>
          @endif
        @endcan
      </div>

      </form>

      <!-- información adicional rrhh -->

      @canany(['Service Request: fulfillments rrhh'])
      <form method="POST" action="{{ route('rrhh.fulfillments.update',$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="card border-danger mb-3">
        <div class="card-header bg-danger text-white">
          Datos adicionales - RRHH
        </div>
          <div class="card-body">

            <div class="row">
              <fieldset class="form-group col-5 col-md-6">
                  <label for="for_resolution_number">N° Resolución</label>
                  <input type="text" class="form-control" disabled name="resolution_number" value="{{$serviceRequest->resolution_number}}">
              </fieldset>

              <fieldset class="form-group col-7 col-md-6">
                  <label for="for_resolution_date">Fecha Resolución</label>
                  <input type="date" class="form-control" disabled name="resolution_date" @if($serviceRequest->resolution_date) value="{{$serviceRequest->resolution_date->format('Y-m-d')}}" @endif>
              </fieldset>
            </div>

            <div class="form-row">

              @if($period->format("Y") == 2021 && $period->format("m") == 1 && $serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->total_to_pay != NULL)
                <fieldset class="form-group col col-md">
                    <label for="for_total_hours_paid">Total hrs. a pagar per.</label>
                    <input type="text" class="form-control" name="total_hours_to_pay" disabled value="{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->total_hours_to_pay}}">
                </fieldset>

                <fieldset class="form-group col col-md">
                    <label for="for_total_paid">Total a pagar</label>
                    <input type="text" class="form-control" name="total_to_pay" disabled value="{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->total_to_pay}}">
                </fieldset>
              @else
                <fieldset class="form-group col col-md">
                    <label for="for_total_hours_paid">Total hrs. a pagar per.</label>
                    <input type="text" class="form-control" name="total_hours_to_pay" value="{{$serviceRequest->weekly_hours}}">
                </fieldset>

                <fieldset class="form-group col col-md">
                    <label for="for_total_paid">Total a pagar</label>
                    <input type="text" class="form-control" name="total_to_pay" value="{{$serviceRequest->net_amount}}">
                </fieldset>
              @endif

            </div>
            <button type="submit" class="btn btn-danger">Guardar</button>
          </div>
      </div>
      </form>
      @endcan


      <!-- información adicional finanzas -->

      @canany(['Service Request: fulfillments finance'])
      <form method="POST" action="{{ route('rrhh.fulfillments.update',$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="card border-info mb-3">
        <div class="card-header bg-info text-white">
          Datos adicionales - Finanzas
        </div>
          <div class="card-body">

            <div class="row">
              <fieldset class="form-group col-5 col-md-6">
                  <label for="for_resolution_number">N° Resolución</label>
                  <input type="text" class="form-control" disabled name="resolution_number" value="{{$serviceRequest->resolution_number}}">
              </fieldset>

              <fieldset class="form-group col-7 col-md-6">
                  <label for="for_resolution_date">Fecha Resolución</label>
                  <input type="date" class="form-control" disabled name="resolution_date" @if($serviceRequest->resolution_date) value="{{$serviceRequest->resolution_date->format('Y-m-d')}}" @endif>
              </fieldset>
            </div>

            <div class="form-row">

              <fieldset class="form-group col col-md">
                  <label for="for_total_hours_paid">Total hrs. a pagar per.</label>
                  <input type="text" class="form-control" name="total_hours_to_pay" disabled value="{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->total_hours_to_pay}}">
              </fieldset>

              <fieldset class="form-group col col-md">
                  <label for="for_total_paid">Total a pagar</label>
                  <input type="text" class="form-control" name="total_to_pay" disabled value="{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->total_to_pay}}">
              </fieldset>

            </div>

            <div class="form-row">

              <fieldset class="form-group col col-md">
                  <label for="for_bill_number">N° Boleta</label>
                  <input type="text" class="form-control" name="bill_number" value="{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->bill_number}}">
              </fieldset>

              <fieldset class="form-group col col-md">
                  <label for="for_total_hours_paid">Tot. hrs pagadas per.</label>
                  <input type="text" class="form-control" name="total_hours_paid" value="{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->total_hours_paid}}">
              </fieldset>

              <fieldset class="form-group col col-md">
                  <label for="for_total_paid">Total pagado</label>
                  <input type="text" class="form-control" name="total_paid" value="{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->total_paid}}">
              </fieldset>

              <fieldset class="form-group col col-md">
                  <label for="for_payment_date">Fecha pago</label>
                  <input type="date" class="form-control" name="payment_date" required @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->payment_date) value="{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->payment_date->format('Y-m-d')}}" @endif>
              </fieldset>

              <fieldset class="form-group col col-md">
          			<label for="for_contable_month">Mes contable pago</label>
          			<select name="contable_month" class="form-control" required>
          				<option value=""></option>
          				<option value="1" @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->contable_month == 1) selected @endif>Enero</option>
          				<option value="2" @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->contable_month == 2) selected @endif>Febrero</option>
          				<option value="3" @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->contable_month == 3) selected @endif>Marzo</option>
          				<option value="4" @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->contable_month == 4) selected @endif>Abril</option>
          				<option value="5" @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->contable_month == 5) selected @endif>Mayo</option>
          				<option value="6" @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->contable_month == 6) selected @endif>Junio</option>
          				<option value="7" @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->contable_month == 7) selected @endif>Julio</option>
                  <option value="8" @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->contable_month == 8) selected @endif>Agosto</option>
                  <option value="9" @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->contable_month == 9) selected @endif>Septiembre</option>
                  <option value="10" @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->contable_month == 10) selected @endif>Octubre</option>
                  <option value="11" @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->contable_month == 11) selected @endif>Noviembre</option>
                  <option value="12" @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->contable_month == 12) selected @endif>Diciembre</option>
          			</select>
          		</fieldset>
            </div>
            <button type="submit" class="btn btn-info">Guardar</button>
          </div>
      </div>
      </form>
      @endcan



      <hr>

      <h4>Inasistencias</h4>

      <form method="POST" action="{{ route('rrhh.fulfillmentItem.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="row">

          <input type="hidden" name="fulfillment_id" value="{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->id}}">

          <fieldset class="form-group col">
      		    <label for="for_type">Tipo</label>
      		    <select name="type" class="form-control for_type" required>
                <option value=""></option>
      					<option value="Inasistencia Injustificada">INASISTENCIA INJUSTIFICADA</option>
                <option value="Licencia no covid">LICENCIA NO COVID</option>
                <option value="Renuncia voluntaria">RENUNCIA VOLUNTARIA</option>
                <option value="Abandono de funciones">ABANDONO DE FUNCIONES</option>
              </select>
      		</fieldset>

          <fieldset class="form-group col">
              <label for="for_estate">Observación</label>
              <input type="text" class="form-control" name="observation">
          </fieldset>

        </div>

        <div class="row">
          <fieldset class="form-group col-3">
              <label for="for_estate">Entrada</label>
              <input type="date" class="form-control start_date" name="start_date" required>
          </fieldset>
          <fieldset class="form-group col">
              <label for="for_estate">Hora</label>
              <input type="time" class="form-control start_hour" name="start_hour" required>
          </fieldset>
          <fieldset class="form-group col-3">
              <label for="for_estate">Salida</label>
              <input type="date" class="form-control end_date" name="end_date" required>
          </fieldset>
          <fieldset class="form-group col">
              <label for="for_estate">Hora</label>
              <input type="time" class="form-control end_hour" name="end_hour" required>
          </fieldset>



          @can('Service Request: fulfillments responsable')
            @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->responsable_approver_id == NULL)
              <fieldset class="form-group col">
                  <label for="for_estate"><br/></label>
                  <button type="submit" class="btn btn-primary form-control">Guardar</button>
              </fieldset>
            @else
              <fieldset class="form-group col">
                  <label for="for_estate"><br/></label>
                  <button type="submit" class="btn btn-primary form-control" disabled>Guardar</button>
              </fieldset>
            @endif
          @endcan

          @can('Service Request: fulfillments rrhh')
            @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->rrhh_approver_id == NULL)
              <fieldset class="form-group col">
                  <label for="for_estate"><br/></label>
                  <button type="submit" class="btn btn-primary form-control">Guardar</button>
              </fieldset>
            @else
              <fieldset class="form-group col">
                  <label for="for_estate"><br/></label>
                  <button type="submit" class="btn btn-primary form-control" disabled>Guardar</button>
              </fieldset>
            @endif
          @endcan

          @can('Service Request: fulfillments finance')
            @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->finances_approver_id == NULL)
              <fieldset class="form-group col">
                  <label for="for_estate"><br/></label>
                  <button type="submit" class="btn btn-primary form-control">Guardar</button>
              </fieldset>
            @else
              <fieldset class="form-group col">
                  <label for="for_estate"><br/></label>
                  <button type="submit" class="btn btn-primary form-control" disabled>Guardar</button>
              </fieldset>
            @endif
          @endcan
        </div>

      </form>

      <table class="table table-sm">
          <thead>
              <tr>
                  <th></th>
                  <th>Tipo</th>
                  <th>Inicio</th>
                  <th>Término</th>
                  <th>Observación</th>
              </tr>
          </thead>
          <tbody>
            @foreach($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->FulfillmentItems as $key => $FulfillmentItem)
              <tr>
                  <td>
                    @can('Service Request: fulfillments responsable')
                      @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->responsable_approver_id == NULL)
                      <form method="POST" action="{{ route('rrhh.fulfillmentItem.destroy', $FulfillmentItem) }}" class="d-inline">
            						@csrf
            						@method('DELETE')
            						<button type="submit" class="btn btn-outline-secondary btn-sm" onclick="return confirm('¿Está seguro de eliminar la información?');">
            							<span class="fas fa-trash-alt" aria-hidden="true"></span>
            						</button>
            					</form>
                      @endif
                    @endcan
                  </td>
                  <td>{{$FulfillmentItem->type}}</td>
                  <td>@if($FulfillmentItem->start_date){{$FulfillmentItem->start_date->format('Y-m-d H:i')}}@endif</td>
                  <td>@if($FulfillmentItem->end_date){{$FulfillmentItem->end_date->format('Y-m-d H:i')}}@endif</td>
                  <td>{{$FulfillmentItem->observation}}</td>
              </tr>
            @endforeach
          </tbody>
      </table>

      <div class="row">
        <fieldset class="form-group col-6">
            <label for="for_invoice">Cargar Boleta</label>
            @livewire('invoice.upload', ['fulfillmentId' => $serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->id,
            'hasInvoiceFile' =>  $serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->has_invoice_file ])
        </fieldset>
        <fieldset class="form-group col">
            <label for="for_estate"><br/></label>

            @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->responsable_approbation != NULL)
              <a type="button"
                 class="btn btn-outline-success form-control"
                 href="{{ route('rrhh.fulfillments.certificate-pdf',$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()) }}" target="_blank">
                 Generar certificado
                 <i class="fas fa-file"></i>
              </a>

                {{--modal firmador--}}
                @php
                    $idModelModal = $serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->id;
                    $routePdfSignModal = "/rrhh/service_requests/resolution-pdf/$idModelModal";
                    $returnUrlSignModal = "rrhh.fulfillments.edit_fulfillment";
                @endphp

                @if(Auth::user()->can('Service Request: sign document'))
                    @include('documents.signatures.partials.sign_file')
                    <button type="button" data-toggle="modal" class="btn btn-outline-secondary form-control"
                            data-target="#signPdfModal{{$idModelModal}}" title="Firmar"> Firmar certificado <span class="fas fa-signature"
                                                                                             aria-hidden="true">
                                                                                        </span>
                    </button>
                @endif

            @endif

        </fieldset>
        <fieldset class="form-group col">
            <label for="for_estate"><br/></label>
            <form>

              @can('Service Request: fulfillments responsable')
                    @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->responsable_approver_id == NULL)

                  <a type="button"
                     class="btn btn-danger form-control"
                     onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de rechazar?');"
                     href="{{ route('rrhh.fulfillments.refuseFulfillment',$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()) }}" >
                     Rechazar
                  </a>
                  <a type="button"
                     class="btn btn-success form-control"
                     onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de confirmar?');"
                     href="{{ route('rrhh.fulfillments.confirmFulfillment',$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()) }}" >
                     Confirmar
                  </a>
                @else
                  <button type="submit" class="btn btn-danger form-control" disabled>Rechazar</button>
                  <button type="submit" class="btn btn-success form-control" disabled>Confirmar</button>
                @endif
              @endcan

              @can('Service Request: fulfillments rrhh')
                @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->rrhh_approver_id == NULL)
                  <a type="button"
                     class="btn btn-danger form-control"
                     onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de rechazar?');"
                     href="{{ route('rrhh.fulfillments.refuseFulfillment',$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()) }}" >
                     Rechazar
                  </a>
                  <a type="button"
                     class="btn btn-success form-control"
                     onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de confirmar?');"
                     href="{{ route('rrhh.fulfillments.confirmFulfillment',$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()) }}" >
                     Confirmar
                  </a>
                @else
                  <button type="submit" class="btn btn-danger form-control" disabled>Rechazar</button>
                  <button type="submit" class="btn btn-success form-control" disabled>Confirmar</button>
                @endif
              @endcan

              @can('Service Request: fulfillments finance')
                @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->finances_approver_id == NULL)
                  <a type="button"
                     class="btn btn-danger form-control"
                     onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de rechazar?');"
                     href="{{ route('rrhh.fulfillments.refuseFulfillment',$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()) }}" >
                     Rechazar
                  </a>
                  <a type="button"
                     class="btn btn-success form-control"
                     onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de confirmar?');"
                     href="{{ route('rrhh.fulfillments.confirmFulfillment',$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()) }}" >
                     Confirmar
                  </a>
                @else
                  <button type="submit" class="btn btn-danger form-control" disabled>Rechazar</button>
                  <button type="submit" class="btn btn-success form-control" disabled>Confirmar</button>
                @endif

              @endcan
            </form>
        </fieldset>
      </div>

      @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->responsable_approver_id != NULL)
      <h5>Visaciones</h5>
      <table class="table table-sm small">
          <thead>
              <tr>
                  <th>Unidad</th>
                  <th>Fecha</th>
                  <th>Usuario</th>
                  <th>Estado</th>
              </tr>
          </thead>
          <tbody>
              @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->responsable_approver_id != NULL)
              <tr>
                  <td>Responsable</td>
                  <td>{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->responsable_approbation_date}}</td>
                  <td>{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->responsableUser->getFullNameAttribute()}}</td>
                  <td>@if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->responsable_approbation === 1) APROBADO @else RECHAZADO @endif</td>
              </tr>
              @endif
              @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->rrhh_approver_id != NULL)
              <tr>
                  <td>RRHH</td>
                  <td>{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->rrhh_approbation_date}}</td>
                  <td>{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->rrhhUser->getFullNameAttribute()}}</td>
                  <td>@if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->rrhh_approbation === 1) APROBADO @else RECHAZADO @endif</td>
              </tr>
              @endif
              @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->finances_approver_id != NULL)
              <tr>
                  <td>Finanzas</td>
                  <td>{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->finances_approbation_date}}</td>
                  <td>{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->financesUser->getFullNameAttribute()}}</td>
                  <td>@if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->finances_approbation === 1) APROBADO @else RECHAZADO @endif</td>
              </tr>
              @endif
          </tbody>
      </table>
      @endif


    @endif

  </div>
</div>

<br>

@endforeach

@else

<div class="card">
  <div class="card-header">
    Información de la solicitud
  </div>
  <div class="card-body">

    <table class="table table-sm">
        <thead>
            <tr>
                <!-- <th>Select</th> -->
                <th>Entrada</th>
                <!-- <th>H.Inicio</th> -->
                <th>Salida</th>
                <!-- <th>H.Término</th> -->
                <th>Observación</th>
            </tr>
        </thead>
        <tbody>
          @foreach($serviceRequest->shiftControls as $key => $shiftControl)
            <tr>
              <!-- <td><input type='checkbox' name='record[]' value="{{$shiftControl}}"></td> -->
              <td>{{Carbon\Carbon::parse($shiftControl->start_date)->format('d-m-Y H:i')}}</td>
              <td>{{Carbon\Carbon::parse($shiftControl->end_date)->format('d-m-Y H:i')}}</td>
              <td>{{$shiftControl->observation}}</td>
            </tr>
          @endforeach
        </tbody>
    </table>

      @livewire('service-request.show-total-hours', ['serviceRequest' => $serviceRequest])

    <div class="row">
      <fieldset class="form-group col-9">

      </fieldset>
      <fieldset class="form-group col">
          <label for="for_estate"><br/></label>

          <a type="button"
             class="btn btn-outline-success form-control"
             href="{{ route('rrhh.fulfillments.certificate-pdf',$serviceRequest->Fulfillments->first()) }}" target="_blank">
             Generar certificado
             <i class="fas fa-file"></i>
          </a>

      </fieldset>
    </div>

    <!-- @if($serviceRequest->Fulfillments->count() == 0)

      <form method="POST" action="{{ route('rrhh.fulfillments.store') }}" enctype="multipart/form-data">
      @csrf

        <input type="hidden" name="service_request_id" value="{{$serviceRequest->id}}">
        <input type="hidden" name="type" value="Turnos">
        <input type="hidden" name="start_date" value="{{\Carbon\Carbon::parse($serviceRequest->start_date)->format('Y-m-d')}}">
        <input type="hidden" name="end_date" value="{{\Carbon\Carbon::parse($serviceRequest->end_date)->format('Y-m-d')}}">

        <table class="table table-sm">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Entrada</th>
                    <th>Salida</th>
                    <th>Observación</th>
                </tr>
            </thead>
            <tbody>
              @foreach($serviceRequest->shiftControls as $key => $shiftControl)
                <tr>
                  <td><input type='checkbox' name='record[]' value="{{$shiftControl}}"></td>
                  <td>{{Carbon\Carbon::parse($shiftControl->start_date)->format('d-m-Y H:i')}}</td>
                  <td>{{Carbon\Carbon::parse($shiftControl->end_date)->format('d-m-Y H:i')}}</td>
                  <td>{{$shiftControl->observation}}</td>
                </tr>
              @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary float-right">Guardar</button>

      </form>

    @else

      <h4>Turnos</h4>

      <form method="POST" action="{{ route('rrhh.fulfillmentItem.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="row">

          <input type="hidden" name="fulfillment_id" value="{{$serviceRequest->Fulfillments->first()->id}}">

          <fieldset class="form-group col">
              <label for="for_type">Tipo</label>
              <select name="type" id="type" class="form-control" required>
                <option value=""></option>
                <option value="Turno" selected>Turno</option>
              </select>
          </fieldset>

          <fieldset class="form-group col">
              <label for="for_estate">Observación</label>
              <input type="text" class="form-control" name="observation" id="observation">
          </fieldset>

        </div>

        <div class="row">
          <fieldset class="form-group col-3">
              <label for="for_estate">Entrada</label>
              <input type="date" class="form-control" name="start_date" required>
          </fieldset>
          <fieldset class="form-group col">
              <label for="for_estate">Hora</label>
              <input type="time" class="form-control" name="start_hour" required>
          </fieldset>
          <fieldset class="form-group col-3">
              <label for="for_estate">Salida</label>
              <input type="date" class="form-control" name="end_date" required>
          </fieldset>
          <fieldset class="form-group col">
              <label for="for_estate">Hora</label>
              <input type="time" class="form-control" name="end_hour" required>
          </fieldset>

          @can('Service Request: fulfillments responsable')
            @if($serviceRequest->Fulfillments->first()->responsable_approver_id == NULL)
              <fieldset class="form-group col">
                  <label for="for_estate"><br/></label>
                  <button type="submit" class="btn btn-primary form-control">Guardar</button>
              </fieldset>
            @else
              <fieldset class="form-group col">
                  <label for="for_estate"><br/></label>
                  <button type="submit" class="btn btn-primary form-control" disabled>Guardar</button>
              </fieldset>
            @endif
          @endcan

          @can('Service Request: fulfillments rrhh')
            @if($serviceRequest->Fulfillments->first()->rrhh_approver_id == NULL)
              <fieldset class="form-group col">
                  <label for="for_estate"><br/></label>
                  <button type="submit" class="btn btn-primary form-control">Guardar</button>
              </fieldset>
            @else
              <fieldset class="form-group col">
                  <label for="for_estate"><br/></label>
                  <button type="submit" class="btn btn-primary form-control" disabled>Guardar</button>
              </fieldset>
            @endif
          @endcan

          @can('Service Request: fulfillments finance')
            @if($serviceRequest->Fulfillments->first()->finances_approver_id == NULL)
              <fieldset class="form-group col">
                  <label for="for_estate"><br/></label>
                  <button type="submit" class="btn btn-primary form-control">Guardar</button>
              </fieldset>
            @else
              <fieldset class="form-group col">
                  <label for="for_estate"><br/></label>
                  <button type="submit" class="btn btn-primary form-control" disabled>Guardar</button>
              </fieldset>
            @endif
          @endcan

        </div>

      </form>

      <table class="table table-sm">
          <thead>
              <tr>
                  <th></th>
                  <th>Entrada</th>
                  <th>Salida</th>
                  <th>Observación</th>
              </tr>
          </thead>
          <tbody>
            @foreach($serviceRequest->Fulfillments->first()->FulfillmentItems as $key => $FulfillmentItem)
              <tr>
                <td>
                  @can('Service Request: fulfillments responsable')
                    <form method="POST" action="{{ route('rrhh.fulfillmentItem.destroy', $FulfillmentItem) }}" class="d-inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-outline-secondary btn-sm" onclick="return confirm('¿Está seguro de eliminar la información?');">
                        <span class="fas fa-trash-alt" aria-hidden="true"></span>
                      </button>
                    </form>
                  @endcan
                </td>
                <td>{{Carbon\Carbon::parse($FulfillmentItem->start_date)->format('d-m-Y H:i')}}</td>
                <td>{{Carbon\Carbon::parse($FulfillmentItem->end_date)->format('d-m-Y H:i')}}</td>
                <td>{{$FulfillmentItem->observation}}</td>
              </tr>
            @endforeach
          </tbody>
      </table>

    @endif

    @if($serviceRequest->Fulfillments->count() > 0)

    <div class="row">
      <fieldset class="form-group col-9">

      </fieldset>
      <fieldset class="form-group col">
          <label for="for_estate"><br/></label>

          @if($serviceRequest->Fulfillments->first()->responsable_approbation != NULL)
            <a type="button"
               class="btn btn-outline-success form-control"
               href="{{ route('rrhh.fulfillments.certificate-pdf',$serviceRequest->Fulfillments->first()) }}" target="_blank">
               Generar certificado
               <i class="fas fa-file"></i>
            </a>
          @endif

      </fieldset>
      <fieldset class="form-group col">
          <label for="for_estate"><br/></label>

            @can('Service Request: fulfillments responsable')
              @if($serviceRequest->Fulfillments->first()->responsable_approver_id == NULL)
                <a type="button"
                   class="btn btn-success form-control"
                   onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de confirmar?');"
                   href="{{ route('rrhh.fulfillments.confirmFulfillment',$serviceRequest->Fulfillments->first()) }}" >
                   Confirmar
                </a>
              @else
                <button type="submit" class="btn btn-success form-control" disabled>Confirmar</button>
              @endif
            @endcan

            @can('Service Request: fulfillments rrhh')
              @if($serviceRequest->Fulfillments->first()->rrhh_approver_id == NULL)
                <a type="button"
                   class="btn btn-success form-control"
                   onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de confirmar?');"
                   href="{{ route('rrhh.fulfillments.confirmFulfillment',$serviceRequest->Fulfillments->first()) }}" >
                   Confirmar
                </a>
              @else
                <button type="submit" class="btn btn-success form-control" disabled>Confirmar</button>
              @endif
            @endcan

            @can('Service Request: fulfillments finance')
              @if($serviceRequest->Fulfillments->first()->finances_approver_id == NULL)
                <a type="button"
                   class="btn btn-success form-control"
                   onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de confirmar?');"
                   href="{{ route('rrhh.fulfillments.confirmFulfillment',$serviceRequest->Fulfillments->first()) }}" >
                   Confirmar
                </a>
              @else
                <button type="submit" class="btn btn-success form-control" disabled>Confirmar</button>
              @endif
            @endcan

      </fieldset>
    </div>

    @if($serviceRequest->Fulfillments->first()->responsable_approver_id != NULL)
    <h5>Aprobaciones</h5>
    <table class="table table-sm small">
        <thead>
            <tr>
                <th>Unidad</th>
                <th>Fecha</th>
                <th>Usuario</th>
            </tr>
        </thead>
        <tbody>
            @if($serviceRequest->Fulfillments->first()->responsable_approver_id != NULL)
            <tr>
                <td>Responsable</td>
                <td>{{$serviceRequest->Fulfillments->first()->responsable_approbation_date}}</td>
                <td>{{$serviceRequest->Fulfillments->first()->responsableUser->getFullNameAttribute()}}</td>
            </tr>
            @endif
            @if($serviceRequest->Fulfillments->first()->rrhh_approver_id != NULL)
            <tr>
                <td>RRHH</td>
                <td>{{$serviceRequest->Fulfillments->first()->rrhh_approbation_date}}</td>
                <td>{{$serviceRequest->Fulfillments->first()->rrhhUser->getFullNameAttribute()}}</td>
            </tr>
            @endif
            @if($serviceRequest->Fulfillments->first()->finances_approver_id != NULL)
            <tr>
                <td>Finanzas</td>
                <td>{{$serviceRequest->Fulfillments->first()->finances_approbation_date}}</td>
                <td>{{$serviceRequest->Fulfillments->first()->financesUser->getFullNameAttribute()}}</td>
            </tr>
            @endif
        </tbody>
    </table>
    @endif

    @endif -->

  </div>
</div>

<br>
<div class="card">
  <div class="card-header">
    Aprobaciones de Solicitud
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="card-table table table-sm table-bordered small">
          <thead>
            <tr>
              <th scope="col">Fecha</th>
              <th scope="col">U.Organizacional</th>
              <th scope="col">Cargo</th>
              <th scope="col">Usuario</th>
              <th scope="col">Tipo</th>
              <th scope="col">Estado</th>
            </tr>
          </thead>
          <tbody>
            @foreach($serviceRequest->SignatureFlows->sortBy('sign_position') as $key => $SignatureFlow)
            @if($SignatureFlow->status === null)
              <tr class="bg-light">
            @elseif($SignatureFlow->status === 0)
              <tr class="bg-danger">
            @elseif($SignatureFlow->status === 1)
              <tr>
            @endif
               <td>{{ $SignatureFlow->signature_date}}</td>
               <td>{{ $SignatureFlow->organizationalUnit->name}}</td>
               <td>{{ $SignatureFlow->employee }}</td>
               <td>{{ $SignatureFlow->user->getFullNameAttribute() }}</td>
               <td>{{ $SignatureFlow->type }}</td>
               <td>@if($SignatureFlow->status === null)  @elseif($SignatureFlow->status === 1) Aceptada @elseif($SignatureFlow->status === 0) Rechazada @endif</td>
             </tr>

             @if($SignatureFlow->status === 0 && $SignatureFlow->observation != null)
             <tr>
               <td class="text-right" colspan="6">Observación rechazo: {{$SignatureFlow->observation}}</td>
             </tr>
             @endif
           @endforeach
          </tbody>
      </table>
      </div>
  </div>
</div>

<br>

@canany(['Service Request: fulfillments rrhh'])
<form method="POST" action="{{ route('rrhh.fulfillments.update',$serviceRequest->Fulfillments->first()) }}" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="card border-danger mb-3">
  <div class="card-header bg-danger text-white">
    Datos adicionales - RRHH
  </div>
    <div class="card-body">

      <div class="row">
        <fieldset class="form-group col-5 col-md-6">
            <label for="for_resolution_number">N° Resolución</label>
            <input type="text" class="form-control" disabled name="resolution_number" value="{{$serviceRequest->resolution_number}}">
        </fieldset>

        <fieldset class="form-group col-7 col-md-6">
            <label for="for_resolution_date">Fecha Resolución</label>
            <input type="date" class="form-control" disabled name="resolution_date" @if($serviceRequest->resolution_date) value="{{$serviceRequest->resolution_date->format('Y-m-d')}}" @endif>
        </fieldset>
      </div>

      <div class="form-row">

        <fieldset class="form-group col col-md">
            <label for="for_total_hours_paid">Total hrs. a pagar per.</label>
            <input type="text" class="form-control" name="total_hours_to_pay" value="{{$serviceRequest->Fulfillments->first()->total_hours_to_pay}}">
        </fieldset>

        <fieldset class="form-group col col-md">
            <label for="for_total_paid">Total a pagar</label>
            <input type="text" class="form-control" name="total_to_pay" value="{{$serviceRequest->Fulfillments->first()->total_to_pay}}">
        </fieldset>

      </div>
      <button type="submit" class="btn btn-danger">Guardar</button>
    </div>
</div>
</form>
@endcan

@canany(['Service Request: fulfillments finance'])
<form method="POST" action="{{ route('rrhh.fulfillments.update',$serviceRequest->Fulfillments->first()) }}" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="card border-info mb-3">
  <div class="card-header bg-info text-white">
    Datos adicionales - Finanzas
  </div>
    <div class="card-body">

      <div class="row">
        <fieldset class="form-group col-5 col-md-6">
            <label for="for_resolution_number">N° Resolución</label>
            <input type="text" class="form-control" disabled name="resolution_number" value="{{$serviceRequest->resolution_number}}">
        </fieldset>

        <fieldset class="form-group col-7 col-md-6">
            <label for="for_resolution_date">Fecha Resolución</label>
            <input type="date" class="form-control" disabled name="resolution_date" @if($serviceRequest->resolution_date) value="{{$serviceRequest->resolution_date->format('Y-m-d')}}" @endif>
        </fieldset>

        <fieldset class="form-group col col-md">
            <label for="for_total_hours_paid">Total hrs. a pagar per.</label>
            <input type="text" class="form-control" name="total_hours_to_pay" value="{{$serviceRequest->Fulfillments->first()->total_hours_to_pay}}" disabled>
        </fieldset>

        <fieldset class="form-group col col-md">
            <label for="for_total_paid">Total a pagar</label>
            <input type="text" class="form-control" name="total_to_pay" value="{{$serviceRequest->Fulfillments->first()->total_to_pay}}" disabled>
        </fieldset>
      </div>

      <div class="form-row">

        <fieldset class="form-group col-3 col-md-3">
            <label for="for_bill_number">N° Boleta</label>
            <input type="text" class="form-control" name="bill_number" value="{{$serviceRequest->Fulfillments->first()->bill_number}}">
        </fieldset>

        <fieldset class="form-group col-3 col-md-3">
            <label for="for_total_hours_paid">Tot. hrs pagadas per.</label>
            <input type="text" class="form-control" name="total_hours_paid" value="{{$serviceRequest->Fulfillments->first()->total_hours_paid}}">
        </fieldset>

        <fieldset class="form-group col-3 col-md-3">
            <label for="for_total_paid">Total pagado</label>
            <input type="text" class="form-control" name="total_paid" value="{{$serviceRequest->Fulfillments->first()->total_paid}}">
        </fieldset>

        <fieldset class="form-group col-3 col-md-3">
            <label for="for_payment_date">Fecha pago</label>
            <input type="date" class="form-control" name="payment_date" required @if($serviceRequest->Fulfillments->first()->payment_date) value="{{$serviceRequest->Fulfillments->first()->payment_date->format('Y-m-d')}}" @endif>
        </fieldset>

      </div>

      <button type="submit" class="btn btn-info">Guardar</button>

    </div>

</div>

<br>
</form>
@endcan
@endif




@endsection

@section('custom_js')

<script type="text/javascript">

	$(".add-row").click(function(){
      var type = $("#type").val();
      var shift_start_date = $("#shift_start_date").val();
      var start_hour = $("#start_hour").val();
			var shift_end_date = $("#shift_end_date").val();
			var end_hour = $("#end_hour").val();
			var observation = $("#observation").val();
      var markup = "<tr><td><input type='checkbox' name='record'></td><td> <input type='hidden' class='form-control' name='type[]' id='type' value='"+ type +"'>"+ type +"</td><td> <input type='hidden' class='form-control' name='shift_start_date[]' id='shift_start_date' value='"+ shift_start_date +"'>"+ shift_start_date +"</td><td> <input type='hidden' class='form-control' name='shift_start_hour[]' id='start_hour' value='"+ start_hour +"'>" + start_hour + "</td><td> <input type='hidden' class='form-control' name='shift_end_date[]' id='shift_end_date' value='"+ shift_end_date +"'>"+ shift_end_date +"</td><td> <input type='hidden' class='form-control' name='shift_end_hour[]' id='end_hour' value='"+ end_hour +"'>" + end_hour + "</td><td> <input type='hidden' class='form-control' name='shift_observation[]' id='observation' value='"+ observation +"'>" + observation + "</td></tr>";
      $("table tbody").append(markup);
  });

	// Find and remove selected table rows
  $(".delete-row").click(function(){
      $("table tbody").find('input[name="record"]').each(function(){
      	if($(this).is(":checked")){
              $(this).parents("tr").remove();
          }
      });
  });

  $('.for_type').on('change', function() {
    $('.start_date').attr('readonly', false);
    $(".start_date").val('');
    $('.start_hour').attr('readonly', false);
    $('.start_hour').val('');
    $('.end_date').attr('readonly', false);
    $(".end_date").val('');
    $('.end_hour').attr('readonly', false);
    $('.end_hour').val('');
    if (this.value == "Inasistencia Injustificada") {

    }
    if (this.value == "Licencia no covid") {
      $('.start_hour').attr('readonly', true);
      $('.end_hour').attr('readonly', true);
    }
    if (this.value == "Renuncia voluntaria") {
      $('.start_date').attr('readonly', true);
      $('.start_hour').attr('readonly', true);
      $('.end_hour').attr('readonly', true);
    }
    if (this.value == "Abandono de funciones") {
      $('.start_date').attr('readonly', true);
      $('.start_hour').attr('readonly', true);
      $('.end_hour').attr('readonly', true);
    }

    // start_date
    // start_hour
    // end_date
    // end_hour
  });



</script>

@endsection

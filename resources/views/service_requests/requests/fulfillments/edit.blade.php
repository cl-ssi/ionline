@extends('layouts.app')

@section('title', 'Cumplimiento de solicitud')

@section('content')

<h3>Cumplimiento de solicitud</h3>

<div class="form-row">

  <fieldset class="form-group col-12 col-md-4">
      <label for="for_request_date">ID Solicitud</label>
      <input type="text" class="form-control" value="{{$serviceRequest->id}}" disabled>
  </fieldset>

  <fieldset class="form-group col-12 col-md-4">
      <label for="for_start_date">Fecha de Inicio</label>
      <input type="text" class="form-control" value="{{\Carbon\Carbon::parse($serviceRequest->start_date)->format('Y-m-d')}}" disabled>
  </fieldset>

  <fieldset class="form-group col-12 col-md-4">
      <label for="for_end_date">Fecha de Término</label>
      <input type="text" class="form-control" value="{{\Carbon\Carbon::parse($serviceRequest->end_date)->format('Y-m-d')}}" disabled>
  </fieldset>

</div>

<div class="form-row">

  <fieldset class="form-group col-12 col-md-4">
      <label for="for_request_date">Rut</label>
      <input type="text" class="form-control" value="{{$serviceRequest->rut}}" disabled>
  </fieldset>

  <fieldset class="form-group col-12 col-md-4">
      <label for="for_start_date">Nombre</label>
      <input type="text" class="form-control" value="{{$serviceRequest->name}}" disabled>
  </fieldset>

  <fieldset class="form-group col-12 col-md-4">
      <label for="for_end_date">Tipo de contrato</label>
      <input type="text" class="form-control" value="{{$serviceRequest->program_contract_type}}" disabled>
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

      <hr>

      <h4>Inasistencias</h4>

      <form method="POST" action="{{ route('rrhh.fulfillmentItem.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="row">

          <input type="hidden" name="fulfillment_id" value="{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->id}}">

          <fieldset class="form-group col">
      		    <label for="for_type">Tipo</label>
      		    <select name="type" id="type" class="form-control" required>
                <option value=""></option>
      					<option value="Inasistencia Injustificada">INASISTENCIA INJUSTIFICADA</option>
                <option value="Licencia no covid">LICENCIA NO COVID</option>
                <option value="Renuncia voluntaria - abandono de funciones">RENUNCIA VOLUNTARIA - ABANDONO DE FUNCIONES</option>
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
                  <td>{{$FulfillmentItem->start_date->format('Y-m-d H:i')}}</td>
                  <td>{{$FulfillmentItem->end_date->format('Y-m-d H:i')}}</td>
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
            @endif

        </fieldset>
        <fieldset class="form-group col">
            <label for="for_estate"><br/></label>
            <form>

              @can('Service Request: fulfillments responsable')

                    @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->responsable_approver_id == NULL)
                  <a type="button"
                     class="btn btn-success form-control"
                     onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de confirmar?');"
                     href="{{ route('rrhh.fulfillments.confirmFulfillment',$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()) }}" >
                     Confirmar
                  </a>
                @else
                  <button type="submit" class="btn btn-success form-control" disabled>Confirmar</button>
                @endif
              @endcan

              @can('Service Request: fulfillments rrhh')
                @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->rrhh_approver_id == NULL)
                  <a type="button"
                     class="btn btn-success form-control"
                     onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de confirmar?');"
                     href="{{ route('rrhh.fulfillments.confirmFulfillment',$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()) }}" >
                     Confirmar
                  </a>
                @else
                  <button type="submit" class="btn btn-success form-control" disabled>Confirmar</button>
                @endif
              @endcan

              @can('Service Request: fulfillments finance')



                @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->finances_approver_id == NULL)
                  <a type="button"
                     class="btn btn-success form-control"
                     onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de confirmar?');"
                     href="{{ route('rrhh.fulfillments.confirmFulfillment',$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()) }}" >
                     Confirmar
                  </a>
                @else
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
              </tr>
          </thead>
          <tbody>
              @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->responsable_approver_id != NULL)
              <tr>
                  <td>Responsable</td>
                  <td>{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->responsable_approbation_date}}</td>
                  <td>{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->responsableUser->getFullNameAttribute()}}</td>
              </tr>
              @endif
              @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->rrhh_approver_id != NULL)
              <tr>
                  <td>RRHH</td>
                  <td>{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->rrhh_approbation_date}}</td>
                  <td>{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->rrhhUser->getFullNameAttribute()}}</td>
              </tr>
              @endif
              @if($serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->finances_approver_id != NULL)
              <tr>
                  <td>Finanzas</td>
                  <td>{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->finances_approbation_date}}</td>
                  <td>{{$serviceRequest->Fulfillments->where('year',$period->format("Y"))->where('month',$period->format("m"))->first()->financesUser->getFullNameAttribute()}}</td>
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

    @if($serviceRequest->Fulfillments->count() == 0)

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
                    <!-- <th>H.Inicio</th> -->
                    <th>Salida</th>
                    <!-- <th>H.Término</th> -->
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

    @endif

  </div>
</div>

@endif

<br>



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

</script>

@endsection

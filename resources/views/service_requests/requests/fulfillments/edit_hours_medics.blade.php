@foreach($serviceRequest->fulfillments as $fulfillment)

<div class="card border-dark">
  <div class="card-header">
    Período <b>{{$fulfillment->year}}-{{$fulfillment->month}}</b>
  </div>
  <div class="card-body">

    <h4>Información del período</h4>

      <form method="POST" action="{{ route('rrhh.fulfillments.update',$fulfillment) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="row">

        <fieldset class="form-group col">
            <label for="for_type">Período</label>
            <select name="type" class="form-control" required>
              <option value=""></option>
              <option value="Mensual" @if($fulfillment->type == "Mensual") selected @endif>Mensual</option>
              <option value="Parcial" @if($fulfillment->type == "Parcial") selected @endif>Parcial</option>
              <option value="Horas" @if($fulfillment->type == "Horas") selected @endif>Horas</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="for_estate">Inicio</label>
            <input type="date" class="form-control" name="start_date" value="{{$fulfillment->start_date->format('Y-m-d')}}" required>
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="for_estate">Término</label>
            <input type="date" class="form-control" name="end_date" value="{{$fulfillment->end_date->format('Y-m-d')}}" required>
        </fieldset>

        <fieldset class="form-group col">
            <label for="for_estate">Observación</label>
            <input type="text" class="form-control" name="observation" value="{{$fulfillment->observation}}">
        </fieldset>

        @can('Service Request: fulfillments responsable')
          @if($fulfillment->responsable_approver_id == NULL)
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
          @if($fulfillment->rrhh_approver_id == NULL)
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
          @if($fulfillment->finances_approver_id == NULL)
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
      <form method="POST" action="{{ route('rrhh.fulfillments.update',$fulfillment) }}" enctype="multipart/form-data">
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

              <!-- @if($fulfillment->year == 2021 && $fulfillment->month == 1 && $fulfillment->total_to_pay != NULL)
                <fieldset class="form-group col col-md">
                    <label for="for_total_hours_paid">Total hrs. a pagar per.</label>
                    <input type="text" class="form-control" name="total_hours_to_pay" disabled value="{{$fulfillment->total_hours_to_pay}}">
                </fieldset>

                <fieldset class="form-group col col-md">
                    <label for="for_total_paid">Total a pagar</label>
                    <input type="text" class="form-control" name="total_to_pay" disabled value="{{$fulfillment->total_to_pay}}">
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
              @endif -->

              <fieldset class="form-group col col-md">
                  <label for="for_total_hours_paid">Total hrs. a pagar per.</label>
                  <input type="text" class="form-control" name="total_hours_to_pay" value="{{$fulfillment->total_hours_to_pay}}">
              </fieldset>

              <fieldset class="form-group col col-md">
                  <label for="for_total_paid">Total a pagar</label>
                  <input type="text" class="form-control" name="total_to_pay" value="{{$fulfillment->total_to_pay}}">
              </fieldset>

            </div>
            <button type="submit" class="btn btn-danger">Guardar</button>
          </div>
      </div>
      </form>
      @endcan


      <!-- información adicional finanzas -->

      @canany(['Service Request: fulfillments finance'])
      <form method="POST" action="{{ route('rrhh.fulfillments.update',$fulfillment) }}" enctype="multipart/form-data">
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
                  <input type="text" class="form-control" name="total_hours_to_pay" disabled value="{{$fulfillment->total_hours_to_pay}}">
              </fieldset>

              <fieldset class="form-group col col-md">
                  <label for="for_total_paid">Total a pagar</label>
                  <input type="text" class="form-control" name="total_to_pay" disabled value="{{$fulfillment->total_to_pay}}">
              </fieldset>

            </div>

            <div class="form-row">

              <fieldset class="form-group col col-md">
                  <label for="for_bill_number">N° Boleta</label>
                  <input type="text" class="form-control" name="bill_number" value="{{$fulfillment->bill_number}}">
              </fieldset>

              <fieldset class="form-group col col-md">
                  <label for="for_total_hours_paid">Tot. hrs pagadas per.</label>
                  <input type="text" class="form-control" name="total_hours_paid" value="{{$fulfillment->total_hours_paid}}">
              </fieldset>

              <fieldset class="form-group col col-md">
                  <label for="for_total_paid">Total pagado</label>
                  <input type="text" class="form-control" name="total_paid" value="{{$fulfillment->total_paid}}">
              </fieldset>

              <fieldset class="form-group col col-md">
                  <label for="for_payment_date">Fecha pago</label>
                  <input type="date" class="form-control" name="payment_date" required @if($fulfillment->payment_date) value="{{$fulfillment->payment_date->format('Y-m-d')}}" @endif>
              </fieldset>

              <fieldset class="form-group col col-md">
          			<label for="for_contable_month">Mes contable pago</label>
          			<select name="contable_month" class="form-control" required>
          				<option value=""></option>
          				<option value="1" @if($fulfillment->contable_month == 1) selected @endif>Enero</option>
          				<option value="2" @if($fulfillment->contable_month == 2) selected @endif>Febrero</option>
          				<option value="3" @if($fulfillment->contable_month == 3) selected @endif>Marzo</option>
          				<option value="4" @if($fulfillment->contable_month == 4) selected @endif>Abril</option>
          				<option value="5" @if($fulfillment->contable_month == 5) selected @endif>Mayo</option>
          				<option value="6" @if($fulfillment->contable_month == 6) selected @endif>Junio</option>
          				<option value="7" @if($fulfillment->contable_month == 7) selected @endif>Julio</option>
                  <option value="8" @if($fulfillment->contable_month == 8) selected @endif>Agosto</option>
                  <option value="9" @if($fulfillment->contable_month == 9) selected @endif>Septiembre</option>
                  <option value="10" @if($fulfillment->contable_month == 10) selected @endif>Octubre</option>
                  <option value="11" @if($fulfillment->contable_month == 11) selected @endif>Noviembre</option>
                  <option value="12" @if($fulfillment->contable_month == 12) selected @endif>Diciembre</option>
          			</select>
          		</fieldset>
            </div>
            <button type="submit" class="btn btn-info">Guardar</button>
          </div>
      </div>
      </form>
      @endcan



      <hr>

      <h4>Turnos extra</h4>

      <form method="POST" action="{{ route('rrhh.fulfillmentItem.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="row">

          <input type="hidden" name="fulfillment_id" value="{{$fulfillment->id}}">

          <fieldset class="form-group col">
      		    <label for="for_type">Tipo</label>
      		    <select name="type" class="form-control for_type" required>
      					<option value="Turno">TURNO EXTRA</option>
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
            @if($fulfillment->responsable_approver_id == NULL)
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
            @if($fulfillment->rrhh_approver_id == NULL)
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
            @if($fulfillment->finances_approver_id == NULL)
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
            @foreach($fulfillment->FulfillmentItems as $key => $FulfillmentItem)
              <tr>
                  <td>
                    @can('Service Request: fulfillments responsable')
                      @if($fulfillment->responsable_approver_id == NULL)
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
      @livewire('service-request.show-total-hours', ['fulfillment' => $fulfillment])

      <div class="row">
        <fieldset class="form-group col">
            @if($fulfillment->responsable_approbation != NULL)
              <a type="button"
                 class="btn btn-outline-success form-control"
                 href="{{ route('rrhh.fulfillments.certificate-pdf',$fulfillment) }}" target="_blank">
                 Generar certificado
                 <i class="fas fa-file"></i>
              </a>

                {{--modal firmador--}}
                @if(Auth::user()->can('Service Request: sign document'))
                    @php
                        $idModelModal = $fulfillment->id;
                        $routePdfSignModal = "/rrhh/fulfillments/certificate-pdf/$idModelModal";
                        $returnUrlSignModal = "rrhh.fulfillments.edit_fulfillment";
                    @endphp
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
              @can('Service Request: fulfillments responsable')
                    @if($fulfillment->responsable_approver_id == NULL)

                  <a type="button"
                     class="btn btn-danger form-control"
                     onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de rechazar?');"
                     href="{{ route('rrhh.fulfillments.refuseFulfillment',$fulfillment) }}" >
                     Rechazar
                  </a>
                  <a type="button"
                     class="btn btn-success form-control"
                     onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de confirmar?');"
                     href="{{ route('rrhh.fulfillments.confirmFulfillment',$fulfillment) }}" >
                     Confirmar
                  </a>
                @else
                  <button type="submit" class="btn btn-danger form-control" disabled>Rechazar</button>
                  <button type="submit" class="btn btn-success form-control" disabled>Confirmar</button>
                @endif
              @endcan

              @can('Service Request: fulfillments rrhh')
                @if($fulfillment->rrhh_approver_id == NULL)
                  <a type="button"
                     class="btn btn-danger form-control"
                     onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de rechazar?');"
                     href="{{ route('rrhh.fulfillments.refuseFulfillment',$fulfillment) }}" >
                     Rechazar
                  </a>
                  <a type="button"
                     class="btn btn-success form-control"
                     onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de confirmar?');"
                     href="{{ route('rrhh.fulfillments.confirmFulfillment',$fulfillment) }}" >
                     Confirmar
                  </a>
                @else
                  <button type="submit" class="btn btn-danger form-control" disabled>Rechazar</button>
                  <button type="submit" class="btn btn-success form-control" disabled>Confirmar</button>
                @endif
              @endcan

              @can('Service Request: fulfillments finance')
                @if($fulfillment->finances_approver_id == NULL)
                  <a type="button"
                     class="btn btn-danger form-control"
                     onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de rechazar?');"
                     href="{{ route('rrhh.fulfillments.refuseFulfillment',$fulfillment) }}" >
                     Rechazar
                  </a>
                  <a type="button"
                     class="btn btn-success form-control"
                     onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de confirmar?');"
                     href="{{ route('rrhh.fulfillments.confirmFulfillment',$fulfillment) }}" >
                     Confirmar
                  </a>
                @else
                  <button type="submit" class="btn btn-danger form-control" disabled>Rechazar</button>
                  <button type="submit" class="btn btn-success form-control" disabled>Confirmar</button>
                @endif

              @endcan

        </fieldset>
      </div>

      <div class="row">
        <div class="col-12 col-md-5">
          <strong>Cargar Resolución:</strong>
          @livewire('service-request.upload-resolution', ['fulfillment' => $fulfillment])
        </div>
        <div class="col-12 col-md-5">
          <strong>Cargar Boleta:</strong>
          @livewire('service-request.upload-invoice', ['fulfillment' => $fulfillment])
        </div>
      </div>

      @if($fulfillment->responsable_approver_id != NULL)
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
              @if($fulfillment->responsable_approver_id != NULL)
              <tr>
                  <td>Responsable</td>
                  <td>{{$fulfillment->responsable_approbation_date}}</td>
                  <td>{{$fulfillment->responsableUser->getFullNameAttribute()}}</td>
                  <td>@if($fulfillment->responsable_approbation === 1) APROBADO @else RECHAZADO @endif</td>
              </tr>
              @endif
              @if($fulfillment->rrhh_approver_id != NULL)
              <tr>
                  <td>RRHH</td>
                  <td>{{$fulfillment->rrhh_approbation_date}}</td>
                  <td>{{$fulfillment->rrhhUser->getFullNameAttribute()}}</td>
                  <td>@if($fulfillment->rrhh_approbation === 1) APROBADO @else RECHAZADO @endif</td>
              </tr>
              @endif
              @if($fulfillment->finances_approver_id != NULL)
              <tr>
                  <td>Finanzas</td>
                  <td>{{$fulfillment->finances_approbation_date}}</td>
                  <td>{{$fulfillment->financesUser->getFullNameAttribute()}}</td>
                  <td>@if($fulfillment->finances_approbation === 1) APROBADO @else RECHAZADO @endif</td>
              </tr>
              @endif
          </tbody>
      </table>
      @endif

  </div>
</div>

<br>

@endforeach

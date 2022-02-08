@extends('layouts.app')

@section('title', 'Pendientes de pago')

@section('content')
<div class="d-print-none">
@include('service_requests.partials.nav')
</div>
<h4 class="mb-3">Pendientes de pago</h4>

<div class="alert alert-warning" role="alert">
  A todos los pagos aceptados, se debe cargar la información de pago para cerrar el proceso en el símbolo de $ de color verde, de lo contario quedaran en la bandeja como pendientes
</div>

<form method="GET" class="form-horizontal" action="{{ route('rrhh.service-request.report.to-pay') }}">

<div class="form-group">

		<div class="form-row">
			<div class="form-group col-12 col-md-2">
				<label>Establecimiento</label>
        <select class="form-control" name="establishment_id">
          <option value="">Todos</option>
          <option value="1" @if($request->establishment_id == 1) selected @endif>Hospital Ernesto Torres Galdames</option>
          <option value="12" @if($request->establishment_id == 12) selected @endif>Dr. Héctor Reyno G.</option>
          <option value="38" @if($request->establishment_id === 0) selected @endif>Dirección SSI</option>
        </select>
      </div>
      <div class="form-group col-12 col-md-2">
        <label>Tipo de Contrato</label>
        <select class="form-control" name="type">
          <option value=""></option>
          <option value="Covid" @if($request->input('type')=='Covid') selected @endif>Covid</option>
          <option value="Suma Alzada" @if($request->input('type')=='Suma Alzada') selected @endif>Suma Alzada</option>
        </select>
      </div>
      <div class="form-group col-9 col-md-2">
        <label>Estado de aprobacion</label>
        <select class="form-control" name="type" disabled>
          <option value=""></option>
          <option value="aprobado">Aprobado</option>
          <option value="pendiente">Pendiente</option>
          <option value="rechazado">Rechazado</option>
        </select>
      </div>

      <div class="form-group col-9 col-md-2">
        <label>Programa</label>
        <select name="programm_name" class="form-control">
          <option value="">Todos</option>
          <option value="Covid19-APS No Médicos" @if($request->programm_name == 'Covid19-APS No Médicos') selected @endif >Covid19-APS No Médicos</option>
          <option value="Covid19-APS Médicos" @if($request->programm_name == 'Covid19-APS Médicos') selected @endif>Covid19-APS Médicos</option>
          <option value="Covid19 No Médicos" @if($request->programm_name == 'Covid19 No Médicos') selected @endif>Covid19 No Médicos</option>
          <option value="Covid19 Médicos" @if($request->programm_name == 'Covid19 Médicos') selected @endif>Covid19 Médicos</option>

          @if(Auth::user()->organizationalUnit->establishment_id == 1)
          <option value="Covid 2022" @if($request->programm_name == 'Covid 2022') selected @endif>Covid 2022</option>
          <option value="CONSULTORIO DE LLAMADA" @if($request->programm_name == 'CONSULTORIO DE LLAMADA') selected @endif>CONSULTORIO DE LLAMADA</option>
          <option value="33 MIL HORAS" @if($request->programm_name == '33 MIL HORAS') selected @endif>33 MIL HORAS</option>
          <option value="DFL" @if($request->programm_name == 'DFL') selected @endif>DFL</option>
          <option value="TURNOS VACANTES" @if($request->programm_name == 'TURNOS VACANTES') selected @endif>TURNOS VACANTES</option>
          <option value="OTROS PROGRAMAS HETG" @if($request->programm_name == 'OTROS PROGRAMAS HETG') selected @endif>OTROS PROGRAMAS HETG</option>
          <option value="CAMPAÑA INVIERNO" @if($request->programm_name == 'CAMPAÑA INVIERNO') selected @endif>CAMPAÑA INVIERNO</option>
          <option value="PABELLON TARDE" @if($request->programm_name == 'PABELLON TARDE') selected @endif>PABELLON TARDE</option>
          <option value="PABELLON GINE" @if($request->programm_name == 'PABELLON GINE') selected @endif>PABELLON GINE</option>
          <option value="TURNO DE RESIDENCIA" @if($request->programm_name == 'TURNO DE RESIDENCIA') selected @endif>TURNO DE RESIDENCIA</option>
          <option value="SENDA" @if($request->programm_name == 'SENDA') selected @endif>SENDA</option>

          @else
          <option value="PRAPS" @if($request->programm_name == 'PRAPS') selected @endif>PRAPS</option>
          <option value="PESPI" @if($request->programm_name == 'PESPI') selected @endif>PESPI</option>
          <option value="CHILE CRECE CONTIGO" @if($request->programm_name == 'CHILE CRECE CONTIGO') selected @endif>CHILE CRECE CONTIGO</option>
          <option value="OTROS PROGRAMAS SSI" @if($request->programm_name == 'OTROS PROGRAMAS SSI') selected @endif>OTROS PROGRAMAS SSI</option>
          <option value="LISTA ESPERA" @if($request->programm_name == 'LISTA ESPERA') selected @endif>LISTA ESPERA</option>
          <option value="CAMPAÑA INVIERNO" @if($request->programm_name == 'CAMPAÑA INVIERNO') selected @endif>CAMPAÑA INVIERNO</option>

          <option value="ADP DIRECTOR" @if($request->programm_name == 'ADP DIRECTOR') selected @endif>ADP DIRECTOR</option>
          <option value="SENDA" @if($request->programm_name == 'SENDA') selected @endif>SENDA</option>
          <option value="LEY DE ALCOHOL" @if($request->programm_name == 'LEY DE ALCOHOL') selected @endif>LEY DE ALCOHOL</option>
          <option value="SENDA UHCIP" @if($request->programm_name == 'SENDA UHCIP') selected @endif>SENDA UHCIP</option>
          <option value="SENDA PSIQUIATRIA ADULTO" @if($request->programm_name == 'SENDA PSIQUIATRIA ADULTO') selected @endif>SENDA PSIQUIATRIA ADULTO</option>
          <option value="SENADIS" @if($request->programm_name == 'SENADIS') selected @endif>SENADIS</option>
          <option value="SUBT.31" @if($request->programm_name == 'SUBT.31') selected @endif>SUBT.31</option>
          @endif

        </select>
      </div>

			<div class="form-group col-3 col-md-4">
        <label>&nbsp;</label>
				<button type="submit" class="btn btn-primary form-control"><i class="fas fa-search"></i> Buscar</button>
			</div>
		</div>

    <div class="col-2">
    	@if($request->establishment_id)
      	<a class="btn btn-outline-success" href="{{route('rrhh.service-request.report.bank-payment-file',$request->establishment_id)}}">
        	<i class="fas fa-file"></i>Archivo de pago banco
		</a>
      	@endif
    </div>
</div>

</form>

<hr>

  <table class="table table-sm table-responsive-xl table-bordered table-stripped">
    <tr>
        <th>Id</th>
        <th>Estab</th>
        <th>Centro de Resp</th>
        <th>Tipo de Contrato</th>
        <th>Programa</th>
        <th>Periodo</th>
        <th>Tipo/Jornada</th>
        <th>Nombre</th>
        <th nowrap>Rut</th>
        <th>Banco - N° Cuenta</th>
        <th>Telefono</th>
        <th class="d-print-none">Hitos</th>
        @canany(['Service Request: fulfillments finance'])
          <th width="250" >Aprobación de pago </th>
        @endcanany
    </tr>
    @foreach($topay_fulfillments as $key => $fulfillment)
      <tr>
          <td>{{$fulfillment->serviceRequest->id}}
          <a href="{{ route('rrhh.service-request.fulfillment.edit',$fulfillment->serviceRequest) }}" title="Editar">
      					<span class="fas fa-edit" aria-hidden="true"></span>
      				</a>
          </td>
          <td class="small">{{$fulfillment->serviceRequest->establishment->name}}</td>
          <td class="small">{{$fulfillment->serviceRequest->responsabilityCenter->name ?? ''}}</td>
          <td>{{$fulfillment->serviceRequest->type ?? ''}}</td>
          <td>{{$fulfillment->serviceRequest->programm_name}}</td>
          <td>
            @if($fulfillment->year)
              {{ $fulfillment->year }}-{{ $fulfillment->month }}
            @else
              {{ $fulfillment->start_date->format('Y-m') }}
            @endif
          </td>
          <td>
            {{$fulfillment->serviceRequest->program_contract_type}}
            <br>
            {{$fulfillment->serviceRequest->working_day_type}}
          </td>
          <td>{{$fulfillment->serviceRequest->employee->fullName}}</td>
          <td nowrap>{{$fulfillment->serviceRequest->employee->runFormat()}}</td>

          <td class="small">{{$fulfillment->serviceRequest->employee->bankAccount->bank->name ?? ''}} - {{$fulfillment->serviceRequest->employee->bankAccount->number?? ''}}</td>
          <td>{{$fulfillment->serviceRequest->phone_number ?? ''}}</td>
          <td nowrap class="d-print-none">
            @if($fulfillment->serviceRequest->has_resolution_file)
              <a href="{{route('rrhh.service-request.fulfillment.download_resolution', $fulfillment->serviceRequest)}}"
                 target="_blank" title="Resolución">
                 <i class="fas fa-file-signature"></i>
              </a>
            @endif
            @if($fulfillment->signatures_file_id)
              <a href="{{ route('rrhh.service-request.fulfillment.signed-certificate-pdf',$fulfillment) }}" target="_blank" title="Certificado">
                <i class="fas fa-certificate"></i>
              </a>
            @else
              <a href="{{ route('rrhh.service-request.fulfillment.certificate-pdf',$fulfillment) }}" target="_blank" title="Certificado">
                <i class="fas fa-paperclip"></i>
              </a>
            @endif

            @if($fulfillment->has_invoice_file)
              <a href="{{route('rrhh.service-request.fulfillment.download_invoice', [$fulfillment, time()])}}"
                 target="_blank" title="Boleta" >
                 <i class="fas fa-file-invoice-dollar"></i>
              </a>
            @endif

              <button class="btn btn-link pt-0" title="Editar Pago" data-toggle="modal"
                      data-target="#editModal"
                      data-fulfillment_id="{{ $fulfillment->id }}"
                      data-service_request_id="{{ $fulfillment->serviceRequest->id }}"
                      data-bill_number = "{{$fulfillment->bill_number}}"
                      data-total_hours_paid = "{{$fulfillment->total_hours_paid}}"
                      data-total_paid = "{{$fulfillment->total_paid}}"
                      data-payment_date = "{{ ($fulfillment->payment_date) ? $fulfillment->payment_date->format('Y-m-d') : ''}}"
                      data-contable_month = "{{$fulfillment->contable_month}}"
                      data-formaction="{{ route('rrhh.service-request.fulfillment.update-paid-values')}}">
                  <i class="fas fa-dollar-sign text-success"></i>
                </button>

          </td>
          @canany(['Service Request: fulfillments finance'])
            <td>
              @livewire('service-request.payment-ready-toggle', ['fulfillment' => $fulfillment])
            </td>
          @endcanany
      </tr>
    @endforeach
</table>


<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form method="post" id="form-edit" >
                <div class="modal-body">
                    @csrf
                    @method('POST')

                    <input type="hidden" name="fulfillment_id">
                    <div class="form-row">
                        <fieldset class="form-group col col-md-2">
                            <label for="for_bill_number">N° Boleta</label>
                            <input type="text" class="form-control mt-4" name="bill_number" >
                        </fieldset>
                        <fieldset class="form-group col col-md-2">
                            <label for="for_total_hours_paid">Tot. hrs pagadas per.</label>
                            <input type="text" class="form-control" name="total_hours_paid" >
                        </fieldset>
                        <fieldset class="form-group col col-md-2">
                            <label for="for_total_paid">Total pagado</label>
                            <input type="text" class="form-control mt-4" name="total_paid" >
                        </fieldset>
                        <fieldset class="form-group col col-md-3">
                            <label for="for_payment_date">Fecha pago</label>
                            <input type="date" class="form-control mt-4" name="payment_date" required >
                        </fieldset>
                        <fieldset class="form-group col col-md-3">
                            <label for="for_contable_month">Mes contable pago</label>
                            <select name="contable_month" class="form-control mt-4" required>
                                <option value=""></option>
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                        </fieldset>
                    </div>

{{--                    <div class="form-group">--}}
{{--                        <label for="name" class="col-form-label">Nombre:</label>--}}
{{--                        <input type="text" class="form-control" name="name">--}}
{{--                    </div>--}}
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('custom_js')

    <script type="text/javascript">
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var modal = $(this)

            modal.find('.modal-title').text('Editando ' + button.data('service_request_id'))
            modal.find('input[name="fulfillment_id"]').val(button.data('fulfillment_id'))
            modal.find('input[name="bill_number"]').val(button.data('bill_number'))
            modal.find('input[name="total_hours_paid"]').val(button.data('total_hours_paid'))
            modal.find('input[name="total_paid"]').val(button.data('total_paid'))
            modal.find('input[name="payment_date"]').val(button.data('payment_date'))
            modal.find('select[name="contable_month"]').val(button.data('contable_month'))

            var formaction  = button.data('formaction')
            modal.find("#form-edit").attr('action', formaction)
        })
    </script>

@endsection

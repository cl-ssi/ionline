@foreach($serviceRequest->fulfillments as $fulfillment)
<div class="card border-dark">
	<div class="card-header">
		<h4>Información del período: {{$fulfillment->year}}-{{$fulfillment->month}} ({{Carbon\Carbon::parse($fulfillment->year . "-" . $fulfillment->month)->monthName}}) <span class="small text-muted float-right">{{ $fulfillment->id}}</span> </h4>
	</div>

	<div class="card-header">
		<h5>Archivos Adjuntos (opcional)</h5>
		<div class="card-body">
			@if($fulfillment->attachments->count() > 0)
			<table class="table small table-striped table-bordered">
				<thead class="text-center">

					<tr>
						<td style="width: 11%">Fecha de Carga</td>
						<th>Nombre</th>
						<th>Archivo</th>
						<th style="width: 10%"></th>
						<th style="width: 2%"></th>
					</tr>
				</thead>
				<tbody>
					@foreach($fulfillment->attachments as $attachment)
					<tr>
						<td>{{ $attachment->updated_at->format('d-m-Y H:i:s') }}</td>
						<td class="text-center">{{ $attachment->name ?? '' }}</td>
						<td class="text-center">
							@if(pathinfo($attachment->file, PATHINFO_EXTENSION) == 'pdf')
							<i class="fas fa-file-pdf fa-2x"></i>
							@endif
						</td>
						<td>
							<a href="{{ route('rrhh.service-request.fulfillment.attachment.show', $attachment) }}" class="btn btn-outline-secondary btn-sm" title="Ir" target="_blank"> <i class="far fa-eye"></i></a>
							<a class="btn btn-outline-secondary btn-sm" href="{{ route('rrhh.service-request.fulfillment.attachment.download', $attachment) }}" target="_blank"><i class="fas fa-download"></i>
							</a>
						</td>
						<td>
							<form method="POST" class="form-horizontal" action="{{ route('rrhh.service-request.fulfillment.attachment.destroy', $attachment) }}">
								@csrf
								@method('DELETE')
								<button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Está seguro que desea eliminar este archivo adjunto?')">
									<i class="fas fa-trash"></i>
								</button>

							</form>
						</td>

					</tr>
					@endforeach
				</tbody>
			</table>
			@endif

		</div>
		<div>
			@livewire('service-request.attachments-fulfillments', ['var' => $fulfillment->id])
		</div>
	</div>

	<div class="card-body">
		<form method="POST" action="{{ route('rrhh.service-request.fulfillment.update',$fulfillment) }}" enctype="multipart/form-data">
			@csrf
			@method('PUT')
			<div class="form-row">
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
			</div>
			<div class="form-row">
				<fieldset class="form-group col">
					<label for="for_backup_assistance">Respaldo de asistencia</label>
					<input type="file" name="backup_assistance" value="{{$fulfillment->backup_assistance}}">
				</fieldset>
				@if($fulfillment->backup_assistance)
				<a href="https://storage.googleapis.com/{{env('APP_ENV') === 'production' ? 'saludiquique-storage' : 'saludiquique-dev'}}/{{$fulfillment->backup_assistance}}" class="btn btn-sm btn-outline-secondary" target="_blank" title="Ver respaldo asistencia">
					<span class="fas fa-file" aria-hidden="true"></span>
				</a>
				@endif

				@can('Service Request: fulfillments responsable')
				@if($fulfillment->responsable_approver_id == NULL)
				<fieldset class="form-group col">
					<label for="for_estate"><br /></label>
					<button type="submit" class="btn btn-primary">Guardar</button>
				</fieldset>
				@else
				<fieldset class="form-group col">
					<label for="for_estate"><br /></label>
					<button type="submit" class="btn btn-primary" disabled>Guardar</button>
				</fieldset>
				@endif
				@endcan

				@can('Service Request: fulfillments rrhh')
				@if($fulfillment->rrhh_approver_id == NULL)
				<fieldset class="form-group col">
					<label for="for_estate"><br /></label>
					<button type="submit" class="btn btn-primary">Guardar</button>
				</fieldset>
				@else
				<fieldset class="form-group col">
					<label for="for_estate"><br /></label>
					<button type="submit" class="btn btn-primary" disabled>Guardar</button>
				</fieldset>
				@endif
				@endcan

				@can('Service Request: fulfillments finance')
				@if($fulfillment->finances_approver_id == NULL)
				<fieldset class="form-group col">
					<label for="for_estate"><br /></label>
					<button type="submit" class="btn btn-primary">Guardar</button>
				</fieldset>
				@else
				<fieldset class="form-group col">
					<label for="for_estate"><br /></label>
					<button type="submit" class="btn btn-primary" disabled>Guardar</button>
				</fieldset>
				@endif
				@endcan

			</div>
		</form>

		<hr>

		<h4>Turnos extra</h4>
		@livewire('service-request.shifts-control', ['fulfillment' => $fulfillment])
		<br>
		<!-- <form method="POST" action="{{ route('rrhh.service-request.fulfillment.item.store') }}" enctype="multipart/form-data">
			@csrf
			<div class="form-row">
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
			<div class="form-row">
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
						<form method="POST" action="{{ route('rrhh.service-request.fulfillment.item.destroy', $FulfillmentItem) }}" class="d-inline">
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
		</table>-->

		@livewire('service-request.show-total-hours', ['fulfillment' => $fulfillment])

		<br>

		<div class="form-row mt-3">
			<fieldset class="form-group col">
				@if($fulfillment->responsable_approbation != NULL)
				<a type="button" class="btn btn-outline-primary" href="{{ route('rrhh.service-request.fulfillment.certificate-pdf',$fulfillment) }}" target="_blank">
					Ver certificado <i class="fas fa-file"></i>
				</a>
				@if($fulfillment->signatures_file_id)
				<a class="btn btn-info" href="{{ route('rrhh.service-request.fulfillment.signed-certificate-pdf',[$fulfillment, time()]) }}" target="_blank" title="Certificado">
					Certificado firmado<i class="fas fa-signature"></i>
				</a>
				@else

				{{--modal firmador--}}

				@php
				$idModelModal = $fulfillment->id;
				$routePdfSignModal = "/rrhh/service-request/fulfillment/certificate-pdf/$idModelModal/".auth()->id();
				$routeCallbackSignModal = 'documents.callbackFirma';
				@endphp

				@include('documents.signatures.partials.sign_file')
				<button type="button" data-toggle="modal" class="btn btn-outline-info" data-target="#signPdfModal{{$idModelModal}}" title="Firmar">
					Firmar certificado <i class="fas fa-signature"></i>
				</button>
				@endif
				@endif
			</fieldset>
			<fieldset class="form-group col-md-6 text-right">
				@can('Service Request: fulfillments responsable')
				@if(Auth::user()->id == $serviceRequest->signatureFlows->where('sign_position',2)->first()->responsable_id or App\Rrhh\Authority::getAmIAuthorityFromOu(now(),['manager'],Auth::user()->id))
				@if($fulfillment->responsable_approver_id == NULL)
				<a type="button" class="btn btn-danger" onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de rechazar?');" href="{{ route('rrhh.service-request.fulfillment.refuse-Fulfillment',$fulfillment) }}">
					Rechazar
				</a>
				<a type="button" class="btn btn-success" onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de confirmar?');" href="{{ route('rrhh.service-request.fulfillment.confirm-Fulfillment',$fulfillment) }}">
					Confirmar
				</a>
				@else
				<button type="submit" class="btn btn-danger" disabled>Rechazar</button>
				<button type="submit" class="btn btn-success" disabled>Confirmar</button>
				@endif
				@endif
				@endcan
			</fieldset>
		</div>

		<!-- información adicional rrhh -->
		@can('Service Request: fulfillments rrhh')
		<form method="POST" action="{{ route('rrhh.service-request.fulfillment.update',$fulfillment) }}" enctype="multipart/form-data">
			@csrf
			@method('PUT')
			<div class="card border-danger mb-3">
				<div class="card-header bg-danger text-white">
					Datos adicionales - RRHH
				</div>
				<div class="card-body">
					<div class="form-row">
						<fieldset class="form-group col-5 col-md-2">
							<label for="for_resolution_number">N° Resolución</label>
							<input type="text" class="form-control" disabled name="resolution_number" value="{{$serviceRequest->resolution_number}}">
						</fieldset>
						<fieldset class="form-group col-7 col-md-2">
							<label for="for_resolution_date">Fecha Resolución</label>
							<input type="date" class="form-control" disabled name="resolution_date" @if($serviceRequest->resolution_date) value="{{$serviceRequest->resolution_date->format('Y-m-d')}}" @endif>
						</fieldset>
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
						<fieldset class="form-group col col-md-2">
							<label for="for_total_hours_paid">Total hrs. a pagar</label>
							<input type="text" class="form-control" name="total_hours_to_pay" value="{{$fulfillment->total_hours_to_pay}}">
						</fieldset>
						<fieldset class="form-group col col-md-2">
							<label for="for_total_paid">Total a pagar</label>
							<input type="text" class="form-control" name="total_to_pay" value="{{$fulfillment->total_to_pay}}">
						</fieldset>
						<div class="form-check form-check-inline">
							<input type="hidden" name="illness_leave" value="0">
							<input class="form-check-input" type="checkbox" name="illness_leave" value="1" {{ ( $fulfillment->illness_leave== '1' ) ? 'checked="checked"' : null }}>
							<label class="form-check-label" for="for_illness_leave">Licencias</label>
						</div>
						<div class="form-check form-check-inline">
							<input type="hidden" name="leave_of_absence" value="0">
							<input class="form-check-input" type="checkbox" id="permisos" name="leave_of_absence" value="1" {{ ( $fulfillment->leave_of_absence== '1' ) ? 'checked="checked"' : null }}>
							<label class="form-check-label" for="permisos">Permisos</label>
						</div>
						<div class="form-check form-check-inline">
							<input type="hidden" name="assistance" value="0">
							<input class="form-check-input" type="checkbox" name="assistance" value="1" {{ ( $fulfillment->assistance== '1' ) ? 'checked="checked"' : null }}>
							<label class="form-check-label" for="asistencia">Asistencia</label>
						</div>


					</div>
					<div class="form-row">
						<div class="col-3">
							<button type="submit" class="btn btn-primary">Guardar</button>
						</div>
						<div class="col-6">
							@if($fulfillment->total_to_pay)
							@livewire('service-request.upload-invoice', ['fulfillment' => $fulfillment])
							@else
							No se ha ingresado el "Total a pagar". <br>Contacte a RRHH.
							@endif
						</div>
						<div class="col-3 text-right">
							@if($fulfillment->rrhh_approver_id == NULL)
							<a type="button" class="btn btn-danger" onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de rechazar?');" href="{{ route('rrhh.service-request.fulfillment.refuse-Fulfillment',$fulfillment) }}">
								Rechazar
							</a>
							<a type="button" class="btn btn-success" onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de confirmar?');" href="{{ route('rrhh.service-request.fulfillment.confirm-Fulfillment',$fulfillment) }}">
								Confirmar
							</a>
							@else
							<button type="submit" class="btn btn-danger" disabled>Rechazar</button>
							<button type="submit" class="btn btn-success" disabled>Confirmar</button>
							@endif
						</div>
					</div>
				</div>
			</div>
		</form>
		@endcan

		<!-- información adicional finanzas -->
		@can('Service Request: fulfillments finance')
		<form method="POST" action="{{ route('rrhh.service-request.fulfillment.update',$fulfillment) }}" enctype="multipart/form-data">
			@csrf
			@method('PUT')
			<div class="card border-info mb-3">
				<div class="card-header bg-info text-white">
					Datos adicionales - Finanzas
				</div>
				<div class="card-body">
					<div class="form-row">
						<fieldset class="form-group col-5 col-md-2">
							<label for="for_resolution_number">N° Resolución</label>
							<input type="text" class="form-control" disabled name="resolution_number" value="{{$serviceRequest->resolution_number}}">
						</fieldset>
						<fieldset class="form-group col-7 col-md-3">
							<label for="for_resolution_date">Fecha Resolución</label>
							<input type="date" class="form-control" disabled name="resolution_date" @if($serviceRequest->resolution_date) value="{{$serviceRequest->resolution_date->format('Y-m-d')}}" @endif>
						</fieldset>
						<fieldset class="form-group col-6 col-md-3">
							<label for="for_total_hours_paid">Total hrs. a pagar per.</label>
							<input type="text" class="form-control" name="total_hours_to_pay" disabled value="{{$fulfillment->total_hours_to_pay}}">
						</fieldset>
						<fieldset class="form-group col-6 col-md-3">
							<label for="for_total_paid">Total a pagar</label>
							<input type="text" class="form-control" name="total_to_pay" disabled value="{{$fulfillment->total_to_pay}}">
						</fieldset>
					</div>
					<div class="form-row">
						<fieldset class="form-group col col-md-2">
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
					<div class="form-row">
						<div class="col-3">
							<button type="submit" class="btn btn-primary">Guardar</button>
						</div>
						<div class="col-6">
							@if($fulfillment->total_to_pay)
							@livewire('service-request.upload-invoice', ['fulfillment' => $fulfillment])
							@else
							No se ha ingresado el "Total a pagar".
							@endif
						</div>
						<div class="col-3 text-right">
							@if($fulfillment->finances_approver_id == NULL)
							<a type="button" class="btn btn-danger" onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de rechazar?');" href="{{ route('rrhh.service-request.fulfillment.refuse-Fulfillment',$fulfillment) }}">
								Rechazar
							</a>
							<a type="button" class="btn btn-success" onclick="return confirm('Una vez confirmado, no podrá modificar la información. ¿Está seguro de confirmar?');" href="{{ route('rrhh.service-request.fulfillment.confirm-Fulfillment',$fulfillment) }}">
								Confirmar
							</a>
							@else
							<button type="submit" class="btn btn-danger" disabled>Rechazar</button>
							<button type="submit" class="btn btn-success" disabled>Confirmar</button>
							@endif
						</div>
					</div>
				</div>
			</div>
		</form>
		@endcan

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
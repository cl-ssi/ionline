<div class="card border-dark">
	<div class="card-header">
		<h4>Información del período: {{ $serviceRequest->Fulfillments->first()->year }}-{{ $serviceRequest->Fulfillments->first()->month }} ({{Carbon\Carbon::parse($serviceRequest->Fulfillments->first()->year . "-" . $serviceRequest->Fulfillments->first()->month)->monthName}}) <span class="small text-muted float-right">{{ $serviceRequest->Fulfillments->first()->id }} </span> </h4>
	</div>
	<div class="card-body">

		<div class="card border-success mb-3">
			<div class="card-header bg-success text-white">Responsable</div>
			<div class="card-body">

		@if($serviceRequest->working_day_type == "DIURNO PASADO A TURNO")
			<h4>Inasistencias</h4>
			@livewire('service-request.fulfillment-absences', ['fulfillment' => $serviceRequest->Fulfillments->first()])
		@endif

		@livewire('service-request.show-total-hours', ['fulfillment' => $serviceRequest->fulfillments->first()])
		<div class="form-row">
			<fieldset class="form-group col-12 col-md-6">
				<a type="button" class="btn btn-outline-primary" href="{{ route('rrhh.service-request.fulfillment.certificate-pdf',$serviceRequest->Fulfillments->first()) }}" target="_blank"> Ver certificado <i class="fas fa-file"></i> </a>

				@if($serviceRequest->Fulfillments->first()->signatures_file_id)
				<a class="btn btn-info" href="{{ route('rrhh.service-request.fulfillment.signed-certificate-pdf',[$serviceRequest->Fulfillments->first(), time()]) }}" target="_blank" title="Certificado">
					Certificado firmado<i class="fas fa-signature"></i>
				</a>
				@can('Service Request: delete signed certificate')
				<a class="btn btn-outline-danger ml-2" href="{{ route('rrhh.service-request.fulfillment.delete-signed-certificate-pdf',$serviceRequest->Fulfillments->first()) }}" title="Borrar Certificado" onclick="return confirm('¿Está seguro que desea eliminar el certificado de cumplimiento firmado?')">
					<i class="fas fa-trash"></i> Certificado
				</a>
				@endcan
				@else
				{{--modal firmador--}}
				@php $idModelModal = $serviceRequest->Fulfillments->first()->id;
				$routePdfSignModal = "/rrhh/service-request/fulfillment/certificate-pdf/$idModelModal/".auth()->id();
				$routeCallbackSignModal = 'documents.callbackFirma';
				@endphp

				@include('documents.signatures.partials.sign_file')
				<button type="button" data-toggle="modal" class="btn btn-outline-info" data-target="#signPdfModal{{$idModelModal}}" title="Firmar">Firmar certificado <i class="fas fa-signature"></i></button>
				@endif
			</fieldset>

			<fieldset class="form-group col-6 col-md-6 text-right">

			</fieldset>
		</div>
		
		@php $fulfillment = $serviceRequest->Fulfillments->first();  @endphp
		<!--archivos adjuntos-->
		<div class="card">
			<div class="card-body">
				<h6 class="card-title">Adjuntar archivos al cumplimiento (opcional)</h6>

					@if($fulfillment->attachments->count() > 0)
					<table class="table table-sm small table-bordered">
						<thead class="text-center">

							<tr class="table-secondary">
								<th width="160">Fecha de Carga</th>
								<th>Nombre</th>
								<th>Archivo</th>
								<th width="100"></th>
								<th width="50"></th>
							</tr>
						</thead>
						<tbody>
							@foreach($fulfillment->attachments as $attachment)
							<tr>
								<td>{{ $attachment->updated_at->format('d-m-Y H:i:s') }}</td>
								<td>{{ $attachment->name ?? '' }}</td>
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
					<div>
						@livewire('service-request.attachments-fulfillments', ['var' => $fulfillment->id])
					</div>
				</div>
			</div>
			<!--fin archivos adjuntos-->

		</div></div>

		<div class="alert alert-warning border-dark" role="alert">
		  Para horas extra, se exige solo al jefe de unidad la firma electrónica del certificado de cumplimiento.
		</div>

		@canany(['Service Request: fulfillments rrhh'])
		<form method="POST" action="{{ route('rrhh.service-request.fulfillment.update',$serviceRequest->Fulfillments->first()) }}" enctype="multipart/form-data">
			@csrf @method('PUT')

			<div class="card border-danger mb-3">
				<div class="card-header bg-danger text-white">
					Datos adicionales - RRHH
				</div>
				<div class="card-body">
					<div class="form-row">
						<fieldset class="form-group col-5 col-md-2">
							<label for="for_resolution_number">N° Resolución</label>
							<input type="text" class="form-control" disabled name="resolution_number" value="{{$serviceRequest->resolution_number}}" />
						</fieldset>

						<fieldset class="form-group col-7 col-md-2">
							<label for="for_resolution_date">Fecha Resolución</label>
							<input type="date" class="form-control" disabled name="resolution_date" @if($serviceRequest->resolution_date) value="{{$serviceRequest->resolution_date->format('Y-m-d')}}" @endif>
						</fieldset>

						<fieldset class="form-group col-6 col-md-2">
							<label for="for_total_hours_paid">Total hrs. a pagar per.</label>
							<input type="text" class="form-control" name="total_hours_to_pay" value="{{$serviceRequest->Fulfillments->first()->total_hours_to_pay}}" />
						</fieldset>

						<fieldset class="form-group col-6 col-md-2">
							<label for="for_total_paid">Total a pagar</label>
							<input type="text" class="form-control" name="total_to_pay" value="{{$serviceRequest->Fulfillments->first()->total_to_pay}}" />
						</fieldset>

						<div class="form-check form-check-inline">
							<input type="hidden" name="illness_leave" value="0">
							<input class="form-check-input" type="checkbox" name="illness_leave" value="1" {{ ( $serviceRequest->Fulfillments->first()->illness_leave== '1' ) ? 'checked="checked"' : null }}>
							<label class="form-check-label" for="for_illness_leave">Licencias</label>
						</div>
						<div class="form-check form-check-inline">
							<input type="hidden" name="leave_of_absence" value="0">
							<input class="form-check-input" type="checkbox" id="permisos" name="leave_of_absence" value="1" {{ ( $serviceRequest->Fulfillments->first()->leave_of_absence== '1' ) ? 'checked="checked"' : null }}>
							<label class="form-check-label" for="permisos">Permisos</label>
						</div>
						<div class="form-check form-check-inline">
							<input type="hidden" name="assistance" value="0">
							<input class="form-check-input" type="checkbox" name="assistance" value="1" {{ ( $serviceRequest->Fulfillments->first()->assistance== '1' ) ? 'checked="checked"' : null }}>
							<label class="form-check-label" for="asistencia">Asistencia</label>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-2">
							<button type="submit" class="btn btn-primary">Guardar</button>
						</div>
						<div class="col-12 col-md-7">
							<a type="button" class="btn btn-outline-success" href="{{ route('rrhh.service-request.report.resolution-pdf',$serviceRequest) }}" target="_blank">
								<i class="fas fa-file"></i> Resolución
							</a>
						</div>
					</div>

				</div>
			</div>
		</form>
		@endcan

		<!-- información  boleta -->
		<div class="card border-warning mb-3">
			<div class="card-header bg-warning text-white">
				Boleta
			</div>
			<div class="card-body">

				<div class="form-row">

					<div class="col-12 col-md-8">
						@if($serviceRequest->Fulfillments->first()->total_to_pay)
						@livewire('service-request.upload-invoice', ['fulfillment' => $serviceRequest->Fulfillments->first() ])
						@else
						No se ha ingresado el "Total a pagar".
						@endif
					</div>
					<div class="col-12 col-md-4">
						<strong></strong>
						<div>
						
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- fin información boleta -->

		@canany(['Service Request: fulfillments finance'])
		<form method="POST" action="{{ route('rrhh.service-request.fulfillment.update',$serviceRequest->Fulfillments->first()) }}" enctype="multipart/form-data">
			@csrf @method('PUT')

			<div class="card border-info mb-3">
				<div class="card-header bg-info text-white">
					Datos adicionales - Finanzas
				</div>
				<div class="card-body">
					<div class="form-row">
						<fieldset class="form-group col-5 col-md-2">
							<label for="for_resolution_number">N° Resolución</label>
							<input type="text" class="form-control" disabled name="resolution_number" value="{{$serviceRequest->resolution_number}}" />
						</fieldset>

						<fieldset class="form-group col-7 col-md-2">
							<label for="for_resolution_date">Fecha Resolución</label>
							<input type="date" class="form-control" disabled name="resolution_date" @if($serviceRequest->resolution_date) value="{{$serviceRequest->resolution_date->format('Y-m-d')}}" @endif>
						</fieldset>

						<fieldset class="form-group col-6 col-md-2">
							<label for="for_total_hours_paid">Total hrs. a pagar per.</label>
							<input type="text" class="form-control" name="total_hours_to_pay" disabled value="{{$serviceRequest->Fulfillments->first()->total_hours_to_pay}}" />
						</fieldset>

						<fieldset class="form-group col-6 col-md-2">
							<label for="for_total_paid">Total a pagar</label>
							<input type="text" class="form-control" name="total_to_pay" disabled value="{{$serviceRequest->Fulfillments->first()->total_to_pay}}" />
						</fieldset>


					</div>

					<div class="form-row">
						<fieldset class="form-group col-3 col-md-2">
							<label for="for_bill_number">N° Boleta</label>
							<input type="text" class="form-control" name="bill_number" value="{{$serviceRequest->Fulfillments->first()->bill_number}}" />
						</fieldset>

						<fieldset class="form-group col-3 col-md-2">
							<label for="for_total_hours_paid">Tot. hrs pagadas per.</label>
							<input type="text" class="form-control" name="total_hours_paid" value="{{$serviceRequest->Fulfillments->first()->total_hours_paid}}" />
						</fieldset>

						<fieldset class="form-group col-3 col-md-2">
							<label for="for_total_paid">Total pagado</label>
							<input type="text" class="form-control" name="total_paid" value="{{$serviceRequest->Fulfillments->first()->total_paid}}" />
						</fieldset>

						<fieldset class="form-group col-3 col-md-2">
							<label for="for_payment_date">Fecha pago</label>
							<input type="date" class="form-control" name="payment_date" required @if($serviceRequest->Fulfillments->first()->payment_date) value="{{$serviceRequest->Fulfillments->first()->payment_date->format('Y-m-d')}}" @endif>
						</fieldset>

						<fieldset class="form-group col col-md-3">
							<label for="for_contable_month">Mes contable pago</label>
							<select name="contable_month" class="form-control" required>
								<option value=""></option>
								<option value="1" @if($serviceRequest->Fulfillments->first()->contable_month == 1) selected @endif>Enero</option>
								<option value="2" @if($serviceRequest->Fulfillments->first()->contable_month == 2) selected @endif>Febrero</option>
								<option value="3" @if($serviceRequest->Fulfillments->first()->contable_month == 3) selected @endif>Marzo</option>
								<option value="4" @if($serviceRequest->Fulfillments->first()->contable_month == 4) selected @endif>Abril</option>
								<option value="5" @if($serviceRequest->Fulfillments->first()->contable_month == 5) selected @endif>Mayo</option>
								<option value="6" @if($serviceRequest->Fulfillments->first()->contable_month == 6) selected @endif>Junio</option>
								<option value="7" @if($serviceRequest->Fulfillments->first()->contable_month == 7) selected @endif>Julio</option>
								<option value="8" @if($serviceRequest->Fulfillments->first()->contable_month == 8) selected @endif>Agosto</option>
								<option value="9" @if($serviceRequest->Fulfillments->first()->contable_month == 9) selected @endif>Septiembre</option>
								<option value="10" @if($serviceRequest->Fulfillments->first()->contable_month == 10) selected @endif>Octubre</option>
								<option value="11" @if($serviceRequest->Fulfillments->first()->contable_month == 11) selected @endif>Noviembre</option>
								<option value="12" @if($serviceRequest->Fulfillments->first()->contable_month == 12) selected @endif>Diciembre</option>
							</select>
						</fieldset>
					</div>
					<div class="form-row">
						<div class="col-md-2">
							<button type="submit" class="btn btn-primary">Guardar</button>
						</div>
						<div class="col-12 col-md-7">

						</div>
					</div>
				</div>
			</div>
		</form>
		@endcan


		<h5>Aprobaciones de Solicitud</h5>

		<div class="table-responsive">
			<table class="table table-sm table-bordered small">
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
					<tr>
						<td>{{$serviceRequest->created_at}}</td>
						<td>{{$serviceRequest->creator->organizationalUnit->name}}</td>
						<td>{{$serviceRequest->creator->position}}</td>
						<td>{{$serviceRequest->creator->getFullNameAttribute()}}</td>
						<td>Creador</td>
						<td>Creada</td>
						<td></td>
					</tr>
					@foreach($serviceRequest->SignatureFlows->sortBy('sign_position') as $key => $SignatureFlow)
					@if($SignatureFlow->status === null)
					<tr class="bg-light">
						@elseif($SignatureFlow->status === 0)
					<tr class="bg-danger">
						@elseif($SignatureFlow->status === 1)
					<tr>
						@elseif($SignatureFlow->status === 2)
					<tr class="bg-warning">
						@endif

						<td>{{ $SignatureFlow->signature_date}}</td>
						<td>{{ $SignatureFlow->organizationalUnit->name}}</td>
						<td>{{ $SignatureFlow->employee }}</td>
						<td>{{ $SignatureFlow->user->getFullNameAttribute() }}</td>
						<!-- <td>{{ $SignatureFlow->type }}</td> -->
						@if($SignatureFlow->sign_position == 1)
						<td>Responsable</td>
						@elseif($SignatureFlow->sign_position == 2)
						<td>Supervisor</td>
						@else
						<td>{{ $SignatureFlow->type }}</td>
						@endif
						<td>
							@if($SignatureFlow->status === null)
							@elseif($SignatureFlow->status === 1) Aceptada
							@elseif($SignatureFlow->status === 0) Rechazada
							@endif
						</td>
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

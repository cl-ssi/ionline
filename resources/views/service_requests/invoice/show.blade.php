@extends('layouts.guest')

@section('title', 'Boleta de Honorario')

@section('content')

@if(empty($serviceRequests))
<div class="alert alert-danger">
	<h4 class="alert-heading">No Posee Solicitudes de Pago de Honorario con este RUT.</h4>
</div>
@else

@livewire('service-request.update-account' , ['serviceRequest' => $serviceRequests->last()])

<hr>

<h4 class="mt-3 mb-3">Información de sus contratos de honorarios</h4>


<!-- <div class="card mb-3">
	<div class="card-header">
		<h4 class="card-title">
		Período: <span class="font-weight-normal">2021-03</span>
		</h4>
		<p class="card-text">
			<strong>ID:</strong> 602 <span class="small">(1028)</span> - 
			<strong>Tipo:</strong> Mensual - 
			<strong>Jornada:</strong> DIURNO</strong>
		</p>
	</div>

	<ul class="list-group list-group-flush">
		<li class="list-group-item">
			<i class="fas fa-circle text-success"></i> 
			Proceso de firmas de resolución. (8/8)</li>
		<li class="list-group-item">
			<i class="fas fa-circle text-success"></i> 
			<a href=""> Resolución. <i class="fas fa-paperclip"></i></a> </li>
		<li class="list-group-item">
			<i class="fas fa-circle text-success"></i> 
			<a href=""> Certificado de cumplimiento. <i class="fas fa-paperclip"></i></a> </li>
		<li class="list-group-item">
			<i class="fas fa-circle text-success"></i> 
			Monto cargado por RRHH. </li>
		<li class="list-group-item">
			<i class="fas fa-circle text-secondary"></i> 
			Cargar boleta. <input type="file" name="" id=""> </li>
		<li class="list-group-item">
			<i class="fas fa-circle text-secondary"></i> 
			Pago pendiente. </li>
	</ul>

	<div class="card-footer text-muted">
		<strong>Monto de boleta:</strong> $123.123
	</div>
</div> 

<div class="card mb-3">
	<div class="card-header bg-success text-white">
		<h4 class="card-title">
		Período: <span class="font-weight-normal">2021-02</span>
		</h4>
		<p class="card-text">
			<strong>ID:</strong> 602 <span class="small">(1028)</span> - 
			<strong>Tipo:</strong> Mensual - 
			<strong>Jornada:</strong> DIURNO</strong>
		</p>
	</div>

	<ul class="list-group list-group-flush">
		<li class="list-group-item">
			<i class="fas fa-circle text-success"></i> 
			Proceso de firmas de resolución. (8/8)</li>
		<li class="list-group-item">
			<i class="fas fa-circle text-success"></i> 
			<a href=""> Resolución. <i class="fas fa-paperclip"></i></a> </li>
		<li class="list-group-item">
			<i class="fas fa-circle text-success"></i> 
			<a href=""> Certificado de cumplimiento. <i class="fas fa-paperclip"></i></a> </li>
		<li class="list-group-item">
			<i class="fas fa-circle text-success"></i> 
			Monto cargado por RRHH. </li>
		<li class="list-group-item">
			<i class="fas fa-circle text-success"></i> 
			<a href=""> Boleta cargada. <i class="fas fa-paperclip"></i></a></li>
		<li class="list-group-item">
			<i class="fas fa-circle text-success"></i> 
			Pagado realizado el 06-04-2021. </li>
	</ul>

	<div class="card-footer text-muted">
		<strong>Monto de boleta:</strong> $123.123
	</div>
</div> 



<hr> -->




<div class="table-responsive">
	<table class="table table-sm table-bordered small">
		<thead>
				<tr>
						<th>ID</th>
						<th>Tipo Contrato</th>
						<th>Estado</th>
						<th class="text-center">Visaciones</th>
						<th>Año</th>
						<th>Mes</th>
						<th>Monto de Boleta</th>
						<th>Fecha de Pago</th>
						<th>Cargar Boleta</th>
				</tr>
		</thead>
				<tbody>
						@foreach ($serviceRequests as $serviceRequest)
						@foreach($serviceRequest->fulfillments->reverse() as $fullfillment)
						<tr></tr>
						<tr>
								<td class="small">{{ $serviceRequest->id ?? '' }} </td>
								<td>{{ $serviceRequest->program_contract_type ?? '' }} <br>
									{{ $serviceRequest->working_day_type ?? '' }} <br>
								  @if($serviceRequest->has_resolution_file)
									<a href="{{route('rrhh.service-request.fulfillment.download_resolution', $serviceRequest)}}"
										target="_blank" class="mr-4"><i class="fas fa-paperclip"></i> Resolución
									</a>
								  @endif
								</td>
								<td>@if($serviceRequest->SignatureFlows->where('status','===',0)->count() > 0) Rechazada
				  									@elseif($serviceRequest->SignatureFlows->whereNull('status')->count() > 0) Pendiente
				  									@else Finalizada @endif</td>
								<td class="p-0">
								  <table class="table table-sm table-bordered small">
									  <tbody>
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
											<td>{{ $SignatureFlow->signature_date->format('Y-m-d H:i')}}</td>
											<td>{{ $SignatureFlow->user->getShortNameAttribute() }}</td>
										  </tr>
										@endforeach
									  </tbody>
								  </table>
								</td>
								<td>@if($fullfillment->type == "Horas")
									  {{$fullfillment->start_date->format('Y')}}
									@else
									  {{ $fullfillment->year ?? '' }}
									@endif
								</td>
								<td>
								  @if($fullfillment->type == "Horas")
										{{$fullfillment->start_date->format('m')}}
									  @else
										{{ $fullfillment->month ?? '' }}
									  @endif
								</td>
								<td>{{ $fullfillment->total_to_pay ?? '' }}</td>
								<td>{{ $fullfillment->payment_date?$fullfillment->payment_date->format('d-m-Y'):''}} </td>
								<td>
								@if($fullfillment->total_to_pay)                                  
								  @livewire('service-request.upload-invoice', ['fulfillment' => $fullfillment])                                  
								  {{ $fullfillment->payment_rejection_detail ?? '' }}
								@else
								  No se ha ingresado el "Total a pagar". <br>Contacte a RRHH.
								  
								@endif
								</td>
						</tr>
						@endforeach
						@endforeach
				</tbody>
		</table>
</div>
@endif


@endsection

@section('custom_js')

@endsection

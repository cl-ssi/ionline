@extends('layouts.guest')

@section('title', 'Boleta de Honorario')

@section('content')

@if($user)

	@if($fulfillments->isEmpty())
		<div class="alert alert-danger">
			<h4 class="alert-heading">No existen contratos de honorarios con cumplimientos para pago con este run.</h4>
		</div>
	@else

		@livewire('service-request.update-account' , ['bankaccount' => $bankaccount->last(), 'user' => $user])

		<hr>

		<h4 class="mt-3 mb-3">Información de sus contratos de honorarios</h4>
		<p>Si tiene alguna duda, respecto a algún contrato, puedes ponerte en contacto con el área de RRHH a través de  
		<a href="https://wa.me/message/IBHMJ3XRQZA3P1" data-toggle="tooltip" title="<img src='{{ asset('images/qr_wp_rrhh.svg') }}' />">WhatsApp</a>. El horario de atención es de 8:30 a 14:00.</p>



		@foreach($fulfillments as $fullfillment)

		<div class="card mb-3">
			<div class="card-header {{ ($fullfillment->payment_date)?'bg-success text-white':'' }}">
				<h4 class="card-title">
					Período: <span class="font-weight-normal">
						@if($fullfillment->type == "Horas")
						{{ optional($fullfillment->start_date)->format('Y') }} - {{ optional($fullfillment->start_date)->format('m') }} @if($fullfillment->payment_date)<a href="#" data-toggle="collapse" data-target="#collapse{{$fullfillment->id}}"> <i class="fas fa-chevron-down"></i> </a>@endif
						@else
						{{ $fullfillment->year ?? '' }} - {{ $fullfillment->month ?? '' }} @if($fullfillment->payment_date)<a href="#" data-toggle="collapse" data-target="#collapse{{$fullfillment->id}}"> <i class="fas fa-chevron-down"></i> </a>@endif
						@endif</span>
				</h4>
				<p class="card-text">
					<strong>ID:</strong> {{ $fullfillment->serviceRequest->id ?? '' }} <span class="small">({{ $fullfillment->id ?? '' }})</span> -
					<strong>Tipo:</strong> {{ $fullfillment->serviceRequest->program_contract_type ?? '' }} -
					<strong>Jornada:</strong> {{ $fullfillment->serviceRequest->working_day_type ?? '' }}</strong>
				</p>
			</div>
			@if($fullfillment->payment_date)
			<div id="collapse{{$fullfillment->id}}" class="collapse">
				@endif
				<ul class="list-group list-group-flush">

					<li class="list-group-item">
						@if($fullfillment->serviceRequest->SignatureFlows->where('status','===',0)->count() > 0)
						<i class="fas fa-circle text-secondary"></i>
						Firmas de resolución rechazada.
						@elseif($fullfillment->serviceRequest->SignatureFlows->whereNull('status')->count() > 0)
						<i class="fas fa-circle text-secondary"></i>
						Firmas de resolución pendiente.
						@else
						<i class="fas fa-circle text-success"></i>
						Firmas de resolución finalizado.
						@endif

						<a href="#" data-toggle="collapse" data-target="#firmas{{$fullfillment->id}}"> <i class="fas fa-chevron-down"></i> </a>

						<div id="firmas{{$fullfillment->id}}" class="collapse" aria-labelledby="headingOne">
							<table class="table table-sm table-bordered small">
								<tbody>
									@foreach($fullfillment->serviceRequest->SignatureFlows->sortBy('sign_position') as $key => $SignatureFlow)
									@if($SignatureFlow->status === null)
									<tr class="bg-light">
										@elseif($SignatureFlow->status === 0)
									<tr class="bg-danger">
										@elseif($SignatureFlow->status === 1)
									<tr>
										@elseif($SignatureFlow->status === 2)
									<tr class="bg-warning">
										@endif
										<td>{{ optional($SignatureFlow->signature_date)->format('Y-m-d H:i')}}</td>
										<td>{{ $SignatureFlow->user->getShortNameAttribute() }}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</li>

					<li class="list-group-item">
						@if($fullfillment->serviceRequest->has_resolution_file)
						<i class="fas fa-circle text-success"></i>
						<a href="{{route('rrhh.service-request.fulfillment.download_resolution', $fullfillment->serviceRequest->id)}}" target="_blank" title="Resolución"> Resolución. <i class="fas fa-paperclip"></i></a>
						@else
						<i class="fas fa-circle text-secondary"></i>
						No se ha cargado resolución.
						@endif
					</li>
					<li class="list-group-item">
						@if($fullfillment->signatures_file_id)
						<i class="fas fa-circle text-success"></i>
						<a href="{{ route('rrhh.service-request.fulfillment.signed-certificate-pdf',$fullfillment) }}" target="_blank" title="Certificado">Certificado de cumplimiento. <i class="fas fa-paperclip"></i></a>
						@else
						<i class="fas fa-circle text-secondary"></i>
						No se ha firmado certificado de cumplimiento.
						@endif
					</li>
					<li class="list-group-item">
						@if($fullfillment->total_to_pay)
						<i class="fas fa-circle text-success"></i>
						Monto de boleta: {{ @money($fullfillment->total_to_pay) }}
						@else
						<i class="fas fa-circle text-secondary"></i>
						No se ha cargado el "total a pagar" por RRHH.
						@endif
					</li>
					<li class="list-group-item">
						@if($fullfillment->total_to_pay and $fullfillment->serviceRequest->has_resolution_file)
						@if($fullfillment->has_invoice_file)
						<i class="fas fa-circle text-success"></i>
						@livewire('service-request.upload-invoice', ['fulfillment' => $fullfillment])
						@else
						<i class="fas fa-circle text-secondary"></i>
						@livewire('service-request.upload-invoice', ['fulfillment' => $fullfillment])
						@endif
						@else
						<i class="fas fa-circle text-secondary"></i> No es posible cargar boleta.
						@endif
					</li>
					<li class="list-group-item">
						@if($fullfillment->payment_date)
						<i class="fas fa-circle text-success"></i>
						Pagado realizado el {{ optional($fullfillment->payment_date)->format('d-m-Y')}}
						@else
						<i class="fas fa-circle text-secondary"></i>
						Pago pendiente.
						@if($fullfillment->payment_rejection_detail)
						<a href="#" data-toggle="collapse" data-target="#rechazo{{$fullfillment->id}}"> 
							<i class="fas fa-chevron-down"></i> </a>
						<div id="rechazo{{$fullfillment->id}}" class="collapse" aria-labelledby="headingOne">
							{!! $fullfillment->payment_rejection_detail !!}
						</div>
						@endif
						@endif
					</li>
				</ul>
				@if($fullfillment->payment_date)
			</div>
			@endif
			

		</div>

		@endforeach

	@endif

@else
	<div class="alert alert-danger">
		<h4 class="alert-heading">No existe un usuario con este run en nuestros registros. </h4>
		<p>Si tiene alguna duda respecto a algún contrato, puede ponerse en contacto con el área de RRHH a través de del anexo 57 9819 o bién a través de 
		<a href="https://wa.me/message/IBHMJ3XRQZA3P1" data-toggle="tooltip" title="<img src='{{ asset('images/qr_wp_rrhh.svg') }}' />">WhatsApp</a>. <br>
		El horario de atención es de 8:30 a 16:00.</p>
	</div>
@endif

@endsection

@section('custom_js')
<script>
$('a[data-toggle="tooltip"]').tooltip({
    animated: 'fade',
    placement: 'top',
    html: true
});
</script>
@endsection
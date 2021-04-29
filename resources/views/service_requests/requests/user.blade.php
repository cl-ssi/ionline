@extends('layouts.app')

@section('title', 'Boleta de Honorario')

@section('content')

@include('service_requests.partials.nav')

<h3 class="mb-3">Historial por usuario</h3>

<form method="post" action="{{ route('rrhh.service-request.user')}}">
    @csrf
    <div class="form-row">
        <fieldset class="col-md-4">
            @livewire('calcular-dv')
        </fieldset>
    </div>
</form>

@if(count($fulfillments) < 1)
<div class="alert alert-info mt-3">
	<h4 class="alert-heading">El funcionario {{ optional($user)->fullName }}
        no posee solicitudes de Honorarios.</h4>
</div>
@else

<h4 class="mt-3 mb-3">Información de contratos de honorarios de
    {{ optional($user)->fullName }}</h4>

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
				@if($fullfillment->total_to_pay)
                    @if($fullfillment->has_invoice_file)
                        <i class="fas fa-circle text-success"></i>
                        Boleta cargada
				    @else
                        <i class="fas fa-circle text-secondary"></i>
                        Pendiente cargar la boleta
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

@extends('layouts.app')

@section('title', 'Listado de Traslados')

@section('content')

@include('pharmacies.nav')

<h3>Listado de Entregas</h3>
<div class="mb-3">
	@cannot(['Pharmacy: transfer view ortesis'])
	<a class="btn btn-primary"
		href="{{ route('pharmacies.products.deliver.create') }}">
		<i class="fas fa-dolly"></i> Nueva entrega</a>
	
	<button type="button" class="btn btn-outline-success" href="" onclick="tableToExcel('tabla_stock', 'Listado de stock')">
		Descargar <i class="fas fa-download"></i>
	</button>
	@endcan
	
</div>
@cannot(['Pharmacy: transfer view ortesis'])
<div class="row">
	<div class="form-group col">
		<h5 class="sub-header">Búsqueda por {{$establishment->name}}</h5>
		<div class="table-responsive">
			<table class="table table-hover table-sm" id="tabla_stock">
				<thead>
					<th>Ayuda técnica</th>
					<th class="text-right">Stock</th>
					<th class="text-right">Mínimo</th>
					<th class="text-right">Pendientes</th>
				</thead>
				<tbody>
					@forelse($products_by_establishment as $product)
					<tr>
						<td>@canany(['Pharmacy: transfer view ortesis']) <a href="#" id="{{$product->id}}" class="ref-product">{{$product->name}}</a> @else {{$product->name}} @endcan</td>
						<td class="text-right">
							{{$product->quantity}}
						</td>
						<td class="text-right">
						{{$product->establishments->first()->pivot->critic_stock != null ? $product->establishments->first()->pivot->critic_stock : 0}}
						</td>
						<td class="text-right">
							{{isset($pendings_by_product[$product->id]) ? $pendings_by_product[$product->id] : 0}}
						</td>
					</tr>
					@empty
						<tr><td colspan="3" class="text-center">Sin productos</td></tr>
					@endforelse
				</tbody>
			</table>
		</div>
		{{ $products_by_establishment->appends(Request::input())->links() }}
	</div>
</div>
@endcan

<h3>Entregas pendientes</h3>
<p><button type="button" class="btn btn-outline-success" href="" onclick="tableToExcel('tabla_pending_deliveries', 'Entregas pendientes')">
		Descargar <i class="fas fa-download"></i>
	</button></p>
<div class="table-responsive">
	<table class="table table-striped table-sm" id="tabla_pending_deliveries">
		<thead>
			<tr>
				<th scope="col" align="left">Origen solicitud</th>
				<th scope="col" align="left">Fecha ingreso</th>
				<th scope="col" align="left">Fecha vencimiento</th>
				<th scope="col" align="left">RUT</th>
				<th scope="col" align="left">Nombre y apellido</th>
				<th scope="col" align="left">Edad</th>
				<th scope="col" align="left">Diagnóstico</th>
				<th scope="col" align="left">Cant.</th>
				<th scope="col" align="left">Ayuda técnica</th>
				<th scope="col" align="left">Médico</th>
				<th scope="col" align="left">Folio</th>
				<th scope="col" align="left">Observaciones</th>
				<th scope="col" colspan="2" align="left">Acciones</th>
			</tr>
		</thead>
		<tbody>
			@forelse($pending_deliveries as $delivery)
			<tr>
				<td>{{$delivery->establishment['name']}}</td>
				<td>{{date("d/m/Y", strtotime($delivery->request_date))}}</td>
        		<td>{{date("d/m/Y", strtotime($delivery->due_date))}}</td>
        		<td>{{$delivery->patient_rut}}</td>
        		<td>{{$delivery->patient_name}}</td>
				<td>{{$delivery->age}}</td>
				<td>{{$delivery->diagnosis}}</td>
				<td>{{$delivery->quantity}}</td>
				<td>{{$delivery->product['name']}}</td>
				<td>{{$delivery->doctor_name}}</td>
				<td>{{$delivery->invoice}}</td>
				<td>{{$delivery->remarks}}</td>
				@cannot(['Pharmacy: transfer view ortesis'])
				<td>
					@foreach($products_by_establishment as $product)
						@if($product->id == $delivery->product_id && $product->quantity >= $delivery->quantity)
							<form method="POST" action="{{ route('pharmacies.products.deliver.confirm', $delivery) }}" class="d-inline">
								@csrf
								@method('PUT')
								<button type="submit" class="btn btn-outline-success btn-sm" data-toggle="tooltip" data-placement="top" title="Confirmar entrega"><i class="fas fa-check"></i></button>
							</form>
							@break
						@endif
						@if($loop->last)
							<button type="button" class="btn btn-outline-danger btn-sm" aria-pressed="false" data-toggle="tooltip" data-placement="top" title="No hay stock para entrega"><i class="fas fa-times"></i></button>
						@endif
					@endforeach
				</td>
				@endcan
				@canany(['Pharmacy: transfer view ortesis'])
				<td>
					<a href="#" class="btn btn-outline-info btn-sm popover-item" id="{{$delivery->id}}" rel="popover" class="popover-item"><i class="fas fa-eye"></i></a>
					<div class="popover-list-content" style="display:none;">
						<ul class="list-group list-group-flush">
							@foreach($products_by_establishment as $product)
								@if($product->id == $delivery->product_id)
								<li class="list-group-item d-flex justify-content-between align-items-center">
									{{$product->name}}&nbsp;<span class="badge badge-info">{{$product->stock}}</span>
								</li>
								@endif
							@endforeach
							{{--@foreach($establishments as $establishment)
								@if($establishment->id == $delivery->establishment_id)
									@foreach($establishment->products as $product)
										@if($product->pivot->stock > 0)
										<li class="list-group-item d-flex justify-content-between align-items-center">
											{{$product->name}}&nbsp;<span class="badge badge-info">{{$product->pivot->stock}}</span>
										</li>
										@endif
									@endforeach
								@endif
							@endforeach--}}
						</ul>
					</div>
				</td>
				@endcan
			</tr>
			@empty
				<tr><td colspan="13" class="text-center">No existen entregas pendientes</td></tr>
			@endforelse
		</tbody>
	</table>
</div>

{{ $pending_deliveries->links() }}

<h3>Entregas confirmadas</h3>
<p><button type="button" class="btn btn-outline-success" href="" onclick="tableToExcel('tabla_confirmed_deliveries', 'Entregas confirmadas')">
		Descargar <i class="fas fa-download"></i>
							</button></p>
<div class="table-responsive">
	<table class="table table-striped table-sm" id="tabla_confirmed_deliveries">
		<thead>
			<tr>
				<th scope="col" align="left">Origen solicitud</th>
				<th scope="col" align="left">Fecha ingreso</th>
				<th scope="col" align="left">Fecha vencimiento</th>
				<th scope="col" align="left">RUT</th>
				<th scope="col" align="left">Nombre y apellido</th>
				<th scope="col" align="left">Edad</th>
				<th scope="col" align="left">Diagnóstico</th>
				<th scope="col" align="left">Cant.</th>
				<th scope="col" align="left">Ayuda técnica</th>
				<th scope="col" align="left">Médico</th>
				<th scope="col" align="left">Folio</th>
				<th scope="col" align="left">Observaciones</th>
			</tr>
		</thead>
		<tbody>
			@forelse($confirmed_deliveries as $delivery)
			<tr>
				<td>{{$delivery->establishment['name']}}</td>
				<td>{{date("d/m/Y", strtotime($delivery->request_date))}}</td>
        		<td>{{date("d/m/Y", strtotime($delivery->due_date))}}</td>
        		<td>{{$delivery->patient_rut}}</td>
        		<td>{{$delivery->patient_name}}</td>
				<td>{{$delivery->age}}</td>
				<td>{{$delivery->diagnosis}}</td>
				<td>{{$delivery->quantity}}</td>
				<td>{{$delivery->product['name']}}</td>
				<td>{{$delivery->doctor_name}}</td>
				<td>{{$delivery->invoice}}</td>
				<td>{{$delivery->remarks}}</td>
			</tr>
			@empty
				<tr><td colspan="13" class="text-center">No existen entregas confirmadas</td></tr>
			@endforelse
		</tbody>
	</table>
</div>

{{ $confirmed_deliveries->links() }}

@endsection

@section('custom_js')
<script type="text/javascript">
	var tableToExcel = (function() {
	    var uri = 'data:application/vnd.ms-excel;base64,'
	    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta http-equiv="Content-Type" content="text/html;charset=utf-8"></head><body><table>{table}</table></body></html>'
	    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
	    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
	    return function(table, name) {
	    if (!table.nodeType) table = document.getElementById(table)
	    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
	    window.location.href = uri + base64(format(template, ctx))
	    }
	})()
</script>
<script>
	$(document).ready(function() {

		$('.popover-item').popover({
			html: true,
			trigger: 'hover',
			content: function() {
				return $(this).next('.popover-list-content').html();
			}
		});
	});
</script>
@endsection

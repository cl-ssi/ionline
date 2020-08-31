@extends('layouts.app')

@section('title', 'Listado de Traslados')

@section('content')

@include('pharmacies.nav')

<link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />

<h3>Listado de stock</h3>

<div class="mb-3">
	@canany(['Pharmacy: transfer view ortesis'])
	<a class="btn btn-primary" href="{{route('pharmacies.products.transfer.edit', $filter)}}" role="button"><i class="fas fa-clipboard-list"></i> Actualizar stock</a>
	@endcan
	<button type="button" class="btn btn-outline-success" href="" onclick="tableToExcel('tabla_stock', 'Listado de stock')">
		Descargar <i class="fas fa-download"></i>
	</button>
</div>

<div class="row">
	@canany(['Pharmacy: transfer view ortesis'])
	<div class="form-group col-6">
		<h5 class="sub-header">Búsqueda por ayudas técnicas
		<a href="#" class="btn btn-primary" role="button" aria-pressed="true" style="visibility:hidden">Primary link</a>
		</h5>
		<div class="table-responsive">
			<table class="table table-hover table-sm" id="tabla_dispatch">
				<thead>
					<th>Ayuda técnica</th>
					<th class="text-right">Cantidad</th>
				</thead>
				<tbody>
					@forelse($products_ortesis as $product)
					<tr>
						<td><a href="#" id="{{$product->id}}" class="ref-product">{{$product->name}}</a></td>
						<td class="text-right">
							@if($product->quantity != 0) 
								<a href="#" id="{{$product->id}}" rel="popover" class="popover-item">{{$product->quantity}}</a>
								<div class="popover-list-content" style="display:none;">
									<ul class="list-group list-group-flush">
										@foreach($product->establishments as $establishment)
											@if($establishment->pivot->stock > 0)
											<li class="list-group-item d-flex justify-content-between align-items-center">
												{{$establishment->name}}&nbsp;<span class="badge badge-info">{{$establishment->pivot->stock}}</span>
											</li>
											@endif
										@endforeach
									</ul>
								</div>
							@else 0 @endif
						</td>
					</tr>
					@empty
						<tr><td colspan="2" class="text-center">Sin productos</td></tr>
					@endforelse
				</tbody>
			</table>
		</div>
		{{ $products_ortesis->links() }}
	</div>
	@endcan
	<div class="form-group col">
		<h5 class="sub-header">Búsqueda por
		@canany(['Pharmacy: transfer view ortesis'])
		<form method="GET" action="{{route('pharmacies.products.transfer.index')}}" class="d-inline">
			<select name="filter" onchange="this.form.submit()" class="selectpicker establishment" data-live-search="true" data-width="fit" data-style="btn btn-link">
				@foreach ($establishments as $establishment)
				<option value="{{$establishment->id}}" {{$establishment->id == $filter ? 'selected' : ''}}>{{$establishment->name}}</option>
				@endforeach
			</select>
		</form>
		<a class="btn btn-outline-primary" href="{{route('pharmacies.products.transfer.auth', $filter)}}" role="button"><i class="fas fa-clipboard-check"></i> Autorizar</a>
		@else
			{{$establishment->name}}
		@endcan
		</h5>
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
						<tr><td colspan="4" class="text-center">Sin productos</td></tr>
					@endforelse
				</tbody>
			</table>
		</div>
		{{ $products_by_establishment->appends(Request::input())->links() }}
	</div>
</div>

@canany(['Pharmacy: transfer view ortesis'])
<h3>Nuevo Traslado</h3>
<form method="POST" action="{{ route('pharmacies.products.transfer.store') }}">
	@csrf

	<div class="row">
		<fieldset class="form-group col-4">
			<label for="product">Ayuda técnica</label>
			<select name="product_id" class="form-control selectpicker" data-live-search="true" required="">
				@foreach($product_ortesis_list as $product)
				<option value="{{$product->id}}">{{$product->name}}</option>
				@endforeach
			</select>
		</fieldset>

		<fieldset class="form-group col">
			<label for="from">Origen</label>
			<select name="from" class="form-control selectpicker" data-live-search="true" required="">
				@foreach ($establishments as $key => $establishment)
				<option value="{{$establishment->id}}" data-content="{{$establishment->name}}"></option>
				@endforeach
			</select>
		</fieldset>

		<fieldset class="form-group col">
			<label for="to">Destino</label>
			<select name="to" class="form-control selectpicker" data-live-search="true" required="">
				@foreach ($establishments as $key => $establishment)
				<option value="{{$establishment->id}}" data-content="{{$establishment->name}}" @if($key == 0) disabled @endif></option>
				@endforeach
			</select>
		</fieldset>

		<fieldset class="form-group col-1">
			<label for="quantity">Cantidad</label>
			<input type="number" class="form-control" min="1" name="quantity" required="">
		</fieldset>
		<fieldset class="form-group col-1">
			<label for="quantity">&nbsp;</label>
			<button type="submit" class="btn btn-primary">Trasladar</button>
		</fieldset>
	</div>
</form>
@endcan

<h3>Listado de Traslados</h3>

<div class="mb-3">
	<button type="button" class="btn btn-outline-success" href="" onclick="tableToExcel('tabla_transfers', 'Traslados')">
		Descargar <i class="fas fa-download"></i>
	</button>
</div>

<div class="table-responsive">
	<table class="table table-striped table-sm" id="tabla_transfers">
		<thead>
			<tr>
				<th scope="col">Fecha</th>
				<th scope="col">Origen</th>
				<th scope="col">Destino</th>
				<th scope="col">Producto</th>
				<th scope="col">Cant.</th>
				<th scope="col">Responsable</th>
			</tr>
		</thead>
		<tbody>
			@foreach($transfers as $transfer)
			<tr>
        		<td>{{$transfer->created_at->format('d/m/Y')}}</td>
        		<td>{{$transfer->establishment_from['name']}}</td>
        		<td>{{$transfer->establishment_to['name']}}</td>
				<td>{{$transfer->product['name']}}</td>
				<td>{{$transfer->quantity}}</td>
				<td>{{$transfer->user['name']}} {{$transfer->user['fathers_family']}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

{{ $transfers->links() }}

@endsection

@section('custom_js')
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/show_hide_tab.js') }}"></script>
<script>
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

	$(document).ready(function() {
		$('.popover-item').popover({
			html: true,
			trigger: 'hover',
			content: function() {
				return $(this).next('.popover-list-content').html();
			}
		});

		$("select[name=from]").change(function() {
			var establishment_id = $(this).val()
			$("select[name=to] option").each(function(){
				$(this).val() == establishment_id ? $(this).prop('disabled', true) : $(this).prop('disabled', false)
				$(this).selectpicker('refresh');
			})
		});

		// REF: <td><a href="#" id="{{$product->id}}" class="ref-product">{{$product->name}}</a></td>
		$('a.ref-product').click(function(e){
			e.preventDefault();
			var productSelected = $(this).attr('id');
			$("select[name=product_id]").val(productSelected).change().focus();
		});

	});
</script>
@endsection

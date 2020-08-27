@extends('layouts.app')

@section('title', 'Productos')

@section('content')

@include('pharmacies.nav')

<h3 class="inline">Productos
	@can('Pharmacy: create products')
	<a href="{{ route('pharmacies.products.create') }}" class="btn btn-primary">Crear</a>
	@endcan
</h3>

<br>

<div align="right">
	<button type="button" class="btn btn-sm btn-outline-primary"
			onclick="tableToExcel('tabla_movimientos', 'Movimientos')">
			Excel <i class="fas fa-download"></i>
	</button>
</div>


<!--form class="form-inline float-right" method="GET" action="{{ route('rrhh.users.index') }}">
	<div class="input-group mb-3">
		<input type="text" name="name" class="form-control" placeholder="Nombre del producto" autocomplete="off">
		<div class="input-group-append">
			<button class="btn btn-outline-secondary" type="submit">
				<i class="fas fa-search" aria-hidden="true"></i></button>
		</div>
	</div>
</form-->

<table class="table table-striped table-sm table-bordered" id="tabla_movimientos">
	<thead>
		<tr>
			<th scope="col">Cod</th>
			<th scope="col">Nombre</th>
			<th scope="col">Unidad</th>
			<!--<th scope="col">Expiración</th>
			<th scope="col">Lote</th>
			<th scope="col">Precio</th>-->
			<th scope="col">Stock</th>
			<th scope="col">Stock Crítico</th>
			<th scope="col">Categoría</th>
			<th scope="col">Programa</th>
			<th scope="col"></th>
			<th scope="col"></th>
		</tr>
	</thead>
	<tbody>
	@foreach($products as $product)

		<tr class="small">
			<td scope="row" nowrap>{{ $product->barcode }} </td>
			<td>{{ $product->name }}</td>
			<td class="text-center">{{ $product->unit }}</td>
			<!--<td class="text-center" nowrap>{{ $product->expiration }}</td>
			<td>{{ $product->batch }}</td>
			<td class="text-right">@numero( $product->price )</td>-->
			<td class="text-right">@numero( $product->stock )</td>
			<td class="text-right">@numero( $product->critic_stock )</td>
			<td>{{ $product->category->name }}</td>
			<td>{{ $product->program->name }}</td>
			<td>
				<a href="{{ route('pharmacies.products.edit', $product) }}"
					class="btn btn-sm btn-outline-secondary">
					<span class="fas fa-edit" aria-hidden="true"></span>
				</a>
			</td>
			<td>
				<form method="POST" action="{{ route('pharmacies.products.destroy', $product) }}" class="d-inline">
					@csrf
					@method('DELETE')
					<button type="submit" class="btn btn-outline-secondary btn-sm" onclick="return confirm('¿Está seguro de eliminar la información?');">
						<span class="fas fa-trash-alt" aria-hidden="true"></span>
					</button>
				</form>
			</td>
		</tr>
		@endforeach
	</tbody>

</table>

{{-- {{ $products->links() }} --}}

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
@endsection

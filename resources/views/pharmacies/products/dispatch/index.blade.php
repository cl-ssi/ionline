@extends('layouts.app')

@section('title', 'Listado de Egresos')

@section('content')

@include('pharmacies.nav')

<h3>Listado de Egresos</h3>

<div class="mb-3">
	{{-- @canany(['Pharmacy: create']) --}}
	@can('Pharmacy: create')
	<a class="btn btn-primary"
		href="{{ route('pharmacies.products.dispatch.create') }}">
		<i class="fas fa-dolly"></i> Nuevo egreso</a>
	@endcan
	{{-- @endcanany --}}

	{{-- <button type="button" class="btn btn-outline-primary"
		onclick="tableToExcel('tabla_dispatch', 'Despachos')">
		<i class="fas fa-download"></i>
	</button> --}}
	<a type="button" class="btn btn-outline-success" href="{{ route('pharmacies.products.exportExcel') }}">
		Descargar <i class="fas fa-download"></i>
	</a>
</div>



<div class="table-responsive">
	<table class="table table-striped table-sm" id="tabla_dispatch">
		<thead>
			<tr>
				<th scope="col">id</th>
				<th scope="col">Fecha</th>
				<th scope="col">Establecimiento</th>
				<th scope="col">Notas</th>
				<th nowrap scope="col"></th>
				@cannot('Pharmacy: APS (id:3)') <th nowrap scope="col">C-19</th> @endcannot
			</tr>
		</thead>
		<tbody>
			@foreach($dispatchs as $key => $dispatch)
			<tr>
				<td>{{ $dispatch->id }}</td>
        		<td>{{ Carbon\Carbon::parse($dispatch->date)->format('d/m/Y')}}</td>
        		<td>{{ $dispatch->establishment->name }}</td>
        		<td>{{ $dispatch->notes }}</td>
				<td nowrap>
					@can('Pharmacy: edit_delete')
					<a href="{{ route('pharmacies.products.dispatch.edit', $dispatch) }}" class="btn btn-outline-secondary btn-sm">
					<span class="fas fa-edit" aria-hidden="true"></span></a>

					<form method="POST" action="{{ route('pharmacies.products.dispatch.destroy', $dispatch) }}" class="d-inline">
			            @csrf
			            @method('DELETE')
						<button type="submit" class="btn btn-outline-secondary btn-sm" onclick="return confirm('¿Está seguro de eliminar la información?');">
							<span class="fas fa-trash-alt" aria-hidden="true"></span>
						</button>
					</form>
					@endcan
					<a href="{{ route('pharmacies.products.dispatch.record', $dispatch) }}"
						class="btn btn-outline-secondary btn-sm" target="_blank">
					<span class="fas fa-file" aria-hidden="true"></span></a>
					{{-- @can('Pharmacy: APS (id:3)') --}}
					@if(!$dispatch->files->isEmpty())
					<a href="{{ route('pharmacies.products.dispatch.openFile', $dispatch) }}"
						class="btn btn-outline-secondary btn-sm" target="_blank">
					<span class="fas fa-download" aria-hidden="true" style="color: green;"></span></a>
					@else
					<form method="POST" action="{{ route('pharmacies.products.dispatch.storeFile', $dispatch) }}" class="d-inline" enctype="multipart/form-data">
			            @csrf
						@method('POST')
						<label class="btn btn-outline-secondary btn-sm" for="filename{{$dispatch->id}}" style="margin:0 auto">
							<span class="fas fa-upload" aria-hidden="true" style="color: red;"></span>
							<input type="file" id="filename{{$dispatch->id}}" name="filename{{$dispatch->id}}" multiple class="form-control-file" accept=".png, .jpg, .jpeg, .pdf" onchange="this.form.submit()" hidden>
						</label>
					</form>
					@endif
					{{-- @endcan --}}
				</td>
				@cannot('Pharmacy: APS (id:3)')
				<td nowrap>
					@if($dispatch->sendC19 == 0)
						<form method="POST" action="{{ route('pharmacies.products.dispatch.sendC19', $dispatch) }}" class="d-inline">
	            @csrf
	            @method('GET')
							<button type="submit" class="btn btn-outline-secondary btn-sm" onclick="return confirm('¿Está seguro de subir la información?');">
								<span style="font-size: 1em; color: #C9C8C8;">
								  <i class="fas fa-arrow-up"></i>
								</span>
							</button>
						</form>
					@else
						<form method="POST" action="{{ route('pharmacies.products.dispatch.deleteC19', $dispatch) }}" class="d-inline">
	            @csrf
	            @method('GET')
							<button type="submit" class="btn btn-outline-secondary btn-sm" onclick="return confirm('¿Está seguro de bajar la información?');">
								<span style="font-size: 1em; color: #06F606;">
									<i class="fas fa-arrow-up"></i>
								</span>
							</button>
						</form>
					@endif
				</td>
				@endcannot
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

{{ $dispatchs->links() }}

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

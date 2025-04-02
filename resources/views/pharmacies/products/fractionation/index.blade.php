@extends('layouts.bt4.app')

@section('title', 'Listado de Fraccionamientos')

@section('content')

@include('pharmacies.nav')

<h3>Listado de Fraccionamientos</h3>

<div class="alert alert-warning alert-dismissible fade show rounded" role="alert">
    <strong>Atención!</strong> Para eliminar un fraccionamiento, debe primero eliminar el detalle (ítems) dentro de él.
</div>

<div class="mb-3">
	@can('Pharmacy: create')
	<a class="btn btn-primary"
		href="{{ route('pharmacies.products.fractionation.create') }}">
		<i class="fas fa-dolly"></i> Nuevo fraccionamiento</a>
	@endcan

	<a type="button" class="btn btn-outline-success" href="{{ route('pharmacies.products.exportExcel') }}">
		Descargar <i class="fas fa-download"></i>
	</a>
</div>


<div class="table-responsive">
	<table class="table table-striped table-sm" id="tabla_fractionation">
		<thead>
			<tr>
				<th scope="col">id</th>
				<th scope="col">Fecha</th>
                <th scope="col">Médico</th>
                <th scope="col">Paciente</th>
                <th scope="col">Adquiriente</th>
                <th scope="col">QF</th>
				<th scope="col">Notas</th>
				<th nowrap scope="col"></th>
			</tr>
		</thead>
		<tbody>
			@foreach($fractionations as $key => $fractionation)
			<tr>
				<td>{{ $fractionation->id }}</td>
        		<td>{{ Carbon\Carbon::parse($fractionation->date)->format('d/m/Y')}}</td>
                <td>
                    {{ $fractionation->medic ? $fractionation->medic->shortName : '' }}
                </td>
                <td>
                    {{ $fractionation->patient ? $fractionation->patient->full_name : '' }}
                </td>
                <td>
                    {{ $fractionation->acquirer }}
                </td>
                <td>
                    {{ $fractionation->qfSupervisor ? $fractionation->qfSupervisor->shortName : '' }}
                </td>
        		<td>{{ $fractionation->notes }}</td>
				<td nowrap>
					@can('Pharmacy: edit_delete')
					<a href="{{ route('pharmacies.products.fractionation.edit', $fractionation) }}" class="btn btn-outline-secondary btn-sm">
					    <span class="fas fa-edit" aria-hidden="true"></span>
                    </a>

					<form method="POST" action="{{ route('pharmacies.products.fractionation.destroy', $fractionation) }}" class="d-inline">
			            @csrf
			            @method('DELETE')
						<button type="submit" @disabled($fractionation->items->count() > 0) class="btn btn-outline-secondary btn-sm" onclick="return confirm('¿Está seguro de eliminar la información?');">
							<span class="fas fa-trash-alt" aria-hidden="true"></span>
						</button>
					</form>
					@endcan
					<a href="{{ route('pharmacies.products.fractionation.record', $fractionation) }}"
						class="btn btn-outline-secondary btn-sm" target="_blank">
					<span class="fas fa-file" aria-hidden="true"></span></a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

{{ $fractionations->links() }}

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

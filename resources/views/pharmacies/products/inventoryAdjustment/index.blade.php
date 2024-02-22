@extends('layouts.bt4.app')

@section('title', 'Listado de ajustes de inventarios')

@section('content')

@include('pharmacies.nav')

<h3>Listado de ajustes de inventarios</h3>

<div class="mb-3">
	@canany(['Pharmacy: create'])
	<a class="btn btn-primary"
		href="{{ route('pharmacies.products.inventory_adjustments.create') }}">
		<i class="fas fa-plus-circle"></i> Nuevo ajuste de inventarios</a>
	@endcanany

	<button type="button" class="btn btn-outline-primary"
		onclick="tableToExcel('tabla_receiving', 'Ingresos')">
		<i class="fas fa-download"></i>
	</button>
</div>


<div class="table-responsive">
	<table class="table table-striped table-sm" id="tabla_receiving">
		<thead>
			<tr>
				<th scope="col">id</th>
				<th scope="col">Fecha</th>
				<th scope="col">Tipo de ajuste</th>
				<th scope="col">Notas</th>
				<th scope="col">Creador</th>
                <th scope="col"></th>
			</tr>
		</thead>
		<tbody>
            @foreach($inventoryAdjustments as $inventoryAdjustment)
            <tr>
                <td>{{$inventoryAdjustment->id}}</td>
                <td>{{$inventoryAdjustment->date->format('Y-m-d')}}</td>
                <td>{{$inventoryAdjustment->type->name}}</td>
                <td>{{$inventoryAdjustment->notes}}</td>
                <td>{{$inventoryAdjustment->user->shortName}}</td>
                <td  nowrap>
				    @can('Pharmacy: edit_delete')
					<a href="{{ route('pharmacies.products.inventory_adjustments.edit', $inventoryAdjustment) }}" class="btn btn-outline-secondary btn-sm">
					<span class="fas fa-edit" aria-hidden="true"></span></a>

					<form method="POST" action="{{ route('pharmacies.products.inventory_adjustments.destroy', $inventoryAdjustment) }}" class="d-inline">
			            @csrf
			            @method('DELETE')
						<button type="submit" class="btn btn-outline-secondary btn-sm" onclick="return confirm('¿Está seguro de eliminar la información?');">
							<span class="fas fa-trash-alt" aria-hidden="true"></span>
						</button>
					</form>
					@endcan
                </td>
            </tr>
            @endforeach
		</tbody>
	</table>
</div>

{{ $inventoryAdjustments->links() }}

@endsection

@section('custom_js')

@endsection

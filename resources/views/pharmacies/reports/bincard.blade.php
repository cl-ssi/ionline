@extends('layouts.bt4.app')

@section('title', 'Informe Bincard')

@section('content')

@include('pharmacies.nav')

<h3>Informe Bincard</h3>

<form method="GET" class="form-horizontal" action="{{ route('pharmacies.reports.bincard') }}">

	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text">Rango de fechas</span>
		</div>
		<input type="date" class="form-control" id="for_dateFrom" name="dateFrom"
			value="{{ ($request->get('dateFrom'))?$request->get('dateFrom'):date('Y-m-01') }}"
			required >
		<input type="date" class="form-control" id="for_dateTo" name="dateTo"
			value="{{ ($request->get('dateTo'))?$request->get('dateTo'):date('Y-m-t') }}"
			required>
	</div>

    <div class="input-group mb-3">
      <div class="input-group-prepend">
          <span class="input-group-text">Productos</span>
      </div>

          <select name="product_id" class="form-control selectpicker" for="for_supplier">
            <!--<option value="0">Todos</option>--> <!--no debe ir, ya que el bincard es por cada producto -->
            @foreach ($products as $key => $product)
              <option value="{{$product->id}}" @if ($product->id == $request->get('product_id'))
                selected
              @endif>{{$product->name}}</option>
            @endforeach
          </select>
          <div class="input-group-append">
              <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
          </div>
    </div>

</form>

<div class="table-responsive">
	<table class="table table-striped table-sm" id="tabla_bincard">
		<thead>
			<tr>
				<th scope="col">TIPO</th>
				<th scope="col">FECHA</th>
				<th scope="col">ORIGEN/DESTINO</th>
				<th scope="col">INGRESO</th>
				<th scope="col">SALIDA</th>
				<th scope="col">SALDO</th>
				<th scope="col">NOTAS</th>
				<th scope="col">ACTA</th>
				<th scope="col">LOTE</th>
				<th scope="col"></th>
				<th>
					<button type="button" class="btn btn-sm btn-outline-primary" onclick="exportTableToExcel('tabla_bincard', 'Bincard')">
						<i class="fas fa-download"></i>
					</button>
				</th>
			</tr>
		</thead>
		<tbody>
			@foreach($matrix as $item)
				@if($item['tipo'] != '')
					<tr>
						<td>{{ $item['tipo'] }}</td>
						<td>{{ $item['date'] }}</td>
						<td>{{ $item['origen_destino'] }}</td>
						<td>{{ $item['ingreso'] }}</td>
						<td>{{ $item['salida'] }}</td>
						<td>{{ $item['saldo'] }}</td>
						<td>{{ $item['notas'] }}</td>
						<td>{{ $item['act_number'] }}</td>
						<td>{{ $item['product_batch'] }}</td>
						<td>
							@if($item['tipo'] == "Salida")
								<a href="{{ route('pharmacies.products.dispatch.openFile', $item['file']) }}"
										class="btn btn-outline-secondary btn-sm" target="_blank">
									<span class="fas fa-download" aria-hidden="true" style="color: green;"></span>
								</a>
							@endif
						</td>
						<td>
							<a href="{{ route('pharmacies.products.'.$item['type'].'.edit', $item['id']) }}"
								class="btn btn-outline-secondary btn-sm">
								<span class="fas fa-edit" aria-hidden="true"></span>
							</a>
						</td>
					</tr>
				@endif
			@endforeach
		</tbody>
	</table>
</div>

@endsection

@section('custom_js')
<script>
function exportTableToExcel(tableId, filename = '') {
    const table = document.getElementById(tableId);
    const wb = XLSX.utils.table_to_book(table, {sheet: "Sheet JS"});
    XLSX.writeFile(wb, filename + '.xlsx');
}
</script>
@endsection

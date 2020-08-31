@extends('layouts.app')

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
				<th>
					<button type="button" class="btn btn-sm btn-outline-primary"
						onclick="tableToExcel('tabla_bincard', 'Bincard')">
						<i class="fas fa-download"></i>
					</button>
				</th>
			</tr>
		</thead>
		<tbody>
			@if($matrix[0]['tipo'] <> '')
					@for($i = count($matrix)-1; $i >= 0; $i--)
					<tr>
						<td>{{ $matrix[$i]['tipo'] }}</td>
						<td>{{ $matrix[$i]['date'] }}</td>
						<td>{{ $matrix[$i]['origen_destino'] }}</td>
						<td>{{ $matrix[$i]['ingreso'] }}</td>
						<td>{{ $matrix[$i]['salida'] }}</td>
						<td>{{ $matrix[$i]['saldo'] }}</td>
						<td>{{ $matrix[$i]['notas'] }}</td>
						<td>
							<a href="{{ route('pharmacies.products.'.$matrix[$i]['type'].'.edit', $matrix[$i]['id']) }}"
								class="btn btn-outline-secondary btn-sm">
							<span class="fas fa-edit" aria-hidden="true"></span></a>
						</td>
					</tr>
					@endfor
			@endif
		</tbody>
	</table>
</div>

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

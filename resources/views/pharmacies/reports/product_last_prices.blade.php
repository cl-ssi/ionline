@extends('layouts.app')

@section('title', 'Últimos precios de costo de Productos')

@section('content')

@include('pharmacies.nav')

<h3>Últimos precios de costo de Productos</h3>

<form method="GET" class="form-horizontal" action="{{ route('pharmacies.reports.product_last_prices') }}">

    <div class="input-group mb-3">
    	<div class="input-group-prepend">
    		<span class="input-group-text">Productos</span>
    	</div>
    	<select name="product_id" class="form-control">
    		<option value="0">Todos</option>
    		@foreach ($products as $key => $product)
    		<option value="{{$product->id}}" @if ($product->id == $request->get('product_id'))
    		selected
    		@endif>{{$product->name}}</option>
    		@endforeach
    	</select>
    	<div class="input-group-append">
    		<button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Buscar
            </button>
    	</div>
    </div>

</form>

<div class="table-responsive">
	<table class="table table-striped table-sm" id="tabla_last">
		<thead>
			<tr>
				<th scope="col">PRODUCTO</th>
				<th scope="col">P.UNIT</th>
				<th scope="col">FECHA</th>
				<th scope="col">LINEA</th>
                <th>
                    <button type="button" class="btn btn-sm btn-outline-primary"
                        onclick="tableToExcel('tabla_last', 'Hoja 1')">
                        <i class="fas fa-download"></i>
                    </button>
                </th>
			</tr>
		</thead>
		<tbody>
      @foreach ($purchaseItems as $key => $purchaseItem)
        <tr>
          <td>{{$purchaseItem->product->name}}</td>
          <td>{{$purchaseItem->unit_cost}}</td>
          <td>{{$purchaseItem->purchase->date->format('d/m/Y')}}</td>
          <td colspan="2">{{$purchaseItem->product->category->name}}</td>
        </tr>
      @endforeach
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

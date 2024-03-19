@extends('layouts.bt4.app')

@section('title', 'Productos')

@section('content')

@include('pharmacies.nav')

<h3>Reporte de productos por f.vencimiento/lote</h3>

<form method="GET" class="form-horizontal" action="{{ route('pharmacies.reports.productsbybatch') }}">

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

        <div class="input-group-prepend">
            <span class="input-group-text">Programa</span>
        </div>
        <input type="text" class="form-control" name="program" {{ ($request->get('program'))?'value='.$request->get('program'):'' }}>

        <div class="input-group-prepend">
            <span class="input-group-text">Estado del producto</span>
        </div>
        <select name="status" class="form-control" id="" required>
            <option value="0" @selected($request->status == 0)>Con Stock - No vencidos</option>
            <option value="1" @selected($request->status == 1)>Con Stock - Vencidos</option>
            <option value="2" @selected($request->status == 2)>Sin Stock - No vencidos</option>
            <option value="3" @selected($request->status == 3)>Sin Stock - Vencidos</option>
            <option value="4" @selected($request->status == 4)>Todos</option>
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
                <th scope="col">PROGRAMA</th>
				<th scope="col">F.VENC</th>
				<th scope="col">LOTE</th>
                <th scope="col">CANTIDAD</th>
                <th>
                    <button type="button" class="btn btn-sm btn-outline-primary"
                        onclick="tableToExcel('tabla_last', 'Hoja 1')">
                        <i class="fas fa-download"></i>
                    </button>
                </th>
			</tr>
		</thead>
		<tbody>

        @foreach ($products_data as $key => $product)
            @foreach ($product->batchs as $key => $batch)
            @if($batch->due_date < now()) <tr class="table-danger">
            @else <tr> @endif
                <td>{{$product->name}}</td>
                <td>{{$product->program->name}}</td>
                <td>{{$batch->due_date->format('d/m/Y')}}</td>
                <td>{{$batch->batch}}</td>
                <td>{{$batch->count}}</td>
            </tr>
            @endforeach
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

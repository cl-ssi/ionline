@extends('layouts.app')

@section('title', 'Consumos históricos')

@section('content')

@include('pharmacies.nav')

<h3>Consumos históricos</h3>

<form method="GET" id="notice" class="form-horizontal" action="{{ route('pharmacies.reports.consume_history') }}">

    <div class="input-group mb-3">
    	<div class="input-group-prepend">
    		<span class="input-group-text">Año</span>
    	</div>
    	<select name="year" class="form-control">
    		<option value="{{Carbon\Carbon::now()->format('Y')-1}}">{{Carbon\Carbon::now()->format('Y')-1}}</option>
    		<option value="{{Carbon\Carbon::now()->format('Y')}}" selected>{{Carbon\Carbon::now()->format('Y')}}</option>
    		<option value="{{Carbon\Carbon::now()->format('Y')+1}}">{{Carbon\Carbon::now()->format('Y')+1}}</option>
    	</select>
    </div>
    <div class="input-group mb-3">
    	<div class="input-group-prepend">
    		<span class="input-group-text">Categorías</span>
    	</div>
    	<select name="category_id" class="form-control">
    		<option value="0">Todos</option>
    		@foreach ($categories as $key => $category)
        		<option value="{{$category->id}}" @if ($category->id == $request->get('category_id'))
        		selected
        		@endif >{{$category->name}}</option>
    		@endforeach
    	</select>
    </div>
    <div class="input-group mb-3">
    	<div class="input-group-prepend">
    		<span class="input-group-text">Establecimientos</span>
    	</div>
    	<select name="establishment_id" class="form-control">
    		<option value="0">Todos</option>
    		@foreach ($establishments as $key => $establishment)
    		<option value="{{$establishment->id}}"
                @if ($establishment->id == $request->get('establishment_id'))
    		          selected
    		    @endif >{{$establishment->name}}</option>
    		@endforeach
    	</select>
    	<div class="input-group-append">
    		<button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
    	</div>
    </div>

</form>

@if ($request->get('year') <> 0)
<button type="button" class="btn btn-sm btn-outline-primary mb-3"
    onclick="tableToExcel('tabla_consumos', 'Bincard')">
    <i class="fas fa-download"></i>
</button>
@endif

<div class="table-responsive">
	<table class="table table-striped table-sm small" id="tabla_consumos">
		<thead>
			<tr>
				<th scope="col">PRODUCTO</th>
				<th scope="col">LINEA</th>
				<!--<th class="text-right" scope="col">STOCK</th>-->
				<th class="text-center" scope="col">ENE</th>
        <th class="text-center" scope="col">FEB</th>
        <th class="text-center" scope="col">MAR</th>
        <th class="text-center" scope="col">ABR</th>
        <th class="text-center" scope="col">MAY</th>
        <th class="text-center" scope="col">JUN</th>
        <th class="text-center" scope="col">JUL</th>
        <th class="text-center" scope="col">AGO</th>
        <th class="text-center" scope="col">SEP</th>
        <th class="text-center" scope="col">OCT</th>
        <th class="text-center" scope="col">NOV</th>
        <th class="text-center" scope="col">DIC</th>
        <th scope="text-center" scope="col">TOTAL</th>
			</tr>
		</thead>
		<tbody>
        @if ($request->get('year') <> 0)
          @if ($matrix <> NULL)
              @foreach ($matrix as $i => $fila)
              <tr>
                  <td>{{$fila['product_name']}}</td>
                  <td>{{$fila['category']}}</td>
                  <!--<td class="text-right">@numero( $fila['stock'] )</td>-->
                  @for ($i=1; $i <= 12; $i++)
                      <td class="text-center">{{ $fila[$i] }}</td>
                  @endfor
                  <td class="text-center">@numero( $fila['total'] )</td>
              </tr>
              @endforeach
          @endif
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

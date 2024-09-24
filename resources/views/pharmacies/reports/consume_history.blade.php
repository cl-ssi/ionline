@extends('layouts.bt4.app')

@section('title', 'Consumos históricos')

@section('content')

@include('pharmacies.nav')

<h3>Consumos históricos</h3>

<form method="GET" id="notice" class="form-horizontal" action="{{ route('pharmacies.reports.consume_history') }}">

    <div class="input-group mb-3">
    	<div class="input-group-prepend">
    		<span class="input-group-text">Año</span>
    	</div>
    	<select name="year" class="form-control" required>
            <option value="{{Carbon\Carbon::now()->format('Y')-3}}" @selected($request->get('year')==Carbon\Carbon::now()->format('Y')-3)>{{Carbon\Carbon::now()->format('Y')-3}}</option>
            <option value="{{Carbon\Carbon::now()->format('Y')-2}}" @selected($request->get('year')==Carbon\Carbon::now()->format('Y')-2)>{{Carbon\Carbon::now()->format('Y')-2}}</option>
    		<option value="{{Carbon\Carbon::now()->format('Y')-1}}" @selected($request->get('year')==Carbon\Carbon::now()->format('Y')-1)>{{Carbon\Carbon::now()->format('Y')-1}}</option>
    		<option value="{{Carbon\Carbon::now()->format('Y')}}" @selected($request->get('year')==Carbon\Carbon::now()->format('Y'))>{{Carbon\Carbon::now()->format('Y')}}</option>
    		<option value="{{Carbon\Carbon::now()->format('Y')+1}}" @selected($request->get('year')==Carbon\Carbon::now()->format('Y')+1)>{{Carbon\Carbon::now()->format('Y')+1}}</option>
    	</select>
    </div>
    <div class="input-group mb-3">
    	<div class="input-group-prepend">
    		<span class="input-group-text">Categorías</span>
    	</div>
    	<select name="category_id" class="form-control" required>
    		<option value=""></option>
    		@foreach ($categories as $key => $category)
        		<option value="{{$category->id}}" @if ($category->id == $request->get('category_id'))
        		selected
        		@endif >{{$category->name}}</option>
    		@endforeach
    	</select>
    </div>
    <div class="input-group mb-3">
    	<div class="input-group-prepend">
    		<span class="input-group-text">Programas</span>
    	</div>
    	<select name="program_id" class="form-control" required>
    		<option value=""></option>
    		@foreach ($programs as $key => $program)
        		<option value="{{$program->id}}" @if ($program->id == $request->get('program_id'))
        		selected
        		@endif >{{$program->name}}</option>
    		@endforeach
    	</select>
    </div>
    <div class="input-group mb-3">
    	<div class="input-group-prepend">
    		<span class="input-group-text">Destinos</span>
    	</div>
    	<select name="destiny_id" class="form-control">
    		<option value="0">Todos</option>
    		@foreach ($destines as $key => $destiny)
    		<option value="{{$destiny->id}}"
                @if ($destiny->id == $request->get('destiny_id'))
    		          selected
    		    @endif >{{$destiny->name}}</option>
    		@endforeach
    	</select>
    	<div class="input-group-append">
    		<button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
    	</div>
    </div>

</form>

@if ($request->get('year') <> 0)
<button type="button" class="btn btn-sm btn-outline-primary mb-3"
onclick="exportTableToExcel('tblData')">
    <i class="fas fa-download"></i>
</button>
@endif

<div class="table-responsive">
	<table class="table table-striped table-sm small" id="tblData">
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
	function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
</script>
@endsection

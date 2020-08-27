@extends('layouts.app')

@section('title', 'Informe de movimientos')

@section('content')

@include('pharmacies.nav')

<h3>Informe de Movimientos</h3>

<form method="GET" class="form-horizontal" action="{{ route('pharmacies.reports.informe_movimientos') }}">
  <div class="row">
    <fieldset class="form-group col-2">
          <input type="radio" name="tipo" value="1" @if ($request->get('tipo') == 1 || $request->get('tipo') == NULL)
            checked="checked"
          @endif onclick="show1()"> Compras
    </fieldset>
    <fieldset class="form-group col-2">
      <input type="radio" name="tipo" value="2" @if ($request->get('tipo') == 2)
            checked="checked"
          @endif onclick="show2()"> Ingresos
    </fieldset>
    <fieldset class="form-group col-2">
      <input type="radio" name="tipo" value="3" @if ($request->get('tipo') == 3)
            checked="checked"
          @endif  onclick="show2()"> Egresos
    </fieldset>
  </div>

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
          <span class="input-group-text">Establecimientos</span>
      </div>

        <select id="establishment_id" name="establishment_id" class="form-control selectpicker" for="for_$establishment" >
          <option value="0">Todos</option>
          @foreach ($establishments as $key => $establishment)
            <option value="{{$establishment->id}}" @if ($establishment->id == $request->get('establishment_id'))
              selected
            @endif>{{$establishment->name}}</option>
          @endforeach
        </select>
    </div>

    <div class="input-group mb-3">
      <div class="input-group-prepend">
          <span class="input-group-text">Programa</span>
      </div>
      <input type="text" class="form-control" id="program" name="program" {{ ($request->get('program'))?'value='.$request->get('program'):'' }}>
    </div>

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Proveedores</span>
        </div>

          <select id="supplier_id" name="supplier_id" class="form-control selectpicker" for="for_supplier">
            <option value="0">Todos</option>
            @foreach ($suppliers as $key => $supplier)
              <option value="{{$supplier->id}}" @if ($supplier->id == $request->get('supplier_id'))
                selected
              @endif>{{$supplier->name}}</option>
            @endforeach
          </select>
    </div>

    <div class="input-group mb-3">
      <div class="input-group-prepend">
          <span class="input-group-text">Notas</span>
      </div>

          <input type="text" class="form-control" id="for_notas" name="notes" {{ ($request->get('notes'))?'value='.$request->get('notes'):'' }}>
          <div class="input-group-append">
              <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
          </div>
    </div>
</form>

<!-- compras -->
@if ($request->get('tipo') == 1)

  <div class="table-responsive">
  	<table class="table table-striped table-sm" id="tabla_movimientos">
  		<thead>
  			<tr>
  				<th scope="col">FECHA</th>
  				<th scope="col">PROVEEDOR</th>
  				<th scope="col">FACTURA</th>
                <th scope="col">GUIA</th>
                <th scope="col">F.DOC</th>
                <th scope="col">DESTINO</th>
                <th scope="col">FONDOS</th>
                <th scope="col">ACTA</th>
                <th>
                    <button type="button" class="btn btn-sm btn-outline-primary"
                        onclick="tableToExcel('tabla_movimientos', 'Movimientos')">
                        <i class="fas fa-download"></i>
                    </button>
                </th>
  			</tr>
  		</thead>
  		<tbody>
  			@foreach($dataCollection as $key => $data)
  					<tr>
  		        <td>{{$data->date->format('d/m/Y')}}</td>
  						<td>{{$data->supplier->name}}</td>
              <td>{{$data->invoice}}</td>
              <td>{{$data->despatch_guide}}</td>
              <td>{{$data->invoice_date}}</td>
              <td>{{$data->destination}}</td>
              <td>{{$data->from}}</td>
              <!--<td>{{$data->acceptance_certificate}}</td>-->
              <td>
                  <a href="{{ route('pharmacies.products.purchase.edit', $data) }}"
                      class="btn btn-outline-secondary btn-sm">
                  <span class="fas fa-edit" aria-hidden="true"></span></a>
              </td>
  					</tr>
  			@endforeach
  		</tbody>
  	</table>
  </div>

@endif

<!-- ingresos -->
@if ($request->get('tipo') == 2)
  <div class="table-responsive">
  	<table class="table table-striped table-sm" id="TableFilter">
  		<thead>
  			<tr>
  				<th scope="col">FECHA</th>
  				<th scope="col">ORIGEN</th>
  				<th scope="col">NOTAS</th>
  			</tr>
  		</thead>
  		<tbody>
  			@foreach($dataCollection as $key => $data)
  					<tr>
  		        <td>{{$data->date->format('d/m/Y')}}</td>
  						<td>{{$data->establishment->name}}</td>
              <td>{{$data->notes}}</td>
  					</tr>
  			@endforeach
  		</tbody>
  	</table>
  </div>

@endif

<!-- egresos -->
@if ($request->get('tipo') == 3)

  <div class="table-responsive">
  	<table class="table table-striped table-sm" id="TableFilter">
  		<thead>
  			<tr>
  				<th scope="col">FECHA</th>
  				<th scope="col">DESTINO</th>
  				<th scope="col">NOTAS</th>
  			</tr>
  		</thead>
  		<tbody>
  			@foreach($dataCollection as $key => $data)
  					<tr>
  		        <td>{{$data->date->format('d/m/Y')}}</td>
  						<td>{{$data->establishment->name}}</td>
              <td>{{$data->notes}}</td>
              {{-- <td>{{$data->dispatchItems->first()->product->program}}</td> --}}
  					</tr>
  			@endforeach
  		</tbody>
  	</table>
  </div>

@endif

@endsection

@section('custom_js')
  <script>
    window.onload = function() {
      if (document.getElementsByName('tipo')[0].checked) {
        show1();
      }
      else{
        show2();
      }
    }

    function show1(){
      document.getElementById('establishment_id').disabled =true;
      document.getElementById('program').disabled =true;
      document.getElementById('supplier_id').disabled =false;
    }
    function show2(){
      document.getElementById('establishment_id').disabled = false;
      document.getElementById('program').disabled = false;
      document.getElementById('supplier_id').disabled = true;
    }

    var tableToExcel = (function() {
        var uri = 'data:application/vnd.ms-excel;base64,'
        , template = '<html </head><body><table>{table}</table></body></html>'
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

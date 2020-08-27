@extends('layouts.app')

@section('title', 'Informe de compras')

@section('content')

@include('pharmacies.nav')

<h3>Informe de compras</h3>

<form method="GET" class="form-horizontal" action="{{ route('pharmacies.reports.purchase_report') }}">
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
          <span class="input-group-text">Factura</span>
      </div>
      <input type="text" class="form-control" name="invoice" {{ ($request->get('invoice'))?'value='.$request->get('invoice'):'' }}>

      <div class="input-group-prepend">
          <span class="input-group-text">Acta</span>
      </div>
      <input type="text" class="form-control" name="acceptance_certificate" {{ ($request->get('acceptance_certificate'))?'value='.$request->get('acceptance_certificate'):'' }}>

      <div class="input-group-prepend">
          <span class="input-group-text">Programa</span>
      </div>
      <input type="text" class="form-control" name="program" {{ ($request->get('program'))?'value='.$request->get('program'):'' }}>

    </div>


    <div class="input-group mb-3">
      <div class="input-group-prepend">
          <span class="input-group-text">Proveedores</span>
      </div>

          <select name="supplier_id" class="form-control selectpicker" for="for_supplier">
            <option value="0">Todos</option>
            @foreach ($suppliers as $key => $supplier)
              <option value="{{$supplier->id}}" @if ($supplier->id == $request->get('supplier_id'))
                selected
              @endif>{{$supplier->name}}</option>
            @endforeach
          </select>
          <div class="input-group-append">
              <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
          </div>
    </div>
</form>

<div class="table-responsive">
	<table class="table table-striped table-sm" id="tabla_compras">
		<thead>
			<tr>
				<th scope="col">FECHA</th>
				<th scope="col">PROVEEDOR</th>
				<th scope="col">FACTURA</th>
				<th scope="col">GUIA</th>
				<th scope="col">F.FACT</th>
                <th scope="col">DESTINO</th>
                <th scope="col">FONDOS</th>
                <th scope="col">ACTA</th>
                <th>
                    <button type="button" class="btn btn-sm btn-outline-primary"
                        onclick="tableToExcel('tabla_compras', 'Compras')">
                        <i class="fas fa-download"></i>
                    </button>
                </th>
			</tr>
		</thead>
		<tbody>
			@foreach($purchases as $key => $purchase)
				<tr>
		        <td>{{$purchase->date->format('d/m/Y')}}</td>
		        <td>{{$purchase->supplier->name}}</td>
                <td>{{$purchase->invoice}}</td>
                <td>{{$purchase->despatch_guide}}</td>
                <td>{{$purchase->invoice_date}}</td>
                <td>{{$purchase->destination}}</td>
                <td>{{$purchase->from}}</td>
                <!--<td>{{$purchase->acceptance_certificate}}</td>-->
                <td>{{$purchase->id}}</td>
                <td>
                    <a href="{{ route('pharmacies.products.purchase.edit', $purchase) }}"
                        class="btn btn-outline-secondary btn-sm">
                    <span class="fas fa-edit" aria-hidden="true"></span></a>
                </td>
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

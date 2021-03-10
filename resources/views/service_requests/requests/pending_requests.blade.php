@extends('layouts.app')

@section('title', 'Reporte COVID-19')

@section('content')

<h3 class="mb-3">Reporte estado de solicitudes</h3>

<form method="GET" class="form-horizontal" action="{{ route('rrhh.service_requests.consolidated_data') }}">
	<div class="input-group mb-3">
		<div class="input-group-prepend">
			<span class="input-group-text">Rango de fechas (Inicio de contrato)</span>
		</div>
		<!-- <input type="date" class="form-control" id="for_dateFrom" name="dateFrom" value="2021-01-01" required >
		<input type="date" class="form-control" id="for_dateTo" name="dateTo" value="2021-01-31" required> -->
		<input type="text" value="Todos los datos" disabled>
    <div class="input-group-append">
        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
    </div>
	</div>
</form>

<!-- <hr> -->

<h4>Usuarios con hojas de ruta pendientes por visar</h4>
<!-- <hr> -->
<table class="table table-sm small table-striped" >
    <thead>
        <tr>
            <th>FUNCIONARIO</th>
            <th>CANTIDAD</th>
        </tr>
    </thead>
    <tbody>
      @foreach($group_array as $key => $data)
      @if($key != NULL)
        <tr>
          <td nowrap>{{$key}}</td>
          <td nowrap>{{$data}}</td>
        </tr>
      @endif
      @endforeach
      <tr>
        <td nowrap>Total</td>
        <td nowrap><b>{{$hoja_ruta_falta_aprobar}}</b></td>
      </tr>
    </tbody>
</table>

<!-- <h4>Detalle</h4>
<hr>
<table class="table table-sm small" >
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">APROBADAS</th>
            <th scope="col">RECHAZADAS</th>
            <th scope="col">VISADOR PENDIENTE</th>
        </tr>
    </thead>
    <tbody>
      @foreach($array as $key => $data)
        <tr>
          <td nowrap>{{$key}}</td>
          <td nowrap>{{$data['aprobados']}}</td>
          <td nowrap>{{$data['rechazados']}}</td>
          <td nowrap>{{$data['falta_aprobar']}}</td>
        </tr>
      @endforeach
    </tbody>
</table> -->

<h4>Cumplimientos pendientes por ingresar</h4>
<!-- <hr> -->
<table class="table table-sm small table-striped" >
    <thead>
        <tr>
            <th>SUPERVISOR</th>
						<th>UNIDAD</th>
            <th>CANTIDAD</th>
        </tr>
    </thead>
    <tbody>
      @foreach($fulfillments_missing as $key => $fulfillment)
				@foreach($fulfillment as $key2 => $cant)
	        <tr>
	          <td nowrap>{{$key}}</td>
						<td nowrap>{{$key2}}</td>
	          <td nowrap>{{$cant}}</td>
	        </tr>
				@endforeach
      @endforeach
			<tr>
				<td nowrap></td>
        <td nowrap>Total</td>
        <td nowrap><b>{{$cumplimiento_falta_ingresar}}</b></td>
      </tr>
    </tbody>
</table>


@endsection

@section('custom_js_head')
<script type="text/javascript">

</script>
@endsection

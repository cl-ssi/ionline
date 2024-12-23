@extends('layouts.bt4.app')

@section('title', 'Reporte contratos activos')

@section('content')

@include('service_requests.partials.nav')

<h3 class="mb-3">Reporte contratos activos</h3>

<form method="GET" class="form-horizontal" action="{{ route('rrhh.service-request.report.active_contracts_report') }}">
	<div class="form-row mb-3">
        <div class="form-group col">
			<label>Programas</label>
			<select class="form-control" name="programm_name" data-size="5">
                <option value=""></option>
                @foreach($programm_name_array as $item)
				    <option value="{{$item->programm_name}}" @selected($request->programm_name == $item->programm_name)>{{$item->programm_name}}</option>
                @endforeach
			</select>
		</div>
        <div class="form-group col">
			<label>Profesión</label>
			<select class="form-control" name="profession_id" data-size="5">
                <option value=""></option>
                @foreach($professions_array as $profession)
				    <option value="{{$profession->id}}" @selected($request->profession_id == $profession->id)>{{$profession->name}}</option>
                @endforeach
			</select>
		</div>
		<div class="form-group col-2 col-md-1">
			<label>&nbsp;</label>
			<button type="submit" class="btn btn-primary form-control"><i class="fas fa-search"></i> Buscar</button>
		</div>
	</div>
</form>

<hr>

<h4>Solicitudes Activas <b>({{$serviceRequests->count()}})</b></h4><br>
<a class="btn btn-outline-success btn-sm mb-3" id="downloadLink" onclick="exportF(this)">Descargar en excel</a>

<table class="table table-sm table-bordered table-responsive small" id="tabla">
	<thead>
		<tr class="text-center">
			<th>ID</th>
			<th>N° CONTRATO</th>
            <th>T.CONTRATO</th>
            <th>NOMBRE DEL PROGRAMA SIRH</th>
            <th>EQUIPO RRHH</th>
			<th>HORAS SEMANALES CONTRATADAS</th>
			<th>RUT</th>
			<th>APELLIDOS Y NOMBRES</th>
			<th>UNIDAD</th>
			<th>FECHA INICIO</th>
			<th>FECHA TÉRMINO</th>
		</tr>
	</thead>
	<tbody>
		@foreach($serviceRequests as $key => $serviceRequest)
            <tr class="table-success">
                <td nowrap>{{$serviceRequest->id}}</td>
                <td nowrap>{{$serviceRequest->contract_number}}</td>
                <td nowrap>{{$serviceRequest->program_contract_type}}</td>
                <td nowrap>{{$serviceRequest->programm_name}}</td>
                @if($serviceRequest->profession)
                    <td nowrap>{{$serviceRequest->profession->name}} - {{$serviceRequest->working_day_type}}</td>
                @else
                    <td nowrap>{{$serviceRequest->rrhh_team}}</td>
                @endif
                <td nowrap>{{$serviceRequest->weekly_hours}}</td>
                <td nowrap>@if($serviceRequest->employee) {{$serviceRequest->employee->runNotFormat()}} @endif</td>
                <td nowrap>@if($serviceRequest->employee) {{$serviceRequest->employee->fullName}} @endif</td>
                
                <td nowrap>{{$serviceRequest->responsabilityCenter->name}}</td>
                <td nowrap>{{\Carbon\Carbon::parse($serviceRequest->start_date)->format('Y-m-d')}}</td>
                <td nowrap>{{\Carbon\Carbon::parse($serviceRequest->end_date)->format('Y-m-d')}}</td>
                
            </tr>

        @endforeach
	</tbody>
</table>

@endsection

@section('custom_js_head')
<script type="text/javascript">
  let date = new Date()
  let day = date.getDate()
  let month = date.getMonth() + 1
  let year = date.getFullYear()
  let hour = date.getHours()
  let minute = date.getMinutes()

  function exportF(elem) {
    var table = document.getElementById("tabla");
    var html = table.outerHTML;
    var html_no_links = html.replace(/<a[^>]*>|<\/a>/g, ""); //remove if u want links in your table
    var url = 'data:application/vnd.ms-excel,' + escape(html_no_links); // Set your html table into url
    elem.setAttribute("href", url);
    elem.setAttribute("download", "tabla.xls"); // Choose the file name
    return false;
  }
</script>
@endsection
@extends('layouts.bt4.app')

@section('title', 'Reporte consolidado por especialidad')

@section('content')

@include('service_requests.partials.nav')

<h3 class="mb-3">Reporte consolidado por especialidad</h3>

<form method="GET" class="form-horizontal" action="{{ route('rrhh.service-request.report.program_consolidated_report') }}">
	<div class="form-row mb-3">
        <div class="form-group col">
            <label>Año Inicio de Contrato</label>
			<select class="form-control" data-live-search="true" name="year" data-size="5">
                <option value="{{now()->addYear(-3)->format('Y')}}" @selected($request->year == now()->addYear(-3)->format('Y'))> {{now()->addYear(-3)->format('Y')}}</option>
                <option value="{{now()->addYear(-2)->format('Y')}}" @selected($request->year == now()->addYear(-2)->format('Y'))> {{now()->addYear(-2)->format('Y')}}</option>
                <option value="{{now()->addYear(-1)->format('Y')}}" @selected($request->year == now()->addYear(-1)->format('Y'))> {{now()->addYear(-1)->format('Y')}}</option>
				<option value="{{now()->format('Y')}}" @selected($request->year == now()->format('Y'))> {{now()->format('Y')}}</option>
                <option value="{{now()->addYear()->format('Y')}}"  @selected($request->year == now()->addYear()->format('Y'))> {{now()->addYear()->format('Y')}}</option>
			</select>
		</div>
        <div class="form-group col">
			<label>Semestre Inicio de Contrato</label>
			<select class="form-control" data-live-search="true" name="semester" data-size="5">
				<option value="1" @if($request->semester == "1") selected @endif>Enero-Abril</option>
                <option value="2" @if($request->semester == "2") selected @endif>Mayo-Agosto</option>
                <option value="3" @if($request->semester == "3") selected @endif>Septiembre-Diciembre</option>
			</select>
		</div>
        <div class="form-group col">
			<label>Programas</label>
			<select class="form-control" name="programm_name" data-size="5">
                @foreach($programm_name_array as $item)
				    <option value="{{$item->programm_name}}" @selected($request->programm_name == $item->programm_name)>{{$item->programm_name}}</option>
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
			<th>MES PAGO</th>
			<th>COD. SIRH S.S.</th>
			<th>SERVICIO DE SALUD</th>
			<th>COD EST.</th>
			<th>ESTABLECIMIENTO</th>
			<th>RUT</th>
			<th>APELLIDOS Y NOMBRES</th>
			<th>FEC NAC.</th>
			<th>NACIONALIDAD</th>
			<th>NOMBRE DEL PROGRAMA SIRH</th>
			<th>ESTRATEGIA DIGERA COVID</th>
			<th>EQUIPO RRHH</th>
			<th>HORAS SEMANALES CONTRATADAS</th>
			<th>UNIDAD</th>
			<th>ESTAMENTO</th>
			<th>FUNCIÓN</th>
			<th>MONTO BRUTO</th>
			<th>CONTRATO REGISTRADO EN SIRH</th>
			<th>RESOLUCIÓN TRAMITADA</th>
			<th>N° RESOLUCIÓN</th>
			<th>FECHA INICIO</th>
			<th>FECHA TÉRMINO</th>
			<th>BOLETA Nº</th>
			<th>TOTAL HORAS PAGADAS PERIODO</th>
			<th>TOTAL PAGADO</th>
			<th>FECHA PAGO</th>
			<th>T.CONTRATO</th>
			<th>ESTADO.SOLICITUD</th>
			<th>JORNADA TRABAJO</th>
			<th>TIPO</th>
			<th>RENUNCIA</th>
		</tr>
	</thead>
	<tbody>
		@foreach($serviceRequests as $key => $serviceRequest)
            @foreach($serviceRequest->fulfillments as $key2 => $fulfillment)
                <tr class="table-success">
                    <td nowrap>{{$serviceRequest->id}}</td>
                    <td nowrap>{{$serviceRequest->contract_number}}</td>
                    <td nowrap>{{$fulfillment->MonthOfPayment()}}</td>
                    <td nowrap>12</td>
                    <td nowrap>SERVICIO DE SALUD DE IQUIQUE</td>
                    <td nowrap>@if($serviceRequest->establishment){{$serviceRequest->establishment->sirh_code}}@endif</td>
                    <td nowrap>@if($serviceRequest->establishment){{$serviceRequest->establishment->name}}@endif</td>
                    <td nowrap>{{$serviceRequest->employee->runNotFormat()}}</td>
                    <td nowrap>{{$serviceRequest->employee->fullName}}</td>
                    <td nowrap>{{$serviceRequest->employee->birthday? $serviceRequest->employee->birthday->format('d-m-Y'):''}}</td>
                    <td nowrap>@if($serviceRequest->employee->country){{$serviceRequest->employee->country->name}}@endif</td>
                    <td nowrap>{{$serviceRequest->programm_name}}</td>
                    <td nowrap>{{$serviceRequest->digera_strategy}}</td>
                    @if($serviceRequest->profession)
                        <td nowrap>{{$serviceRequest->profession->name}} - {{$serviceRequest->working_day_type}}</td>
                    @else
                        <td nowrap>{{$serviceRequest->rrhh_team}}</td>
                    @endif
                    <td nowrap>{{$serviceRequest->weekly_hours}}</td>
                    <td nowrap>{{$serviceRequest->responsabilityCenter->name}}</td>
                    @if($serviceRequest->profession)
                        <td nowrap>{{$serviceRequest->profession->estamento}}</td>
                        <td nowrap>
                            @if($serviceRequest->profession->category == "E" || $serviceRequest->profession->category == "F")
                                Apoyo Administrativo
                            @else
                                Apoyo Clínico
                            @endif
                        </td>
                    @else
                        <td nowrap>{{$serviceRequest->estate}}</td>
                        <td nowrap>
                            @if($serviceRequest->estate == "Administrativo")
                                Apoyo Administrativo
                            @else
                                Apoyo Clínico
                            @endif
                        </td>
                    @endif
                    <td nowrap>{{$serviceRequest->gross_amount}}</td>
                    <td nowrap>
                        @if($serviceRequest->sirh_contract_registration === 1) Sí
                        @elseif($serviceRequest->sirh_contract_registration === 0) No 
                        @endif
                    </td>
                    <td nowrap>@if($serviceRequest->resolution_number)Sí @else No @endif</td>
                    <td nowrap>@if($serviceRequest->resolution_number){{$serviceRequest->resolution_number}}@else En trámite @endif</td>
                    <td nowrap>{{\Carbon\Carbon::parse($serviceRequest->start_date)->format('Y-m-d')}}</td>
                    <td nowrap>{{\Carbon\Carbon::parse($serviceRequest->end_date)->format('Y-m-d')}}</td>
                    <td nowrap>{{$fulfillment->bill_number}}</td>
                    <td nowrap>{{$fulfillment->total_hours_paid}}</td>
                    <td nowrap>@if($fulfillment->total_paid){{$fulfillment->total_paid}}@else En proceso de pago @endif</td>
                    <td nowrap>@if($fulfillment->payment_date){{$fulfillment->payment_date->format('Y-m-d')}}@endif</td>
                    <td nowrap>{{$serviceRequest->program_contract_type}}</td>
                    <td nowrap>
                        @if($serviceRequest->SignatureFlows->where('status','===',0)->count() > 0) Rechazada
                        @elseif($serviceRequest->SignatureFlows->whereNull('status')->count() > 0) Pendiente
                        @else Finalizada @endif
                    </td>
                    <td nowrap>{{$serviceRequest->working_day_type}}</td>
                    <td nowrap>{{$serviceRequest->type}}</td>
                    <td nowrap>{{$fulfillment->quit_status()}}</td>
                </tr>
            @endforeach 
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
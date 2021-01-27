@extends('layouts.app')

@section('title', 'Reporte COVID-19')

@section('content')

<h3 class="mb-3">Reporte consolidado</h3>

</main><main class="py-4">

<table class="table table-sm table-bordered table-responsive small" >
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
        </tr>
    </thead>
    <tbody>
      @foreach($serviceRequests as $key => $serviceRequest)
        <tr>
          <td nowrap>{{$serviceRequest->id}}</td>
          <td nowrap>{{$serviceRequest->contract_number}}</td>
          <td nowrap>{{$serviceRequest->MonthOfPayment()}}</td>
          <td nowrap>Dato fijo</td>
          <td nowrap>Dato fijo</td>
          <td nowrap>{{$serviceRequest->establishment_id}} falta cod.sirh</td>
          <td nowrap>@if($serviceRequest->establishment){{$serviceRequest->establishment->name}}@endif</td>
          <td nowrap>{{$serviceRequest->rut}}</td>
          <td nowrap>{{$serviceRequest->name}}</td>
          <td nowrap>{{$serviceRequest->nationality}}</td>
          <td nowrap>{{$serviceRequest->programm_name}}</td>
          <td nowrap>{{$serviceRequest->digera_strategy}}</td>
          <td nowrap>{{$serviceRequest->rrhh_team}}</td>
          @if($serviceRequest->program_contract_type == "Horas")
            <td nowrap>{{$serviceRequest->ControlHrs}}</td>
          @else
            <td nowrap>{{$serviceRequest->daily_hours + $serviceRequest->nightly_hours}}</td>
          @endif
          <td nowrap>{{$serviceRequest->responsabilityCenter->name}}</td>
          <td nowrap>{{$serviceRequest->estate}}</td>
          <td nowrap>{{$serviceRequest->service_description}}</td>
          <td nowrap>{{$serviceRequest->gross_amount}}</td>
          <td nowrap>@if($serviceRequest->sirh_contract_registration==1) Sí @else No @endif</td>
          <td nowrap>{{$serviceRequest->resolution_number}}</td>
          <td nowrap></td>
          <td nowrap>{{\Carbon\Carbon::parse($serviceRequest->start_date)->format('Y-m-d')}}</td>
          <td nowrap>{{\Carbon\Carbon::parse($serviceRequest->end_date)->format('Y-m-d')}}</td>
          <td nowrap>{{$serviceRequest->bill_number}}</td>
          <td nowrap>{{$serviceRequest->total_hours_paid}}</td>
          <td nowrap>{{$serviceRequest->total_paid}}</td>
          <td nowrap>{{\Carbon\Carbon::parse($serviceRequest->payment_date)->format('Y-m-d')}}</td>
        </tr>
      @endforeach
    </tbody>
</table>

@endsection

@section('custom_js_head')
<script type="text/javascript">

</script>
@endsection

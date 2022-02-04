@extends('layouts.app')

@section('title', 'Reporte - Cumplimiento')

@section('content')

@include('service_requests.partials.nav')

<form method="GET" class="form-horizontal" action="{{ route('rrhh.service-request.report.compliance') }}">
    <div class="form-row">
    <fieldset class="form-group col-6 col-md-4">
            <label for="for_rut">Rut/Nombre</label>
            <input name="rut" class="form-control" placeholder="Run o nombre" value="{{ old('rut') }}" aucomplete="off">
            </input>
        </fieldset>
        <fieldset class="form-group col-6 col-md-3">
            <label for="for_year">Establecimiento</label>
            <select name="establishment" class="form-control">
                <option value=""></option>
                <option value="1" {{ (old('establishment')==1)?'selected':'' }}>HETG</option>
                <option value="12" {{ (old('establishment')==12)?'selected':'' }}>Reyno</option>
                <option value="38" {{ (old('establishment')==38)?'selected':'' }}>SSI</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-4 col-md-1">
            <label for="for_year">Año</label>
            <select name="year" class="form-control">
                <option value=""></option>
                @foreach($years as $year)
                    <option value="{{ $year }}" {{ (old('year')==$year)?'selected':''}}>{{$year}}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-4 col-md-1">
            <label for="for_month">Mes</label>
            <select name="month" class="form-control text-capitalize">
                <option value=""></option>
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ old('month')==$i ? 'selected':'' }}>
                        {{ Carbon\Carbon::parse("0000-$i-1")->monthName }}
                    </option>
                @endfor
            </select>
        </fieldset>

    <fieldset class="form-group col-4 col-md-1">
            <label for="for_resolution">Resolución</label>
            <select name="resolution" class="form-control">
                <option value="">Todas</option>
                <option value="Yes" @if($request->input('resolution')=='Yes') selected @endif>Con</option>
                <option value="No" @if($request->input('resolution')=='No') selected @endif>Sin</option>
            </select>
        </fieldset>
        <fieldset class="form-group col-6 col-md-2">
            <label for="for_certificate">Certificado</label>
            <select name="certificate" class="form-control">
                <option value="">Todas</option>
                <option value="Yes" @if($request->input('certificate')=='Yes') selected @endif>Con Certificado</option>
                <option value="No" @if($request->input('certificate')=='No') selected @endif>Sin Certificado</option>
            </select>
        </fieldset>
        <fieldset class="form-group col-6 col-md-2">
            <label for="for_ok_responsable">Responsable</label>
            <select name="ok_responsable" class="form-control">
                <option value="">Todos</option>
                <option value="Yes" @if($request->input('ok_responsable')=='Yes') selected @endif>Aprobado</option>
                <option value="No" @if($request->input('ok_responsable')=='No')) selected @endif>Sin Aprobar</option>
            </select>
        </fieldset>
        <fieldset class="form-group col-6 col-md-2">
            <label for="for_ok_rrhh">RRHH</label>
            <select name="ok_rrhh" class="form-control">
                <option value="">Todos</option>
                <option value="Yes" @if($request->input('ok_rrhh')=='Yes') selected @endif>Aprobado</option>
                <option value="No" @if($request->input('ok_rrhh')=='No')) selected @endif>Sin Aprobar</option>
            </select>
        </fieldset>
        <fieldset class="form-group col-6 col-md-2">
            <label for="for_ok_finances">Finanzas</label>
            <select name="ok_finances" class="form-control">
                <option value="">Todas</option>
                <option value="Yes" @if($request->input('ok_finances')=='Yes') selected @endif>Aprobado</option>
                <option value="No" @if($request->input('ok_finances')=='No')) selected @endif>Sin Aprobar</option>
            </select>
        </fieldset>
        <fieldset class="form-group col-6 col-md-2">
            <label for="for_invoice">Boleta</label>
            <select name="invoice" class="form-control">
                <option value="">Todos</option>
                <option value="Yes" @if($request->input('invoice')=='Yes') selected @endif>Con</option>
                <option value="No" @if($request->input('invoice')=='No')) selected @endif>Sin</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_payment_date">Pago</label>
            <select name="payment_date" class="form-control">
                <option value="">Todos</option>
                <option value="P" @if($request->input('payment_date')=='P') selected @endif>Pagado</option>
                <option value="SP" @if($request->input('payment_date')=='SP')) selected @endif>No Pagado</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_type">Origen Financiamiento</label>
            <select name="type" class="form-control">
                <option value="">Todos</option>
                <option value="Covid" @if($request->input('type')=='Covid') selected @endif>Covid</option>
                <option value="Suma Alzada" @if($request->input('type')=='Suma Alzada') selected @endif>Suma Alzada</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-5 col-md-2">
          <label for="for_program_contract_type">Programas</label>
          <select name="programm_name" class="form-control">
    				<option value="">Todos</option>
    				<option value="Covid19-APS No Médicos" @if($request->programm_name == 'Covid19-APS No Médicos') selected @endif >Covid19-APS No Médicos</option>
    				<option value="Covid19-APS Médicos" @if($request->programm_name == 'Covid19-APS Médicos') selected @endif>Covid19-APS Médicos</option>
    				<option value="Covid19 No Médicos" @if($request->programm_name == 'Covid19 No Médicos') selected @endif>Covid19 No Médicos</option>
    				<option value="Covid19 Médicos" @if($request->programm_name == 'Covid19 Médicos') selected @endif>Covid19 Médicos</option>

    				@if(Auth::user()->organizationalUnit->establishment_id == 1)
    				<option value="Covid 2022" @if($request->programm_name == 'Covid 2022') selected @endif>Covid 2022</option>
    				<option value="CONSULTORIO DE LLAMADA" @if($request->programm_name == 'CONSULTORIO DE LLAMADA') selected @endif>CONSULTORIO DE LLAMADA</option>
    				<option value="33 MIL HORAS" @if($request->programm_name == '33 MIL HORAS') selected @endif>33 MIL HORAS</option>
    				<option value="DFL" @if($request->programm_name == 'DFL') selected @endif>DFL</option>
    				<option value="TURNOS VACANTES" @if($request->programm_name == 'TURNOS VACANTES') selected @endif>TURNOS VACANTES</option>
    				<option value="OTROS PROGRAMAS HETG" @if($request->programm_name == 'OTROS PROGRAMAS HETG') selected @endif>OTROS PROGRAMAS HETG</option>
    				<option value="CAMPAÑA INVIERNO" @if($request->programm_name == 'CAMPAÑA INVIERNO') selected @endif>CAMPAÑA INVIERNO</option>
    				<option value="PABELLON TARDE" @if($request->programm_name == 'PABELLON TARDE') selected @endif>PABELLON TARDE</option>
    				<option value="PABELLON GINE" @if($request->programm_name == 'PABELLON GINE') selected @endif>PABELLON GINE</option>
    				<option value="TURNO DE RESIDENCIA" @if($request->programm_name == 'TURNO DE RESIDENCIA') selected @endif>TURNO DE RESIDENCIA</option>
    				<option value="SENDA" @if($request->programm_name == 'SENDA') selected @endif>SENDA</option>

    				@else
    				<option value="PRAPS" @if($request->programm_name == 'PRAPS') selected @endif>PRAPS</option>
    				<option value="PESPI" @if($request->programm_name == 'PESPI') selected @endif>PESPI</option>
    				<option value="CHILE CRECE CONTIGO" @if($request->programm_name == 'CHILE CRECE CONTIGO') selected @endif>CHILE CRECE CONTIGO</option>
    				<option value="OTROS PROGRAMAS SSI" @if($request->programm_name == 'OTROS PROGRAMAS SSI') selected @endif>OTROS PROGRAMAS SSI</option>
    				<option value="LISTA ESPERA" @if($request->programm_name == 'LISTA ESPERA') selected @endif>LISTA ESPERA</option>
    				<option value="CAMPAÑA INVIERNO" @if($request->programm_name == 'CAMPAÑA INVIERNO') selected @endif>CAMPAÑA INVIERNO</option>

    				<option value="ADP DIRECTOR" @if($request->programm_name == 'ADP DIRECTOR') selected @endif>ADP DIRECTOR</option>
    				<option value="SENDA" @if($request->programm_name == 'SENDA') selected @endif>SENDA</option>
    				<option value="LEY DE ALCOHOL" @if($request->programm_name == 'LEY DE ALCOHOL') selected @endif>LEY DE ALCOHOL</option>
    				<option value="SENDA UHCIP" @if($request->programm_name == 'SENDA UHCIP') selected @endif>SENDA UHCIP</option>
    				<option value="SENDA PSIQUIATRIA ADULTO" @if($request->programm_name == 'SENDA PSIQUIATRIA ADULTO') selected @endif>SENDA PSIQUIATRIA ADULTO</option>
    				<option value="SENADIS" @if($request->programm_name == 'SENADIS') selected @endif>SENADIS</option>
    				<option value="SUBT.31" @if($request->programm_name == 'SUBT.31') selected @endif>SUBT.31</option>
    				@endif

          </select>
        </fieldset>

        <fieldset class="form-group col-5 col-md-2">
            <label for="for_program_contract_type">Tipos de contrato</label>
            <select name="program_contract_type" class="form-control">
                <option value="">Todos</option>
                <option value="Mensual" @if($request->input('program_contract_type')=='Mensual') selected @endif>Mensual</option>
                <option value="Horas" @if($request->input('program_contract_type')=='Horas') selected @endif>Horas</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-md-6">
            <label for="for_working_day_type">Jornada de Trabajo</label>
            <select name="working_day_type" class="form-control">
                <option value="">Todas</option>
                <option value="DIURNO" @if($request->input('working_day_type')=='DIURNO') selected @endif>DIURNO</option>
        				<option value="TERCER TURNO" @if($request->input('working_day_type')=='TERCER TURNO') selected @endif>TERCER TURNO</option>
        				<option value="TERCER TURNO - MODIFICADO" @if($request->input('working_day_type')=='TERCER TURNO - MODIFICADO') selected @endif>TERCER TURNO - MODIFICADO</option>
        				<option value="CUARTO TURNO" @if($request->input('working_day_type')=='CUARTO TURNO') selected @endif>CUARTO TURNO</option>
        				<option value="CUARTO TURNO - MODIFICADO" @if($request->input('working_day_type')=='CUARTO TURNO - MODIFICADO') selected @endif>CUARTO TURNO - MODIFICADO</option>
        				<option value="DIURNO PASADO A TURNO" @if($request->input('working_day_type')=='DIURNO PASADO A TURNO') selected @endif>DIURNO PASADO A TURNO</option>
        				<option value="HORA MÉDICA" @if($request->input('working_day_type')=='HORA MÉDICA') selected @endif>HORA MÉDICA</option>
        				<option value="HORA EXTRA" @if($request->input('working_day_type')=='HORA EXTRA') selected @endif>HORA EXTRA</option>
        				<option value="TURNO EXTRA" @if($request->input('working_day_type')=='TURNO EXTRA') selected @endif>TURNO EXTRA</option>
        				<option value="TURNO DE REEMPLAZO" @if($request->input('working_day_type')=='TURNO DE REEMPLAZO') selected @endif >TURNO DE REEMPLAZO</option>
                <option value="DIARIO" @if($request->input('working_day_type')=='DIARIO') selected @endif >DIARIO</option>
            </select>
        </fieldset>

         <fieldset class="form-group col-5 col-md-2">
            <label for="">&nbsp;</label>
            <button type="submit" class="form-control btn btn-primary"><i class="fas fa-search"></i></button>
        </fieldset>

        <fieldset class="form-group col-7 col-md-2">
            <label for="">&nbsp;</label>
            <button type="submit" class="form-control btn btn-outline-primary" title="Descargar Excel" name="excel">Descargar Excel <i class="fas fa-file-excel"></i> </button>
        </fieldset>

    </div>


    <!-- <button type="submit" name="excel" class="form-control btn btn-primary"><i class="fas fa-file-excel"></i></button> -->


    <!--
        <a type="button" class="btn btn-outline-primary" title="Descargar Excel" href="#"
        id="downloadLink">Descargar Excel <small>(todos)</small> <i class="fas fa-file-excel"></i> </a> -->



</form>

<hr>

<h3 class="mb-3">Reporte de cumplimiento</h3>


    <table class="table table-sm table-bordered table-responsive table-stripped" id="tabla_cumplimiento">
        <tr>
            <th>Ct.</th>
            <th>Id Sol.</th>
            <th nowrap>Rut</th>
            <th>Nombre</th>
            <th>Unidad</th>
            <th>Período</th>
            <th>Tipo</th>
            <th>Tipo de Contrato</th>
            <th>Tipo de Jornada</th>
            <th>Hitos</th>
            <th></th>
        </tr>
        @foreach($fulfillments as $key => $fulfillment)
        <tr>
            <td>{{ ++$key }}</td>
            <td>{{$fulfillment->servicerequest->id?? ''}}
                <span class="small">({{$fulfillment->id}})</span>
            </td>
            <td>{{$fulfillment->servicerequest?$fulfillment->servicerequest->employee->runFormat(): ''}}</td>
            <td class="text-uppercase">{{$fulfillment->servicerequest->employee->fullname?? ''}}</td>
            <td>{{$fulfillment->servicerequest->responsabilityCenter->name??''}}</td>
            <td>{{$fulfillment->year}}-{{$fulfillment->month}}</td>
            <td>{{$fulfillment->servicerequest->type?? ''}}</td>
            <td>{{$fulfillment->servicerequest->program_contract_type?? ''}}</td>
            <td class="small">{{$fulfillment->servicerequest->working_day_type?? ''}}</td>
            <td>
                <i title="Resolución" class="fas fa-file-signature
                    {{ ($fulfillment->serviceRequest->has_resolution_file)?'text-primary':'text-secondary'}}"></i>

                <i title="Certificado" class="fas fa-certificate
                    {{ ($fulfillment->signatures_file_id)?'text-primary':'text-secondary'}}"></i>

                <i title="Aprobado Responsable" class="fas fa-chess-king
                    {{ ($fulfillment->responsable_approbation)?'text-primary':'text-secondary'}}"></i>

                <i title="Aprobado RRHH" class="fas fa-user-shield
                    {{ ($fulfillment->rrhh_approbation)?'text-primary':'text-secondary'}}"></i>

                <i title="Aprobado Finanzas" class="fas fa-piggy-bank
                    {{ ($fulfillment->finances_approbation)?'text-primary':'text-secondary'}}"></i>

                <i title="Boleta" class="fas fa-file-invoice-dollar
                    {{ ($fulfillment->has_invoice_file)?'text-primary':'text-secondary'}}"></i>
                <i title="Pago" class="fas fa-money-bill
                    {{ ($fulfillment->payment_date)?'text-primary':'text-secondary'}}"></i>
            </td>
            <td>
                @if($fulfillment->servicerequest)
                <a href="{{ route('rrhh.service-request.fulfillment.edit',$fulfillment->servicerequest) }}" title="Editar">
                    <span class="fas fa-edit" aria-hidden="true"></span>
                </a>
                @endif
            </td>

        </tr>

        @endforeach
    </table>




{{ $fulfillments->appends(request()->query())->links() }}

@endsection

@section('custom_js')


<script type="text/javascript">
  let date = new Date()
  let day = date.getDate()
  let month = date.getMonth() + 1
  let year = date.getFullYear()
  let hour = date.getHours()
  let minute = date.getMinutes()

  function exportF(elem) {
    //alert('entre acá');
    var table = document.getElementById("tabla_cumplimiento");
    var html = table.outerHTML;
    var html_no_links = html.replace(/<a[^>]*>|<\/a>/g, ""); //remove if u want links in your table
    var url = 'data:application/vnd.ms-excel,' + escape(html_no_links); // Set your html table into url
    elem.setAttribute("href", url);
    alert(table);
    elem.setAttribute("download", "probando.xls"); // Choose the file name
    return false;
  }
</script>


@endsection

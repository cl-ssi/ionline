@extends('layouts.app')

@section('title', 'Reporte - Cumplimiento')

@section('content')

@include('service_requests.partials.nav')

<form method="GET" class="form-horizontal" action="{{ route('rrhh.service-request.report.compliance') }}">
    <div class="form-row">
        <fieldset class="form-group col-4 col-md-2">
            <label for="for_year">Estab</label>
            <select name="establishment" class="form-control">
                <option value=""></option>
                <option value="1" {{ (old('establishment')==1)?'selected':'' }}>HETG</option>
                <option value="12" {{ (old('establishment')==12)?'selected':'' }}>Reyno</option>
                <option value="38" {{ (old('establishment')==38)?'selected':'' }}>SSI</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-12 col-md-2">
            <label for="for_rut">Rut/Nombre</label>
            <input name="rut" class="form-control" placeholder="Run o nombre" value="{{ old('rut') }}" aucomplete="off">
            </input>
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

        <fieldset class="form-group col-4 col-md-2">
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

        <fieldset class="form-group col-4 col-md-2">
            <label for="for_type">Tipo</label>
            <select name="type" class="form-control">
                <option value=""></option>
                <option value="Covid" @if($request->input('type')=='Covid') selected @endif>Covid</option>
                <option value="Suma Alzada" @if($request->input('type')=='Suma Alzada') selected @endif>Suma Alzada</option>
            </select>
        </fieldset>


        <fieldset class="form-group col-6 col-md-2">
            <label for="for_program_contract_type">Tipo de contrato</label>
            <select name="program_contract_type" class="form-control">
                <option value=""></option>
                <option value="Mensual" @if($request->input('program_contract_type')=='Mensual') selected @endif>Mensual</option>
                <option value="Horas" @if($request->input('program_contract_type')=='Horas') selected @endif>Horas</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-2 col-md-1">
            <label for="">&nbsp;</label>
            <button type="submit" class="form-control btn btn-primary"><i class="fas fa-search"></i></button>
        </fieldset>
    </div>

    <div class="form-row">


        <fieldset class="form-group col-6 col-md-1">
            <label for="for_resolution">Resolución</label>
            <select name="resolution" class="form-control">
                <option value=""></option>
                <option value="Yes" @if($request->input('resolution')=='Yes') selected @endif>Con</option>
                <option value="No" @if($request->input('resolution')=='No') selected @endif>Sin</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_certificate">Certificado</label>
            <select name="certificate" class="form-control">
                <option value=""></option>
                <option value="Yes" @if($request->input('certificate')=='Yes') selected @endif>Con Certificado</option>
                <option value="No" @if($request->input('certificate')=='No') selected @endif>Sin Certificado</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_ok_responsable">Responsable</label>
            <select name="ok_responsable" class="form-control">
                <option value=""></option>
                <option value="Yes" @if($request->input('ok_responsable')=='Yes') selected @endif>Aprobado</option>
                <option value="No" @if($request->input('ok_responsable')=='No')) selected @endif>Sin Aprobar</option>
            </select>
        </fieldset>


        <fieldset class="form-group col-6 col-md-2">
            <label for="for_ok_rrhh">RRHH</label>
            <select name="ok_rrhh" class="form-control">
                <option value=""></option>
                <option value="Yes" @if($request->input('ok_rrhh')=='Yes') selected @endif>Aprobado</option>
                <option value="No" @if($request->input('ok_rrhh')=='No')) selected @endif>Sin Aprobar</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_ok_finances">Finanzas</label>
            <select name="ok_finances" class="form-control">
                <option value=""></option>
                <option value="Yes" @if($request->input('ok_finances')=='Yes') selected @endif>Aprobado</option>
                <option value="No" @if($request->input('ok_finances')=='No')) selected @endif>Sin Aprobar</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-6 col-md-1">
            <label for="for_invoice">Boleta</label>
            <select name="invoice" class="form-control">
                <option value=""></option>
                <option value="Yes" @if($request->input('invoice')=='Yes') selected @endif>Con</option>
                <option value="No" @if($request->input('invoice')=='No')) selected @endif>Sin</option>
            </select>
        </fieldset>

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_payment_date">Pago</label>
            <select name="payment_date" class="form-control">
                <option value=""></option>
                <option value="P" @if($request->input('payment_date')=='P') selected @endif>Pagado</option>
                <option value="SP" @if($request->input('payment_date')=='SP')) selected @endif>No Pagado</option>
            </select>
        </fieldset>
    </div>

    <div class="form-row">
    <fieldset class="form-group col-6 col-md-2">
            <label for="for_working_day_type">Jornada de Trabajo</label>
            <select name="working_day_type" class="form-control">
                <option value=""></option>
                <option value="DIURNO" @if($request->input('working_day_type')=='DIURNO') selected @endif>DIURNO</option>
				<option value="TERCER TURNO" @if($request->input('working_day_type')=='TERCER TURNO') selected @endif>TERCER TURNO</option>
				<option value="TERCER TURNO - MODIFICADO" @if($request->input('working_day_type')=='TERCER TURNO - MODIFICADO') selected @endif>TERCER TURNO - MODIFICADO</option>
				<option value="CUARTO TURNO" @if($request->input('working_day_type')=='CUARTO TURNO') selected @endif>CUARTO TURNO</option>
				<option value="CUARTO TURNO - MODIFICADO" @if($request->input('working_day_type')=='CUARTO TURNO - MODIFICADO') selected @endif>CUARTO TURNO - MODIFICADO</option>
				<option value="DIURNO PASADO A TURNO" @if($request->input('working_day_type')=='DIURNO PASADO A TURNO') selected @endif>DIURNO PASADO A TURNO</option>
				<option value="HORA MÉDICA" @if($request->input('working_day_type')=='HORA MÉDICA') selected @endif>HORA MÉDICA</option>
				<option value="HORA EXTRA" @if($request->input('working_day_type')=='HORA EXTRA') selected @endif>HORA EXTRA</option>
				<option value="TURNO EXTRA">TURNO EXTRA</option>
				<option value="TURNO DE REEMPLAZO">TURNO DE REEMPLAZO</option>
            </select>
        </fieldset>

        <div class="col-6 text-right">

        <a type="button" class="btn btn-outline-primary" title="Descargar Excel"
        id="downloadLink" onclick="exportF(this)">Descargar Excel <small>(Resultado primera hoja)</small> <i class="fas fa-file-excel"></i> </a>

        </div>


    </div>

</form>

<hr>

<h3 class="mb-3">Reporte de cumplimiento</h3>

<div class="table-responsive">
    <table class="table table-sm table-bordered table-stripped" id="tabla_cumplimiento">
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

</div>


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
    var table = document.getElementById("tabla_cumplimiento");
    var html = table.outerHTML;
    var html_no_links = html.replace(/<a[^>]*>|<\/a>/g, ""); //remove if u want links in your table
    var url = 'data:application/vnd.ms-excel,' + escape(html_no_links); // Set your html table into url
    elem.setAttribute("href", url);
    elem.setAttribute("download", "tabla_cumplimiento.xls"); // Choose the file name
    return false;
  }
</script>


@endsection
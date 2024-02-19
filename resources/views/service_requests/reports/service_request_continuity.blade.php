@extends('layouts.bt4.app')

@section('title', 'Reporte de contrato')

@section('content')

@include('service_requests.partials.nav')

<h3 class="mb-3">Reporte continuidad de contratos </h3>
@if(!empty($results))
<small>Cantidad de registros: {{ count($results) }}</small>
@endif

<form method="GET" class="form-horizontal" action="{{ route('rrhh.service-request.report.service-request-continuity') }}">
    <div class="form-row">
        <fieldset class="form-group col-md-3">
            <label for="for_from">Desde*</label>
            <input type="date" class="form-control" name="from" value="{{ $request->from }}" required>
        </fieldset>

        <fieldset class="form-group col-md-3">
            <label for="for_to">Hasta*</label>
            <input type="date" class="form-control" name="to" value="{{ $request->to }}" required>
        </fieldset>





        <fieldset class="form-group col-md-3">
            <label for="for_to">Nombre Programa*</label>
            <!-- <select name="type" class="form-control" value="{{ $request->type }}">
                <option value=""></option>
                <option value="Covid" @if($request->type == 'Covid') selected @endif>Covid (Sólo 2021)</option>
                <option value="Suma alzada" @if($request->type == 'Suma alzada') selected @endif>Suma alzada</option>
            </select> -->
            <select name="programm_name" class="form-control" id="programm_name">
              <option value=""></option>
      				<option value="Covid19-APS No Médicos" @if($request->programm_name == 'Covid19-APS No Médicos') selected @endif >Covid19-APS No Médicos</option>
      				<option value="Covid19-APS Médicos" @if($request->programm_name == 'Covid19-APS Médicos') selected @endif>Covid19-APS Médicos</option>
      				<option value="Covid19 No Médicos" @if($request->programm_name == 'Covid19 No Médicos') selected @endif>Covid19 No Médicos</option>
      				<option value="Covid19 Médicos" @if($request->programm_name == 'Covid19 Médicos') selected @endif>Covid19 Médicos</option>

      				@if(auth()->user()->organizationalUnit->establishment_id == 1)
      				<option value="Covid 2022" @if($request->programm_name == 'Covid 2022') selected @endif>Covid 2022</option>
      				<option value="CONSULTORIO DE LLAMADA" @if($request->programm_name == 'CONSULTORIO DE LLAMADA') selected @endif>CONSULTORIO DE LLAMADA</option>
      				<option value="33 MIL HORAS" @if($request->programm_name == '33 MIL HORAS') selected @endif>33 MIL HORAS</option>
      				<option value="DFL" @if($request->programm_name == 'DFL') selected @endif>DFL</option>
      				<option value="TURNOS VACANTES" @if($request->programm_name == 'TURNOS VACANTES') selected @endif>TURNOS VACANTES</option>
      				<option value="OTROS PROGRAMAS HETG" @if($request->programm_name == 'OTROS PROGRAMAS HETG') selected @endif>OTROS PROGRAMAS HETG</option>
                      <option value="LEQ Fonasa" @if($request->programm_name == 'LEQ Fonasa') selected @endif>LEQ Fonasa</option>
      				<option value="CAMPAÑA INVIERNO" @if($request->programm_name == 'CAMPAÑA INVIERNO') selected @endif>CAMPAÑA INVIERNO</option>
                    <option value="CONTINGENCIA RESPIRATORIA" @if($request->programm_name == 'CONTINGENCIA RESPIRATORIA') selected @endif>CONTINGENCIA RESPIRATORIA</option>
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
                    <option value="CONTINGENCIA RESPIRATORIA" @if($request->programm_name == 'CONTINGENCIA RESPIRATORIA') selected @endif>CONTINGENCIA RESPIRATORIA</option>

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

        <fieldset class="form-group col-md-1">
            <label for="">&nbsp;</label>
            <button type="submit" class="form-control btn btn-primary"><i class="fas fa-search"></i></button>
        </fieldset>

        <!-- <fieldset class="form-group col-md-1">
            <label for="">&nbsp;</label>
            <button type="button" class="form-control btn btn-secondary" id="downloadLink" onclick="exportF(this)" ><i class="fas fa-file-excel"></i></button>
        </fieldset> -->

        <fieldset class="form-group col-md-1">
            <label for="">&nbsp;</label>
            <a class="btn btn-outline-success btn-sm mb-1" id="downloadLink" onclick="exportF(this)">Excel Resultados</a>
        </fieldset>

    </div>
</form>

<hr>

@if(!empty($results))
<table class="table table-sm table-bordered small" id="tabla_contrato">
    <tr>
        <th>Funcionario</th>
        <th></th>
        <th></th>
    </tr>

    @foreach($results as $key => $result)
    <tr>
        <td>{{$key}}</td>
        @foreach($result as $key2 => $serviceRequest)
    <tr>
        <td></td>
        <td>
            <a href="{{ route('rrhh.service-request.edit',$serviceRequest) }}" target="_blank">
                {{ $serviceRequest->id ?? '' }}
            </a>
        </td>
        <td>{{$key2}}</td>
    </tr>
    @endforeach
    </tr>
    @endforeach

</table>
@endif

@endsection

@section('custom_js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">
    let date = new Date()
    let day = date.getDate()
    let month = date.getMonth() + 1
    let year = date.getFullYear()
    let hour = date.getHours()
    let minute = date.getMinutes()

    function exportF(elem) {
        var table = document.getElementById("tabla_contrato");
        var html = table.outerHTML;
        var html_no_links = html.replace(/<a[^>]*>|<\/a>/g, ""); //remove if u want links in your table
        var url = 'data:application/vnd.ms-excel,' + escape(html_no_links); // Set your html table into url
        elem.setAttribute("href", url);
        elem.setAttribute("download", "tabla_contrato_continuidad_" + day + "_" + month + "_" + year + ".xls"); // Choose the file name
        return false;
    }
</script>


@endsection

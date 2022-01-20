@extends('layouts.app')

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
            <label for="for_to">Origen de Financiamiento</label>
            <select name="type" class="form-control" value="{{ $request->type }}">
            <option value=""></option>
            <option value="Suma alzada" @if($request->type == 'Covid') selected @endif>Covid (Sólo 2021)</option>
            <option value="Covid" @if($request->type == 'Suma alzada') selected @endif>Suma alzada</option>
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
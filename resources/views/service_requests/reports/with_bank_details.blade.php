@extends('layouts.app')

@section('title', 'Reporte para pagos')

@section('content')

@include('service_requests.partials.nav')

<h3 class="mb-3">Funcionario a Honorario con Datos Bancarios</h3>

<a class="btn btn-outline-success btn-sm mb-3" id="downloadLink" onclick="exportF(this)">Descargar en excel</a>


<table class="table table-sm table-bordered" id="tabla_correctora">
    <tr>
        <th nowrap>Rut</th>
        <th>Nombre</th>
        <th>Dirección</th>
        <th>Teléfono</th>
        <th>Email</th>
        <th>Banco</th>
        <th>Número de Cuenta</th>
        <th>Tipo de Pago</th>
    </tr>
    @foreach($userbankaccounts as $userbankaccount)
    <tr>
        <td>{{ $userbankaccount->user->runFormat() ?? '' }}</td>
        <td>{{ $userbankaccount->user->getFullNameAttribute() ?? '' }}</td>
        <td>{{ $userbankaccount->user->address ?? '' }}</td>        
        <td>{{ $userbankaccount->user->phone_number ?? '' }}</td>
        <td>{{ $userbankaccount->user->email ?? '' }}</td>
        <td>{{ $userbankaccount->bank->name ?? '' }}</td>
        <td>{{ $userbankaccount->number ?? '' }}</td>
        <td>{{ $userbankaccount->getTypeText() ?? '' }}</td>
        
    </tr>

    @endforeach
</table>

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
        var table = document.getElementById("tabla_correctora");
        var html = table.outerHTML;
        var html_no_links = html.replace(/<a[^>]*>|<\/a>/g, ""); //remove if u want links in your table
        var url = 'data:application/vnd.ms-excel,' + escape(html_no_links); // Set your html table into url
        elem.setAttribute("href", url);
        elem.setAttribute("download", "datos_bancarios_honorarios_"+day+"_"+month+"_"+year+".xls"); // Choose the file name
        return false;
    }
</script>


@endsection

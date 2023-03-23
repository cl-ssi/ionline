@extends('layouts.app')

@section('title', 'Contenido DOS')

@section('content')

@include('welfare.nav')

<form method="GET" action="{{ route('welfare.balances') }}">

    <div class="form-row">
        <fieldset class="form-group col-3 col-md-2">
            <label for="for_month">{{ __('Mes') }}</label>
            <select name="month" class="form-control @error('month') is-invalid @enderror" required>
                <option value=""></option>
                @foreach($meses as $mes)
                <option value="{{ $mes->mes }}" {{ old('month') == $mes->mes ? 'selected' : '' }}>{{ $mes->mes_nombre }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-6 col-md-2">
            <label for="for_year">{{ __('Año') }}</label>
            <select name="year" class="form-control" required>
                <option value=""></option>
                @foreach(range((now()->year)-1, now()->year) as $year)
                <option value="{{ $year }}" {{ old('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
        </fieldset>

        <fieldset class="form-group col-6 col-md-3">
            <label for="for_type">{{ __('Tipo de Balance') }}</label>
            <select name="type" class="form-control"">
                <option value="">Todos</option>
                <option value="ingresos" {{ old('type') == 'ingresos' ? 'selected' : '' }}>Ingresos</option>
                <option value="gastos" {{ old('type') == 'gastos' ? 'selected' : '' }}>Gastos</option>
            </select>
        </fieldset>

        <fieldset class="col-1">
            <label for="">&nbsp;</label>
            <button type="submit" class="btn btn-primary form-control">{{ __('Buscar') }}</button>
        </fieldset>

        </form>

        <div class="col-md-1 offset-2">
            <label for="">Descargar</label>
            <a href="{{ route('welfare.exportBalance') }}" class="btn btn-outline-secondary form-control">
                <i class="fas fa-file-csv"></i> &nbsp;
            </a>
        </div>

        <div class="col-md-1">
            <label for="">&nbsp;</label>
            <a id="downloadLinkExcel" onclick="exportF(this)" class="btn btn-outline-secondary form-control">
                <i class="fas fa-file-excel"></i> &nbsp;
            </a>
        </div>

    </div>



@if($balances->isNotEmpty())
<h4 style="text-align:center; font-weight:bold; text-decoration:underline;">ESTADO PRESUPUESTARIO DE {{strtoupper(old('type'))}} </h4>
<h4 style="text-align:center; font-weight:bold; text-decoration:underline;">{{$ultimo_dia_del_mes}}</h4>

<table class="table table-bordered" id="tabla_balance">
    <tbody>
        @foreach ($balances as $balance)

        <!--Muestra un salto de linea en los gastos-->
        @if($balance->titulo == '10') 
        <tr><td colspan="9"><h4>Ingresos</h4></td></tr>
        <tr>
            <th>Título</th>
            <th>Ítem</th>
            <th>Asignación</th>
            <th>Glosa</th>
            <th>Presupuesto Inicial</th>
            <th>Modificaciones Mes {{$ultimo_dia_del_mes}}</th>
            <th>Presupuesto Ajustado</th>
            <th>Presupuesto Ejecutado</th>
            <th>Saldo Presupuesto</th>
        </tr>
        @endif

        <!--Muestra un salto de linea en los gastos-->
        @if($balance->titulo == '20') 
        <tr><td colspan="9"><h4>Gastos</h4></td></tr>
        <tr>
            <th>Título</th>
            <th>Ítem</th>
            <th>Asignación</th>
            <th>Glosa</th>
            <th>Presupuesto Inicial</th>
            <th>Modificaciones Mes {{$ultimo_dia_del_mes}}</th>
            <th>Presupuesto Ajustado</th>
            <th>Presupuesto Ejecutado</th>
            <th>Saldo Presupuesto</th>
        </tr>
        @endif
        
        <tr @if($balance->item == '000') class="table-secondary" @endif>
            <td>{{ $balance->titulo }}</td>
            <td>{{ $balance->item }}</td>
            <td>{{ $balance->asignacion }}</td>
            <td>{{ $balance->glosa }}</td>
            <td class="text-right">{{ money($balance->inicial) }}</td>
            <td class="text-right @if($balance->traspaso <0) text-danger @endif">{{ money($balance->traspaso) }}</td>
            <td class="text-right">{{ money($balance->ajustado) }}</td>
            <td class="text-right">{{ money($balance->ejecutado) }}</td>
            <td class="text-right">{{ money($balance->saldo) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@else
<p>No hay resultados disponibles.</p>
@endif
@endsection



<script type="text/javascript">
    function exportF(elem) {
        var table = document.getElementById("tabla_balance");
        var html = table.outerHTML;
        var html_no_links = html.replace(/<a[^>]*>|<\/a>/g, ""); //remove if u want links in your table
        var url = 'data:application/vnd.ms-excel,' + escape(html_no_links); // Set your html table into url
        elem.setAttribute("href", url);
        elem.setAttribute("download", "tabla_balance.xls"); // Choose the file name
        return false;
    }
</script>
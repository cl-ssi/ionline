@extends('layouts.app')

@section('title', 'Contenido DOS')

@section('content')

@include('wellness.nav')

<div class="card-body">
    <form method="GET" action="{{ route('wellness.balances') }}">
        <div class="form-row">
            <fieldset class="form-group col-md-6">
                <label for="for_month">{{ __('Mes') }}</label>
                <select name="month" class="form-control selectpicker @error('month') is-invalid @enderror" required>
                    <option value=""></option>
                    <option value="1" {{ old('month') == 1 ? 'selected' : '' }}>Enero</option>
                    <option value="2" {{ old('month') == 2 ? 'selected' : '' }}>Febrero</option>
                    <option value="3" {{ old('month') == 3 ? 'selected' : '' }}>Marzo</option>
                    <option value="4" {{ old('month') == 4 ? 'selected' : '' }}>Abril</option>
                    <option value="5" {{ old('month') == 5 ? 'selected' : '' }}>Mayo</option>
                    <option value="6" {{ old('month') == 6 ? 'selected' : '' }}>Junio</option>
                    <option value="7" {{ old('month') == 7 ? 'selected' : '' }}>Julio</option>
                    <option value="8" {{ old('month') == 8 ? 'selected' : '' }}>Agosto</option>
                    <option value="9" {{ old('month') == 9 ? 'selected' : '' }}>Septiembre</option>
                    <option value="10" {{ old('month') == 10 ? 'selected' : '' }}>Octubre</option>
                    <option value="11" {{ old('month') == 11 ? 'selected' : '' }}>Noviembre</option>
                    <option value="12" {{ old('month') == 12 ? 'selected' : '' }}>Diciembre</option>
                </select>
            </fieldset>
            <fieldset class="form-group col-md-6">
                <label for="for_year">{{ __('Año') }}</label>
                <select name="year" class="form-control selectpicker" required>
                    <option value=""></option>
                    @foreach(range((now()->year)-1, now()->year) as $year)
                    <option value="{{ $year }}" {{ old('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </fieldset>
            <fieldset class="form-group col-md-6">
                <label for="for_type">{{ __('Tipo de Balance') }}</label>
                <select name="type" class="form-control selectpicker">
                    <option value="">Todos</option>
                    <option value="ingresos" {{ old('type') == 'ingresos' ? 'selected' : '' }}>Ingresos</option>
                    <option value="gastos" {{ old('type') == 'gastos' ? 'selected' : '' }}>Gastos</option>
                </select>
            </fieldset>

        </div>
        <button type="submit" class="btn btn-primary">{{ __('Consultar') }}</button>
    </form>
</div>

<div class="row mb-3">
    <div class="col-md-12 text-right">
        <a href="{{ route('wellness.exportBalance') }}" class="btn btn-success">
            <i class="fa fa-file-excel"></i> Descargar Resultado con Formato
        </a>
        <a id="downloadLinkExcel" onclick="exportF(this)" class="btn btn-success">
            <i class="fa fa-file-excel"></i> Descargar Resultado en Pantalla en Excel
        </a>
    </div>
</div>

@if($balances->isNotEmpty())
<h4 style="text-align:center; font-weight:bold; text-decoration:underline;">ESTADO PRESUPUESTARIO DE {{strtoupper(old('type'))}} </h4>
<h4 style="text-align:center; font-weight:bold; text-decoration:underline;">{{$ultimo_dia_del_mes}}</h4>

<table class="table table-bordered" id="tabla_balance">
    <thead>
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
    </thead>
    <tbody>
        @foreach ($balances as $balance)

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
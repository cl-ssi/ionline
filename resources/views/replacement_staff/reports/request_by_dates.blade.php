@extends('layouts.bt4.app')

@section('title', 'Listado de STAFF')

@section('content')

@include('replacement_staff.nav')

<div class="row">
    <div class="col-sm-8">
        <h5 class="mb-3"><i class="far fa-file-alt"></i> Reporte: Solicitudes por fecha de creación </h5>
    </div>
</div>

<div class="card card-body small">
    <h5 class="mb-3"><i class="fas fa-search"></i> Buscar:</h5>
    
    <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.reports.search_request_by_dates') }}" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="form-row">
            <fieldset class="form-group col-sm">
                <label for="regiones">Fecha de creación de Solicitud</label>
                <div class="input-group">
                    <input type="date" class="form-control" name="start_date_search" @if($request) value="{{ $request->start_date_search }}" @endif required>
                    <input type="date" class="form-control" name="end_date_search" @if($request) value="{{ $request->end_date_search }}" @endif required>
                </div>
            </fieldset>

            <fieldset class="form-group col-sm">
                <label for="organizational_unit_id_search">Unidad Organizacional</label>
                @livewire('search-select-organizational-unit', [
                    'selected_id'          => 'organizational_unit_id_search'
                ])
            </fieldset>
        </div>

        <button type="submit" class="btn btn-primary float-right"> Consultar</button>
    </form>
</div>

<br>

@if($totalRequestByDates->count() > 0)

<div class="row">
    <div class="col-sm">
        <h5>
            1-. Total de Solicitudes por Estado: 
            @if($request->organizational_unit_id_search != null) 
                {{ App\Models\Rrhh\OrganizationalUnit::find($request->organizational_unit_id_search)->name }}
            @else 
                Todas las Unidades Organizacionales 
            @endif
        </h5>
    </div>
</div>
    
<div class="row">
    <div class="col-sm">
        <div id="piechart"></div>
    </div>
    <div class="col-sm">
        <h6>Resumen</h6>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm">
                <thead class="text-center">
                    <tr>
                        <th width="60%">Estado de Solicitud</th>
                        <th width="40%">Cantidad</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr>
                        <th width="60%">Pendientes</th>
                        <td width="40%">{{ $pending }}</td>
                    </tr>
                    <tr>
                        <th width="60%">Finalizadas</th>
                        <td width="40%">{{ $complete }}</td>
                    </tr>
                    <tr>
                        <th width="60%">Rechazadas</th>
                        <td width="40%">{{ $rejected }}</td>
                    </tr>
                    <tr>
                        <th width="60%">Total</th>
                        <td width="40%"><b>{{ $totalRequestByDates->count() }}</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<br>
<hr>
<br>

<div class="row">
    <div class="col-sm">
        <h5>
            2-. Total por Tipo de Solicitudes (Primera Solicitud o Continuidad)
            @if($request->organizational_unit_id_search != null) 
                {{ App\Models\Rrhh\OrganizationalUnit::find($request->organizational_unit_id_search)->name }}
            @else 
                Todas las Unidades Organizacionales 
            @endif
        </h5>
    </div>
</div>

<div class="row">
    <div class="col-sm">
        <div id="piechart_by_type"></div>
    </div>
    <div class="col-sm">
        <h6>Resumen</h6>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm">
                <thead class="text-center">
                    <tr>
                        <th width="60%">Formulario</th>
                        <th width="40%">Cantidad</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr>
                        <th width="60%">Primera Solicitud</th>
                        <td width="40%">{{ $firstRequest }}</td>
                    </tr>
                    <tr>
                        <th width="60%">Continuidad</th>
                        <td width="40%">{{ $continuity }}</td>
                    </tr>
                    <tr>
                        <th width="60%">Total</th>
                        <td width="40%"><b>{{ $totalRequestByDates->count() }}</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@else
<div class="row">
    <div class="col">
        <div class="card mb-3 bg-light">
            <div class="card-body">
                Estimado Usuario: No existen registros según las fechas consultadas.
            </div>
        </div>
    </div>
</div>
@endif


@endsection

@section('custom_js')

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
            ['Estado', 'Cantidad'],
            ['Pendientes',  {!! $pending !!}],
            ['Finalizados', {!! $complete !!}],
            ['Rechazadas', {!! $rejected !!}]
            ]);

            var options = {
            title: 'Solicitudes por estado',
            is3D: true,
            colors: ['#0000ff', '#008F39', '#FF0000'],
            height: 400,
            backgroundColor: '#f8fafc',
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>

<script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
            ['Tipo', 'Cantidad'],
            ['Primera Solicitud',  {!! $firstRequest !!}],
            ['Continuidad', {!! $continuity !!}]
            ]);

            var options = {
            title: 'Solicitudes por estado',
            is3D: true,
            colors: ['#0000ff', '#008F39', '#FF0000'],
            height: 400,
            backgroundColor: '#f8fafc',
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart_by_type'));

            chart.draw(data, options);
        }
    </script>

@endsection

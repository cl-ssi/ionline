@extends('layouts.app')
@section('title', 'Reportes Módulo de Bienestar')
@section('content')
@include('welfare.nav')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- Agregar el div donde se mostrará el gráfico de torta -->
                <div id="inicial-chart"></div>
                <hr>
                <div id="traspaso-chart"></div>
                <hr>
                <div id="ajustado-chart"></div>
                <hr>
                <div id="ejecutado-chart"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom_js')
<!-- Importar Google Charts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<!-- Cargar la librería de gráficos y definir la función para crear el gráfico de torta -->
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
        // Obtener los datos de ingreso y gasto desde el controlador
        var ingresoinicial = {{$ingreso->inicial??''}};
        var gastoinicial = {{$gasto->inicial??''}};

        var ingresotraspaso = {{$ingreso->traspaso??''}};
        var gastotraspaso = {{$gasto->traspaso??''}};

        var ingresoajustado = {{$ingreso->ajustado??''}};
        var gastoajustado = {{$gasto->ajustado??''}};

        var ingresoejecutado = {{$ingreso->ejecutado??''}};
        var gastoejecutado = {{$gasto->ejecutado??''}};

        // Crear las tablas de datos
        var datainicial = google.visualization.arrayToDataTable([
            ['Concepto', 'Valor'],
            ['Ingreso', ingresoinicial],
            ['Gasto', gastoinicial]
        ]);

        var datatraspaso = google.visualization.arrayToDataTable([
            ['Concepto', 'Valor'],
            ['Ingreso', ingresotraspaso],
            ['Gasto', gastotraspaso]
        ]);

        var dataajustado = google.visualization.arrayToDataTable([
            ['Concepto', 'Valor'],
            ['Ingreso', ingresoajustado],
            ['Gasto', gastoajustado]
        ]);

        var dataejecutado = google.visualization.arrayToDataTable([
            ['Concepto', 'Valor'],
            ['Ingreso', ingresoejecutado],
            ['Gasto', gastoejecutado]
        ]);

        // Definir las opciones de los gráficos de torta
        var optionsinicial = {
            title: 'Presupuesto Inicial',
            pieHole: 0.4
        };

        var optionstraspaso = {
            title: 'Traspasos de Presupuestos',
            pieHole: 0.4
        };

        var optionsajustado = {
            title: 'Presupuesto Ajustado',
            pieHole: 0.4
        };

        var optionsejecutado = {
            title: 'Presupuesto Ejecutado',
            pieHole: 0.4
        };

        // Crear el gráfico de torta y mostrarlo en el div correspondiente
        var chart = new google.visualization.PieChart(document.getElementById('inicial-chart'));
        chart.draw(datainicial, optionsinicial);

        // Crear el gráfico de torta y mostrarlo en el div correspondiente
        var chart2 = new google.visualization.PieChart(document.getElementById('traspaso-chart'));
        chart2.draw(datatraspaso, optionstraspaso);

        var chart3 = new google.visualization.PieChart(document.getElementById('ajustado-chart'));
        chart3.draw(dataajustado, optionsajustado);

        var chart4 = new google.visualization.PieChart(document.getElementById('ejecutado-chart'));
        chart4.draw(dataejecutado, optionsejecutado);
    }
</script>

@endsection
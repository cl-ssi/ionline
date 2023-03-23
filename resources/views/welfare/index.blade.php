@extends('layouts.app')

@section('title', 'Módulo de Bienestar')

@section('content')

@include('welfare.nav')


<div class="row">
    <div class="col-12 col-md-5">
        <h3 class="mb-3">¡Bienvenidos al Módulo de Estado Financiero de Bienestar!</h3>
        <p class="lead text-center">
            Este módulo de iOnline permite visualizar el estado financiero en el tiempo del Servicio de Bienestar.<br>
            Este panel de información incluye tanto gráficos de los fondos ejecutados y un resumen del balance presupuestario mes a mes del Servico de Bienestar.
        </p>

    </div>
    <div class="col-12 col-md-7">
        <div id="barchart" style="width: 900px; height: 500px;"></div>
    </div>
</div>


@endsection


@section('custom_js')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
        ['Ppto', 
            '', { role: 'style' }, { role: 'annotation' }, 
            '', { role: 'style' }, { role: 'annotation' } ],
        ['Prespuesto', 800000000, '','Ppto Inicial', 100000000, '','Ajuste'],
        ['Ejecutado', 300000000, '#1b9e77', 'Ejecutado',0, '',''],
      ]);

      var options = {
        width: 600,
        height: 400,
        legend: { position: 'none', maxLines: 3 },
        bar: { groupWidth: '75%' },
        isStacked: true,
        title: 'Estado de la ejecución presupuestaria',
      };

        var chart = new google.visualization.ColumnChart(document.getElementById('barchart'));

        chart.draw(data, options);
      }
    </script>
@endsection
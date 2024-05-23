@extends('layouts.bt4.app')

@section('title', 'Módulo de Bienestar')

@section('content')

@include('welfare.nav')

    <div class="row">
        <div class="col-12 col-md-12">
            <h3 class="mb-3">¡Bienvenidos al Módulo de Bienestar!</h3><br>
            <li>Este módulo de iOnline permite visualizar el estado financiero en el tiempo del Servicio de Bienestar</li>
            <li>Este módulo de iOnline permite hacer gestión sobre amipass.</li>
            <li>Este módulo de iOnline permite solicitar beneficios a asociados.</li>

        </div>
    </div>

    <!-- Se restringe la visualización a usuarios de bienestar y administradores -->
    @if(auth()->user()->welfare || auth()->user()->can('be god') || auth()->user()->can('welfare: amipass') || auth()->user()->can('welfare: balance'))
        <h5 class="text-white p-2 bg_azul_gob mt-3 text-center">
            <i class="fas fa-file-signature"></i>
            Reserva de cabañas - Bienestar
        </h5>

        <div class="mt-4 p-5 text-black rounded bg-light">

            <h6>En el siguiente video podrá visualizar como realizar una reserva de cabañas.</h6>
            <br>
            <div class="row">
                <fieldset class="form-group col-12 col-md-12">
                    <iframe src="https://drive.google.com/file/d/1YsmCsLqlfcdSqODBUwtUb3xoDdSMzljo/preview" width="100%" height="540" allow="autoplay; fullscreen" allowfullscreen></iframe>
                </fieldset>
            </div>
        </div>
    @endif

@endsection


@section('custom_js')
<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
</script> -->
@endsection
@extends('layouts.bt4.app')

@section('title', 'Módulo de Bienestar')

@section('content')

@include('welfare.nav')

    <div class="row">
        <div class="col-12 col-md-12">
            <h3 class="mb-3">¡Bienvenidos al Módulo de Bienestar!</h3><br>

            <!-- <div class="alert alert-warning" role="alert" style="font-size: 22px; color: #856404; background-color: #fff3cd; border-color: #ffeeba;">
                <strong>Módulo de reserva de cabañas</strong><br>
                El módulo de reserva de cabañas se encuentra en mantención temporalmente. Lo anterior, con el fin de mejorar el servicio a nuestros socios y socias.<br><br>
                Desde hoy toda reserva se realizará de forma presencial en Oficina de Bienestar Hospital o al teléfono Anexo
                Minsal <b>576143</b> o otro <b>572-536143</b>.
            </div><br> -->

            <li>Este módulo de iOnline permite visualizar el estado financiero en el tiempo del Servicio de Bienestar</li>
            <li>Este módulo de iOnline permite hacer gestión sobre amipass.</li>
            <li>Este módulo de iOnline permite solicitar beneficios a asociados.</li>

        </div>
    </div>

    <!-- Se restringe la visualización a usuarios de bienestar y administradores -->
    @if(auth()->user()->welfare || auth()->user()->can('be god') || auth()->user()->can('welfare: amipass') || auth()->user()->can('welfare: balance')
        || auth()->user()->can('welfare: benefits') || auth()->user()->can('welfare: hotel booking administrator'))
        <h5 class="text-white p-2 bg_azul_gob mt-3 text-center">
            <i class="fas fa-file-signature"></i>
            Reserva de cabañas - Bienestar
        </h5>

        <div class="mt-4 p-5 text-black rounded bg-light">

            @if(auth()->user()->can('welfare: hotel booking administrator'))
                <div class="d-flex justify-content-end">
                    <button class="btn btn-warning rounded-pill px-3 d-flex align-items-center" type="button">
                        <b>@livewire('hotel-booking.pending-requests-count')</b> 
                        <span class="ml-2">reservas pendientes por revisar</span>
                    </button>
                </div>
            @endif

            <h6>En el siguiente video podrá visualizar como realizar una reserva de cabañas.</h6>
            <br>
            <div class="row">
                <fieldset class="form-group col-12 col-md-12">
                    <iframe src="https://drive.google.com/file/d/1YsmCsLqlfcdSqODBUwtUb3xoDdSMzljo/preview" width="100%" height="540" allow="autoplay; fullscreen" allowfullscreen></iframe>
                </fieldset>
            </div>
        </div>

        <h5 class="text-white p-2 bg_azul_gob mt-3 text-center">
            <i class="fas fa-file-signature"></i>
            Solicitud de beneficios - Bienestar
        </h5>

        <div class="mt-4 p-5 text-black rounded bg-light">

            <h6>En el siguiente video podrá visualizar como realizar una solicitud de beneficios al área de Bienestar. Para acceder al módulo presionar <a href="{{ route('welfare.index') }}">aquí</a>.</h6>
            <br>
            <div class="row">
                <fieldset class="form-group col-12 col-md-12">
                    <iframe src="https://drive.google.com/file/d/1lh2YXr6WW_XwYNWodIyFwhq6iu8euoAB/preview" width="100%" height="540" allow="autoplay; fullscreen" allowfullscreen></iframe>
                </fieldset>
            </div>
        </div>

        <h5 class="text-white p-2 bg_azul_gob mt-3 text-center">
            <i class="fas fa-file-signature"></i>
            Solicitud de devolución de horas
        </h5>

        <div class="mt-4 p-5 text-black rounded bg-light">

            <h6>En el siguiente video podrá visualizar como realizar una solicitud de devolución de horas.</h6>
            <br>
            <div class="row">
                <fieldset class="form-group col-12 col-md-12">
                    <iframe src="https://drive.google.com/file/d/1G8clldHDmhFy1edQXy06GyCgVmwe8fQu/preview" width="100%" height="315" allow="autoplay; fullscreen" allowfullscreen></iframe>
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
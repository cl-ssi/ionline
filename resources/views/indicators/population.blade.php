@extends('layouts.app')

@section('title', 'Reporte de población')

@section('content')
<h3 class="mb-3">Reporte de población</h3>

<form method="GET" class="form-horizontal" action="{{ route('indicators.population') }}">

<div class="form-group">

		<div class="form-row">
			<div class="form-group col-12 col-md-2">
				<label>Año</label>
        <select class="form-control" name="year">
					<option value="2020"@if($request->year == 2020) selected @endif>2020</option>
          <option value="2021" @if($request->year == 2021) selected @endif>2021</option>
					<option value="2022" @if($request->year == 2022) selected @endif>2022</option>
        </select>
      </div>

			<div class="form-group col-12 col-md-2">
				<label>Establecimiento</label>
        <select class="form-control" name="establishment_id">
          <option value="">Todos</option>
          @foreach($establishments as $establishment)
            <option value="{{$establishment->Codigo}}" @if($request->establishment_id == $establishment->Codigo) selected @endif>{{$establishment->nombre}}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group col-12 col-md-2">
        <label>Género</label>
        <select class="form-control" name="gender_id">
          <option value="">Todos</option>
          <option value="M" @if($request->gender_id == 'M') selected @endif>Masculino</option>
          <option value="F" @if($request->gender_id == 'F') selected @endif>Femenino</option>
					<option value="Other" @if($request->gender_id == 'Other') selected @endif>Otro</option>
        </select>
      </div>

      <div class="form-group col-9 col-md-2">
        <label>Comuna</label>
        <select class="form-control" name="commune_name">
          <option value="">Todos</option>
          @foreach($communes as $commune)
            <option value="{{$commune->name}}" @if($request->commune_name == $commune->name) selected @endif>{{$commune->name}}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group col-9 col-md-2">
        <label>Grupos etários</label>
        <select class="form-control" name="etario_id">
          <option value="">Todos</option>
					<option value="00 - 02" @if($request->etario_id == '00 - 02') selected @endif>00 - 02</option>
					<option value="03 - 04" @if($request->etario_id == '03 - 04') selected @endif>03 - 04</option>
					<option value="05 - 09" @if($request->etario_id == '05 - 09') selected @endif>05 - 09</option>
					<option value="10 - 14" @if($request->etario_id == '10 - 14') selected @endif>10 - 14</option>
					<option value="15 - 19" @if($request->etario_id == '15 - 19') selected @endif>15 - 19</option>
					<option value="20 - 24" @if($request->etario_id == '20 - 24') selected @endif>20 - 24</option>
					<option value="25 - 29" @if($request->etario_id == '25 - 29') selected @endif>25 - 29</option>
					<option value="30 - 34" @if($request->etario_id == '30 - 34') selected @endif>30 - 34</option>
					<option value="35 - 39" @if($request->etario_id == '35 - 39') selected @endif>35 - 39</option>
					<option value="40 - 44" @if($request->etario_id == '40 - 44') selected @endif>40 - 44</option>
					<option value="45 - 49" @if($request->etario_id == '45 - 49') selected @endif>45 - 49</option>
					<option value="50 - 54" @if($request->etario_id == '50 - 54') selected @endif>50 - 54</option>
					<option value="55 - 59" @if($request->etario_id == '55 - 59') selected @endif>55 - 59</option>
					<option value="60 - 64" @if($request->etario_id == '60 - 64') selected @endif>60 - 64</option>
					<option value="65 - 69" @if($request->etario_id == '65 - 69') selected @endif>65 - 69</option>
					<option value="70 - 74" @if($request->etario_id == '70 - 74') selected @endif>70 - 74</option>
					<option value="75 - 79" @if($request->etario_id == '75 - 79') selected @endif>75 - 79</option>
					<option value="80 - 84" @if($request->etario_id == '80 - 84') selected @endif>80 - 84</option>
					<option value="85 - 89" @if($request->etario_id == '85 - 89') selected @endif>85 - 89</option>
					<option value="90 - 94" @if($request->etario_id == '90 - 94') selected @endif>90 - 94</option>
					<option value="95 - 99" @if($request->etario_id == '95 - 99') selected @endif>95 - 99</option>
					<option value="Más de 99" @if($request->etario_id == 'Más de 99') selected @endif>Más de 99</option>
        </select>
      </div>

			<div class="form-group col-3 col-md-2">
        <label>&nbsp;</label>
				<button type="submit" class="btn btn-primary form-control"><i class="fas fa-search"></i> Buscar</button>
			</div>
		</div>

</div>

</form>

<h2>Total población: <b>{{$total_pob}}</b></h2>
<div class="row">
    <div class="col-12 col-md-6">
      <div id="chart_establishments" ></div>
    </div>

    <div class="col-12 col-md-6">
      <div id="chart_communes" ></div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-6">
      <div id="chart_div" ></div>
    </div>

    <div class="col-12 col-md-6">
      <div id="piechart"></div>
    </div>
</div>



@endsection

@section('custom_js_head')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart','line']});
      google.charts.setOnLoadCallback(drawChartEstablisments);
      google.charts.setOnLoadCallback(drawChartCommunes);
      google.charts.setOnLoadCallback(drawStacked);
      google.charts.setOnLoadCallback(drawChart);

      function drawChartEstablisments() {
          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Establecimiento');
          data.addColumn('number', 'Cantidad');
          // data.addColumn('number', 'Mujeres');
          data.addRows([
              @foreach($pob_x_establecimientos as $key => $pob_x_establecimiento)
                ['{{$pob_x_establecimiento->NOMBRE_CENTRO}}',{{ $pob_x_establecimiento->valor }}],
              @endforeach
          ]);

          var options = {
              title: 'Población por establecimientos',
              curveType: 'log',
              // width: 380,
              height: 400,
              colors: ['#3366CC', '#CC338C'],
              legend: { position: 'bottom' },
              backgroundColor: '#f8fafc',
              chartArea: {'width': '85%', 'height': '80%'},
              hAxis: {
                  textStyle : {
                      fontSize: 9 // or the number you want
                  },
                  textPosition: '50',
              },
          };

          var chart = new google.visualization.ColumnChart(document.getElementById('chart_establishments'));

          chart.draw(data, options);
      }


      function drawChartCommunes() {
          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Establecimiento');
          data.addColumn('number', 'Cantidad');
          // data.addColumn('number', 'Mujeres');
          data.addRows([
              @foreach($pob_x_comunas as $key => $pob_x_comuna)
                ['{{$pob_x_comuna->comuna}}',{{ $pob_x_comuna->valor }}],
              @endforeach
          ]);

          var options = {
              title: 'Población por comunas',
              curveType: 'log',
              // width: 380,
              height: 400,
              colors: ['#FF5733', '#CC338C'],
              legend: { position: 'bottom' },
              backgroundColor: '#f8fafc',
              chartArea: {'width': '85%', 'height': '80%'},
              hAxis: {
                  textStyle : {
                      fontSize: 9 // or the number you want
                  },
                  textPosition: '50',
              },
          };

          var chart = new google.visualization.ColumnChart(document.getElementById('chart_communes'));

          chart.draw(data, options);
      }



        function drawStacked() {
        var data = google.visualization.arrayToDataTable([
          ['Tramo', 'Cantidad'],
          @foreach($pob_x_etarios as $key => $pob_x_etario)
            ['{{$pob_x_etario->grupo}}', {{$pob_x_etario->cantidad}}],
          @endforeach
        ]);

        var options = {
          title: 'Problación tramo por edad',
          height: 400,
          chartArea: {width: '50%'},
          isStacked: true,
          hAxis: {
            title: 'Cantidad',
            minValue: 0,
          },
          vAxis: {
            title: 'Tramo'
          }
        };
        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }


      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Género', 'Cantidad'],
          @foreach($pob_x_generos as $key => $pob_x_genero)
            ['{{$pob_x_genero->GENERO}}',    {{$pob_x_genero->valor}}],
          @endforeach

        ]);

        var options = {
          title: 'Población por género',
          height: 400
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
</script>
@endsection

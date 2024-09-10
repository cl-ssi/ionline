@extends('layouts.bt4.app')

@section('title', 'Reporte de población')

@section('content')
<h4 class="mb-3"><i class="fas fa-chart-pie"></i> Tablero de Población</h4>

@auth
<div class="alert alert-info alert-sm" role="alert">
    <div class="row">
        <div class="col-sm">
            <i class="fas fa-info-circle"></i> <b>Población preliminar</b>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <br />
            Para efectos de consultas a población preliminar en su totalidad se dispone de enlaces a archivos excel para su descarga según año de interés.
        </div>
        <div class="col-sm-6">
          <ul class="list-group list-group-horizontal">
            <li class="list-group-item"><a href="{{ route('indicators.population.percapita', 2024) }}"><i class="far fa-file-excel"></i> Descargar preliminar 2024</li></a>
            <li class="list-group-item"><a href="{{ route('indicators.population.percapita', 2023) }}"><i class="far fa-file-excel"></i> Descargar preliminar 2023</li></a>
            <li class="list-group-item"><a href="{{ route('indicators.population.percapita', 2022) }}"><i class="far fa-file-excel"></i> Descargar preliminar 2022</li></a>
            <li class="list-group-item"><a href="{{ route('indicators.population.percapita', 2021) }}"><i class="far fa-file-excel"></i> Descargar preliminar 2021</li></a>
          </ul>
        </div>
    </div>
</div>
@endauth

<div class="card">
	<div class="card-body">
		<form method="GET" class="form-horizontal" action="{{ route('indicators.population') }}">

			<div class="form-row">
				<fieldset class="form-group col-sm-2">
					<label>Fuente</label>
					<select class="form-control selectpicker show-tick" name="type" required>
							<option value="">Selección...</option>
							<option value="Definitivo" @if($request->type == "Definitivo") selected @endif>Definitivo</option>
							<option value="Preliminar"@if($request->type == "Preliminar") selected @endif>Preliminar</option>
					</select>
				</fieldset>

				{{--
				@livewire('indicators.dashboard.population-search-form', ['request' => $request])
				--}}
				
				<fieldset class="form-group col-sm-6">
					<label for="regiones">Año / Establecimiento *</label>
					<div class="input-group">
						<select class="form-control selectpicker show-tick" id="for_year_id" name="year" required>
							<option value="">Selección...</option>
							<option value="2024" @if($request->year == '2024') selected @endif>2024</option>
							<option value="2023" @if($request->year == '2023') selected @endif>2023</option>
							<option value="2022" @if($request->year == '2022') selected @endif>2022</option>
							<option value="2021" @if($request->year == '2021') selected @endif>2021</option>
							<option value="2020" @if($request->year == '2020') selected @endif>2020</option>
						</select>

						<select class="form-control selectpicker" id="for_establishment_id" name="establishment_id[]" data-live-search="true" data-actions-box="true" multiple wire:model="selectedEstablishment" required>
							{{-- @foreach($establishments as $estab)
							<option value="{{ $estab->Codigo }}">{{ $estab->alias_estab }}</option>
							@endforeach --}}

							@php($temp = null)
							@foreach($establishments as $estab)
								@if($estab->comuna != $temp) <optgroup label="{{$estab->comuna}}"> @endif
								<option value="{{ $estab->Codigo }}" @if (isset($establecimiento) && in_array($estab->Codigo, $establecimiento)) selected @endif>{{ $estab->alias_estab }}</option>
								@php($temp = $estab->comuna)
								@if($estab->comuna != $temp) </optgroup> @endif
							@endforeach
						</select>
					</div>
				</fieldset>

				<fieldset class="form-group col-sm-2">
					<label>Sexo</label>
					<select class="form-control selectpicker" name="gender_id[]" data-actions-box="true" multiple required>
						<option value="M" @if($request->type!= NULL && in_array('M', $request->gender_id)) selected @endif>Masculino</option>
						<option value="F" @if($request->type!= NULL && in_array('F', $request->gender_id)) selected @endif>Femenino</option>
						<option value="I" @if($request->type!= NULL && in_array('I', $request->gender_id)) selected @endif>Otro</option>
					</select>
				</fieldset>

				<fieldset class="form-group col-9 col-md-2">
					<label>Grupos etários</label>
					<select class="form-control selectpicker" name="etario_id[]" data-actions-box="true" title="Seleccione..." multiple required>
						@foreach(range(0, 99) as $edad) {
							<option value="{{ $edad }}" @if($request->type!= NULL && in_array($edad, $request->etario_id)) selected @endif>{{$edad}}</option>
						@endforeach
						<option value=">=100" @if($request->type!= NULL && in_array('>=100', $request->etario_id)) selected @endif>100 y más</option>
						<option value="Sin. Info." @if($request->type!= NULL && in_array('s.i.', $request->etario_id)) selected @endif>Sin. Info.</option>
					</select>
				</fieldset>
			</div>

			<button type="submit" class="btn btn-primary float-right"><i class="fas fa-chart-pie"></i> Consultar</button>

		</form>
	</div>
</div>

<br>

@if($request->has('type') && $total_pob->count() > 0)
		<h4>Total población: <b>{{ number_format($total_pob->sum('valor'),0,",",".") }}</b>
		@auth
		<form method="POST" class="form-inline float-right" action="{{ route('indicators.population.export') }}" onsubmit="this.submit_button.disabled = true;">
			@csrf
			@method('POST')
			<input type="hidden" name="type" value="{{ $request->type }}">
			<input type="hidden" name="year" value="{{ $request->year }}">
			@foreach($request->gender_id as $gender_id)
			<input type="hidden" name="gender_id[]" value="{{ $gender_id }}">
			@endforeach
			@foreach($request->etario_id as $etario_id)
			<input type="hidden" name="etario_id[]" value="{{ $etario_id }}">
			@endforeach
			@foreach($request->establishment_id as $establishment_id)
			<input type="hidden" name="establishment_id[]" value="{{ $establishment_id }}">
			@endforeach
			<button type="submit" name="submit_button" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i> Exportar</button>
		</form>
		@endauth
		</h4>

		<div class="row">
		    <div class="col-sm-12">
		      <div id="chart_establishments" ></div>
		    </div>
		</div>

		<br>

		<div class="row">
					<div class="col-sm-6">
						<div id="chart_communes" ></div>
					</div>


			    <div class="col-sm-6">
			      <div id="piechart"></div>
			    </div>
		</div>

		<br>

		<div class="row">
				<div class="col-sm-12">
						<div id="chart_div"></div>
				</div>
		</div>

@elseif($request->has('type') && $total_pob->count() == 0)

	<div class="row">
			<div class="col-sm-12">
					<div class="alert alert-secondary" role="alert">
						  Estimado Usuario: se informa que no se encontró población en nuestros registros, favor cambiar criterios de busqueda.
					</div>
			</div>
	</div>

@else

@endif


@endsection

@section('custom_js_head')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
	@if($request->type != NULL)
      google.charts.load('current', {'packages':['corechart','line']});
      google.charts.setOnLoadCallback(drawChartEstablisments);
      google.charts.setOnLoadCallback(drawChartCommunes);
			google.charts.setOnLoadCallback(drawChart);
      google.charts.setOnLoadCallback(drawStacked);


      function drawChartEstablisments() {
          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Establecimiento');
          data.addColumn('number', 'Población');
          // data.addColumn('number', 'Mujeres');
          data.addRows([

							@php($total_pob_group = $total_pob->groupBy($request->type == 'Definitivo' ? 'Centro_APS' : 'Nombre_Centro')->all())

							@foreach($total_pob_group as $key => $pob)
                ['{{ $key }}',{{ $pob->sum('valor') }}],
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

							@php($total_pob_group = $total_pob->groupBy($request->type == 'Definitivo' ? 'Comuna' : 'comuna')->all())
              @foreach($total_pob_group as $key => $pob)
                ['{{ $key }}',{{ $pob->sum('valor') }}],
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

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Género', 'Cantidad'],
					@php($total_pob_group = $total_pob->groupBy($request->type == 'Definitivo' ? 'Sexo' : 'GENERO')->all())
          @foreach($total_pob_group as $key => $pob)
            ['{{ $key }}',    {{ $pob->sum('valor') }}],
          @endforeach
        ]);

        var options = {
          title: 'Población por género',
          height: 400,
					backgroundColor: '#f8fafc',
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }

			function drawStacked() {
        var data = google.visualization.arrayToDataTable([
          ['Edad', 'Cantidad'],
					@php($total_pob_group = $total_pob->groupBy('Edad')->all())
          @foreach($total_pob_group as $key => $pob_x_etario)
            ['{{ $key }}', {{$pob_x_etario->sum('valor') }}],
          @endforeach
        ]);

        var options = {
					title: 'Población por edad',
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
				var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));

        chart.draw(data, options);
      }
	@endif
</script>

@endsection

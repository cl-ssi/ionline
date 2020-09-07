@extends('layouts.app')

@section('title', 'Requerimientos')

@section('content')

@include('requirements.partials.nav')

<h3>Informe de Requerimientos</h3>

<form method="GET" class="form-horizontal" action="{{ route('requirements.report1') }}">

    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Rango de fechas</span>
        </div>

        <input type="date" class="form-control" id="for_dateFrom" name="dateFrom"
            value="{{ ($request->get('dateFrom'))?$request->get('dateFrom'):date('Y-m-01') }}"
            required >
    	  <input type="date" class="form-control" id="for_dateTo" name="dateTo"
              value="{{ ($request->get('dateTo'))?$request->get('dateTo'):date('Y-m-t') }}"
              required>
    </div>

    <div class="input-group mb-3">
      <div class="input-group-prepend">
          <span class="input-group-text">Unidad</span>
      </div>

          <select name="organizational_unit_id" class="form-control selectpicker" for="for_organizational_unit_id">
            <option value="0">Todos</option>
            @foreach ($organizationalUnit as $key => $unit)
              <option value="{{$unit->id}}" @if ($unit->id == $request->get('organizational_unit_id'))
                selected
              @endif>{{$unit->name}}</option>
            @endforeach
          </select>
          <div class="input-group-append">
              <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
          </div>
    </div>

</form>

<div class="row">
    <div class="col-sm">
        <div id="chartdiv"></div>
    </div>
</div>

<div class="row" {{ ($request->get('organizational_unit_id') == 0)?'hidden':'' }}>
    <div class="col-sm">
        <div id="chartdiv2"></div>
    </div>
</div>

@endsection

@section('custom_js')

<!-- INDICADOR 1 -->
<style>
    #chartdiv, #chartdiv2018 {
      width: 100%;
      height: 600px;
    }
</style>

<style>
    #chartdiv2, #chartdiv2018 {
      width: 100%;
      height: 450px;
    }
</style>

<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/material.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv", am4charts.XYChart);

chart.data = [
@foreach($matrix as $data)
{
    "Unidad": '{{$data['unidad']}}',
    "Creado": '{{$data['creado']}}',
    "Respondido": '{{$data['respondido']}}',
    "Cerrado": '{{$data['cerrado']}}',
    "Derivado": '{{$data['derivado']}}',
    "Reabierto": '{{$data['reabierto']}}'
},
@endforeach
];

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "Unidad";
categoryAxis.title.text = "Unidades del servicio";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 20;
categoryAxis.renderer.cellStartLocation = 0.1;
categoryAxis.renderer.cellEndLocation = 0.9;
categoryAxis.renderer.labels.template.rotation = 340;
categoryAxis.renderer.labels.template.fontSize=10;
categoryAxis.fontSize = 15;

var  valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.min = 0;
valueAxis.title.text = "Cantidad requerimientos";
valueAxis.fontSize = 15;


// Create series
function createSeries(field, name, stacked) {
  var series = chart.series.push(new am4charts.ColumnSeries());
  series.dataFields.valueY = field;
  series.dataFields.categoryX = "Unidad";
  series.name = name;
  series.columns.template.tooltipText = "{name}: [bold]{valueY}[/]";
  series.stacked = stacked;
  series.columns.template.width = am4core.percent(95);
}

createSeries("Creado", "Creado", false);
createSeries("Respondido", "Respondido", false);
createSeries("Cerrado", "Cerrado", false);
createSeries("Derivado", "Derivado", false);
createSeries("Reabierto", "Reabierto", false);

// Add legend
chart.legend = new am4charts.Legend();

}); // end am4core.ready()






am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv2", am4charts.XYChart);

chart.data = [
@foreach($matrix2 as $data)
{
    "Usuario": '{{$data['usuario']}}',
    "Creado": '{{$data['creado']}}',
    "Respondido": '{{$data['respondido']}}',
    "Cerrado": '{{$data['cerrado']}}',
    "Derivado": '{{$data['derivado']}}',
    "Reabierto": '{{$data['reabierto']}}'
},
@endforeach
];

// Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "Usuario";
categoryAxis.title.text = "Trabajadores del servicio";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 20;
categoryAxis.renderer.cellStartLocation = 0.1;
categoryAxis.renderer.cellEndLocation = 0.9;
categoryAxis.renderer.labels.template.rotation = 340;
categoryAxis.renderer.labels.template.fontSize=10;
categoryAxis.fontSize = 15;

var  valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.min = 0;
valueAxis.title.text = "Cantidad requerimientos";
valueAxis.fontSize = 15;

// Create series
function createSeries(field, name, stacked) {
  var series = chart.series.push(new am4charts.ColumnSeries());
  series.dataFields.valueY = field;
  series.dataFields.categoryX = "Usuario";
  series.name = name;
  series.columns.template.tooltipText = "{name}: [bold]{valueY}[/]";
  series.stacked = stacked;
  series.columns.template.width = am4core.percent(95);
}

createSeries("Creado", "Creado", false);
createSeries("Respondido", "Respondido", false);
createSeries("Cerrado", "Cerrado", false);
createSeries("Derivado", "Derivado", false);
createSeries("Reabierto", "Reabierto", false);

// Add legend
chart.legend = new am4charts.Legend();

}); // end am4core.ready()

</script>

@endsection

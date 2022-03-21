@extends('layouts.app')

@section('title', 'Metas Sanitarias Ley N° ' . $law . '/'. $year)

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('indicators.index') }}">Indicadores</a></li>
        <li class="breadcrumb-item"><a href="{{ route('indicators.health_goals.index', $law) }}">Ley {{number_format($law,0,',','.')}}</a></li>
        <li class="breadcrumb-item">{{$year}}</li>
    </ol>
</nav>


<h3 class="mb-3">Metas Sanitarias Ley N° {{number_format($law,0,',','.')}} / {{$year}}. {{--@canany(['Indicators: manager']) <a class="btn btn-primary btn-sm" href="{{route('indicators.comges.create', [$year])}}" role="button"><span class="fa fa-plus"></span></a>@endcanany--}}</h3>
@if($healthGoals->isEmpty())
    <p>No existen o no se han definido aún metas sanitarias ley N° {{number_format($law,0,',','.')}} para el presente año</p>
@else
    @if($law == '19813')
    @foreach($healthGoals as $item)
    <p>{{$item->name}}</p>
        <ul style="list-style-type: none;">
        @foreach($item->indicators as $indicator)
            <li>
              <a href="{{ route('indicators.health_goals.show', [$law, $year, $indicator->id]) }}">
                {{$indicator->number}}. {{$indicator->name}}
              </a>
              @if($item->status == 'development')
                  <span class="badge bg-warning" data-toggle="tooltip" data-placement="top" title="Desarrollo"><i class="fas fa-wrench" style="color:#fff;"></i></span>
              @endif
              @if($item->status == 'review')
                  <span class="badge bg-warning" data-toggle="tooltip" data-placement="top" title="Revisión"><i class="fas fa-exclamation" style="color:#fff;"></i></span>
              @endif
              @if($item->status == 'verified')
                  <span class="badge bg-success" data-toggle="tooltip" data-placement="top" title="Verificado"><i class="fa fa-check" style="color:#fff;"></i></span>
              @endif
            </li>
        @endforeach
        </ul>
    @endforeach
    @else
    @foreach($healthGoals as $item)
    <p>
        <a href="{{ route('indicators.health_goals.show', [$law, $year, $item->number]) }}">{{$item->number}}. {{$item->name}}</a>
    </p>
    @endforeach
    @endif
    @if($law == '19813')
    <div class="row">
        <div class="col-sm">
            <div id="chartdiv" class="w-100" style="height: 450px"></div>
        </div>
    </div>
    @endif
@endif
@endsection

@section('custom_js')
@if($law == '19813')
<script src='{{asset('assets/amcharts/js/core.js')}}'></script>
<script src='{{asset('assets/amcharts/js/charts.js')}}'></script>
<script src='{{asset('assets/amcharts/js/material.js')}}'></script>
<script src='{{asset('assets/amcharts/js/animated.js')}}'></script>
<!-- Chart code -->
<script>
    am4core.ready(function() {

    // Themes begin
    am4core.useTheme(am4themes_material);
    am4core.useTheme(am4themes_animated);
    // Themes end

    // Create chart instance
    var chart = am4core.create("chartdiv", am4charts.XYChart);

    // Add percent sign to all numbers
    chart.numberFormatter.numberFormat = "#.##'%'";

    // Add data
    @foreach($healthGoals as $healthGoal)
        @foreach($healthGoal->indicators as $indicator)
            @php($dataByCommune = null) @php($total = 0)
            @foreach($communes as $index => $commune)
              @php($totalCommune = $indicator->getValuesAcum('denominador') != 0 ? $indicator->getValuesAcum2('numerador', $commune, null)/$indicator->getValuesAcum('denominador') * 100 : 0)
              @php($dataByCommune .= $index.": ". $totalCommune . ", ")
              @php($total += $totalCommune)
            @endforeach
            chart.data.push({ "indicador": "Ind {{$indicator->number}}\n" + parseFloat({{$total}}).toFixed(2) + "%", {{$dataByCommune}} });
        @endforeach
    @endforeach

    // Create axes
    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = "indicador";
    categoryAxis.renderer.grid.template.location = 0;
    categoryAxis.renderer.minGridDistance = 30;
    categoryAxis.renderer.labels.template.fontSize = 14;


    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis.min = 0;
    valueAxis.max = 100;

    let axisBreak = valueAxis.axisBreaks.create();
    axisBreak.startValue = 300;
    axisBreak.endValue = 1200;
    axisBreak.breakSize = 0.05;

    // Create series
    function createSeries(field, name) {

      // Set up series
      var series = chart.series.push(new am4charts.ColumnSeries());
      series.name = name;
      series.dataFields.valueY = field;
      series.dataFields.categoryX = "indicador";
      series.sequencedInterpolation = true;

      // Make it stacked
      series.stacked = true;

      // Configure columns
      series.columns.template.width = am4core.percent(60);
      series.columns.template.tooltipText = "[bold]{name}[/]\n[font-size:14px] {valueY}";

      return series;
    }

    // console.log(chart.data);

    @foreach($communes as $index => $commune)
    createSeries({{$index}}, "{{$commune}}");
    @endforeach

    //Title
    let title = chart.titles.create();
    title.text = "Cobertura - {{$year}} - Servicio de Salud Iquique";
    title.fontSize = 15;
    title.marginBottom = 10;

    // Legend
    chart.legend = new am4charts.Legend();

    }); // end am4core.ready()
@endif
</script>
@endsection

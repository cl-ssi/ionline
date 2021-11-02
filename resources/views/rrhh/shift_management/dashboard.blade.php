@extends('layouts.app')

@section('title', 'Gestion de Turnos')

	@section('content')
	<style>
#chartpeoplecant {
  width: 100%;
  height: 500px;
}

</style>
		@include("rrhh.shift_management.tabs", array('actuallyMenu' => 'dashboard'))

		<h3>Dashboard</h3>
		<br>

		<div class="row">
			<div class="col-md-3">
				<div class="card">
				  <div class="card-body">
				    <h5 class="card-title">Días por estado</h5>
				    <h6 class="card-subtitle mb-2 text-muted">En el mes actual</h6>
				    <div id="chartdayperstatus"></div>
				    <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
				  <!--   <a href="#" class="card-link">Card link</a>
				    <a href="#" class="card-link">Another link</a> -->
				  </div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="card" >
				  <div class="card-body">
				    <h5 class="card-title">Cant. de personal</h5>
				    <h6 class="card-subtitle mb-2 text-muted">Por día de la semana, en el mes actual</h6>
				    <div id="chartpeoplecantX"></div>
				  	
				  </div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="card" >
				  <div class="card-body">
				    <h5 class="card-title">Días por Jornada</h5>
				    <h6 class="card-subtitle mb-2 text-muted">En el mes actual</h6>
				    <div id="chartdayperjournaltype"></div>
				   
				  </div>
				</div>
			</div>

			
		</div>
				    <div id="chartpeoplecant"></div>
	
	@endsection
	@section('custom_js')

		<script>
			
			//Dias por estado
			am4core.ready(function() {
				// Themes begin
				am4core.useTheme(am4themes_animated);
				// Themes end

				// Create chart instance
				var chart = am4core.create("chartdayperstatus", am4charts.PieChart);

				// Add and configure Series
				var pieSeries = chart.series.push(new am4charts.PieSeries());
				pieSeries.dataFields.value = "cant";
				pieSeries.dataFields.category = "status";

				// Let's cut a hole in our Pie chart the size of 30% the radius
				chart.innerRadius = am4core.percent(30);
				
				// Put a thick white border around each Slice
				pieSeries.slices.template.stroke = am4core.color("#fff");
				pieSeries.slices.template.strokeWidth = 2;
				pieSeries.slices.template.strokeOpacity = 1;
				pieSeries.slices.template
  				// change the cursor on hover to make it apparent the object can be interacted with
  				.cursorOverStyle = [
    				{
      					"property": "cursor",
      					"value": "pointer"
    				}
  				];

				pieSeries.alignLabels = true;
				pieSeries.labels.template.bent = true;
				pieSeries.labels.template.radius = 3;
				pieSeries.labels.template.padding(0,0,0,0);

				pieSeries.ticks.template.disabled = true;

				// Create a base filter effect (as if it's not there) for the hover to return to
				var shadow = pieSeries.slices.template.filters.push(new am4core.DropShadowFilter);
				shadow.opacity = 0;

				// Create hover state
				var hoverState = pieSeries.slices.template.states.getKey("hover"); // normally we have to create the hover state, in this 				case it already exists

				// Slightly shift the shadow and make it more prominent on hover
				var hoverShadow = hoverState.filters.push(new am4core.DropShadowFilter);
				hoverShadow.opacity = 0.7;
				hoverShadow.blur = 5;

				// Add a legend
				// chart.legend = new am4charts.Legend();

				chart.data = [
					@foreach($shiftDayPerStatus as $s)
						{
				  			"status": "{{ucfirst($s["name"])}}",
				  			"cant": {{$s["cant"]}}
						},

					@endforeach
						
				];
			}); // end Dias por estado
						
			//Dias por tipo de jornada
			am4core.ready(function() {
				// Themes begin
				am4core.useTheme(am4themes_animated);
				// Themes end

				// Create chart instance
				var chart = am4core.create("chartdayperjournaltype", am4charts.PieChart);

				// Add and configure Series
				var pieSeries = chart.series.push(new am4charts.PieSeries());
				pieSeries.dataFields.value = "cant";
				pieSeries.dataFields.category = "status";

				// Let's cut a hole in our Pie chart the size of 30% the radius
				chart.innerRadius = am4core.percent(30);
				
				// Put a thick white border around each Slice
				pieSeries.slices.template.stroke = am4core.color("#fff");
				pieSeries.slices.template.strokeWidth = 2;
				pieSeries.slices.template.strokeOpacity = 1;
				pieSeries.slices.template
  				// change the cursor on hover to make it apparent the object can be interacted with
  				.cursorOverStyle = [
    				{
      					"property": "cursor",
      					"value": "pointer"
    				}
  				];

				pieSeries.alignLabels = true;
				pieSeries.labels.template.bent = true;
				pieSeries.labels.template.radius = 3;
				pieSeries.labels.template.padding(0,0,0,0);

				pieSeries.ticks.template.disabled = true;

				// Create a base filter effect (as if it's not there) for the hover to return to
				var shadow = pieSeries.slices.template.filters.push(new am4core.DropShadowFilter);
				shadow.opacity = 0;

				// Create hover state
				var hoverState = pieSeries.slices.template.states.getKey("hover"); // normally we have to create the hover state, in this 				case it already exists

				// Slightly shift the shadow and make it more prominent on hover
				var hoverShadow = hoverState.filters.push(new am4core.DropShadowFilter);
				hoverShadow.opacity = 0.7;
				hoverShadow.blur = 5;

				// Add a legend
				// chart.legend = new am4charts.Legend();

				chart.data = [
					@foreach($shiftDayPerJournalType as $s)
						{
				  			"status": "{{ucfirst($s["name"])}}",
				  			"cant": {{$s["cant"]}}
						},

					@endforeach
						
				];
			}); // end Dias tipo de jornada
			
			am4core.ready(function() {

				// Themes begin
				am4core.useTheme(am4themes_animated);
				// Themes end

				// Create chart instance
				var chart = am4core.create("chartpeoplecant", am4charts.XYChart);

				// Add data
				// chart.data = generateChartData();
			 //  	chartData.push({
			 //  	          date: newDate,
			 //  	          visits: visits
			 //  	      });
			 //  	Cambiar
				// Create axes
				chart.data = [
					@foreach($chartpeoplecant as $s)
						{
				  			"date": "{{ucfirst($s["name"])}}",
				  			"visits": {{$s["cant"]}}
						},

					@endforeach
						
				];
					

				var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
				dateAxis.renderer.minGridDistance = 50;

				var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

				// Create series
				var series = chart.series.push(new am4charts.LineSeries());
				series.dataFields.valueY = "visits";
				series.dataFields.categoryX = "date";
				series.strokeWidth = 2;
				series.minBulletDistance = 10;
				series.tooltipText = "{valueY}";
				series.tooltip.pointerOrientation = "vertical";
				series.tooltip.background.cornerRadius = 20;
				series.tooltip.background.fillOpacity = 0.5;
				series.tooltip.label.padding(12,12,12,12)
				// Add scrollbar
				chart.scrollbarX = new am4charts.XYChartScrollbar();
				chart.scrollbarX.series.push(series);

				// Add cursor
				chart.cursor = new am4charts.XYCursor();
				chart.cursor.xAxis = dateAxis;
				chart.cursor.snapToSeries = series;

				// function use in example page 
				function generateChartData() {
    				var chartData = [];
    				var firstDate = new Date();
    				firstDate.setDate(firstDate.getDate() - 1000);
    				var visits = 1200;
    				for (var i = 0; i < 500; i++) {
        				// we create date objects here. In your data, you can have date strings
        				// and then set format of your dates using chart.dataDateFormat property,
        				// however when possible, use date objects, as this will speed up chart rendering.
        				var newDate = new Date(firstDate);
        				newDate.setDate(newDate.getDate() + i);
        
        				visits += Math.round((Math.random()<0.5?1:-1)*Math.random()*10);

        				chartData.push({
           		 			date: newDate,
            				visits: visits
        				});
    				}
    				return chartData;
				}
			}); // end am4core.ready()

			am4core.ready(function() {

				// Themes begin
				am4core.useTheme(am4themes_frozen);
				am4core.useTheme(am4themes_animated);
				// Themes end
			
				// Create chart instance
				var chart = am4core.create("chartdiv", am4charts.XYChart);
			
				// Add data
				chart.data = 

				// Create axes

				var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
				categoryAxis.dataFields.category = "country";
				categoryAxis.renderer.grid.template.location = 0;
				categoryAxis.renderer.minGridDistance = 30;
			
			categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
			  if (target.dataItem && target.dataItem.index & 2 == 2) {
			    return dy + 25;
			  }
			  return dy;
			});

			var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

			// Create series
			var series = chart.series.push(new am4charts.ColumnSeries());
			series.dataFields.valueY = "visits";
			series.dataFields.categoryX = "country";
			series.name = "Visits";
			series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
			series.columns.template.fillOpacity = .8;

			var columnTemplate = series.columns.template;
			columnTemplate.strokeWidth = 2;
			columnTemplate.strokeOpacity = 1;
			
		}); // end am4core.ready()
		</script>
	@endsection

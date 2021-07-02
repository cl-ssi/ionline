@extends('layouts.app')

@section('title', 'Gestion de Turnos')

	@section('content')

		@include("rrhh.shift_management.tabs", array('actuallyMenu' => 'reports'))

		<h3>Reportes</h3>
		<br>
		<div class="row">
			<div class="col-md-3">
				<div class="card" style="width: 18rem;">
				  <div class="card-body">
				    <h5 class="card-title">Días por estado</h5>
				    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
				    <div id="chartdiv"></div>
				    <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
				  <!--   <a href="#" class="card-link">Card link</a>
				    <a href="#" class="card-link">Another link</a> -->
				  </div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="card" style="width: 18rem;">
				  <div class="card-body">
				    <h5 class="card-title">Card title</h5>
				    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
				    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
				    <a href="#" class="card-link">Card link</a>
				    <a href="#" class="card-link">Another link</a>
				  </div>
				</div>
			</div>

			<div class="col-md-3">
				<div class="card" style="width: 18rem;">
				  <div class="card-body">
				    <h5 class="card-title">Card title</h5>
				    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
				    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
				    <a href="#" class="card-link">Card link</a>
				    <a href="#" class="card-link">Another link</a>
				  </div>
				</div>
			</div>
		</div>
	@endsection
	@section('custom_js')
		<script>

			am4core.ready(function() {
				// Themes begin
				am4core.useTheme(am4themes_animated);
				// Themes end

				// Create chart instance
				var chart = am4core.create("chartdiv", am4charts.PieChart);

				// Add and configure Series
				var pieSeries = chart.series.push(new am4charts.PieSeries());
				pieSeries.dataFields.value = "litres";
				pieSeries.dataFields.category = "country";

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

				pieSeries.alignLabels = false;
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
				chart.legend = new am4charts.Legend();

				chart.data = [{
				  "country": "Lithuania",
				  "litres": 501.9
				},{
				  "country": "Germany",
				  "litres": 165.8
				}, {
				  "country": "Australia",
				  "litres": 139.9
				}, {
				  "country": "Austria",
				  "litres": 128.3
				}, {
				  "country": "UK",
				  "litres": 99
				}, {
				  "country": "Belgium",
				  "litres": 60
				}];

			}); // end am4core.ready()
		</script>
	@endsection

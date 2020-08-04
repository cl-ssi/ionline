@extends('layouts.app')

@section('title', 'Ley N° 18.834')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">Indicadores</h3>
<h6 class="mb-3">Metas Sanitarias Ley N° 18.834</h6>

<ol>
    <li> <a href="{{ route('indicators.18834.2019.servicio') }}">Servicio de Salud. </a>
        <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            <i class="fas fa-chart-bar"></i> Gráfica
        </button>
        <div>
            <div class="row">
                <div class="col-sm">
                    <div class="collapse" id="collapseExample">
                        <div id="chartdiv"></div>
                        <ol>
                            <li type="disc">
                              <font size="2">1.3. Porcentaje de pacientes hipertensos compensados bajo control en el grupo de 15 y más años en el nivel primario.</font>
                            </li>
                            <li type="disc">
                              <font size="2">1.4. Porcentaje de cumplimiento de programación de consultas de profesionales no médicos de establecimientos hospitalarios de alta complejidad.</font>
                            </li>
                            <li type="disc">
                              <font size="2">1.7. Porcentaje de Gestión Efectiva para el Cumplimiento GES en la Red.</font>
                            </li>
                            <li type="disc">
                              <font size="2">1.8. Porcentaje de pretaciones trazadoras de tratamiento GES otrogadas según lo programado de prestaciones trazadoras de tratamiento GES en contrato PPV para el año t.</font>
                            </li>
                            <li type="disc">
                              <font size="2">3.1. Porcentajes de funcionarios regidos por el Estatuto Administrativo, capacitados durante el año en al menos una actividad pertinente, de los nueve ejes estratégicos de la Estrategia Nacional de Salud.</font>
                            </li>
                  			</ol>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <br>
    <li> <a href="{{ route('indicators.18834.2019.hospital') }}">Hospital Dr. Ernesto Torres G.</a>
        <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample-2" aria-expanded="false" aria-controls="collapseExample">
            <i class="fas fa-chart-bar"></i> Gráfica
        </button>
        <div>
            <div class="row">
                <div class="col-sm">
                    <div class="collapse" id="collapseExample-2">
                        <div id="chartdiv-hetg"></div>
                        <ol>
                            <li type="disc">
                              <font size="2">1.4. Porcentaje de cumplimiento de programación de consultas de profesionales no médicos de establecimientos hospitalarios de alta complejidad.</font>
                    				</li>
                            <li type="disc">
                              <font size="2">1.5. Porcentaje de categorización de Urgencia a través de ESI en las UEH.</font>
                    				</li>
                    				<li type="disc">
                    					<font size="2">1.6. Porcentaje de categorización de pacientes en niveles de riesgo dependencia.</font>
                    				</li>
                            <li type="disc">
                    					<font size="2">1.7. Porcentaje de Gestión Efectiva para el Cumplimiento GES en la Red.</font>
                    				</li>
                    				<li type="disc">
                    					<font size="2">1.8. Porcentaje de pretaciones trazadoras de tratamiento GES otrogadas según lo programado de prestaciones trazadoras de tratamiento GES en contrato PPV para el año t.</font>
                    				</li>
                            <li type="disc">
                    					<font size="2">2.0. Porcentaje de egreso de maternidades con Lactancia Materna Exclusiva (LME).</font>
                    				</li>
                            <li type="disc">
                    					<font size="2">3.1. Porcentajes de funcionarios regidos por el Estatuto Administrativo, capacitados durante el año en al menos una actividad pertinente, de los nueve ejes estratégicos de la Estrategia Nacional de Salud.</font>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <br>
    <li> <a href="{{ route('indicators.18834.2019.reyno') }}">CGU Dr. Héctor Reyno.</a>
        <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample-3" aria-expanded="false" aria-controls="collapseExample">
            <i class="fas fa-chart-bar"></i> Gráfica
        </button>
    </li>
    <div>
        <div class="row">
            <div class="col-sm">
                <div class="collapse" id="collapseExample-3">
                    <div id="chartdiv-reyno"></div>
                    <ol>
                        <li type="disc">
                          <font size="2">1.1. Pacientes diabéticos compensados en el grupo de 15 años y más.</font>
                        </li>
                        <li type="disc">
                          <font size="2">1.2. Evaluación anual de los pies en personas de 15 años y más con diabetes bajo control.</font>
                        </li>
                        <li type="disc">
                          <font size="2">1.3. Pacientes hipertenesos compensados bajo control en el grupo de 15 años y más.</font>
                        </li>
                        <li type="disc">
                          <font size="2">1.7. Porcentaje de Gestión Efectiva para el Cumplimiento GES en la Red.</font>
                        </li>
                        <li type="disc">
                          <font size="2">1.8. Porcentaje de pretaciones trazadoras de tratamiento GES otrogadas según lo programado de prestaciones trazadoras de tratamiento GES en contrato PPV para el año t.</font>
                        </li>
                        <li type="disc">
                          <font size="2">3.1. Porcentajes de funcionarios regidos por el Estatuto Administrativo, capacitados durante el año en al menos una actividad pertinente, de los nueve ejes estratégicos de la Estrategia Nacional de Salud.</font>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</ol>



@endsection

@section('custom_js')

<script type="text/javascript">
    $('#myTab a[href="#IQUIQUE"]').tab('show') // Select tab by name
</script>

<!-- INDICADOR 1 -->
<style>
    #chartdiv, #chartdiv-hetg, #chartdiv-reyno {
      width: 95%;
      height: 400px;
    }
</style>

<!-- CURRENT CHART SSI -->
<script>
    am4core.ready(function() {

    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end

    // Create chart instance
    var chart = am4core.create("chartdiv", am4charts.XYChart);

    // Export
    //chart.exporting.menu = new am4core.ExportMenu();

    // Add percent sign to all numbers
    chart.numberFormatter.numberFormat = "#.##'%'";

    // VARIABLES PARA GRAFICOS  2019
    /* ----------------------------------------------------------------------------- */
    var arrayJS=<?php echo json_encode($data13);?>;

    var cumInd1_3 = arrayJS['cumplimiento'];
    var meta1_3 = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data14);?>;

    var cumInd1_4 = arrayJS['cumplimiento'];
    var meta1_4 = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data17);?>;

    var cumInd1_7 = arrayJS['cumplimiento'];
    var meta1_7 = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data18);?>;

    var cumInd1_8 = arrayJS['cumplimiento'];
    var meta1_8 = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data31);?>;

    var cumInd3_1 = arrayJS['cumplimiento'];
    var meta3_1 = arrayJS['meta'];

    /* ----------------------------------------------------------------------------- */

    var data = [ {
      "comuna": "1.3",
      "cumplimiento": cumInd1_3,
      "meta": meta1_3
    }, {
      "comuna": "1.4",
      "cumplimiento": cumInd1_4,
      "meta": meta1_4
    }, {
      "comuna": "1.7",
      "cumplimiento": cumInd1_7,
      "meta": meta1_7
    }, {
      "comuna": "1.8",
      "cumplimiento": cumInd1_8,
      "meta": meta1_8
    }, {
      "comuna": "3.1",
      "cumplimiento": cumInd3_1,
      "meta": meta3_1
    }];

    /* Create axes */
    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = "comuna";
    categoryAxis.renderer.minGridDistance = 30;
    categoryAxis.renderer.labels.template.fontSize = 12;

    /* Create value axis */
    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis.min = 0;
    valueAxis.max = 110;

    /* Create series */
    var columnSeries = chart.series.push(new am4charts.ColumnSeries());
    columnSeries.name = "Cumplimiento";
    columnSeries.dataFields.valueY = "cumplimiento";
    columnSeries.dataFields.categoryX = "comuna";
    //columnSeries.dataFields.label.fontSize = 12;

    columnSeries.columns.template.tooltipText = "[#fff font-size: 10px]{name} en {categoryX}:\n[/][#fff font-size: 12px]{valueY} [/] [#fff]{additional}[/]"
    //columnSeries.columns.template.propertyFields.fillOpacity = "fillOpacity";
    columnSeries.columns.template.propertyFields.stroke = "stroke";
    columnSeries.columns.template.propertyFields.strokeWidth = "strokeWidth";
    columnSeries.columns.template.propertyFields.strokeDasharray = "columnDash";
    columnSeries.tooltip.label.textAlign = "middle";

    var valueLabel = columnSeries.bullets.push(new am4charts.LabelBullet());
    valueLabel.label.text = "[bold]{valueY}[/]";
    valueLabel.label.fill = am4core.color("#fff");
    valueLabel.locationY = 0.1;
    valueLabel.label.fontSize = 12;

    var lineSeries = chart.series.push(new am4charts.LineSeries());
    lineSeries.name = "Meta";
    lineSeries.dataFields.valueY = "meta";
    lineSeries.dataFields.categoryX = "comuna";

    lineSeries.stroke = am4core.color("#fdd400");
    lineSeries.strokeWidth = 3;
    lineSeries.propertyFields.strokeDasharray = "lineDash";
    lineSeries.tooltip.label.textAlign = "middle";

    var bullet = lineSeries.bullets.push(new am4charts.Bullet());
    bullet.fill = am4core.color("#fdd400"); // tooltips grab fill from parent by default
    bullet.tooltipText = "[#fff font-size: 10px]{name} en {categoryX}:\n[/][#fff font-size: 12px]{valueY} [/] [#fff]{additional}[/]";

    var circle = bullet.createChild(am4core.Circle);
    circle.radius = 4;
    circle.fill = am4core.color("#fff");
    circle.strokeWidth = 3;

    let title = chart.titles.create();
    title.text = "Cumplimiento vs Meta - Año 2019";
    title.fontSize = 15;
    title.marginBottom = 10;

    chart.data = data;

    chart.responsive.enabled = true;

    }); // end am4core.ready()
</script>

<!-- CURRENT CHART HETG -->
<script>
    am4core.ready(function() {

    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end

    // Create chart instance
    var chart = am4core.create("chartdiv-hetg", am4charts.XYChart);

    // Export
    //chart.exporting.menu = new am4core.ExportMenu();

    // Add percent sign to all numbers
    chart.numberFormatter.numberFormat = "#.##'%'";

    // VARIABLES PARA GRAFICOS  2019
    /* ----------------------------------------------------------------------------- */
    var arrayJS=<?php echo json_encode($data14_hosp);?>;

    var cumInd1_4_hosp = arrayJS['cumplimiento'];
    var meta1_4_hosp = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data15_hosp);?>;

    var cumInd1_5_hosp = arrayJS['cumplimiento'];
    var meta1_5_hosp = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data16_hosp);?>;

    var cumInd1_6_hosp = arrayJS['cumplimiento'];
    var meta1_6_hosp = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data17_hosp);?>;

    var cumInd1_7_hosp = arrayJS['cumplimiento'];
    var meta1_7_hosp = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data18_hosp);?>;

    var cumInd1_8_hosp = arrayJS['cumplimiento'];
    var meta1_8_hosp = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data20_hosp);?>;

    var cumInd2_0_hosp = arrayJS['cumplimiento'];
    var meta2_0_hosp = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data31_hosp);?>;

    var cumInd3_1_hosp = arrayJS['cumplimiento'];
    var meta3_1_hosp = arrayJS['meta'];

    /* ----------------------------------------------------------------------------- */

    var data = [ {
      "comuna": "1.4",
      "cumplimiento": cumInd1_4_hosp,
      "meta": meta1_4_hosp
    }, {
      "comuna": "1.5",
      "cumplimiento": cumInd1_5_hosp,
      "meta": meta1_5_hosp
    }, {
      "comuna": "1.6",
      "cumplimiento": cumInd1_6_hosp,
      "meta": meta1_5_hosp
    }, {
      "comuna": "1.7",
      "cumplimiento": cumInd1_7_hosp,
      "meta": meta1_7_hosp
    }, {
      "comuna": "1.8",
      "cumplimiento": cumInd1_8_hosp,
      "meta": meta1_8_hosp
    }, {
      "comuna": "2.0",
      "cumplimiento": cumInd2_0_hosp,
      "meta": meta2_0_hosp
    } , {
      "comuna": "3.1",
      "cumplimiento": cumInd3_1_hosp,
      "meta": meta3_1_hosp
    }];

    /* Create axes */
    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = "comuna";
    categoryAxis.renderer.minGridDistance = 30;
    categoryAxis.renderer.labels.template.fontSize = 12;

    /* Create value axis */
    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis.min = 0;
    valueAxis.max = 110;

    /* Create series */
    var columnSeries = chart.series.push(new am4charts.ColumnSeries());
    columnSeries.name = "Cumplimiento";
    columnSeries.dataFields.valueY = "cumplimiento";
    columnSeries.dataFields.categoryX = "comuna";
    //columnSeries.dataFields.label.fontSize = 12;

    columnSeries.columns.template.tooltipText = "[#fff font-size: 10px]{name} en {categoryX}:\n[/][#fff font-size: 12px]{valueY} [/] [#fff]{additional}[/]"
    //columnSeries.columns.template.propertyFields.fillOpacity = "fillOpacity";
    columnSeries.columns.template.propertyFields.stroke = "stroke";
    columnSeries.columns.template.propertyFields.strokeWidth = "strokeWidth";
    columnSeries.columns.template.propertyFields.strokeDasharray = "columnDash";
    columnSeries.tooltip.label.textAlign = "middle";

    var valueLabel = columnSeries.bullets.push(new am4charts.LabelBullet());
    valueLabel.label.text = "[bold]{valueY}[/]";
    valueLabel.label.fill = am4core.color("#fff");
    valueLabel.locationY = 0.1;
    valueLabel.label.fontSize = 12;

    var lineSeries = chart.series.push(new am4charts.LineSeries());
    lineSeries.name = "Meta";
    lineSeries.dataFields.valueY = "meta";
    lineSeries.dataFields.categoryX = "comuna";

    lineSeries.stroke = am4core.color("#fdd400");
    lineSeries.strokeWidth = 3;
    lineSeries.propertyFields.strokeDasharray = "lineDash";
    lineSeries.tooltip.label.textAlign = "middle";

    var bullet = lineSeries.bullets.push(new am4charts.Bullet());
    bullet.fill = am4core.color("#fdd400"); // tooltips grab fill from parent by default
    bullet.tooltipText = "[#fff font-size: 10px]{name} en {categoryX}:\n[/][#fff font-size: 12px]{valueY} [/] [#fff]{additional}[/]";

    var circle = bullet.createChild(am4core.Circle);
    circle.radius = 4;
    circle.fill = am4core.color("#fff");
    circle.strokeWidth = 3;

    let title = chart.titles.create();
    title.text = "Cumplimiento vs Meta - Año 2019";
    title.fontSize = 15;
    title.marginBottom = 10;

    chart.data = data;

    chart.responsive.enabled = true;

    }); // end am4core.ready()
</script>

<!-- CURRENT CHART HETG -->
<script>
    am4core.ready(function() {

    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end

    // Create chart instance
    var chart = am4core.create("chartdiv-reyno", am4charts.XYChart);

    // Export
    //chart.exporting.menu = new am4core.ExportMenu();

    // Add percent sign to all numbers
    chart.numberFormatter.numberFormat = "#.##'%'";

    // VARIABLES PARA GRAFICOS  2019
    /* ----------------------------------------------------------------------------- */
    var arrayJS=<?php echo json_encode($data11_reyno);?>;

    var cumInd1_1_reyno = arrayJS['cumplimiento'];
    var meta1_1_reyno = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data12_reyno);?>;

    var cumInd1_2_reyno = arrayJS['cumplimiento'];
    var meta1_2_reyno = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data13_reyno);?>;

    var cumInd1_3_reyno = arrayJS['cumplimiento'];
    var meta1_3_reyno = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data17_reyno);?>;

    var cumInd1_7_reyno = arrayJS['cumplimiento'];
    var meta1_7_reyno = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data31_reyno);?>;

    var cumInd3_1_reyno = arrayJS['cumplimiento'];
    var meta3_1_reyno = arrayJS['meta'];


    /* ----------------------------------------------------------------------------- */

    var data = [ {
      "comuna": "1.1",
      "cumplimiento": cumInd1_1_reyno,
      "meta": meta1_1_reyno
    }, {
      "comuna": "1.2",
      "cumplimiento": cumInd1_2_reyno,
      "meta": meta1_2_reyno
    }, {
      "comuna": "1.3",
      "cumplimiento": cumInd1_3_reyno,
      "meta": meta1_2_reyno
    }, {
      "comuna": "1.7",
      "cumplimiento": cumInd1_7_reyno,
      "meta": meta1_7_reyno
    }, {
      "comuna": "3.1",
      "cumplimiento": cumInd3_1_reyno,
      "meta": meta3_1_reyno
    } ];

    /* Create axes */
    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = "comuna";
    categoryAxis.renderer.minGridDistance = 30;
    categoryAxis.renderer.labels.template.fontSize = 12;

    /* Create value axis */
    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
    valueAxis.min = 0;
    valueAxis.max = 110;

    /* Create series */
    var columnSeries = chart.series.push(new am4charts.ColumnSeries());
    columnSeries.name = "Cumplimiento";
    columnSeries.dataFields.valueY = "cumplimiento";
    columnSeries.dataFields.categoryX = "comuna";
    //columnSeries.dataFields.label.fontSize = 12;

    columnSeries.columns.template.tooltipText = "[#fff font-size: 10px]{name} en {categoryX}:\n[/][#fff font-size: 12px]{valueY} [/] [#fff]{additional}[/]"
    //columnSeries.columns.template.propertyFields.fillOpacity = "fillOpacity";
    columnSeries.columns.template.propertyFields.stroke = "stroke";
    columnSeries.columns.template.propertyFields.strokeWidth = "strokeWidth";
    columnSeries.columns.template.propertyFields.strokeDasharray = "columnDash";
    columnSeries.tooltip.label.textAlign = "middle";

    var valueLabel = columnSeries.bullets.push(new am4charts.LabelBullet());
    valueLabel.label.text = "[bold]{valueY}[/]";
    valueLabel.label.fill = am4core.color("#fff");
    valueLabel.locationY = 0.1;
    valueLabel.label.fontSize = 12;

    var lineSeries = chart.series.push(new am4charts.LineSeries());
    lineSeries.name = "Meta";
    lineSeries.dataFields.valueY = "meta";
    lineSeries.dataFields.categoryX = "comuna";

    lineSeries.stroke = am4core.color("#fdd400");
    lineSeries.strokeWidth = 3;
    lineSeries.propertyFields.strokeDasharray = "lineDash";
    lineSeries.tooltip.label.textAlign = "middle";

    var bullet = lineSeries.bullets.push(new am4charts.Bullet());
    bullet.fill = am4core.color("#fdd400"); // tooltips grab fill from parent by default
    bullet.tooltipText = "[#fff font-size: 10px]{name} en {categoryX}:\n[/][#fff font-size: 12px]{valueY} [/] [#fff]{additional}[/]";

    var circle = bullet.createChild(am4core.Circle);
    circle.radius = 4;
    circle.fill = am4core.color("#fff");
    circle.strokeWidth = 3;

    let title = chart.titles.create();
    title.text = "Cumplimiento vs Meta - Año 2019";
    title.fontSize = 15;
    title.marginBottom = 10;

    chart.data = data;

    chart.responsive.enabled = true;

    }); // end am4core.ready()
</script>

@endsection

@section('custom_js_head')

<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/material.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

@endsection

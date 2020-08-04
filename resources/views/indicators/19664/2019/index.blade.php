@extends('layouts.app')

@section('title', 'Indicadores')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">Indicadores Ley N°19.664</h3>

<ol>
    <li> <a href="{{ route('indicators.19664.2019.servicio') }}">Servicio de Salud.</a>
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
                              <font size="2">1.1.1 Pacientes diabéticos compensados en el grupo de 15 años y más.</font>
                            </li>
                            <li type="disc">
                              <font size="2">1.1.2 Evaluacion Anual de los Pies en personas con DM2 de 15 y más con diabetes bajo control.</font>
                            </li>
                            <li type="disc">
                              <font size="2">1.1.3 Pacientes hipertensos compensados bajo control en el grupo de 15 años y más.</font>
                            </li>
                            <li type="disc">
                              <font size="2">1.2 Porcentaje de Intervenciones Quirúrgicas Suspendidas.</font>
                            </li>
                            <li type="disc">
                              <font size="2">1.4 Variación procentual del número de días promedio de espera para intervenciones quirúrgicas, según línea base.</font>
                            </li>
                            <li type="disc">
                              <font size="2">b. Porcentaje de cumplimento de la programación anual de consulta médicas realizadas por especialista.</font>
                            </li>
                            <li type="disc">
                              <font size="2">c. Porcentaje de Cumplimiento de la Programación anual de Consultas Médicas realizadas en modalidad Telemedicina.</font>
                            </li>
                            <li type="disc">
                              <font size="2">d. Variación procentual de pacientes que esperan más de 12 horas en la Unidad de Emeergencia Hospitalaria UEH para ceder a una cama de dotación.</font>
                            </li>
                            <li type="disc">
                              <font size="2">3.a Porcentaje de Gestión Efectiva para el Cumplimiento GES en la Red.</font>
                            </li>
                            <li type="disc">
                              <font size="2">3.b Porcentaje de intervenciones sanitarias GES otrogadas según lo programado en contrato PPV para el año t.</font>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <br>
    <li> <a href="{{ route('indicators.19664.2019.hospital') }}">Hospital Dr. Ernesto Torres G.</a>
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
                              <font size="2">1.2 Porcentaje de Intervenciones Quirúrgicas Suspendidas.</font>
                            </li>
                            <li type="disc">
                              <font size="2">1.3 Porcentaje de ambulatorización de cirugías mayores en el año t.</font>
                            </li>
                            <li type="disc">
                              <font size="2">1.4 Variación procentual del número de días promedio de espera para intervenciones quirúrgicas, según línea base.</font>
                            </li>
                            <li type="disc">
                              <font size="2">a. Porcentaje de altas Odonotlógicas de especialidades del nivel secundario por ingreso de tratamiento.</font>
                            </li>
                            <li type="disc">
                              <font size="2">b. Porcentaje de cumplimento de la programación anual de consulta médicas realizadas por especialista.</font>
                            </li>
                            <li type="disc">
                              <font size="2">c. Porcentaje de Cumplimiento de la Programación anual de Consultas Médicas realizadas en modalidad Telemedicina.</font>
                            </li>
                            <li type="disc">
                              <font size="2">d. Variación procentual de pacientes que esperan más de 12 horas en la Unidad de Emeergencia Hospitalaria UEH para ceder a una cama de dotación.</font>
                            </li>
                            <li type="disc">
                              <font size="2">e. Promedio de días de estadía de pacientes derivados vía UUCC a prestadores privados fuera de convenio.</font>
                            </li>
                            <li type="disc">
                              <font size="2">3.a Porcentaje de Gestión Efectiva para el Cumplimiento GES en la Red.</font>
                            </li>
                            <li type="disc">
                              <font size="2">3.b Porcentaje de intervenciones sanitarias GES otrogadas según lo programado en contrato PPV para el año t.</font>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <br>
    <li> <a href="{{ route('indicators.19664.2019.reyno') }}"> CGU Dr. Héctor Reyno.</a>
        <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample-3" aria-expanded="false" aria-controls="collapseExample">
            <i class="fas fa-chart-bar"></i> Gráfica
        </button>
        <div>
            <div class="row">
                <div class="col-sm">
                    <div class="collapse" id="collapseExample-3">
                        <div id="chartdiv-reyno"></div>
                        <ol>
                            <li type="disc">
                              <font size="2">1.1.1 Pacientes diabéticos compensados en el grupo de 15 años y más.</font>
                            </li>
                            <li type="disc">
                              <font size="2">1.1.2 Evaluacion Anual de los Pies en personas con DM2 de 15 y más con diabetes bajo control.</font>
                            </li>
                            <li type="disc">
                              <font size="2">1.1.3 Pacientes hipertensos compensados bajo control en el grupo de 15 años y más.</font>
                            </li>
                            <li type="disc">
                              <font size="2">3.a Porcentaje de Gestión Efectiva para el Cumplimiento GES en la Red.</font>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </li>
</ol>

@endsection

@section('custom_js')

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
    var arrayJS=<?php echo json_encode($data111);?>;

    var cumInd111 = arrayJS['cumplimiento'];
    var meta111 = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data112);?>;

    var cumInd112 = arrayJS['cumplimiento'];
    var meta112 = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data113);?>;

    var cumInd113 = arrayJS['cumplimiento'];
    var meta113 = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data12);?>;

    var cumInd12 = arrayJS['cumplimiento'];
    var meta12 = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($datab);?>;

    var cumIndb = arrayJS['cumplimiento'];
    var metab = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($datac);?>;

    var cumIndc = arrayJS['cumplimiento'];
    var metac = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data3a);?>;

    var cumInd3a = arrayJS['cumplimiento'];
    var meta3a = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data3b);?>;

    var cumInd3b = arrayJS['cumplimiento'];
    var meta3b = arrayJS['meta'];

    /* ----------------------------------------------------------------------------- */

    var data = [ {
      "comuna": "1.1.1",
      "cumplimiento": cumInd111,
      "meta": meta111
    }, {
      "comuna": "1.1.2",
      "cumplimiento": cumInd112,
      "meta": meta112
    }, {
      "comuna": "1.1.3",
      "cumplimiento": cumInd113,
      "meta": meta113
    }, {
      "comuna": "1.2",
      "cumplimiento": cumInd12,
      "meta": meta12
    }, {
      "comuna": "1.4",
      "cumplimiento": 0,
      "meta": 0
    }, {
      "comuna": "b",
      "cumplimiento": cumIndb,
      "meta": metab
    }, {
      "comuna": "c",
      "cumplimiento": cumIndc,
      "meta": metac
    }, {
      "comuna": "3a",
      "cumplimiento": cumInd3a,
      "meta": meta3a
    }, {
      "comuna": "3b",
      "cumplimiento": cumInd3b,
      "meta": meta3b
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

    var arrayJS=<?php echo json_encode($data12_hetg);?>;

    var cumInd12_hetg = arrayJS['cumplimiento'];
    var meta12_hetg = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data13_hetg);?>;

    var cumInd13_hetg = arrayJS['cumplimiento'];
    var meta13_hetg = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data14_hetg);?>;

    var cumInd14_hetg = arrayJS['cumplimiento'];
    var meta14_hetg = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($dataa_hetg);?>;

    var cumInda_hetg = arrayJS['cumplimiento'];
    var metaa_hetg = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($datab_hetg);?>;

    var cumIndb_hetg = arrayJS['cumplimiento'];
    var metab_hetg = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($datac_hetg);?>;

    var cumIndc_hetg = arrayJS['cumplimiento'];
    var metac_hetg = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($datae_hetg);?>;

    var cumInde_hetg = arrayJS['cumplimiento'];
    var metae_hetg = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data3a_hetg);?>;

    var cumInd3a_hetg = arrayJS['cumplimiento'];
    var meta3a_hetg = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data3b_hetg);?>;

    var cumInd3b_hetg = arrayJS['cumplimiento'];
    var meta3b_hetg = arrayJS['meta'];

    /* ----------------------------------------------------------------------------- */

    var data = [ {
      "comuna": "1.2",
      "cumplimiento": cumInd12_hetg,
      "meta": meta12_hetg
    }, {
      "comuna": "1.3",
      "cumplimiento": cumInd13_hetg,
      "meta": meta13_hetg
    }, {
      "comuna": "1.4",
      "cumplimiento": cumInd14_hetg,
      "meta": meta14_hetg
    }, {
      "comuna": "a",
      "cumplimiento": cumInda_hetg,
      "meta": metaa_hetg
    }, {
      "comuna": "b",
      "cumplimiento": cumIndb_hetg,
      "meta": metab_hetg
    }, {
      "comuna": "c",
      "cumplimiento": cumIndc_hetg,
      "meta": metac_hetg
    }, {
      "comuna": "d",
      "cumplimiento": 0,
      "meta": 0
    }, {
      "comuna": "e",
      "cumplimiento": cumInde_hetg,
      "meta": metae_hetg
    }, {
      "comuna": "3.a",
      "cumplimiento": cumInd3a_hetg,
      "meta": meta3a_hetg
    }, {
      "comuna": "3.b",
      "cumplimiento": cumInd3b_hetg,
      "meta": meta3b_hetg
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

<!-- CURRENT CHART REYNO -->
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

    var arrayJS=<?php echo json_encode($data111_reyno);?>;

    var cumInd111_reyno = arrayJS['cumplimiento'];
    var meta111_reyno = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data112_reyno);?>;

    var cumInd112_reyno = arrayJS['cumplimiento'];
    var meta112_reyno = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data113_reyno);?>;

    var cumInd113_reyno = arrayJS['cumplimiento'];
    var meta113_reyno = arrayJS['meta'];

    var arrayJS=<?php echo json_encode($data3a_reyno);?>;

    var cumInd3a_reyno = arrayJS['cumplimiento'];
    var meta3a_reyno = arrayJS['meta'];

    /* ----------------------------------------------------------------------------- */

    var data = [ {
      "comuna": "1.1.1",
      "cumplimiento": cumInd111_reyno,
      "meta": meta111_reyno
    }, {
      "comuna": "1.1.2",
      "cumplimiento": cumInd112_reyno,
      "meta": meta112_reyno
    }, {
      "comuna": "1.1.3",
      "cumplimiento": cumInd113_reyno,
      "meta": meta113_reyno
    }, {
      "comuna": "3.a",
      "cumplimiento": cumInd3a_reyno,
      "meta": meta3a_reyno
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

@endsection

@section('custom_js_head')

<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/material.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

@endsection

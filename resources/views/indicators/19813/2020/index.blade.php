@extends('layouts.app')

@section('title', 'Indicadores')

@section('content')

@include('indicators.partials.nav')

<h3 class="mb-3">Indicadores</h3>

<ol>
    <li> <a href="{{ route('indicators.19813.2020.indicador1') }}">Porcentaje de niños y niñas de 12 a 23 meses con riesgo del desarrollo psicomotor recuperados.</a> <span class="badge badge-success"><i class="fas fa-check"></i></span></li>
    <li> <a href="{{ route('indicators.19813.2020.indicador2') }}">Papanicolau (Pap) Vigente en mujeres de 25 a 64 años.</a> <span class="badge badge-warning"><i class="fas fa-exclamation"></i></span></li>
    <li>
        <ul>
            <li> <a href="{{ route('indicators.19813.2020.indicador3a') }}">Porcentaje de altas odontológicas totales en adolescentes de 12 años.</a> <span class="badge badge-success"><i class="fas fa-check"></i></span></li>
            <li> <a href="{{ route('indicators.19813.2020.indicador3b') }}">Porcentaje de alta odontológica total en embarazadas.</a> <span class="badge badge-success"><i class="fas fa-check"></i></span></li>
            <li> <a href="{{ route('indicators.19813.2020.indicador3c') }}">Porcentaje de egresos odontológicos en niños y niñas de 6 años.</a> <span class="badge badge-success"><i class="fas fa-check"></i></span></li>
        </ul>
    </li>
    <li>
        <ul>
            <li> <a href="{{ route('indicators.19813.2020.indicador4a') }}">Porcentaje de cobertura efectiva de personas con Diabetes Mellitus Tipo 2.</a> <span class="badge badge-warning"><i class="fas fa-exclamation"></i></span></li>
            <li> <a href="{{ route('indicators.19813.2020.indicador4b') }}">Porcentaje de personas con diabetes de 15 años y más con evaluación anual de pie.</a> <span class="badge badge-warning"><i class="fas fa-exclamation"></i></span></li>
        </ul>
    <li> <a href="{{ route('indicators.19813.2020.indicador5') }}">Porcentaje de personas mayores de 15 años y más con cobertura efectiva de hipertensión arterial.</a> <span class="badge badge-warning"><i class="fas fa-exclamation"></i></span></li>
    <li> <a href="{{ route('indicators.19813.2020.indicador6') }}">Porcentaje de niños y niñas que al sexto mes de vida, cuentan con lactancia materna exclusiva.</a> <span class="badge badge-success"><i class="fas fa-check"></i></span></li>
</ol>

<div class="row">
    <div class="col-sm">
        <div id="chartdiv"></div>
    </div>
</div>

<button class="btn btn-primary float-right" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" disabled>
    <i class="fas fa-eye"></i> 2019
</button>

<br>
<br>
<br>

<div>
    <div class="row">
        <div class="col-sm">
            <div class="collapse" id="collapseExample">
                <div id="chartdiv2018"></div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('custom_js')

<style>
    #chartdiv, #chartdiv2018 {
      width: 100%;
      height: 450px;
    }
</style>

<script>
    var mescarga = '<?php echo $ultimo_rem; ?>'
    var mes;
    switch (mescarga) {
      case '1':
        mes = 'enero';
        break;
      case '2':
        mes = 'febrero';
        break;
      case '3':
        mes = 'marzo';
        break;
      case '4':
        mes = 'abril';
        break;
      case '5':
        mes = 'mayo';
        break;
      case '6':
        mes = 'junio';
        break;
      case '7':
        mes = 'julio';
        break;
      case '8':
        mes = 'agosto';
        break;
      case '9':
        mes = 'septiembre';
        break;
      case '10':
        mes = 'octubre';
        break;
      case '11':
        mes = 'noviembre';
        break;
      case '12':
        mes = 'diciembre';
        break;
      default:
      //Declaraciones ejecutadas cuando ninguno de los valores coincide con el valor de la expresión
        break;
    }

    // VARIABLES PARA GRAFICOS  2019
    /* ----------------------------------------------------------------------------- */
    var arrayJS=<?php echo json_encode($data12020);?>;

    var denMeta1 = arrayJS['ALTO HOSPICIO']['denominadores']['total'] +
                   arrayJS['CAMIÑA']['denominadores']['total'] +
                   arrayJS['COLCHANE']['denominadores']['total'] +
                   arrayJS['HUARA']['denominadores']['total'] +
                   arrayJS['IQUIQUE']['denominadores']['total'] +
                   arrayJS['PICA']['denominadores']['total'] +
                   arrayJS['POZO ALMONTE']['denominadores']['total'];

    var ahosInd1 = arrayJS['ALTO HOSPICIO']['numeradores']['total'] / denMeta1 * 100;
    var camInd1 = arrayJS['CAMIÑA']['numeradores']['total'] / denMeta1 * 100;
    var colInd1 = arrayJS['COLCHANE']['numeradores']['total'] / denMeta1 * 100;
    var huaInd1 = arrayJS['HUARA']['numeradores']['total'] / denMeta1 * 100;
    var iquInd1 = arrayJS['IQUIQUE']['numeradores']['total'] / denMeta1 * 100;
    var picInd1 = arrayJS['PICA']['numeradores']['total'] / denMeta1 * 100;
    var pozInd1 = arrayJS['POZO ALMONTE']['numeradores']['total'] / denMeta1 * 100;

    var sumaInd1 = 0;
    sumaInd1 = ahosInd1 + camInd1 + colInd1 + huaInd1 + iquInd1 + picInd1 + pozInd1;
    if (isNaN(sumaInd1)) {
      sumaInd1 = 0;
    }
    /* ----------------------------------------------------------------------------- */
    /* ----------------------------------------------------------------------------- */
    var arrayJS2=<?php echo json_encode($data22020);?>;

    var denMeta2 = arrayJS2['ALTO HOSPICIO']['denominador'] +
                   arrayJS2['CAMIÑA']['denominador'] +
                   arrayJS2['COLCHANE']['denominador'] +
                   arrayJS2['HUARA']['denominador'] +
                   arrayJS2['IQUIQUE']['denominador'] +
                   arrayJS2['PICA']['denominador'] +
                   arrayJS2['POZO ALMONTE']['denominador'];

    var ahosInd2 = arrayJS2['ALTO HOSPICIO']['numerador'] / denMeta2 * 100;
    var camInd2 = arrayJS2['CAMIÑA']['numerador'] / denMeta2 * 100;
    var colInd2 = arrayJS2['COLCHANE']['numerador'] / denMeta2 * 100;
    var huaInd2 = arrayJS2['HUARA']['numerador'] / denMeta2 * 100;
    var iquInd2 = arrayJS2['IQUIQUE']['numerador'] / denMeta2 * 100;
    var picInd2 = arrayJS2['PICA']['numerador'] / denMeta2 * 100;
    var pozInd2 = arrayJS2['POZO ALMONTE']['numerador'] / denMeta2 * 100;



    var sumaInd2 = 0;
    sumaInd2 = ahosInd2 + camInd2 + colInd2 + huaInd2 + iquInd2 + picInd2 + pozInd2;
    if (isNaN(sumaInd2)) {
      sumaInd2 = 0;
    }
    /* ----------------------------------------------------------------------------- */
    /* ----------------------------------------------------------------------------- */
    var arrayJS3a=<?php echo json_encode($data3a2020);?>;

    var denMeta3a = arrayJS3a['ALTO HOSPICIO']['denominador'] +
                    arrayJS3a['CAMIÑA']['denominador'] +
                    arrayJS3a['COLCHANE']['denominador'] +
                    arrayJS3a['HUARA']['denominador'] +
                    arrayJS3a['IQUIQUE']['denominador'] +
                    arrayJS3a['PICA']['denominador'] +
                    arrayJS3a['POZO ALMONTE']['denominador'];

    var ahosInd3a = arrayJS3a['ALTO HOSPICIO']['numeradores']['total'] / denMeta3a * 100;
    var camInd3a = arrayJS3a['CAMIÑA']['numeradores']['total'] / denMeta3a * 100;
    var colInd3a = arrayJS3a['COLCHANE']['numeradores']['total'] / denMeta3a * 100;
    var huaInd3a = arrayJS3a['HUARA']['numeradores']['total'] / denMeta3a * 100;
    var iquInd3a = arrayJS3a['IQUIQUE']['numeradores']['total'] / denMeta3a * 100;
    var picInd3a = arrayJS3a['PICA']['numeradores']['total'] / denMeta3a * 100;
    var pozInd3a = arrayJS3a['POZO ALMONTE']['numeradores']['total'] / denMeta3a * 100;

    var sumaInd3a = 0;
    sumaInd3a = ahosInd3a + camInd3a + colInd3a + huaInd3a + iquInd3a + picInd3a + pozInd3a;
    if (isNaN(sumaInd3a)) {
      sumaInd3a = 0;
    }
    /* ----------------------------------------------------------------------------- */
    /* ----------------------------------------------------------------------------- */
    var arrayJS3b=<?php echo json_encode($data3b2020);?>;

    var denMeta3b = arrayJS3b['ALTO HOSPICIO']['denominadores']['total'] +
                    arrayJS3b['CAMIÑA']['denominadores']['total'] +
                    arrayJS3b['COLCHANE']['denominadores']['total'] +
                    arrayJS3b['HUARA']['denominadores']['total'] +
                    arrayJS3b['IQUIQUE']['denominadores']['total'] +
                    arrayJS3b['PICA']['denominadores']['total'] +
                    arrayJS3b['POZO ALMONTE']['denominadores']['total'];

    var ahosInd3b = arrayJS3b['ALTO HOSPICIO']['numeradores']['total'] / denMeta3b * 100;
    var camInd3b = arrayJS3b['CAMIÑA']['numeradores']['total'] / denMeta3b * 100;
    var colInd3b = arrayJS3b['COLCHANE']['numeradores']['total'] / denMeta3b * 100;
    var huaInd3b = arrayJS3b['HUARA']['numeradores']['total'] / denMeta3b * 100;
    var iquInd3b = arrayJS3b['IQUIQUE']['numeradores']['total'] / denMeta3b * 100;
    var picInd3b = arrayJS3b['PICA']['numeradores']['total'] / denMeta3b * 100;
    var pozInd3b = arrayJS3b['POZO ALMONTE']['numeradores']['total'] / denMeta3b * 100;

    var sumaInd3b = 0;
    sumaInd3b = ahosInd3b + camInd3b + colInd3b + huaInd3b + iquInd3b + picInd3b + pozInd3b;

    if (isNaN(sumaInd3b)) {
      sumaInd3b = 0;
    }
    /* ----------------------------------------------------------------------------- */
    /* ----------------------------------------------------------------------------- */
    var arrayJS3c=<?php echo json_encode($data3c2020);?>;

    var denMeta3c = arrayJS3c['ALTO HOSPICIO']['denominador'] +
                    arrayJS3c['CAMIÑA']['denominador'] +
                    arrayJS3c['COLCHANE']['denominador'] +
                    arrayJS3c['HUARA']['denominador'] +
                    arrayJS3c['IQUIQUE']['denominador'] +
                    arrayJS3c['PICA']['denominador'] +
                    arrayJS3c['POZO ALMONTE']['denominador'];

    var ahosInd3c = arrayJS3c['ALTO HOSPICIO']['numeradores']['total'] / denMeta3c * 100;
    var camInd3c = arrayJS3c['CAMIÑA']['numeradores']['total'] / denMeta3c * 100;
    var colInd3c = arrayJS3c['COLCHANE']['numeradores']['total'] / denMeta3c * 100;
    var huaInd3c = arrayJS3c['HUARA']['numeradores']['total'] / denMeta3c * 100;
    var iquInd3c = arrayJS3c['IQUIQUE']['numeradores']['total'] / denMeta3c * 100;
    var picInd3c = arrayJS3c['PICA']['numeradores']['total'] / denMeta3c * 100;
    var pozInd3c = arrayJS3c['POZO ALMONTE']['numeradores']['total'] / denMeta3c * 100;

    var sumaInd3c = 0;
    sumaInd3c = ahosInd3c + camInd3c + colInd3c + huaInd3c + iquInd3c + picInd3c + pozInd3c;
    if (isNaN(sumaInd3c)) {
      sumaInd3c = 0;
    }
    /* ----------------------------------------------------------------------------- */
    /* ----------------------------------------------------------------------------- */
    var arrayJS4a=<?php echo json_encode($data4a2020);?>;

    var denMeta4a = arrayJS4a['ALTO HOSPICIO']['denominador'] +
                   arrayJS4a['CAMIÑA']['denominador'] +
                   arrayJS4a['COLCHANE']['denominador'] +
                   arrayJS4a['HUARA']['denominador'] +
                   arrayJS4a['IQUIQUE']['denominador'] +
                   arrayJS4a['PICA']['denominador'] +
                   arrayJS4a['POZO ALMONTE']['denominador'];

    var ahosInd4a = arrayJS4a['ALTO HOSPICIO']['numerador'] / denMeta4a * 100;
    var camInd4a = arrayJS4a['CAMIÑA']['numerador'] / denMeta4a * 100;
    var colInd4a = arrayJS4a['COLCHANE']['numerador'] / denMeta4a * 100;
    var huaInd4a = arrayJS4a['HUARA']['numerador'] / denMeta4a * 100;
    var iquInd4a = arrayJS4a['IQUIQUE']['numerador'] / denMeta4a * 100;
    var picInd4a = arrayJS4a['PICA']['numerador'] / denMeta4a * 100;
    var pozInd4a = arrayJS4a['POZO ALMONTE']['numerador'] / denMeta4a * 100;

    var sumaInd4a = 0;
    sumaInd4a = ahosInd4a + camInd4a + colInd4a + huaInd4a + iquInd4a + picInd4a + pozInd4a;
    if (isNaN(sumaInd4a)) {
      sumaInd4a = 0;
    }
    /* ----------------------------------------------------------------------------- */
    /* ----------------------------------------------------------------------------- */
    var arrayJS4b=<?php echo json_encode($data4b2020);?>;

    var denMeta4b = arrayJS4b['ALTO HOSPICIO']['denominador'] +
                   arrayJS4b['CAMIÑA']['denominador'] +
                   arrayJS4b['COLCHANE']['denominador'] +
                   arrayJS4b['HUARA']['denominador'] +
                   arrayJS4b['IQUIQUE']['denominador'] +
                   arrayJS4b['PICA']['denominador'] +
                   arrayJS4b['POZO ALMONTE']['denominador'];

    var ahosInd4b = arrayJS4b['ALTO HOSPICIO']['numerador'] / denMeta4b * 100;
    var camInd4b = arrayJS4b['CAMIÑA']['numerador'] / denMeta4b * 100;
    var colInd4b = arrayJS4b['COLCHANE']['numerador'] / denMeta4b * 100;
    var huaInd4b = arrayJS4b['HUARA']['numerador'] / denMeta4b * 100;
    var iquInd4b = arrayJS4b['IQUIQUE']['numerador'] / denMeta4b * 100;
    var picInd4b = arrayJS4b['PICA']['numerador'] / denMeta4b * 100;
    var pozInd4b = arrayJS4b['POZO ALMONTE']['numerador'] / denMeta4b * 100;

    var sumaInd4b = 0;
    sumaInd4b = ahosInd4b + camInd4b + colInd4b + huaInd4b + iquInd4b + picInd4b + pozInd4b;
    if (isNaN(sumaInd4b)) {
      sumaInd4b = 0;
    }
    /* ----------------------------------------------------------------------------- */
    /* ----------------------------------------------------------------------------- */
    var arrayJS5=<?php echo json_encode($data52020);?>;

    var denMeta5 = arrayJS5['ALTO HOSPICIO']['denominador'] +
                   arrayJS5['CAMIÑA']['denominador'] +
                   arrayJS5['COLCHANE']['denominador'] +
                   arrayJS5['HUARA']['denominador'] +
                   arrayJS5['IQUIQUE']['denominador'] +
                   arrayJS5['PICA']['denominador'] +
                   arrayJS5['POZO ALMONTE']['denominador'];

    var ahosInd5 = arrayJS5['ALTO HOSPICIO']['numerador'] / denMeta5 * 100;
    var camInd5 = arrayJS5['CAMIÑA']['numerador'] / denMeta5 * 100;
    var colInd5 = arrayJS5['COLCHANE']['numerador'] / denMeta5 * 100;
    var huaInd5 = arrayJS5['HUARA']['numerador'] / denMeta5 * 100;
    var iquInd5 = arrayJS5['IQUIQUE']['numerador'] / denMeta5 * 100;
    var picInd5 = arrayJS5['PICA']['numerador'] / denMeta5 * 100;
    var pozInd5 = arrayJS5['POZO ALMONTE']['numerador'] / denMeta5 * 100;

    var sumaInd5 = 0;
    sumaInd5 = ahosInd5 + camInd5 + colInd5 + huaInd5 + iquInd5 + picInd5 + pozInd5;
    if (isNaN(sumaInd5)) {
      sumaInd5 = 0;
    }
    /* ----------------------------------------------------------------------------- */
    /* ----------------------------------------------------------------------------- */
    var arrayJS6=<?php echo json_encode($data62020);?>;

    var denMeta6 = arrayJS6['ALTO HOSPICIO']['denominadores']['total'] +
                   arrayJS6['CAMIÑA']['denominadores']['total'] +
                   arrayJS6['COLCHANE']['denominadores']['total'] +
                   arrayJS6['HUARA']['denominadores']['total'] +
                   arrayJS6['IQUIQUE']['denominadores']['total'] +
                   arrayJS6['PICA']['denominadores']['total'] +
                   arrayJS6['POZO ALMONTE']['denominadores']['total'];

    var ahosInd6 = arrayJS6['ALTO HOSPICIO']['numeradores']['total'] / denMeta6 * 100;
    var camInd6 = arrayJS6['CAMIÑA']['numeradores']['total'] / denMeta6 * 100;
    var colInd6 = arrayJS6['COLCHANE']['numeradores']['total'] / denMeta6 * 100;
    var huaInd6 = arrayJS6['HUARA']['numeradores']['total'] / denMeta6 * 100;
    var iquInd6 = arrayJS6['IQUIQUE']['numeradores']['total'] / denMeta6 * 100;
    var picInd6 = arrayJS6['PICA']['numeradores']['total'] / denMeta6 * 100;
    var pozInd6 = arrayJS6['POZO ALMONTE']['numeradores']['total'] / denMeta6 * 100;

    var sumaInd6 = 0;
    sumaInd6 = ahosInd6 + camInd6 + colInd6 + huaInd6 + iquInd6 + picInd6 + pozInd6;
    if (isNaN(sumaInd6)) {
      sumaInd6 = 0;
    }
    /* ----------------------------------------------------------------------------- */

</script>

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
    chart.data = [{
      "indicador": "Ind 1\n"+ parseFloat(sumaInd1).toFixed(2) + "%",
      "ahos": ahosInd1,
      "cam": camInd1,
      "col": colInd1,
      "hua": huaInd1,
      "iqu": iquInd1,
      "pic": picInd1,
      "poz": pozInd1
    },{
      "indicador": "Ind 2\n"+ parseFloat(sumaInd2).toFixed(2) + "%",
      "ahos": ahosInd2,
      "cam": camInd2,
      "col": colInd2,
      "hua": huaInd2,
      "iqu": iquInd2,
      "pic": picInd2,
      "poz": pozInd2
    },{
      "indicador": "Ind 3a\n"+ parseFloat(sumaInd3a).toFixed(2) + "%",
      "ahos": ahosInd3a,
      "cam": camInd3a,
      "col": colInd3a,
      "hua": huaInd3a,
      "iqu": iquInd3a,
      "pic": picInd3a,
      "poz": pozInd3a
    },{
      "indicador": "Ind 3b\n"+ parseFloat(sumaInd3b).toFixed(2) + "%",
      "ahos": ahosInd3b,
      "cam": camInd3b,
      "col": colInd3b,
      "hua": huaInd3b,
      "iqu": iquInd3b,
      "pic": picInd3b,
      "poz": pozInd3b
    },{
      "indicador": "Ind 3c\n"+ parseFloat(sumaInd3c).toFixed(2) + "%",
      "ahos": ahosInd3c,
      "cam": camInd3c,
      "col": colInd3c,
      "hua": huaInd3c,
      "iqu": iquInd3c,
      "pic": picInd3c,
      "poz": pozInd3c
    },{
      "indicador": "Ind 4a\n"+ parseFloat(sumaInd4a).toFixed(2) + "%",
      "ahos": ahosInd4a,
      "cam": camInd4a,
      "col": colInd4a,
      "hua": huaInd4a,
      "iqu": iquInd4a,
      "pic": picInd4a,
      "poz": pozInd4a
    },{
      "indicador": "Ind 4b\n"+ parseFloat(sumaInd4b).toFixed(2) + "%",
      "ahos": ahosInd4b,
      "cam": camInd4b,
      "col": colInd4b,
      "hua": huaInd4b,
      "iqu": iquInd4b,
      "pic": picInd4b,
      "poz": pozInd4b
    },{
      "indicador": "Ind 5\n"+ parseFloat(sumaInd5).toFixed(2) + "%",
      "ahos": ahosInd5,
      "cam": camInd5,
      "col": colInd5,
      "hua": huaInd5,
      "iqu": iquInd5,
      "pic": picInd5,
      "poz": pozInd5
    },{
      "indicador": "Ind 6\n"+ parseFloat(sumaInd6).toFixed(2) + "%",
      "ahos": ahosInd6,
      "cam": camInd6,
      "col": colInd6,
      "hua": huaInd6,
      "iqu": iquInd6,
      "pic": picInd6,
      "poz": pozInd6
    }];

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

    createSeries("ahos", "Alto Hospicio");
    createSeries("cam", "Camiña");
    createSeries("col", "Colchane");
    createSeries("hua", "Huara");
    createSeries("iqu", "Iquique");
    createSeries("pic", "Pica");
    createSeries("poz", "Pozo Almonte");

    //Title
    let title = chart.titles.create();
    title.text = "Cobertura - 2020 - Servicio de Salud Iquique";
    title.fontSize = 15;
    title.marginBottom = 10;

    // Legend
    chart.legend = new am4charts.Legend();

    }); // end am4core.ready()
</script>

@endsection

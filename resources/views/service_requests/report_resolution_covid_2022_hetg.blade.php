<?php setlocale(LC_ALL, 'es'); ?>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>Resolucion</title>
  <meta name="description" content="">
  <meta name="author" content="Servicio de Salud Iquique">
  <style media="screen">
    body {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 0.75rem;
    }

    .content {
      margin: 0 auto;
      /*border: 1px solid #F2F2F2;*/
      width: 724px;
      /*height: 1100px;*/
    }

    .monospace {
      font-family: "Lucida Console", Monaco, monospace;
    }

    .pie_pagina {
      margin: 0 auto;
      /*border: 1px solid #F2F2F2;*/
      width: 724px;
      height: 26px;
      position: fixed;
      bottom: 0;
    }

    .seis {
      font-size: 0.6rem;
    }

    .siete {
      font-size: 0.7rem;
    }

    .ocho {
      font-size: 0.8rem;
    }

    .nueve {
      font-size: 0.9rem;
    }

    .plomo {
      background-color: F3F1F0;
    }

    .titulo {
      text-align: center;
      font-size: 1.2rem;
      font-weight: bold;
      padding: 4px 0 6px;
    }

    .center {
      text-align: center;
    }

    .left {
      text-align: left;
    }

    .right {
      text-align: right;
    }

    .justify {
      text-align: justify;
    }

    .indent {
      text-indent: 30px;
    }

    .uppercase {
      text-transform: uppercase;
    }

    #firmas {
      margin-top: 80px;
    }

    #firmas>div {
      display: inline-block;
    }

    .li_letras {
      list-style-type: lower-alpha;
    }

    table {
      border: 1px solid grey;
      border-collapse: collapse;
      padding: 0 4px 0 4px;
      width: 100%;
    }

    th,
    td {
      border: 1px solid grey;
      border-collapse: collapse;
      padding: 0 4px 0 4px;
    }

    .column {
      float: left;
      width: 50%;
    }

    /* Clear floats after the columns */
    .row:after {
      content: "";
      display: table;
      clear: both;
    }

    .page-break {
      page-break-after: always;
    }
  </style>
</head>

<body>
  <div class="content">

    <div class="content">
      <img style="padding-bottom: 4px;" src="images/logo_pluma.jpg" width="120" alt="Logo Servicio de Salud"><br>


      <div class="siete" style="padding-top: 3px;">
        HOSPITAL DR. ERNESTO TORRES GALDÁMEZ<br>

        SUBDIRECCIÓN DE GESTIÓN Y DESARROLLO DE LAS PERSONAS
      </div>
      <div class="seis" style="padding-top: 4px;">
        N.I.PHUQHAÑA. {{$ServiceRequest->id}} - {{\Carbon\Carbon::now()->format('d/m/Y')}} -
        @foreach($ServiceRequest->SignatureFlows as $SignatureFlow)
        {{$SignatureFlow->user->Initials}},
        @endforeach
      </div>


      <div class="right" style="float: right; width: 280px;">
        <div class="left" style="padding-bottom: 6px;">
          <strong>RESOLUCIÓN EXENTA N°: {{$ServiceRequest->resolution_number}}</strong>
        </div>
        <div class="left" style="padding-bottom: 2px;">
          <strong>IQUIQUE,</strong>
        </div>
      </div>


      <div style="clear: both; padding-bottom: 10px">&nbsp;</div>

      <p class="justify">
        <strong>VISTOS:</strong><br>

        @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
        @if($ServiceRequest->program_contract_type == "Mensual")
        En estos antecedentes, según lo dispuesto en el art. 11° del D.F.L. N° 29, de 2004 del Ministerio de Hacienda, que Fija el texto refundido, coordinado y sistematizado de la Ley N° 18.834, de 1989 sobre Estatuto Administrativo; art. 36° letra f) inciso 2, del D.F.L. N° 01, de 2005 del Ministerio de Salud, que Fija texto refundido, coordinado y sistematizado del Decreto Ley N° 2.763, de 1979 y de las Leyes N° 18.933 y N° 18.469; Art. 54° II letras a), b) y c) del Decreto Supremo N° 140, de 2004, que aprobó el Reglamento Orgánico de los Servicios de Salud; Ley N° 19.880 de Bases de Procedimiento Administrativo, Art. 23° letra f) del Decreto N° 38, de 2005 que Aprueba Reglamento Orgánico de los Establecimientos de Salud de Menor Complejidad y de los Establecimientos de Autogestión en Red todas del Ministerio de Salud;
        {{App\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->decree}},
        del Servicio de Salud Iquique, Gabinete Presidencial N° 02, de 2018 de la Presidencia de la República, Ley N° 21.395, de 2021 del Ministerio de Hacienda, que Aprueba Presupuesto del Sector Público año 2022; Resoluciones N° 18, de 2017 y N° 6, de 2019 ambas de la Contraloría General de la República.
        @elseif($ServiceRequest->program_contract_type == "Horas")
        @if($ServiceRequest->estate == "Profesional Médico")
        Dispuesto en el art. 11° del D.F.L. N° 29, de 2004 del Ministerio de Hacienda, que Fija el texto refundido, coordinado y sistematizado de la Ley N° 18.834, de 1989 sobre Estatuto Administrativo; art. 36° letra f) inciso 2, del D.F.L. N° 01, de 2005 del Ministerio de Salud, que Fija texto refundido, coordinado y sistematizado del Decreto Ley N° 2.763, de 1979 y de las Leyes N° 18.933 y N° 18.469; Art. 54° II letras a), b) y c) del Decreto Supremo N° 140, de 2004, que aprobó el Reglamento Orgánico de los Servicios de Salud; Ley N° 19.880 de Bases de Procedimiento Administrativo, Art. 23° letra f) del Decreto N° 38, de 2005 que Aprueba Reglamento Orgánico de los Establecimientos de Salud de Menor Complejidad y de los Establecimientos de Autogestión en Red todas del Ministerio de Salud;
        {{App\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->decree}},
        del Servicio de Salud Iquique, Gabinete Presidencial N° 02, de 2018 de la Presidencia de la República, Ley N° 21.289, de 2020 del Ministerio de Hacienda, que Aprueba Presupuesto del Sector Público año 2021; Resoluciones N° 18, de 2017 y N° 6, de 2019 ambas de la Contraloría General de la República;
        @else
        En estos antecedentes, según lo dispuesto en el art. 11° del D.F.L. N° 29, de 2004 del Ministerio de Hacienda, que Fija el texto refundido, coordinado y sistematizado de la Ley N° 18.834, de 1989 sobre Estatuto Administrativo; art. 36° letra f) inciso 2, del D.F.L. N° 01, de 2005 del Ministerio de Salud, que Fija texto refundido, coordinado y sistematizado del Decreto Ley N° 2.763, de 1979 y de las Leyes N° 18.933 y N° 18.469; Art. 54° II letras a), b) y c) del Decreto Supremo N° 140, de 2004, que aprobó el Reglamento Orgánico de los Servicios de Salud; Ley N° 19.880 de Bases de Procedimiento Administrativo, Art. 23° letra f) del Decreto N° 38, de 2005 que Aprueba Reglamento Orgánico de los Establecimientos de Salud de Menor Complejidad y de los Establecimientos de Autogestión en Red todas del Ministerio de Salud;
        {{App\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->decree}},
        del Servicio de Salud Iquique, Gabinete Presidencial N° 02, de 2018 de la Presidencia de la República, Ley N° 21.395, de 2021 del Ministerio de Hacienda, que Aprueba Presupuesto del Sector Público año 2022; Resoluciones N° 18, de 2017 y N° 6, de 2019 ambas de la Contraloría General de la República.
        @endif
        @endif
        @else
        dispuesto en el art. 11° del D.F.L. N° 29, de 2004 del Ministerio de Hacienda, que Fija el texto refundido, coordinado y sistematizado de la Ley N° 18.834, de 1989 sobre Estatuto Administrativo; art. 36° letra f) inciso 2, del D.F.L. N° 01, de 2005 del Ministerio de Salud, que Fija texto refundido, coordinado y sistematizado del Decreto Ley N° 2.763, de 1979 y de las Leyes N° 18.933 y N° 18.469; Art. 54° II letras a), b) y c) del Decreto Supremo N° 140, de 2004, que aprobó el Reglamento Orgánico de los Servicios de Salud; Ley N° 19.880 de Bases de Procedimiento Administrativo, Gabinete Presidencial N° 02, de 2018 de la Presidencia de la República, Ley N° 21.395, de 2021 del Ministerio de Hacienda, que Aprueba Presupuesto del Sector Público año 2022; Resoluciones N° 18, de 2017 y N° 6, de 2019 ambas de la Contraloría General de la República.

        las facultades que me confiere el {{App\Rrhh\Authority::getAuthorityFromDate(1,now(),['manager'])->decree}};
        @endif

      </p>

      <p class="justify">
        <strong>CONSIDERANDO:</strong><br>
      <ol>
        <li>Que, mediante Decreto N°52 de fecha 16 de diciembre de 2021 del Ministerio de Salud, prorroga vigencia del Decreto N° 4 de fecha 05 de enero de 2020 del Ministerio de Salud, que decreta alerta sanitaria por el período que se señala y otorga facultades extraordinarias que indica por emergencia de salud pública de importancia internacional (ESPII) por brote del nuevo coronavirus (2019-ncov) hasta el 31 de marzo del 2022
        </li>

        <li>Que, el Hospital “Dr. Ernesto Torres Galdames” de Iquique debido a la contingencia ha debido implementar diversas estrategias asociadas a la complejización e incremento de camas básicas a medias y de alta complejidad a modo de satisfacer y dar cobertura a las necesidades de la población, producto de la pandemia sanitaria.
        </li>

        <li>Que, el Hospital “Dr. Ernesto Torres Galdames” de Iquique, producto de esta contingencia ha debido mantener los servicios de personal para reforzar los equipos de salud, además de reforzando las unidades de apoyo que deben ponerse a disposición para enfrentar la pandemia.
        </li>

        <li>Que, mediante Memorándum C31/ N°55 de fecha 24 de diciembre de 2020, emitido por el Jefe de División de Gestión y Desarrollo de las Personas del Minsal, se envía instrucciones para la construcción de nómina gasto en honorarios Covid-19 año 2021, con la finalidad de gestionar los recursos financieros extraordinarios ante DIPRES, como también tener un control respecto de todas las contrataciones adicionales que deberán ser consideradas en el presupuesto 2021.
        </li>

        <li>Que, la Contraloría General de la República mediante el dictamen N°E173171 del 10 de enero 2022, “Imparte instrucciones respecto de las contrataciones a honorarios en los órganos de la administración del estado”.
        </li>

        <li>Que, en razón de lo dispuesto en el considerando anterior el presente convenio se ajusta a los convenios excluidos de dictamen ya citado que dice en relación con “convenios a honorarios convenidos con el personal el área de la salud, al fin de cubrir la recarga de las tareas provocadas por la pandemia de COVID-19”.
        </li>

        <li>
        Que, esta labor no puede cumplirse con los recursos humanos propios de la institución no por carecer de ellos, sino porque éstos tienen relación con labores accidentales y no habituales de la Institución, de tal forma de encuadrarse en el Art. 11 Ley N°18.834, sobre Estatuto Administrativo
        </li>

        <li>
        Que, por la índole del servicio que debe realizarse es más recomendable fijar un honorario consistente en una suma alzada.
        </li>

        <li>
        Que, el Hospital "Dr. Ernesto Torres Galdames", cuenta con las disponibilidades presupuestarias suficientes para solventar tal convenio.
        </li>

      </ol>

      </p>

      <p class="justify">
        <strong>RESUELVO:</strong><br><br>

        <strong>1. CONTRÁTESE </strong> a honorarios a suma alzada Covid 19 en el Hospital Ernesto Torres Galdames, a la persona que más abajo se individualiza de acuerdo a su área de competencia,
      </p>

      @if($ServiceRequest->program_contract_type == "Mensual")
      <table class="siete">
        <tr>
          <th>Nombre</th>
          <th>Run</th>
          <th>Función</th>
          <!-- <th>Jornada Laboral</th> -->
          <th>Desde</th>
          <th>Hasta</th>
          <th>Lugar de Trabajo</th>
          <th>Monto Total</th>
        </tr>
        <tr>
          <td style="text-align:center">{{$ServiceRequest->employee->getFullNameAttribute()}}</td>
          <td style="text-align:center">{{$ServiceRequest->employee->runFormat()}}</td>
          <td style="text-align:center">{{$ServiceRequest->profession->name}} - {{$ServiceRequest->working_day_type}}</td>
          <!-- <td style="text-align:center">{{$ServiceRequest->weekly_hours}}</td> -->
          <td style="text-align:center">{{$ServiceRequest->start_date->format('d/m/Y')}}</td>
          <td style="text-align:center">{{$ServiceRequest->end_date->format('d/m/Y')}}</td>
          <td style="text-align:center">{{$ServiceRequest->responsabilityCenter->name}}</td>
          <td style="text-align:center">${{number_format($ServiceRequest->gross_amount)}}</td>
        </tr>
      </table>
      @elseif($ServiceRequest->program_contract_type == "Horas")
      @if($ServiceRequest->estate == "Profesional Médico")
      <table class="siete">
        <tr>
          <th>Nombre</th>
          <th>Run</th>
          <th>Función</th>
          <th>Jornada Laboral</th>
          <th>Desde</th>
          <th>Hasta</th>
          <th>Lugar de Trabajo</th>
          <th>Valor por Hora</th>
        </tr>
        <tr>
          <td style="text-align:center">{{$ServiceRequest->employee->getFullNameAttribute()}}</td>
          <td style="text-align:center">{{$ServiceRequest->employee->runFormat()}}</td>
          <td style="text-align:center">{{$ServiceRequest->profession->name}} - {{$ServiceRequest->working_day_type}}</td>
          <td style="text-align:center">{{$ServiceRequest->working_day_type}}</td>
          <td style="text-align:center">{{$ServiceRequest->start_date->format('d/m/Y')}}</td>
          <td style="text-align:center">{{$ServiceRequest->end_date->format('d/m/Y')}}</td>
          <td style="text-align:center">{{$ServiceRequest->responsabilityCenter->name}}</td>
          <td style="text-align:center">${{number_format($ServiceRequest->gross_amount)}}</td>
        </tr>
      </table>
      @else
      <table class="siete">
        <tr>
          <th>Nombre</th>
          <th>Run</th>
          <th>Función</th>
          <th>Desde</th>
          <th>Hasta</th>
          <th>Lugar de Trabajo</th>
          <th>Monto Total</th>
        </tr>
        <tr>
          <td style="text-align:center">{{$ServiceRequest->employee->getFullNameAttribute()}}</td>
          <td style="text-align:center">{{$ServiceRequest->employee->runFormat()}}</td>
          <td style="text-align:center">{{$ServiceRequest->profession->name}} - {{$ServiceRequest->working_day_type}}</td>
          <td style="text-align:center">{{$ServiceRequest->start_date->format('d/m/Y')}}</td>
          <td style="text-align:center">{{$ServiceRequest->end_date->format('d/m/Y')}}</td>
          <td style="text-align:center">{{$ServiceRequest->responsabilityCenter->name}}</td>
          <td style="text-align:center">${{number_format($ServiceRequest->Fulfillments->first()->total_to_pay)}}</td>
        </tr>
      </table>
      @endif
      @endif

      @php
      $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
      $fecha = \Carbon\Carbon::parse($ServiceRequest->start_date);
      $mes = $meses[($fecha->format('n')) - 1];
      $inputs['Fecha'] = $fecha->format('d') . ' días del mes del ' . $mes . ' del ' . $fecha->format('Y');
      @endphp

      <p class="justify">
        En Iquique, a {{$inputs['Fecha']}}, comparece por una parte el <b>HOSPITAL ERNESTO TORRES GALDAMES</b>, persona jurídica de derecho público, RUT. 62.000.530-4 , con domicilio en calle Av.héroes de la concepcion N 502 de la ciudad de Iquique, representado por su {{App\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->position}}
        <b>{{App\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->user->FullNameUpper}}</b>,
        chileno, Cédula Nacional de Identidad N°{{App\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->user->runFormat()}}, del mismo domicilio del servicio público que representa, en
        adelante , "El Director del Hospital Ernesto Torres Galdames", y por la otra don <b>{{$ServiceRequest->employee->getFullNameAttribute()}}</b>@if($ServiceRequest->profession), {{$ServiceRequest->profession->name}}@endif, RUT:{{$ServiceRequest->employee->id}}-{{$ServiceRequest->employee->dv}}, chileno,
        con domicilio en {{$ServiceRequest->address}}, de la ciudad de Iquique, en adelante “El Profesional” y exponen lo siguiente:
      </p>


      <p class="justify">
        <strong>PRIMERO:</strong>
        Don {{App\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->user->FullNameUpper}}, en su calidad de {{App\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->position}} del Hospital “Dr. Ernesto Torres Galdames” de Iquique, contrata los servicios a honorarios a suma alzada de {{$ServiceRequest->employee->getFullNameAttribute()}}, ({{$ServiceRequest->profession->name}} - {{$ServiceRequest->working_day_type}}), para que preste servicios en el {{$ServiceRequest->responsabilityCenter->name}} al fin de cubrir la recarga de las tareas provocadas por la pandemia de COVID-19.
      </p>

      <p class="justify">
        <strong>SEGUNDO:</strong> En cumplimiento del presente convenio El prestador deberá llevar a cabo las siguientes prestaciones:
      <ul>
        <li>{!! nl2br(e($ServiceRequest->service_description)) !!}</li>
      </ul>
      </p>

      <p class="justify">
        <strong>TERCERO:</strong> El prestador recibirá los lineamientos por parte del Supervisor del {{$ServiceRequest->responsabilityCenter->name}}, del Hospital Regional de Iquique,el cual tendrá la responsabilidad de evaluar sus servicios en forma mensual.
        <br>
        {{$ServiceRequest->subt31}}
      </p>

      <p class="justify">
        <strong>CUARTO:</strong> El prestador de Servicios contratante a través de la declaración jurada señaló no estar afecto a ninguna de las inhabilidades establecidas en los arts. 54, 55 y 56 de la Ley Nº 18.575, Orgánica Constitucional de las Bases Generales de la Administración del Estado. Dichas disposiciones relativas a inhabilidades e incompatibilidades administrativas serán aplicables al prestador, con quién se suscribe el presente convenio a Honorarios a Suma Alzada.
      </p>

      <p class="justify">
        <strong>QUINTO:</strong> El presente convenio empezará a regir, a contar del {{$ServiceRequest->start_date->day}} de {{$ServiceRequest->start_date->monthName}} del {{$ServiceRequest->start_date->year}} al {{$ServiceRequest->end_date->day}} de {{$ServiceRequest->end_date->monthName}} del {{$ServiceRequest->end_date->year}}, de acuerdo al artículo 52 de la Ley 19.880, sobre Bases de Procedimientos Administrativos.
      </p>

      <p class="justify">
        <strong>SEXTO:</strong>
        El Hospital “Dr. Ernesto Torres Galdames” de Iquique podrá poner término anticipadamente a este convenio sin expresión de causa, previo aviso por escrito al prestador con a lo menos 48 horas de anticipación.
      </p>

      @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
      @if($ServiceRequest->program_contract_type == "Mensual")
      <p class="justify">
        <strong>SÉPTIMO:</strong>
        En este caso, el Hospital “Dr. Ernesto Torres Galdames”, pagará a la persona en referencia sólo hasta el porcentaje de la mensualidad correspondiente al período efectivamente prestado.
      </p>
      @elseif($ServiceRequest->program_contract_type == "Horas")
      @if($ServiceRequest->estate == "Profesional Médico")
      <p class="justify">
        <strong>SÉPTIMO:</strong>
        En este caso, el Hospital “Dr. Ernesto Torres Galdames”, pagará a la persona en referencia sólo hasta el porcentaje de la mensualidad correspondiente al período efectivamente prestado.
      </p>
      @else
      @if($ServiceRequest->working_day_type == "TURNO EXTRA")
      <p class="justify">
        <strong>SÉPTIMO:</strong>
        En el desempeño de sus funciones, el prestador cumplió con un total de {{number_format($ServiceRequest->Fulfillments->first()->total_hours_to_pay)}} Horas en turno extras en el mes de {{$ServiceRequest->start_date->monthName}}, cuya suma alzada totas es de ${{number_format($ServiceRequest->Fulfillments->first()->total_to_pay)}}.- ({{$ServiceRequest->fulfillments->first()->total_to_pay_description}}) impuesto incluido, en conformidad a lo dispuesto en el inciso segundo del Art. 2º del Decreto Nº 98 de 1991 del Ministerio de Hacienda y se cancelará en una cuota de ${{number_format($ServiceRequest->Fulfillments->first()->total_to_pay)}} el mes de {{$ServiceRequest->start_date->monthName}}; se deberá acreditar contra presentación de certificado extendido por el Jefe del {{$ServiceRequest->responsabilityCenter->name}}, dependiente del
        @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
        Hospital Regional de Iquique,
        @else
        Servicio de Salud Iquique,
        @endif
        en que conste el cumplimiento de las labores estipuladas en el convenio. El pago será efectuado el día
        @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
        10
        @else
        5
        @endif
        del mes siguiente, y si este cae en día inhábil, se efectuará el día hábil más cercano una vez que el establecimiento dé su conformidad a la prestación realizada y previa presentación de la boleta de honorario respectiva. El Hospital retendrá y pagará el impuesto correspondiente por los honorarios pactados. Asimismo, el prestador deberá entregar dentro de los primeros 5 días del mes siguiente el certificado de servicios prestados realizados, a la Subdirección de Gestión y Desarrollo de las Personas
        del Hospital Dr. Ernesto Torres Galdames de Iquique,
        el cual debe venir con las debidas observaciones de la Jefatura directa.
      </p>
      @elseif($ServiceRequest->working_day_type == "HORA EXTRA")
      <p class="justify">
        <strong>SÉPTIMO:</strong>
        En el desempeño de sus funciones, el prestador cumplió con un total de {{number_format($ServiceRequest->Fulfillments->first()->total_hours_to_pay)}} Horas por extensión horaria en el mes de {{$ServiceRequest->start_date->monthName}}, cuya suma alzada totas es de ${{number_format($ServiceRequest->Fulfillments->first()->total_to_pay)}}.- ({{$ServiceRequest->fulfillments->first()->total_to_pay_description}}) impuesto incluido, en conformidad a lo dispuesto en el inciso segundo del Art. 2º del Decreto Nº 98 de 1991 del Ministerio de Hacienda y se cancelará en una cuota de ${{number_format($ServiceRequest->Fulfillments->first()->total_to_pay)}} el mes de {{$ServiceRequest->start_date->monthName}}; se deberá acreditar contra presentación de certificado extendido por el Jefe del {{$ServiceRequest->responsabilityCenter->name}}, dependiente del
        Hospital Regional de Iquique,

        en que conste el cumplimiento de las labores estipuladas en el convenio. El pago será efectuado el día
        @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
        10
        @else
        5
        @endif
        del mes siguiente, y si este cae en día inhábil, se efectuará el día hábil más cercano una vez que el establecimiento dé su conformidad a la prestación realizada y previa presentación de la boleta de honorario respectiva. El Hospital retendrá y pagará el impuesto correspondiente por los honorarios pactados. Asimismo, el prestador deberá entregar dentro de los primeros 5 días del mes siguiente el certificado de servicios prestados realizados, a la Subdirección de Gestión y Desarrollo de las Personas del Hospital Dr. Ernesto Torres Galdames de Iquique, el cual debe venir con las debidas observaciones de la Jefatura directa.
      </p>
      @endif
      @endif
      @endif
      @else
      @if($ServiceRequest->program_contract_type == "Mensual")
      <p class="justify">
        <strong>SÉPTIMO:</strong>
        El Servicio de Salud Iquique, cancelará a la persona en referencia sólo hasta la mensualidad correspondiente al período efectivamente prestado.
      </p>
      @elseif($ServiceRequest->program_contract_type == "Horas")
      <p class="justify">
        <strong>SÉPTIMO:</strong>
        El Servicio de Salud Iquique, cancelará a la persona en referencia sólo hasta la mensualidad correspondiente al período efectivamente prestado.
      </p>
      @else
      <strong>SÉPTIMO:</strong>
      En el desempeño de sus funciones, el prestador cumplió con un total de {{number_format($ServiceRequest->Fulfillments->first()->total_hours_to_pay)}} Horas en turno extras en el mes de {{$ServiceRequest->start_date->monthName}}, cuya suma alzada totas es de ${{number_format($ServiceRequest->Fulfillments->first()->total_to_pay)}}.- ({{$ServiceRequest->fulfillments->first()->total_to_pay_description}}) impuesto incluido, en conformidad a lo dispuesto en el inciso segundo del Art. 2º del Decreto Nº 98 de 1991 del Ministerio de Hacienda y se cancelará en una cuota de ${{number_format($ServiceRequest->Fulfillments->first()->total_to_pay)}} el mes de {{$ServiceRequest->start_date->monthName}}; se deberá acreditar contra presentación de certificado extendido por el Jefe del {{$ServiceRequest->responsabilityCenter->name}}, dependiente del
      @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
      Hospital Regional de Iquique,
      @else
      Servicio de Salud Iquique,
      @endif
      en que conste el cumplimiento de las labores estipuladas en el convenio. El pago será efectuado el día
      @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
      10
      @else
      5
      @endif
      del mes siguiente, y si este cae en día inhábil, se efectuará el día hábil más cercano una vez que el establecimiento dé su conformidad a la prestación realizada y previa presentación de la boleta de honorario respectiva. El Hospital retendrá y pagará el impuesto correspondiente por los honorarios pactados. Asimismo, el prestador deberá entregar dentro de los primeros 5 días del mes siguiente el certificado de servicios prestados realizados, a la Subdirección de Gestión y Desarrollo de las Personas
      del Hospital Dr. Ernesto Torres Galdames de Iquique,
      el cual debe venir con las debidas observaciones de la Jefatura directa.
      @endif
      @endif



      @if($ServiceRequest->program_contract_type == "Mensual")
      <p class="justify">
        <strong>OCTAVO:</strong> La presente contratación se efectuará sobre la base de honorarios, por una suma alzada de ${{number_format($ServiceRequest->gross_amount)}}.- ({{$ServiceRequest->gross_amount_description}}), impuesto incluido, en conformidad a lo dispuesto en el inciso segundo del Art. 2º del Decreto Nº 98 de 1991 del Ministerio de Hacienda y se cancelará en
        <!-- TODO para salir del caso excepcional de gramático  se debe cambiar-->
        @livewire('service-request.monthly-quotes', ['serviceRequest' => $ServiceRequest])
        se deberá acreditar contra presentación de certificado extendido por el Supervisor
        Jefe del {{$ServiceRequest->responsabilityCenter->name}}, dependiente del
        Hospital Regional de Iquique, en que conste el cumplimiento de las labores estipuladas en el convenio, el cual debe ser creado en el sistema interno Phuqhaña. El pago será efectuado dentro de los primeros 10 días del mes siguiente, y si este cae en día inhábil, se efectuará el día hábil más cercano una vez que el establecimiento dé su conformidad a la prestación realizada y previa presentación de la boleta de honorario respectiva. El Servicio retendrá y pagará el impuesto correspondiente por los honorarios pactados.
        <br>

      </p>
      @elseif($ServiceRequest->program_contract_type == "Horas")
      @if($ServiceRequest->estate == "Profesional Médico")
      <p class="justify">
        <strong>OCTAVO:</strong> El “valor por hora” será por la suma de ${{number_format($ServiceRequest->gross_amount)}}.- ({{$ServiceRequest->gross_amount_description}}), para efectos del pago, cada final de mes el
        @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
        Supervisor
        @else
        Jefe
        @endif del {{$ServiceRequest->responsabilityCenter->name}} o por la jefatura inmediatamente superior, deberá certificar las horas realizadas por el profesional médico de manera presencial (no es aceptable la suplantación de personas). Debiendo, además, adjuntar el registro de asistencia efectuado en el respectivo servicio, los cuales serán indispensables para su cancelación, sin perjuicio de las funciones de control de la Subdirección de Gestión y Desarrollo de las Personas del Hospital de Iquique,
        <br><br>
        El pago será efectuado el día
        @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
        10
        @else
        5
        @endif
        del mes siguiente, y si este cae en día inhábil, se efectuará el día hábil más cercano una vez que el establecimiento dé su conformidad a la prestación realizada y previa presentación de la boleta de honorario respectiva. El Servicio retendrá y pagará el impuesto correspondiente por los honorarios pactados.
        <br><br>
        Asimismo, el prestador deberá entregar dentro de los primeros 5 días del mes siguiente el certificado de servicios prestados realizados, a la Unidad de Honorarios Covid del
        @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
        Hospital Dr. Ernesto Torres Galdames de Iquique,
        @else
        Servicio de salud Iquique,
        @endif
        el cual debe venir con las debidas observaciones de la Jefatura directa.
        <br>
      </p>
      @else
      <p class="justify">
        <strong>OCTAVO:</strong> El prestador deberá cumplir las prestaciones de servicios pactadas entre las partes en el presente convenio, y se deberá acreditar su porcentaje de cumplimiento conforme al verificador establecido, contra presentación de certificado extendido por la jefatura del área donde presta servicios.
      </p>
      @endif
      @endif

      @if($ServiceRequest->program_contract_type == "Horas" && $ServiceRequest->responsability_center_ou_id == 138 && $ServiceRequest->working_day_type == "TURNO EXTRA" &&
      (($ServiceRequest->start_date >= '2021/11/01 00:00') && ($ServiceRequest->start_date <= '2021/12/31 23:59:59' ))) <p class="justify">
        El valor a pagar por hora es por las “Condiciones Especiales en que están desarrollando el trabajo en la unidad de Emergencia”.
        </p>
        @endif

        @if($ServiceRequest->program_contract_type == "Mensual")
        <p class="justify">
          <strong>NOVENO:</strong> El prestador deberá cumplir las prestaciones de servicios pactadas entre las partes en el presente convenio, y se deberá acreditar su porcentaje de cumplimiento conforme al verificador establecido, contra presentación de certificado extendido por la jefatura del área donde presta servicios.
        </p>
        @elseif($ServiceRequest->program_contract_type == "Horas")
        @if($ServiceRequest->estate == "Profesional Médico")
        <p class="justify">
          <strong>NOVENO:</strong> El prestador deberá cumplir las prestaciones de servicios pactadas entre las partes en el presente convenio, y se deberá acreditar su porcentaje de cumplimiento conforme al verificador establecido, contra presentación de certificado extendido por la jefatura del área donde presta servicios.
        </p>
        @else
        <p class="justify">
          <strong>NOVENO:</strong> Se deja establecido que, el horario en el cual debe realizar sus servicios el prestador, se indica con el fin de verificar la realización de éstos, sin que altere la naturaleza jurídica del convenio, en virtud del Dictamen N°26.092/2017 de la C.G.R., los atrasos superiores a una hora, serán descontados de la cuota mensual correspondiente, como también los días de inasistencia, los cuales deberán quedar informados en el respectivo informe de prestaciones mensual. Los reiterados atrasos e inasistencias deberán ser amonestados.
        </p>
        @endif
        @endif

        @if($ServiceRequest->program_contract_type == "Mensual")
        <p class="justify">
          <strong>DÉCIMO:</strong> El prestador cumplirá una jornada

          @switch($ServiceRequest->working_day_type)
          @case('DIURNO')
          <!-- DIURNA de lunes a viernes de 08:00 a 16:48 hrs. -->
          {{$ServiceRequest->schedule_detail}}.
          @break
          @case('TERCER TURNO')
          de turnos rotativos, en TERCER TURNO, 2 largo de 08:00 a 20:00 hrs, 2 noche de 20:00 a 08:00 hrs y 2 días libres.
          @break
          @case('TERCER TURNO - MODIFICADO')
          de turnos rotativos, en TERCER TURNO, modificado por necesidades del servicio.
          @break
          @case('CUARTO TURNO')
          de turnos rotativos, en CUARTO TURNO, 1 largo de 08:00 a 20:00 hrs, 1 noche de 20:00 a 08:00 hrs y 2 días libres.
          @break
          @case('CUARTO TURNO - MODIFICADO')
          de turnos rotativos, en CUARTO TURNO, modificado por necesidades del servicio.
          @break
          @endswitch

          @if($ServiceRequest->working_day_type_other)
          {{$ServiceRequest->working_day_type_other}}<br>
          @endif

          Se deja establecido que, el horario en el cual debe realizar sus servicios el prestador, se indica con el fin de verificar la realización de éstos, sin que altere la naturaleza jurídica del convenio, en virtud del Dictamen N°26.092/2017 de la C.G.R., si durante una jornada de trabajo existiese un cambio de hora, se pagarán las horas efectivamente trabajadas. Los atrasos superiores a una hora, serán descontados de la cuota mensual correspondiente, como también los días de inasistencia, los cuales deberán quedar informados en el respectivo informe de prestaciones mensual. Los reiterados atrasos e inasistencias deberán ser amonestados.
        </p>
        @elseif($ServiceRequest->program_contract_type == "Horas")
        @if($ServiceRequest->estate == "Profesional Médico")
        <p class="justify">
          <strong>DÉCIMO:</strong> Se deja establecido que, el horario en el cual debe realizar sus servicios el prestador,
          se indican con el fin de verificar la realización de éstos, sin que se altere la naturaleza jurídica del convenio,
          en virtud del Dictamen N°26.092/2017 de la C.G.R.,
          si durante una jornada de trabajo existiese un cambio de hora, se pagarán las horas efectivamente trabajadas.
          Los atrasos superiores a una hora, serán descontados de sus horas realizadas.
        </p>
        @else
        <p class="justify">
          <strong>DÉCIMO:</strong> Déjese establecido que el incumplimiento de los términos del presente convenio implica la caducidad inmediata de éste.
        </p>
        @endif
        @endif

        @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
        @if($ServiceRequest->program_contract_type == "Mensual")
        <p class="justify">
          <strong>DÉCIMO PRIMERO:</strong> Déjese establecido que el incumplimiento de los términos del presente convenio implica la caducidad inmediata de éste.
        </p>
        @elseif($ServiceRequest->program_contract_type == "Horas")
        @if($ServiceRequest->estate == "Profesional Médico")
        <p class="justify">
          <strong>DÉCIMO PRIMERO:</strong> Déjese establecido que el incumplimiento de los términos del presente convenio implica la caducidad inmediata de éste.
        </p>
        @else
        <p class="justify">
          <strong>DÉCIMO PRIMERO:</strong> La personería de D.{{App\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->user->FullNameUpper}} , para representar al Hospital “Dr. E. Torres G.” de Iquique, en su calidad de {{App\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->position}}, consta en
          {{App\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->decree}},
          del Servicio de Salud Iquique.
        </p>
        @endif
        @endif
        @else
        @if($ServiceRequest->program_contract_type == "Mensual")
        <p class="justify">
          <strong>DÉCIMO PRIMERO:</strong> Déjese establecido que el incumplimiento de los términos del presente convenio implica la caducidad inmediata de éste.
        </p>
        @elseif($ServiceRequest->program_contract_type == "Horas")
        <p class="justify">
          <strong>DÉCIMO PRIMERO:</strong> La personería de D. {{App\Rrhh\Authority::getAuthorityFromDate(1,now(),['manager'])->user->FullNameUpper}} , para representar al Servicio Salud Iquique, en su calidad de {{App\Rrhh\Authority::getAuthorityFromDate(1,now(),['manager'])->position}}, consta en
          {{App\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->decree}},
          del Servicio de Salud Iquique.
        </p>
        @endif
        @endif


        <p class="justify">
          <strong>DÉCIMO SEGUNDO:</strong>
          Déjese establecido que el trabajador le será aplicable el procedimiento establecido en el “Manual de Procedimientos de Denuncia, Prevención y Sanción del Maltrato, Acoso Laboral y/o Sexual y Discriminación, conforme resolución vigente en el Servicio de Salud Iquique N°4294 del 10 de octubre del 2019.
        </p>



        @if($ServiceRequest->program_contract_type == "Mensual")
        <p class="justify">
          <strong>DÉCIMO TERCERO:</strong> Déjese establecido que el prestador tendrá derecho a presentar licencias médicas,
          la cual sólo justificará los días de inasistencia, no procediendo el pago de éstos y siendo responsabilidad del prestador del servicio, la tramitación de la licencia médica ante el organismo que corresponda; además deberá dejar copia de licencia médica en la Subdirección de Gestión y Desarrollo de las Personas. Las ausencias por esta causa serán descontadas de la cuota mensual.
          <br><br>
          A contar del 01 de enero del 2019 el personal a honorarios estará obligado a imponer, tanto en salud como en AFP, de manera personal, como lo indica la Ley N°20.894, por lo tanto, deberá realizar el cobro del subsidio de salud directamente en la institución correspondiente, ya sea Fonasa o Isapre.

          Las mujeres podrán solicitar permiso post-natal parental, los cuales sólo justificará los días de inasistencia, no procediendo el pago por los días mientras dure el permiso; el beneficio es sólo para la persona definida en el convenio e intransferible
        </p>
        @endif


        <p class="justify">
          <strong>DECIMO CUARTO:</strong> El prestador (a) individualizado (a) en la presente resolución tendrá los siguientes beneficios adicionales:<br><br>

          <ins>Feriado Legal:</ins><br>
          Derecho a días de descanso, correspondiente a 20 días hábiles, después de un año de prestación de servicio continúo en calidad de honorario, sin opción de acumulación, previa autorización de la jefatura de la unidad que se desempeña.<br><br>

          
          <ins>Permiso Administrativo (Solo para convenios por 3 meses):</ins><br>
          Permisos para ausentarse de sus labores por motivos particulares por un día hábil durante el periodo del presente convenio, con goce de prestación. Dicho permiso podrá fraccionarse por 1 día o 2 medio día y serán resueltos por la Coordinadora del área correspondiente.<br> <br>


          {!! nl2br($ServiceRequest->additional_benefits) !!}
        </p>

        <p class="justify">
          <strong>DECIMO QUINTO:</strong>
          El prestador tiene la obligación de adherirse a una mutualidad a objeto de estar cubierto por la ley 16.744, sobre accidentes y enfermedades profesionales.
          El prestador deberá entregar en la unidad de honorarios covid y en un plazo no superior a 30 días de la fecha de inicio del convenio el certificado de adhesión a una mutualidad.
        </p>


        @if($ServiceRequest->signature_page_break)
        <div class="page-break"></div>
        @endif

        

        Para constancia firman: <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        {{$ServiceRequest->employee->getFullNameAttribute()}} 
        <br><br>

        <p class="">
          <strong>2.</strong> El convenio que por este acto se aprueban, se entiende que forman parte integrante de la presente Resolución.
        </p>

        @if($ServiceRequest->program_contract_type == "Mensual")
        <p class="">

          <strong>3.</strong> IMPÚTESE el gasto correspondiente al ítem 21-03-001-001-02 Honorario Suma Alzada Personal
          @if($ServiceRequest->estate == "Profesional Médico")
          Médico,
          @else
          No Médico,
          @endif
          del presupuesto del
          @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
          Hospital “Dr. Ernesto Torres Galdames” de Iquique.
          @else
          Servicio Salud Iquique.
          @endif
        </p>
        @elseif($ServiceRequest->program_contract_type == "Horas")
        @if($ServiceRequest->estate == "Profesional Médico")
        <p class="">
          <strong>3.</strong> IMPÚTESE el gasto correspondiente al ítem 21-03-001-001-03 Honorario Suma Alzada Personal Médico del presupuesto del
          @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
          Hospital “Dr. Ernesto Torres Galdames” de Iquique.
          @else
          Servicio Salud Iquique.
          @endif
        </p>
        @else
        <p class="">
          <strong>3.</strong> IMPÚTESE el gasto correspondiente al ítem 21-03-001-001-02 Honorario Suma Alzada Personal No Médico, del presupuesto del
          @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
          Hospital “Dr. Ernesto Torres Galdames” de Iquique.
          @else
          Servicio Salud Iquique.
          @endif
        </p>
        @endif
        @endif

        <p class="center">
          <strong>
            ANÓTESE, COMUNÍQUESE Y REMÍTASE ESTA RESOLUCIÓN CON LOS ANTECEDENTES QUE CORRESPONDAN A LA CONTRALORÍA REGIONAL DE TARAPACÁ PARA SU REGISTRO Y CONTROL POSTERIOR.
          </strong>
        </p>

        <div id="firmas">
          <div class="center" style="width: 100%;">

            @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
            <strong>
              <span class="uppercase">
                {{App\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->user->FullNameUpper}}
              </span>
              <br>
              <span style="text-transform:uppercase">{{App\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->position}}</span>
              <br>
              HOSPITAL DR ERNESTO TORRES GALDÁMEZ<br>
            </strong>

            <br style="padding-bottom: 4px;">
            Lo que me permito transcribe a usted para su conocimiento y fines consiguientes.

            <br><br><br><br><br><br><br><br><br>
            <br style="padding-bottom: 4px;">
            MINISTRO DE FE
            @else
            <!-- <strong>
          <span class="uppercase">JORGE GALLEGUILLOS MOLLER</span><br>
          DIRECTOR<br>
          SERVICIO DE SALUD IQUIQUE<br>
          </strong>

          <br style="padding-bottom: 4px;">
          Lo que me permito transcribe a usted para su conocimiento y fines consiguientes.

          <br><br><br>
          <br style="padding-bottom: 4px;">
          MINISTRO DE FE-->
            @endif
          </div>
        </div>
        <br style="padding-bottom: 4px;">
        @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
        <div class="siete" style="padding-top: 2px;">
          <strong><u>DISTRIBUCIÓN:</u></strong><br>

          Honorarios Covid<br>
          Oficina de partes<br>
          {{--
    @else

      @if($ServiceRequest->responsabilityCenter->establishment_id == 12)
        CGU (roxana.penaranda@redsalud.gov.cl, anakena.bravo@redsalud.gov.cl)<br>
        Finanzas (patricia.salinasm@redsalud.gov.cl, finanzas.ssi@redsalud.gov.cl)<br>
        Interesado<br>
        Oficina de Partes<br>
      @else
        Personal SSI (vania.ardiles@redsalud.gov.cl, rosa.contreras@redsalud.gov.cl, isis.gallardo@redsalud.gov.cl)<br>
        Finanzas (patricia.salinasm@redsalud.gov.cl, finanzas.ssi@redsalud.gov.cl)<br>
        Interesado<br>
        Oficina de Partes<br>

      @endif
      --}}

        </div>
        @endif


    </div>
</body>

</html>
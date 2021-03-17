<?php setlocale(LC_ALL, 'es_CL.UTF-8');?>
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
            margin-top: 100px;
        }

        #firmas > div {
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
        th, td {
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

        @media all {
            .page-break { display: none; }
        }

        @media print {
            .page-break { display: block; page-break-before: always; }
        }

        </style>
    </head>
    <body>
        <div class="content">

                <div class="content">
                    <img style="padding-bottom: 4px;" src="images/logo_pluma.jpg"
                        width="120" alt="Logo Servicio de Salud"><br>


<div class="siete" style="padding-top: 3px;">
    HOSPITAL DR. ERNESTO TORRES GALDÁMEZ<br>
    SUBDIRECCIÓN DE GESTIÓN Y DESARROLLO DE LAS PERSONAS
</div>
<div class="seis" style="padding-top: 4px;">
    N.I. {{$ServiceRequest->id}} - {{\Carbon\Carbon::now()->format('d/m/Y')}}
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

@if($ServiceRequest->program_contract_type == "Mensual")
  En estos antecedentes, según lo dispuesto en el art. 11° del D.F.L. N° 29, de 2004 del Ministerio de Hacienda, que Fija el texto refundido, coordinado y sistematizado de la Ley N° 18.834, de 1989 sobre Estatuto Administrativo; art. 36° letra f) inciso 2, del D.F.L. N° 01, de 2005 del Ministerio de Salud, que Fija texto refundido, coordinado y sistematizado del Decreto Ley N° 2.763, de 1979 y de las Leyes N° 18.933 y N° 18.469; Art. 54° II letras a), b) y c) del Decreto Supremo N° 140, de 2004, que aprobó el Reglamento Orgánico de los Servicios de Salud; Ley N° 19.880 de Bases de Procedimiento Administrativo, Art. 23° letra f) del Decreto N° 38, de 2005 que Aprueba Reglamento Orgánico de los Establecimientos de Salud de Menor Complejidad y de los Establecimientos de Autogestión en Red todas del Ministerio de Salud; Resolución Exenta RA N° 425/300/2020, de fecha 30 de noviembre del 2020  del Servicio de Salud Iquique, Gabinete Presidencial N° 02, de 2018 de la Presidencia de la República, Ley N° 21.289, de 2020 del Ministerio de Hacienda, que Aprueba Presupuesto del Sector Público año 2021; Resoluciones  N° 18, de 2017 y N° 6, de 2019 ambas de la Contraloría General de la República;
@elseif($ServiceRequest->program_contract_type == "Horas")
  @if($ServiceRequest->estate == "Profesional Médico")
    Dispuesto en el art. 11° del D.F.L. N° 29, de 2004 del Ministerio de Hacienda, que Fija el texto refundido, coordinado y sistematizado de la Ley N° 18.834, de 1989 sobre Estatuto Administrativo; art. 36° letra f) inciso 2, del D.F.L. N° 01, de 2005 del Ministerio de Salud, que Fija texto refundido, coordinado y sistematizado del Decreto Ley N° 2.763, de 1979 y de las Leyes N° 18.933 y N° 18.469; Art. 54° II letras a), b) y c) del Decreto Supremo N° 140, de 2004, que aprobó el Reglamento Orgánico de los Servicios de Salud; Ley N° 19.880 de Bases de Procedimiento Administrativo, Art. 23° letra f) del Decreto N° 38, de 2005 que Aprueba Reglamento Orgánico de los Establecimientos de Salud de Menor Complejidad y de los Establecimientos de Autogestión en Red todas del Ministerio de Salud; Resolución Exenta RA N° 425/300/2020, de fecha 30 de noviembre del 2020  del Servicio de Salud Iquique, Gabinete Presidencial N° 02, de 2018 de la Presidencia de la República, Ley N° 21.289, de 2020 del Ministerio de Hacienda, que Aprueba Presupuesto del Sector Público año 2021; Resoluciones  N° 18, de 2017 y N° 6, de 2019 ambas de la Contraloría General de la República;
  @else
    En estos antecedentes, según lo dispuesto en el art. 11° del D.F.L. N° 29, de 2004 del Ministerio de Hacienda, que Fija el texto refundido, coordinado y sistematizado de la Ley N° 18.834, de 1989 sobre Estatuto Administrativo; art. 36° letra f) inciso 2, del D.F.L. N° 01, de 2005 del Ministerio de Salud, que Fija texto refundido, coordinado y sistematizado del Decreto Ley N° 2.763, de 1979 y de las Leyes N° 18.933 y N° 18.469; Art. 54° II letras a), b) y c) del Decreto Supremo N° 140, de 2004, que aprobó el Reglamento Orgánico de los Servicios de Salud; Ley N° 19.880 de Bases de Procedimiento Administrativo, Art. 23° letra f) del Decreto N° 38, de 2005 que Aprueba Reglamento Orgánico de los Establecimientos de Salud de Menor Complejidad y de los Establecimientos de Autogestión en Red todas del Ministerio de Salud; Resolución Exenta RA N° 425/300/2020, de fecha 30 de noviembre del 2020 del Servicio de Salud Iquique, Gabinete Presidencial N° 02, de 2018 de la Presidencia de la República, Ley N° 21.289, de 2020 del Ministerio de Hacienda, que Aprueba Presupuesto del Sector Público año 2021; Resoluciones N° 18, de 2017 y N° 6, de 2019 ambas de la Contraloría General de la República;
  @endif
@endif
</p>

<p class="justify">
<strong>CONSIDERANDO:</strong><br>
Que, mediante Decreto N°1 de fecha 07 de enero de 2021 prorroga vigencia del Decreto N° 4 de fecha 05 de enero de 2020, del Ministerio de Salud, se decreta alerta sanitaria por el período que se señala y otorga facultades extraordinarias que indica por emergencia de salud pública de importancia internacional (ESPII) por brote del nuevo coronavirus (2019-ncov).
Que, el Hospital “Dr. Ernesto Torres Galdames” de Iquique debido a la contingencia ha debido implementar diversas estrategias asociadas a la complejización e incremento de camas básicas a medias y de alta complejidad a modo de satisfacer y dar cobertura a las necesidades de la población, producto de la pandemia sanitaria.
Que, el Hospital “Dr. Ernesto Torres Galdames” de Iquique, producto de esta contingencia ha debido mantener los servicios de personal para reforzar los equipos de salud, quienes apoyaran la implementación de estrategias definidas por el nivel central en las líneas de detección y tratamiento de la enfermedad, además de reforzar las unidades de apoyo que deben ponerse a disposición para enfrentar la pandemia.
Que, mediante Memorándum C31/ N°55 de fecha 24 de diciembre de 2020, emitido por el Jefe de División de Gestión y Desarrollo de las Personas del Minsal, se envía instrucciones para la construcción de nómina gasto en honorarios Covid-19 año 2021, con la finalidad de gestionar los recursos financieros extraordinarios ante DIPRES, como también tener un control respecto de todas las contrataciones adicionales que deberán ser consideradas en el presupuesto 2021.
</p>

<p class="justify">
<strong>RESUELVO:</strong><br><br>

<strong>1.</strong> APRUÉBESE <strong>Convenio a Honorario a Suma Alzada</strong> en el Hospital Dr. “Ernesto Torres Galdames” de Iquique, a la persona que más abajo se individualiza, para apoyar de acuerdo de funciones, de acuerdo con su área de competencia, en el período que se señala.

</p>

@if($ServiceRequest->program_contract_type == "Mensual")
  <table class="siete">
      <tr>
          <th>Nombre</th>
          <th>Run</th>
          <th>Función</th>
          <th>Jornada Laboral</th>
          <th>Desde</th>
          <th>Hasta</th>
          <th>Lugar de Trabajo</th>
          <th>Monto Total</th>
      </tr>
      <tr>
          <td style="text-align:center">{{$ServiceRequest->name}}</td>
          <td style="text-align:center">{{$ServiceRequest->run_s_dv}}-{{$ServiceRequest->dv}}</td>
          <td style="text-align:center">{{$ServiceRequest->estate}} ({{$ServiceRequest->rrhh_team}})</td>
          <td style="text-align:center">{{$ServiceRequest->weekly_hours}}</td>
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
            <td style="text-align:center">{{$ServiceRequest->name}}</td>
            <td style="text-align:center">{{$ServiceRequest->run_s_dv}}-{{$ServiceRequest->dv}}</td>
            <td style="text-align:center">{{$ServiceRequest->estate}} ({{$ServiceRequest->rrhh_team}})</td>
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
            <td style="text-align:center">{{$ServiceRequest->name}}</td>
            <td style="text-align:center">{{$ServiceRequest->run_s_dv}}-{{$ServiceRequest->dv}}</td>
            <td style="text-align:center">{{$ServiceRequest->estate}} ({{$ServiceRequest->rrhh_team}})</td>
            <td style="text-align:center">{{$ServiceRequest->start_date->format('d/m/Y')}}</td>
            <td style="text-align:center">{{$ServiceRequest->end_date->format('d/m/Y')}}</td>
            <td style="text-align:center">{{$ServiceRequest->responsabilityCenter->name}}</td>
            <td style="text-align:center">${{number_format($ServiceRequest->Fulfillments->first()->total_to_pay)}}</td>
        </tr>
    </table>
  @endif
@endif

<p class="justify">
    En Iquique, a catorce días del mes de enero de dos mil veintiuno, entre D. HECTOR ALARCON ALARCON RUN: 14.101.085-9,  en su calidad de Director  del Hospital “Dr. Ernesto Torres Galdames” de Iquique, con domicilio en Av. Héroes de la Concepción N° 502 de Iquique, en adelante "el Director  del Hospital “Dr. Ernesto Torres Galdames", y por la otra {{$ServiceRequest->name}}, RUN: {{$ServiceRequest->run_s_dv}}-{{$ServiceRequest->dv}}, domiciliado en {{$ServiceRequest->address}}, de la Ciudad de Iquique, en adelante "el prestador”, ambos mayores de edad, se ha convenido el siguiente:
</p>

<p class="justify">
    <strong>PRIMERO:</strong> Don HECTOR ALARCON ALARCON, en su calidad de Director del Hospital “Dr. Ernesto Torres Galdames” de Iquique, contrata a {{$ServiceRequest->name}}, ({{$ServiceRequest->rrhh_team}}), para que preste servicios en el Servicio de Emergencia del Hospital de Iquique bajo la modalidad de Honorarios a Suma Alzada.
</p>

<p class="justify">
    <strong>SEGUNDO:</strong> En cumplimiento del presente convenio La Profesional deberá llevar a cabo las siguientes prestaciones:
    <ul>
        <li>{{$ServiceRequest->service_description}}</li>
    </ul>
</p>

<p class="justify">
    <strong>TERCERO:</strong> El prestador recibirá los lineamientos por parte del Jefe del {{$ServiceRequest->responsabilityCenter->name}}, del Hospital Regional de Iquique, el cual tendrá la responsabilidad de evaluar sus servicios en forma mensual.
</p>

<p class="justify">
    <strong>CUARTO:</strong> El prestador de Servicios contratante a través de la declaración jurada señaló no estar afecto a ninguna de las inhabilidades establecidas en los arts. 54, 55 y 56 de la Ley Nº 18.575, Orgánica Constitucional de las Bases Generales de la Administración del Estado. Dichas disposiciones relativas a inhabilidades e incompatibilidades administrativas serán aplicables al prestador, con quién se suscribe el presente contrato a Honorarios a Suma Alzada.
</p>

<?php setlocale(LC_ALL, 'es'); ?>
<p class="justify">
    <strong>QUINTO:</strong> El presente convenio empezará a regir, a contar del {{\Carbon\Carbon::parse($ServiceRequest->start_date)->formatLocalized('%d de %B de %Y')}} al {{\Carbon\Carbon::parse($ServiceRequest->end_date)->formatLocalized('%d de %B de %Y')}}, de acuerdo al artículo 52 de la Ley 19.880, sobre Bases de Procedimientos Administrativos.
</p>

<p class="justify">
    <strong>SEXTO:</strong> El Hospital “Dr. Ernesto Torres Galdames” de Iquique podrá poner término anticipadamente a este contrato mediante razones fundadas, previo aviso por escrito al prestador con 48 horas hábiles de anticipación.
</p>

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
          En el desempeño de sus funciones, el prestador cumplió con un total de {{number_format($ServiceRequest->Fulfillments->first()->total_hours_to_pay)}} Horas en turno extras en el mes de {{\Carbon\Carbon::parse($ServiceRequest->start_date)->formatLocalized('%B')}}, cuya suma alzada totas es de ${{number_format($ServiceRequest->Fulfillments->first()->total_to_pay)}}.- ({{$ServiceRequest->fulfillments->first()->total_to_pay_description}}) impuesto incluido, en conformidad a lo dispuesto en el inciso segundo del Art. 2º del Decreto Nº 98 de 1991 del Ministerio de Hacienda y se cancelará en una cuota de ${{number_format($ServiceRequest->Fulfillments->first()->total_to_pay)}} el mes de {{\Carbon\Carbon::parse($ServiceRequest->start_date)->formatLocalized('%B')}}; se deberá acreditar contra presentación de certificado extendido por el Jefe del {{$ServiceRequest->responsabilityCenter->name}}, dependiente del Hospital Regional de Iquique, en que conste el cumplimiento de las labores estipuladas en el contrato. El pago será efectuado el día 05 del mes siguiente, y si este cae en día inhábil, se efectuará el día hábil más cercano una vez que el establecimiento dé su conformidad a la prestación realizada y previa presentación de la boleta de honorario respectiva. El Hospital retendrá y pagará el impuesto correspondiente por los honorarios pactados. Asimismo, el prestador deberá entregar dentro de los primeros 5 días del mes siguiente el certificado de servicios prestados realizados, a la Subdirección de Gestión y Desarrollo de las Personas del Hospital Dr. Ernesto Torres Galdames de Iquique, el cual debe venir con las debidas observaciones de la Jefatura directa.
      </p>
    @elseif($ServiceRequest->working_day_type == "HORA EXTRA")
      <p class="justify">
          <strong>SÉPTIMO:</strong>
          En el desempeño de sus funciones, el prestador cumplió con un total de {{number_format($ServiceRequest->Fulfillments->first()->total_hours_to_pay)}} Horas por extensión horaria en el mes de {{\Carbon\Carbon::parse($ServiceRequest->start_date)->formatLocalized('%B')}}, cuya suma alzada totas es de ${{number_format($ServiceRequest->Fulfillments->first()->total_to_pay)}}.- ({{$ServiceRequest->fulfillments->first()->total_to_pay_description}}) impuesto incluido, en conformidad a lo dispuesto en el inciso segundo del Art. 2º del Decreto Nº 98 de 1991 del Ministerio de Hacienda y se cancelará en una cuota de ${{number_format($ServiceRequest->Fulfillments->first()->total_to_pay)}} el mes de {{\Carbon\Carbon::parse($ServiceRequest->start_date)->formatLocalized('%B')}}; se deberá acreditar contra presentación de certificado extendido por el Jefe del {{$ServiceRequest->responsabilityCenter->name}}, dependiente del Hospital Regional de Iquique, en que conste el cumplimiento de las labores estipuladas en el contrato. El pago será efectuado el día 05 del mes siguiente, y si este cae en día inhábil, se efectuará el día hábil más cercano una vez que el establecimiento dé su conformidad a la prestación realizada y previa presentación de la boleta de honorario respectiva. El Hospital retendrá y pagará el impuesto correspondiente por los honorarios pactados. Asimismo, el prestador deberá entregar dentro de los primeros 5 días del mes siguiente el certificado de servicios prestados realizados, a la Subdirección de Gestión y Desarrollo de las Personas del Hospital Dr. Ernesto Torres Galdames de Iquique, el cual debe venir con las debidas observaciones de la Jefatura directa.
      </p>
    @endif
  @endif
@endif


@if($ServiceRequest->program_contract_type == "Mensual")
  <p class="justify">
      <strong>OCTAVO:</strong> La presente contratación se efectuará sobre la base de honorarios, por una suma alzada de ${{number_format($ServiceRequest->gross_amount)}}.- ({{$ServiceRequest->gross_amount_description}}),  impuesto incluido, en conformidad a lo dispuesto en el inciso segundo del Art. 2º del Decreto Nº 98 de 1991 del Ministerio de Hacienda y se cancelará en @livewire('service-request.monthly-quotes', ['serviceRequest' => $ServiceRequest]) se deberá acreditar contra presentación de certificado extendido por el Jefe del {{$ServiceRequest->responsabilityCenter->name}}, dependiente del Hospital Regional de Iquique, en que conste el cumplimiento de las labores estipuladas en el contrato. El pago será efectuado el día 05 del mes siguiente, y si este cae en día inhábil, se efectuará el día hábil más cercano una vez que el establecimiento dé su conformidad a la prestación realizada y previa presentación de la boleta de honorario respectiva. El Servicio retendrá y pagará el impuesto correspondiente por los honorarios pactados.
    <br>
    Asimismo, el prestador deberá entregar dentro de los primeros 5 días del mes siguiente el certificado de servicios prestados realizados, a la Subdirección de Gestión y Desarrollo de las Personas del Hospital Dr. Ernesto Torres Galdames de Iquique, el cual debe venir con las debidas observaciones de la Jefatura directa.
  </p>
@elseif($ServiceRequest->program_contract_type == "Horas")
  @if($ServiceRequest->estate == "Profesional Médico")
    <p class="justify">
        <strong>OCTAVO:</strong> El “valor por hora” será por la suma de ${{number_format($ServiceRequest->gross_amount)}}.- ({{$ServiceRequest->gross_amount_description}}), para efectos del pago, cada final de mes el Jefe del {{$ServiceRequest->responsabilityCenter->name}} o por la jefatura inmediatamente superior, deberá certificar las horas realizadas por el profesional médico de manera presencial (no es aceptable la suplantación de personas). Debiendo, además, adjuntar el registro de asistencia efectuado en el respectivo servicio, los cuales serán indispensables para su cancelación, sin perjuicio de las funciones de control de la Subdirección de Gestión y Desarrollo de las Personas del Hospital de Iquique,
        <br><br>
      	El pago será efectuado el día 05 del mes siguiente, y si este cae en día inhábil, se efectuará el día hábil más cercano una vez que el establecimiento dé su conformidad a la prestación realizada y previa presentación de la boleta de honorario respectiva. El Servicio retendrá y pagará el impuesto correspondiente por los honorarios pactados.
        <br><br>
        Asimismo, el prestador deberá entregar dentro de los primeros 5 días del mes siguiente el certificado de servicios prestados realizados, a la Unidad de Honorarios Covid del Hospital Dr. Ernesto Torres Galdames de Iquique, el cual debe venir con las debidas observaciones de la Jefatura directa.
        <br>
    </p>
  @else
    <p class="justify">
        <strong>OCTAVO:</strong> El prestador deberá cumplir las prestaciones de servicios pactadas entre las partes en el presente convenio, y se deberá acreditar su porcentaje de cumplimiento conforme al verificador establecido, contra presentación de certificado extendido por la jefatura del área donde presta servicios.
    </p>
  @endif
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
      <strong>DÉCIMO:</strong> El prestador cumplirá una jornada de turnos rotativos, en cuarto turno, un largo de 08:00 a 20:00 hrs., una noche de 20:00 a 08:00 hrs. y dos días libres. Se deja establecido que, el horario en el cual debe realizar sus servicios el prestador, se indica con el fin de verificar la realización de éstos, sin que altere la naturaleza jurídica del convenio, en virtud del Dictamen N°26.092/2017 de la C.G.R., los atrasos superiores a una hora, serán descontados de la cuota mensual correspondiente, como también los días de inasistencia, los cuales deberán quedar informados en el respectivo informe de prestaciones mensual. Los reiterados atrasos e inasistencias deberán ser amonestados.
  </p>
@elseif($ServiceRequest->program_contract_type == "Horas")
  @if($ServiceRequest->estate == "Profesional Médico")
    <p class="justify">
        <strong>DÉCIMO:</strong> Se deja establecido que, el horario en el cual debe realizar sus servicios el prestador, se indican con el fin de verificar la realización de éstos, sin que se altere la naturaleza jurídica del convenio, en virtud del Dictamen N°26.092/2017 de la C.G.R., los atrasos superiores a una hora, serán descontados de sus horas realizadas.
    </p>
  @else
    <p class="justify">
        <strong>DÉCIMO:</strong> Déjese establecido que el incumplimiento de los términos del presente contrato implicará la caducidad inmediata de éste, como así la devolución de las cuotas pagadas.
    </p>
  @endif
@endif

@if($ServiceRequest->program_contract_type == "Mensual")
  <p class="justify">
      <strong>DÉCIMO PRIMERO:</strong> Déjese establecido que el incumplimiento de los términos del presente contrato implicará la caducidad inmediata de éste, como así la devolución de las cuotas pagadas.
  </p>
@elseif($ServiceRequest->program_contract_type == "Horas")
  @if($ServiceRequest->estate == "Profesional Médico")
    <p class="justify">
        <strong>DÉCIMO PRIMERO:</strong> Déjese establecido que el incumplimiento de los términos del presente contrato implicará la caducidad inmediata de éste, como así la devolución de las cuotas pagadas.
    </p>
  @else
    <p class="justify">
        <strong>DÉCIMO PRIMERO:</strong> La personería de D. HECTOR ALARCON ALARCON, para representar al Hospital “Dr. E. Torres G.” de Iquique, en su calidad de Director, consta en Resolución Exenta RA N° 425/300/2020, de fecha 30 de noviembre del 2020, del Servicio de Salud Iquique.
    </p>
  @endif
@endif



@if($ServiceRequest->program_contract_type == "Mensual")
  <p class="justify">
      <strong>DÉCIMO SEGUNDO:</strong> Déjese establecido que el prestador tendrá derecho a presentar licencias médicas de todo tipo, la cual sólo justificará los días de inasistencia, no procediendo el pago de éstos, además deberá dejar copia de licencia médica en la Subdirección de Recursos Humanos. Las ausencias por esta causa serán descontadas de la cuota mensual.
      <br><br>
      A contar del 01 de enero del 2019 el personal a honorarios estará obligado a imponer, tanto en salud como en AFP, de manera personal, como lo indica la Ley N°20.894, por lo tanto, deberá realizar el cobro del subsidio de salud directamente en la institución correspondiente, ya sea Fonasa o Isapre.
  </p>
  <p class="justify">
      <strong>DECIMO TERCERO:</strong> En caso que el prestador tenga contacto con un contagiado de COVID-19, o en su defecto, deba realizar cuarentena obligatoria por ser positivo de COVID-19, el Director de Servicio o establecimiento podrá disponer la autorización de permiso preventivo, el cual no será causal de descuento. De considerarse contacto estrecho, se podrá establecer un sistema de teletrabajo en aquellas funciones que lo permitan.
  </p>
  <p class="justify">
      <strong>DECIMO CUARTO:</strong> La personería de D. HECTOR ALARCON ALARCON, para representar al Hospital “Dr. E. Torres G.” de Iquique, en su calidad de Director, consta en Resolución Exenta RA N° 425/300/2020, de fecha 30 de noviembre del 2020, del Servicio de Salud Iquique.
  </p>
@elseif($ServiceRequest->program_contract_type == "Horas")
  @if($ServiceRequest->estate == "Profesional Médico")
    <p class="justify">
        <strong>DÉCIMO SEGUNDO:</strong> Déjese establecido que el presente convenio de honorarios covid, el prestador no dará derecho a beneficios de feriados legales, permisos administrativos y otro tipo de permisos contemplados y/o asimilados a funciones estatutarias, complementariamente con respecto al ausentismo por licencias médicas.
        <br><br>
        A contar del 01 de enero del 2019 el personal a honorarios estará obligado a imponer, tanto en salud como en AFP, de manera personal, como lo indica la Ley N°20.894, por lo tanto, deberá realizar el cobro del subsidio de salud directamente en la institución correspondiente, ya sea Fonasa o Isapre.
    </p>
    <p class="justify">
        <strong>DECIMO TERCERO:</strong> La personería de D. HECTOR ALARCON ALARCON, para representar al Hospital “Dr. E. Torres G.” de Iquique, en su calidad de Director, consta en Resolución Exenta RA N° 425/300/2020, de fecha 30 de noviembre del 2020, del Servicio de Salud Iquique.
    </p>
  @else

  @endif
@endif

<br><br>
Para constancia firman:

<p class="">
    <strong>2.</strong> El convenio que por este acto se aprueban, se entiende que forman parte integrante de la presente Resolución.
</p>

@if($ServiceRequest->program_contract_type == "Mensual")
  <p class="">
      <strong>3.</strong> IMPÚTESE el gasto correspondiente al ítem 21-03-001-001-02 Honorario Suma Alzada Personal No Médico, del presupuesto del Hospital “Dr. Ernesto Torres Galdames” de Iquique.
  </p>
@elseif($ServiceRequest->program_contract_type == "Horas")
  @if($ServiceRequest->estate == "Profesional Médico")
    <p class="">
        <strong>3.</strong> IMPÚTESE el gasto correspondiente al ítem 21-03-001-001-03 Honorario Suma Alzada Personal Médico del presupuesto del Hospital “Dr. Ernesto Torres Galdames” de Iquique.
    </p>
  @else
    <p class="">
        <strong>3.</strong> IMPÚTESE el gasto correspondiente al ítem 21-03-001-001-02 Honorario Suma Alzada Personal No Médico, del presupuesto del Hospital “Dr. Ernesto Torres Galdames” de Iquique.
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
        <strong>
        <span class="uppercase">HECTOR ALARCÓN ALARCÓN</span><br>
        DIRECTOR<br>
        HOSPITAL DR ERNESTO TORRES GALDÁMEZ<br>
        </strong>
        <br style="padding-bottom: 4px;">
        Lo que me permito transcribe a usted para su conocimiento y fines consiguientes.
    </div>
</div>
<br style="padding-bottom: 4px;">
<div class="siete" style="padding-top: 2px;">
    <strong><u>DISTRIBUCIÓN:</u></strong><br>
    Honorarios Covid<br>
    Finanzas<br>
    Interesado<br>
    Oficina de partes<br>
</div>


</div>
</body>
</html>

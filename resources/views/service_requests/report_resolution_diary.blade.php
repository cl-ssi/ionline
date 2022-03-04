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

    @media all {
      .page-break {
        display: none;
      }
    }

    @media print {
      .page-break {
        display: block;
        page-break-before: always;
      }
    }
  </style>
</head>

<body>
  <div class="content">

    <div class="content">
      <img style="padding-bottom: 4px;" src="images/logo_pluma.jpg" width="120" alt="Logo Servicio de Salud"><br>


      <div class="siete" style="padding-top: 3px;">
        @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
        HOSPITAL DR. ERNESTO TORRES GALDÁMEZ<br>
        @else

        @endif
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

      <!-- VISTO HETG -->
      @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
      <p class="justify">
        <strong>VISTOS:</strong><br>

        Lo dispuesto en el art. 11° del D.F.L. N° 29, de 2004 del Ministerio de Hacienda, que Fija el texto refundido, coordinado y sistematizado de la Ley N° 18.834, de 1989 sobre Estatuto Administrativo; art. 36° letra f) inciso 2, del D.F.L. N° 01, de 2005 del Ministerio de Salud, que Fija texto refundido, coordinado y sistematizado del Decreto Ley N° 2.763, de 1979 y de las Leyes N° 18.933 y N° 18.469; Art. 54° II letras a), b) y c) del Decreto Supremo N° 140, de 2004, que aprobó el Reglamento Orgánico de los Servicios de Salud; Ley N° 19.880 de Bases de Procedimiento Administrativo, Art. 23° letra f) del Decreto N° 38, de 2005 que Aprueba Reglamento Orgánico de los Establecimientos de Salud de Menor Complejidad y de los Establecimientos de Autogestión en Red todas del Ministerio de Salud;
        {{App\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->decree}},
        del Servicio de Salud Iquique, Gabinete Presidencial N° 02, de 2018 de la Presidencia de la República, Ley N° 21.289, de 2020 del Ministerio de Hacienda, que Aprueba Presupuesto del Sector Público año 2020; Resoluciones N° 18, de 2017 y N° 6, de 2019 ambas de la Contraloría General de la República.<br>
      </p>
      @else
      <p class="justify">
        <strong>VISTOS:</strong><br>
        En estos antecedentes, según lo dispuesto según inciso final del Art. 2º y 3º del Decreto Nº 98 de 1991 del
        Ministerio de Hacienda, Circular Nº 2C/45 de 1998 todos del Ministerio de Salud, Art. 11° del D.F.L. Nº29/04 que
        fija texto refundido, coordinado y sistematizado de la Ley 18.834/89 sobre Estatuto Administrativo,
        Ley Nº 21.395/2021 de Presupuesto del Sector Público para el año 2022
        D.F.L. Nº01/05 que fija texto refundido,
        coordinado y sistematizado, Dto. Ley Nº 2763/79 y de las leyes 18.933 y 18469 del Ministerio de Salud;
        Art. 8° III letra d) del Dto. Nº 140/04 del Ministerio de Salud que aprobó el Reglamento Orgánico de
        los Servicios de Salud, {{App\Rrhh\Authority::getAuthorityFromDate(1,now(),['manager'])->decree}},
        Resolución Nº6/2019, Resolución N° 18/2017, Resol N° 2/2022; Dictamen Nº 21.900/98 y Dictamen N°E173171/2022
        todos de la Contraloría General de la República.<br>
      </p>

      @endif

      <p class="justify">
        <strong>CONSIDERANDO:</strong><br>

        {{$ServiceRequest->objectives}}.<br>

        <b>- Que</b>, esta labor no puede cumplirse con los recursos humanos propios de la institución no por carecer de ellos, sino porque éstos tienen relación con labores accidentales y no habituales de la Institución, de tal forma de encuadrarse en el Art. 11 Ley N°18.834, sobre Estatuto Administrativo. <br>

        <b>- Que</b>, por la índole del servicio que debe realizarse es más recomendable fijar un honorario consistente en una suma alzada.<br>

        <b>- Que</b>, el @if($ServiceRequest->responsabilityCenter->establishment_id == 1) Hospital Ernesto Torres Galdames @else Servicio de Salud Iquique @endif, cuenta con las disponibilidades presupuestarias suficientes para solventar tal convenio.<br>
      </p>

      <p class="justify">
        <strong>RESUELVO:</strong><br>
        <!-- {{$ServiceRequest->resolve}}<br><br> -->

        <strong>1.CONTRÁTESE</strong> a honorarios a suma alzada en el @if($ServiceRequest->responsabilityCenter->establishment_id == 1) Hospital Ernesto Torres Galdames, @else Servicio de Salud Iquique, @endif a la persona que más abajo se individualiza de acuerdo a su área de competencia,

      </p>

      <table class="siete">
        <tr>
          <th>Nombre</th>
          <th>Run</th>
          <th>Función</th>
          <th>Desde</th>
          <th>Hasta</th>
          <th>Monto Total</th>
        </tr>
        <tr>
          <td style="text-align:center">{{$ServiceRequest->employee->getFullNameAttribute()}}</td>
          <td style="text-align:center">{{$ServiceRequest->employee->runFormat()}}</td>
          <td style="text-align:center">{{$ServiceRequest->profession->name}} - {{$ServiceRequest->working_day_type}}</td>
          <td style="text-align:center">{{$ServiceRequest->start_date->format('d/m/Y')}}</td>
          <td style="text-align:center">{{$ServiceRequest->end_date->format('d/m/Y')}}</td>
          <td style="text-align:center">${{number_format($ServiceRequest->gross_amount)}}</td>
        </tr>
      </table>

      @php
      $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
      $fecha = \Carbon\Carbon::parse($ServiceRequest->start_date);
      $mes = $meses[($fecha->format('n')) - 1];
      $inputs['Fecha'] = $fecha->format('d') . ' días del mes del ' . $mes . ' del ' . $fecha->format('Y');
      @endphp

      @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
      <p class="justify">
        En Iquique, a {{$inputs['Fecha']}}, comparece por una parte el <b>HOSPITAL ERNESTO TORRES GALDAMES</b>, persona jurídica de derecho público, RUT. 62.000.530-4 , con domicilio en calle Av.héroes de la concepcion N 502 de la ciudad de Iquique, representado por su {{App\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->position}}
        <b>{{App\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->user->FullNameUpper}}</b>,
        chileno, Cédula Nacional de Identidad N°{{App\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->user->runFormat()}}, del mismo domicilio del servicio público que representa, en
        adelante , "El Director del Hospital Ernesto Torres Galdames", y por la otra don <b>{{$ServiceRequest->employee->getFullNameAttribute()}}</b>@if($ServiceRequest->profession), {{$ServiceRequest->profession->name}}@endif, RUT:{{$ServiceRequest->employee->id}}-{{$ServiceRequest->employee->dv}}, chileno,
        con domicilio en {{$ServiceRequest->address}}, de la ciudad de Iquique, en adelante “El Profesional” y exponen lo siguiente:
      </p>
      @else
      <p class="justify">
        En Iquique, a {{$inputs['Fecha']}}, comparece por una parte el <b>SERVICIO DE SALUD IQUIQUE</b>, persona jurídica de derecho público, RUT. 61.606.100-3, con domicilio en calle Aníbal
        Pinto N°815 de la ciudad de Iquique, representado por su Director <b>{{App\Rrhh\Authority::getAuthorityFromDate(1,now(),['manager'])->user->FullNameUpper}}</b> chileno, Cédula Nacional de Identidad N°{{App\Rrhh\Authority::getAuthorityFromDate(1,now(),['manager'])->user->runFormat()}}, del mismo domicilio del servicio público que representa, en
        adelante , "El Director del Servicio de Salud Iquique", y por la otra don <b>{{$ServiceRequest->employee->getFullNameAttribute()}}</b>@if($ServiceRequest->profession), {{$ServiceRequest->profession->name}}@endif, RUT:{{$ServiceRequest->employee->id}}-{{$ServiceRequest->employee->dv}}, chileno,
        con domicilio en {{$ServiceRequest->address}}, de la ciudad de Iquique, en adelante “El Profesional” y exponen lo siguiente:
      </p>

      @endif
      @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
      <strong>PRIMERO:</strong>
      Don {{App\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->user->FullNameUpper}}, en su calidad de {{App\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->position}} del Hospital Ernesto Torres Galdames, contrata los servicios a honorarios a suma alzada de {{$ServiceRequest->employee->getFullNameAttribute()}},
      @if($ServiceRequest->profession){{$ServiceRequest->profession->name}},@endif apoyo a {{$ServiceRequest->responsabilityCenter->name}} de la Dirección del Hospital Ernesto Torres Galdames.
      @else
      <p class="justify">
        <strong>PRIMERO:</strong>
        D. {{App\Rrhh\Authority::getAuthorityFromDate(1,now(),['manager'])->user->FullNameUpper}}, en su calidad de {{App\Rrhh\Authority::getAuthorityFromDate(1,now(),['manager'])->user->position}} del Servicio de Salud Iquique, contrata los servicios a honorarios a suma alzada de {{$ServiceRequest->employee->getFullNameAttribute()}},
        @if($ServiceRequest->profession){{$ServiceRequest->profession->name}},@endif apoyo a {{$ServiceRequest->responsabilityCenter->name}} de la Dirección del Servicio Salud Iquique.
      </p>
      @endif

      <p class="justify">
        <strong>SEGUNDO:</strong> En cumplimiento del presente convenio El prestador deberá llevar a cabo las siguientes prestaciones:
      <ul>

        <li>{!! nl2br(e($ServiceRequest->service_description)) !!}</li>
      </ul>
      </p>

      <p class="justify">
        <strong>TERCERO:</strong> El prestador recibirá los lineamientos por parte del Jefe del {{$ServiceRequest->responsabilityCenter->name}}, del
        @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
        Hospital Regional de Iquique,
        @else
        Servicio de Salud Iquique,
        @endif
        el cual tendrá la responsabilidad de evaluar sus servicios en forma mensual.



      </p>

      <p class="justify">
        <strong>CUARTO:</strong> El profesional contratante a través de declaración jurada señaló no estar afecto a ninguna de las inhabilidades establecidas en el artículo 54 de la
        Ley Nº 18.575, que pasan a expresarse:<br><br>

        <i>De las inhabilidades e incompatibilidades administrativas<br>
        Artículo 56:<br>

        a) Las personas que tengan vigente o suscriban, por sí o por terceros, contratos o cauciones ascendentes a doscientas unidades tributarias mensuales o más, con el respectivo organismo de la Administración Pública. Tampoco podrán hacerlo quienes tengan litigios pendientes con la institución de que se trata, a menos que se refieran al ejercicio de derechos propios, de su cónyuge, hijos, adoptados o parientes hasta el tercer grado de consanguinidad y segundo de afinidad inclusive. Igual prohibición regirá respecto de los directores, administradores, representantes y socios titulares del diez por ciento o más de los derechos de cualquier clase de sociedad, cuando ésta tenga contratos o cauciones vigentes ascendentes a doscientas unidades tributarias mensuales o más, o litigios pendientes, con el organismo de la Administración a cuyo ingreso se postule.<br>

        b) Las personas que tengan la calidad de cónyuge, hijos, adoptados o parientes hasta el tercer grado de consanguinidad y segundo de afinidad inclusive respecto de las autoridades y de los funcionarios directivos del organismo de la administración civil del Estado al que postulan, hasta el nivel de jefe de departamento o su equivalente, inclusive.<br>
        c) Las personas que se hallen condenadas por crimen o simple delito<br><br>
        Artículo 57:<br>
        Para los efectos del artículo anterior, los postulantes a un cargo público deberán prestar una declaración jurada que acredite que no se encuentran afectos a alguna de las causales de inhabilidad previstas en ese artículo. (Igual obligación rige para los contratados a honorarios).<br>

        @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
        @else
        Artículo 58:<br>
        Todos los funcionarios tendrán derecho a ejercer libremente cualquier profesión, industria, comercio u oficio conciliable con su posición en la Administración del Estado, siempre que con ello no se perturbe el fiel y oportuno cumplimiento de sus deberes funcionarios, sin perjuicio de las prohibiciones o limitaciones establecidas por ley. Estas actividades deberán desarrollarse siempre fuera de la jornada de trabajo y con recursos privados. Son incompatibles con la función pública las actividades particulares cuyo ejercicio deba realizarse en horarios que coincidan total o parcialmente con la jornada de trabajo que se tenga asignada. Asimismo, son incompatibles con el ejercicio de la función pública las actividades particulares de las autoridades o funcionarios que se refieran a materias específicas o casos concretos que deban ser analizados, informados o resueltos por ellos o por el organismo o servicio público a que pertenezcan; y la representación de un tercero en acciones civiles deducidas en contra de un organismo de la Administración del Estado, salvo que actúen en favor de alguna de las personas señaladas en la letra b) del artículo 56 o que medie disposición especial de ley que regule dicha representación. Del mismo modo son incompatibles las actividades de las ex autoridades o ex funcionarios de una institución fiscalizadora que impliquen una relación laboral con entidades del sector privado sujetas a la fiscalización de ese organismo. Esta incompatibilidad se mantendrá hasta seis meses después de haber expirado en servicios.<br><br>
        @endif
  </i>




      </p>

      <p class="justify">
        <strong>QUINTO:</strong> El presente convenio empezará a regir, a contar del {{$ServiceRequest->start_date->day}} de {{$ServiceRequest->start_date->monthName}} del {{$ServiceRequest->start_date->year}} al {{$ServiceRequest->end_date->day}} de {{$ServiceRequest->end_date->monthName}} del {{$ServiceRequest->end_date->year}}, de acuerdo al artículo 52 de la Ley 19.880, sobre Bases de Procedimientos Administrativos.
      </p>

      <p class="justify">
        <strong>SEXTO:</strong>
        El Hospital “Dr. Ernesto Torres Galdames” de Iquique podrá poner término anticipadamente a este contrato mediante razones fundadas, previo aviso por escrito al prestador con 48 horas de anticipación
      </p>


      <p class="justify">
        <strong>SÉPTIMO:</strong>
        En este caso, el Hospital “Dr. Ernesto Torres Galdames” de Iquique, pagará a la persona en referencia sólo hasta el porcentaje de la mensualidad correspondiente al período efectivamente prestado.
      </p>




      <p class="justify">
        <strong>OCTAVO:</strong> El valor por día será por la suma de ${{number_format($ServiceRequest->gross_amount)}}.- ({{$ServiceRequest->gross_amount_description}}), para efectos del pago Hospital Regional de Iquique, en que conste el cumplimiento de las labores estipuladas en el contrato. El pago será efectuado el día
        @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
        10
        @else
        5
        @endif
        del mes siguiente, y si este cae en día inhábil, se efectuará el día hábil más cercano una vez que el establecimiento dé su conformidad a la prestación realizada y previa presentación de la boleta de honorario respectiva. La entidad retendrá y pagará el impuesto correspondiente por los honorarios pactados.<br><br>
        <b>Asimismo, el prestador deberá entregar dentro de los primeros 5 días del mes siguiente el certificado de servicios prestados realizados, a la Subdirección de Gestión y Desarrollo de las Personas del
          @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
          Hospital Dr. Ernesto Torres Galdames de Iquique,
          @else
          Servicio de salud Iquique,
          @endif
          el cual debe venir con las debidas observaciones de la Jefatura directa.
        </b>
      </p>


      <p class="justify">
        <strong>NOVENO:</strong> El profesional deberá cumplir las prestaciones de servicios pactadas entre las partes en el presente convenio, y se deberá acreditar su porcentaje de cumplimiento conforme al verificador establecido, contra presentación de documentos (protocolos operatorios) que deberán ser entregado a la Subdirección Médica.
      </p>


      <p class="justify">
        <strong>DÉCIMO:</strong> El prestador cumplirá una jornada que deberá ser acreditada mediante copia del registro de asistencia,
        que deberán ser entregado a la Subdirección Médica, se deja establecido que, la copia del registro de asistencia,
        se indica con el fin de verificar la realización de éstos, sin que altere la naturaleza jurídica del convenio,
        en virtud del Dictamen N°26.092/2017 de la C.G.R. Si durante una jornada de trabajo existiese un cambio de hora, se pagarán las horas efectivamente trabajadas.
      </p>


      <p class="justify">
        <strong>DÉCIMO PRIMERO:</strong> Déjese establecido que el incumplimiento de los términos del presente contrato implica la caducidad inmediata de éste.
      </p>


      <p class="justify">
        <strong>DÉCIMO SEGUNDO:</strong> Déjese establecido que el trabajador se regirá por el procedimiento establecido en el “Manual de Procedimientos de Denuncia, Prevención y Sanación del Maltrato, Acoso Laboral y/o Sexual y Discriminación, conforme resolución vigente en el Servicio de Salud Iquique.
      </p>

      Para constancia firman: <br><br> {{$ServiceRequest->employee->getFullNameAttribute()}} <br><br>

      <p class="">
        <strong>2.</strong> El convenio que por este acto se aprueban, se entiende que forman parte integrante de la presente Resolución.
      </p>

      <p class="">
        <strong>3.</strong> El gasto corresponde
        @if($ServiceRequest->subt31)
        {{$ServiceRequest->subt31}}
        @else
        al ítem
        @if($ServiceRequest->programm_name == "OTROS PROGRAMAS SSI" || $ServiceRequest->programm_name == "LISTA ESPERA" || $ServiceRequest->programm_name == "ADP DIRECTOR")
        21-03-001-001-02
        @elseif($ServiceRequest->programm_name == "SENDA")
        11-40-504 <b>SENDA</b> (Fondos Extrapresupuestario) asociado al convenio SENDA 1,
        @elseif($ServiceRequest->programm_name == "SENDA UHCIP")
        11450602
        @elseif($ServiceRequest->programm_name == "LEY DE ALCOHOL" || $ServiceRequest->programm_name == "SENDA LEY ALCOHOLES")
        114050601
        @elseif($ServiceRequest->programm_name == "SENDA PSIQUIATRIA ADULTO")
        11450602
        @elseif($ServiceRequest->programm_name == "PESPI")
        21-03-001-001-04 PESPI ( Programa Especial de Salud Pueblos Indígenas)
        @elseif($ServiceRequest->programm_name == "SUBT.31")
        El gasto corresponde al ítem 31-02-001 SUBT.21 ( Consultorías) Honorario Suma Alzada.
        @elseif($ServiceRequest->programm_name == "OTROS PROGRAMAS HETG")
        21-03-001-001-02 Honorarios a Suma Alzada del presupuesto del Hospital “Dr. Ernesto Torres Galdames” de Iquique. )
        @elseif($ServiceRequest->programm_name == "33 MIL HORAS")
        21-03-001-001-06 Honorarios Suma Alzada “Programa Cierres de Brechas 33.000 horas” dispuestos por el Ministerio de Salud, Subtítulo 21.
        @endif
        Honorario Suma Alzada.

        @endif
        <br>







      </p>

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

          <br>
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
      <br>
      @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
      <div class="siete" style="padding-top: 2px;">
        <strong><u>DISTRIBUCIÓN:</u></strong><br>
        Honorarios Suma Alzada<br>
        <!-- Finanzas<br>
        Interesado<br> -->
        Oficina de Partes<br>
        {{--
    @else
      @if($ServiceRequest->responsabilityCenter->establishment_id == 12)
        CGU (roxana.penaranda@redsalud.gov.cl, anakena.bravo@redsalud.gov.cl)<br>
        Finanzas (patricia.salinasm@redsalud.gov.cl, finanzas.ssi@redsalud.gov.cl)<br>
        Interesado<br>
        Oficina de Partes<br>


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

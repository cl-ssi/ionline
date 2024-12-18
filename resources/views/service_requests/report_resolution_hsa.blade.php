<?php setlocale(LC_ALL, 'es'); ?>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>Resolución</title>
  <meta name="description" content="">
  <meta name="author" content="Servicio de Salud Iquique">
  <style media="screen">
    body {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 0.75rem;
    }

    .content {
      margin: 0 auto;
      width: 724px;
      margin-bottom: 8%;
    }

    .monospace {
      font-family: "Lucida Console", Monaco, monospace;
    }

    .pie_pagina {
      margin: 0 auto;
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

    .row:after {
      content: "";
      display: table;
      clear: both;
    }

    .page-break {
      page-break-after: always;
    }

    footer {
      position: fixed;
      bottom: -40px;
      left: 0px;
      right: 0px;
      height: 50px;
      text-align: center;
      clear: both;
    }

    footer .pagenum:before {
      content: counter(page);
    }
  </style>
</head>

<body>

  <footer>
    <table width="100%" style="border: 0px;">
      <tr>
        <td width="20%" style="padding-left: 80px; vertical-align: bottom; border: 0px;">
          <div style="width: 120px;">
            <div style="float: left; width: 41%; height: 6px; background-color: #0168B3;"></div>
            <div style="float: right; width: 59%; height: 6px; background-color: #EE3A43;"></div>
            <div style="clear: both;"></div>
          </div>
        </td>
        <td class="center" style="font-size: 8px; vertical-align: bottom; border: 0px;">
          ID Phuqhaña {{$ServiceRequest->id}} - Página <span class="pagenum"></span>
        </td>
        <td width="20%" class="right;" style="border: 0px;">
          <img src="{{ public_path('/images/footer-gob.png') }}" width="100" alt="Logo de la institución" style="border: 0px;">
        </td>
      </tr>
    </table>
  </footer>

  <main>
    <div class="content">

      <img style="padding-bottom: 4px;" src="images/logo_pluma_SST.png" width="120" alt="Logo Servicio de Salud Tarapacá"><br>

      <div class="siete" style="padding-top: 3px;">
        @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
            HOSPITAL DR. ERNESTO TORRES GALDAMES<br>
        @elseif($ServiceRequest->responsabilityCenter->establishment_id == 38)
            SERVICIO DE SALUD TARAPACÁ<br>
        @elseif($ServiceRequest->responsabilityCenter->establishment_id == 41)
            HOSPITAL DE ALTO HOSPICIO<br>
        @endif
        SUBDIRECCIÓN DE GESTIÓN Y DESARROLLO DE LAS PERSONAS
      </div>

      <div class="seis" style="padding-top: 4px;">
        N.I. {{$ServiceRequest->id}} - {{\Carbon\Carbon::now()->format('d/m/Y')}} -
        @foreach($ServiceRequest->SignatureFlows as $SignatureFlow)
          {{$SignatureFlow->user->Initials}},
        @endforeach
      </div>

      <div class="right" style="float: right; width: 280px;">
        <div class="left" style="padding-bottom: 6px;">
          @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
            @if($ServiceRequest->programm_name == "OTROS PROGRAMAS HETG" or $ServiceRequest->programm_name == "LEQ Fonasa" or $ServiceRequest->programm_name == "CONTINGENCIA RESPIRATORIA")
              <strong>RESOLUCIÓN EXENTA N°: {{$ServiceRequest->resolution_number}}</strong>
            @else
              <strong>RESOLUCIÓN N°: {{$ServiceRequest->resolution_number}}</strong>
            @endif
          @else
            <strong>RESOLUCIÓN EXENTA N°: {{$ServiceRequest->resolution_number}}</strong>
          @endif
        </div>
        <div class="left" style="padding-bottom: 2px;">
          <strong>IQUIQUE,</strong>
        </div>
      </div>

      <br><br>

      @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
        <p class="justify">
          <strong>VISTOS:</strong><br>
          Lo dispuesto en el art. 11° del D.F.L. N° 29, de 2004 del Ministerio de Hacienda, que Fija el texto refundido,
          coordinado y sistematizado de la Ley N° 18.834, de 1989 sobre Estatuto Administrativo; art. 36° letra f)
          inciso 2, del D.F.L. N° 01, de 2005 del Ministerio de Salud, que Fija texto refundido, coordinado y sistematizado
          del Decreto Ley N° 2.763, de 1979 y de las Leyes N° 18.933 y N° 18.469; Art. 54° II letras a), b) y c) del
          Decreto Supremo N° 140, de 2004, que aprobó el Reglamento Orgánico de los Servicios de Salud;
          Ley N° 19.880 de Bases de Procedimiento Administrativo, Art. 23° letra f) del Decreto N° 38, de 2005 que
          Aprueba Reglamento Orgánico de los Establecimientos de Salud de Menor Complejidad y de los Establecimientos
          de Autogestión en Red todas del Ministerio de Salud;
          {{App\Models\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->decree}},
          del Servicio de Salud Iquique, Gabinete Presidencial N° 02, de 2018 de la Presidencia de la República,
          Ley N° 21.289, de 2020 del Ministerio de Hacienda, que Aprueba Presupuesto del Sector Público año 2020;
          Resoluciones N° 18, de 2017 y N° 6, de 2019 ambas de la Contraloría General de la República.<br>
        </p>
      @else
        <p class="justify">
          <strong>VISTOS:</strong><br>
          En estos antecedentes, según lo dispuesto según inciso final del Art. 2º y 3º del Decreto Nº 98 de 1991 del Ministerio de Hacienda,
          Circular Nº 2C/45 de 1998 del Ministerio de Salud, Art. 11° del D.F.L. Nº29/04 que 
          fija texto refundido, coordinado y sistematizado de la Ley 18.834/89 sobre Estatuto Administrativo, 
          Ley Nº 21.640/2023 de Presupuesto del Sector Público para el año 2024
          D.F.L. Nº01/05 que fija texto refundido, 
          coordinado y sistematizado, del Ministerio de Salud, Decreto Ley Nº 2.763 de 1979 y de las Leyes Nos. 18.933 y 18.469; Decreto N° 140/04, del Ministerio de Salud 
          que aprobó el Reglamento Orgánico de los Servicios de Salud;  
          Decreto Afecto N° 56, de 29 de diciembre de 2022, del Ministerio de Salud<br>
        </p>
      @endif

      <p class="justify">
        <strong>CONSIDERANDO:</strong><br>
        {{$ServiceRequest->objectives}}.<br><br>
        <b>- Que</b>, esta labor no puede cumplirse con los recursos humanos propios de la institución no por carecer de ellos, sino porque éstos tienen relación con labores accidentales y no habituales de la Institución, de tal forma de encuadrarse en el Art. 11 Ley N°18.834, sobre Estatuto Administrativo. <br>
        <b>- Que</b>, por la índole del servicio que debe realizarse es más recomendable fijar un honorario consistente en una suma alzada.<br>
        <b>- Que</b>, el 
        @if($ServiceRequest->responsabilityCenter->establishment_id == 1) 
            Hospital Ernesto Torres Galdames
        @elseif($ServiceRequest->responsabilityCenter->establishment_id == 38) 
            Servicio de Salud Tarapacá
        @elseif($ServiceRequest->responsabilityCenter->establishment_id == 41) 
            Hospital de Alto hospicio
        @endif, cuenta con las disponibilidades presupuestarias suficientes para solventar tal convenio.<br>
      </p>

      <p class="justify">
        <strong>RESUELVO:</strong><br>
        <strong>1.CONTRÁTESE</strong> a honorarios a suma alzada en el 
        @if($ServiceRequest->responsabilityCenter->establishment_id == 1) 
            Hospital Ernesto Torres Galdames, 
        @elseif($ServiceRequest->responsabilityCenter->establishment_id == 38) 
            Servicio de Salud Tarapacá, 
        @elseif($ServiceRequest->responsabilityCenter->establishment_id == 41) 
            Hospital de Alto hospicio
        @endif 
        a la persona que más abajo se individualiza de acuerdo a su área de competencia,
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
          <td style="text-align:center">{{$ServiceRequest->employee->fullName}}</td>
          <td style="text-align:center">{{$ServiceRequest->employee->runFormat()}}</td>
          <td style="text-align:center">{{ $ServiceRequest->profession->name ?? $ServiceRequest->estate }} - {{$ServiceRequest->working_day_type}}</td>
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
          En Iquique, a {{$inputs['Fecha']}}, comparece por una parte el <b>HOSPITAL ERNESTO TORRES GALDAMES</b>, persona jurídica de derecho público, RUT. 62.000.530-4 , con domicilio en calle Av.héroes de la concepcion N 502 de la ciudad de {{$ServiceRequest->employee->commune->name}}, representado por su {{App\Models\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->position}}
          <b>{{App\Models\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->user->fullNameUpper}}</b>,
          chileno, Cédula Nacional de Identidad N°{{App\Models\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->user->runFormat()}}, del mismo domicilio del servicio público que representa, en
          adelante , "El Director del Hospital Ernesto Torres Galdames", y por la otra don <b>{{$ServiceRequest->employee->fullName}}</b>@if($ServiceRequest->profession), {{$ServiceRequest->profession->name}}@endif, RUT:{{$ServiceRequest->employee->id}}-{{$ServiceRequest->employee->dv}}, chileno,
          con domicilio en {{$ServiceRequest->address}}, de la ciudad de {{$ServiceRequest->employee->commune->name}}, en adelante “El Profesional” y exponen lo siguiente:
        </p>
      @elseif($ServiceRequest->responsabilityCenter->establishment_id == 38)
        <p class="justify">
          En Iquique, a {{$inputs['Fecha']}}, comparece por una parte el <b>SERVICIO DE SALUD TARAPACÁ</b>, persona jurídica de derecho público, RUT. 61.606.100-3, con domicilio en calle Aníbal
          Pinto N°815 de la ciudad de Iquique, representado por su {{ App\Models\Rrhh\Authority::getAuthorityFromDate(1,now(),['manager'])->position }} <b>{{App\Models\Rrhh\Authority::getAuthorityFromDate(1,now(),['manager'])->user->fullNameUpper}}</b> chileno, Cédula Nacional de Identidad N°{{App\Models\Rrhh\Authority::getAuthorityFromDate(1,now(),['manager'])->user->runFormat()}}, del mismo domicilio del servicio público que representa, en
          adelante , "{{ App\Models\Rrhh\Authority::getAuthorityFromDate(1,now(),['manager'])->position }} del Servicio de Salud Tarapacá", y por la otra don <b>{{$ServiceRequest->employee->fullName}}</b>@if($ServiceRequest->profession), {{$ServiceRequest->profession->name}}@endif, RUT:{{$ServiceRequest->employee->id}}-{{$ServiceRequest->employee->dv}}, chileno,
          con domicilio en {{$ServiceRequest->address}}, de la ciudad de {{$ServiceRequest->employee->commune->name}}, en adelante “El Profesional” y exponen lo siguiente:
        </p>
      @elseif($ServiceRequest->responsabilityCenter->establishment_id == 41)
        <p class="justify">
          En Iquique, a {{$inputs['Fecha']}}, comparece por una parte el <b>HOSPITAL DE ALTO HOSPICIO</b>, persona jurídica de derecho público, RUT. 65.228.694-1, con domicilio en calle
          Alemania N°3240 de la comuna de Alto hospicio, representado por su {{ App\Models\Rrhh\Authority::getAuthorityFromDate(246,now(),['manager'])->position }} <b>{{App\Models\Rrhh\Authority::getAuthorityFromDate(246,now(),['manager'])->user->fullNameUpper}}</b> chileno, Cédula Nacional de Identidad N°{{App\Models\Rrhh\Authority::getAuthorityFromDate(246,now(),['manager'])->user->runFormat()}}, del mismo domicilio del servicio público que representa, en
          adelante , "{{ App\Models\Rrhh\Authority::getAuthorityFromDate(246,now(),['manager'])->position }} del Hospital de Alto hospicio", y por la otra don <b>{{$ServiceRequest->employee->fullName}}</b>@if($ServiceRequest->profession), {{$ServiceRequest->profession->name}}@endif, RUT:{{$ServiceRequest->employee->id}}-{{$ServiceRequest->employee->dv}}, chileno,
          con domicilio en {{$ServiceRequest->address}}, de la ciudad de {{$ServiceRequest->employee->commune->name}}, en adelante “El Profesional” y exponen lo siguiente:
        </p>
      @endif

      @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
        <strong>PRIMERO:</strong>
        Don {{App\Models\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->user->fullNameUpper}}, en su calidad de {{App\Models\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->position}} del Hospital Ernesto Torres Galdames, contrata los servicios a honorarios a suma alzada de {{$ServiceRequest->employee->fullName}}@if($ServiceRequest->profession), {{$ServiceRequest->profession->name}}@endif, apoyo a {{$ServiceRequest->responsabilityCenter->name}} de la Dirección del Hospital Ernesto Torres Galdames.
      @elseif($ServiceRequest->responsabilityCenter->establishment_id == 38)
        <p class="justify">
          <strong>PRIMERO:</strong>
          D. {{App\Models\Rrhh\Authority::getAuthorityFromDate(1,now(),['manager'])->user->fullNameUpper}}, en su calidad de {{App\Models\Rrhh\Authority::getAuthorityFromDate(1,now(),['manager'])->user->position}} del Servicio de Salud Tarapacá, contrata los servicios a honorarios a suma alzada de {{$ServiceRequest->employee->fullName}}@if($ServiceRequest->profession), {{$ServiceRequest->profession->name}}@endif, apoyo a {{$ServiceRequest->responsabilityCenter->name}} de la Dirección del Servicio Salud Tarapacá.
        </p>
      @elseif($ServiceRequest->responsabilityCenter->establishment_id == 41)
        <p class="justify">
          <strong>PRIMERO:</strong>
          D. {{App\Models\Rrhh\Authority::getAuthorityFromDate(246,now(),['manager'])->user->fullNameUpper}}, en su calidad de {{App\Models\Rrhh\Authority::getAuthorityFromDate(246,now(),['manager'])->user->position}} del Hospital de Alto hospicio, contrata los servicios a honorarios a suma alzada de {{$ServiceRequest->employee->fullName}}@if($ServiceRequest->profession), {{$ServiceRequest->profession->name}}@endif, apoyo a {{$ServiceRequest->responsabilityCenter->name}} de la Dirección del Hospital de Alto hospicio.
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
        @elseif($ServiceRequest->responsabilityCenter->establishment_id == 38)
            Servicio de Salud Tarapacá,
        @elseif($ServiceRequest->responsabilityCenter->establishment_id == 41)
            Hospital de Alto hospicio,
        @endif
        el cual tendrá la responsabilidad de evaluar sus servicios en forma mensual.
      </p>

      <p class="justify">
        <strong>CUARTO:</strong> El prestador de Servicios contratante a través de la declaración jurada señaló no estar afecto a ninguna de las inhabilidades
        establecidas en los arts. 54, 55 y 56 de la Ley Nº 18.575, Orgánica Constitucional de las Bases Generales de la Administración del Estado. Dichas disposiciones
        relativas a inhabilidades e incompatibilidades administrativas serán aplicables al prestador,
        con quién se suscribe el presente contrato a Honorarios a Suma Alzada.
      </p>

      <p class="justify">
        <strong>QUINTO:</strong> El presente convenio empezará a regir, a contar del {{$ServiceRequest->start_date->day}} de {{$ServiceRequest->start_date->monthName}} del {{$ServiceRequest->start_date->year}} al {{$ServiceRequest->end_date->day}} de {{$ServiceRequest->end_date->monthName}} del {{$ServiceRequest->end_date->year}}, de acuerdo al artículo 52 de la Ley 19.880, sobre Bases de Procedimientos Administrativos.
      </p>

      <p class="justify">
        <strong>SEXTO:</strong>
        @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
            El Hospital “Dr. Ernesto Torres Galdames” de Iquique podrá poner término anticipadamente a este convenio sin expresión de causa, previo aviso por escrito a la afectada con a lo menos 1 mes de anticipación.
        @elseif($ServiceRequest->responsabilityCenter->establishment_id == 38)
            El Servicio de Salud Tarapacá podrá poner término anticipadamente a este convenio sin expresión de causa, previo aviso por escrito a la afectada con a lo menos 1 mes de anticipación.
        @elseif($ServiceRequest->responsabilityCenter->establishment_id == 41)
            El Hospital de Alto hospicio podrá poner término anticipadamente a este convenio sin expresión de causa, previo aviso por escrito a la afectada con a lo menos 1 mes de anticipación.
        @endif
      </p>

      <p class="justify">
        <strong>SÉPTIMO:</strong>
        @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
            En este caso, el Hospital “Dr. Ernesto Torres Galdames” de Iquique, pagará a la persona en referencia sólo hasta el porcentaje de la mensualidad correspondiente al período efectivamente prestado.
        @elseif($ServiceRequest->responsabilityCenter->establishment_id == 38)
            El Servicio de Salud Tarapacá, cancelará a la persona en referencia sólo hasta la mensualidad correspondiente al período efectivamente prestado.
        @elseif($ServiceRequest->responsabilityCenter->establishment_id == 41)
            El Hospital de Alto hospicio, cancelará a la persona en referencia sólo hasta la mensualidad correspondiente al período efectivamente prestado.
        @endif
      </p>

      @if($ServiceRequest->program_contract_type == "Mensual")
        <p class="justify">
          <strong>OCTAVO:</strong> La presente contratación se efectuará sobre la base de honorarios, por una suma alzada de ${{number_format($ServiceRequest->gross_amount)}}.- ({{$ServiceRequest->gross_amount_description}} PESOS), impuesto incluido, en conformidad a lo dispuesto en el inciso segundo del Art. 2º del Decreto Nº 98 de 1991 del Ministerio de Hacienda y se cancelará en @livewire('service-request.monthly-quotes', ['serviceRequest' => $ServiceRequest]) se deberá acreditar contra presentación de certificado extendido por el Jefe del {{$ServiceRequest->responsabilityCenter->name}}, dependiente del
          @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
            Hospital Regional de Iquique,
          @elseif($ServiceRequest->responsabilityCenter->establishment_id == 38)
            Servicio de Salud Tarapacá,
          @elseif($ServiceRequest->responsabilityCenter->establishment_id == 41)
            Hospital de Alto hospicio,
          @endif
          en que conste el cumplimiento de las labores estipuladas en el contrato. El pago será efectuado el día
          @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
            10
          @elseif($ServiceRequest->responsabilityCenter->establishment_id == 38)
            5
          @elseif($ServiceRequest->responsabilityCenter->establishment_id == 41)
            5
          @endif
          del mes siguiente, y si este cae en día inhábil, se efectuará el día hábil más cercano una vez que el establecimiento dé su conformidad a la prestación realizada y previa presentación de la boleta de honorario respectiva. El Servicio retendrá y pagará el impuesto correspondiente por los honorarios pactados.<br><br>
          <b>Asimismo, el prestador deberá entregar dentro de los primeros 5 días del mes siguiente el certificado de servicios prestados realizados, a la Subdirección de Gestión y Desarrollo de las Personas del
            @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
                Hospital Dr. Ernesto Torres Galdames de Iquique,
            @elseif($ServiceRequest->responsabilityCenter->establishment_id == 38)
                Servicio de salud Tarapacá,
            @elseif($ServiceRequest->responsabilityCenter->establishment_id == 41)
                Hospital de Alto hospicio,
            @endif
            el cual debe venir con las debidas observaciones de la Jefatura directa.
          </b>
        </p>
      @elseif($ServiceRequest->program_contract_type == "Horas")
        <p class="justify">
          <strong>OCTAVO:</strong> El
          @if($ServiceRequest->working_day_type == 'HORA EXTRA')
            valor total por horas extras del mes
          @else
            valor por hora
          @endif
          será por la suma de ${{number_format($ServiceRequest->gross_amount)}}.- ({{$ServiceRequest->gross_amount_description}}), para efectos del pago
          @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
            Hospital Regional de Iquique,
          @elseif($ServiceRequest->responsabilityCenter->establishment_id == 38)
            Servicio de Salud Iquique,
          @elseif($ServiceRequest->responsabilityCenter->establishment_id == 41)
            Hospital de Alto hospicio,
          @endif
          en que conste el cumplimiento de las labores estipuladas en el contrato. El pago será efectuado el día
          @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
            10
          @elseif($ServiceRequest->responsabilityCenter->establishment_id == 38)
            5
          @elseif($ServiceRequest->responsabilityCenter->establishment_id == 41)
            5
          @endif
          del mes siguiente, y si este cae en día inhábil, se efectuará el día hábil más cercano una vez que el establecimiento dé su conformidad a la prestación realizada y previa presentación de la boleta de honorario respectiva. La entidad retendrá y pagará el impuesto correspondiente por los honorarios pactados.<br><br>
          <b>Asimismo, el prestador deberá entregar dentro de los primeros 5 días del mes siguiente el certificado de servicios prestados realizados, a la Subdirección de Gestión y Desarrollo de las Personas del
            @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
                Hospital Dr. Ernesto Torres Galdames de Iquique,
            @elseif($ServiceRequest->responsabilityCenter->establishment_id == 38)
                Servicio de salud Tarapacá,
            @elseif($ServiceRequest->responsabilityCenter->establishment_id == 41)
                Hospital de Alto hospicio,
            @endif
            el cual debe venir con las debidas observaciones de la Jefatura directa.
          </b>
        </p>
      @endif

      <p class="justify">
        <strong>NOVENO:</strong> El profesional deberá cumplir las prestaciones de servicios pactadas entre las partes en el presente convenio, y se deberá acreditar su porcentaje de cumplimiento conforme al verificador establecido, contra presentación de certificado extendido por la jefatura del área donde presta servicios.
      </p>

      <p class="justify">
        <strong>DÉCIMO:</strong> El prestador cumplirá una jornada
        @switch($ServiceRequest->working_day_type)
          @case('DIURNO')
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
          @default
            --
            @break
        @endswitch
        @if($ServiceRequest->working_day_type_other)
          {{$ServiceRequest->working_day_type_other}}<br>
        @endif

        Se deja establecido que, el horario en el cual debe realizar sus servicios el prestador,
        se indica con el fin de verificar la realización de éstos, sin que altere la naturaleza
        jurídica del convenio, en virtud del Dictamen N°26.092/2017 de la C.G.R.,
        si durante una jornada de trabajo existiese un cambio de hora, se pagarán las horas efectivamente trabajadas.
        Los atrasos superiores a una hora, serán descontados de la cuota mensual correspondiente,
        como también los días de inasistencia, los cuales deberán quedar informados en el respectivo
        informe de prestaciones mensual. Los reiterados atrasos e inasistencias deberán ser amonestados.
      </p>

      <p class="justify">
        <strong>DÉCIMO PRIMERO:</strong> Déjese establecido que el incumplimiento de los términos del presente contrato implica la caducidad inmediata de éste.
      </p>

      <p class="justify">
        <strong>DÉCIMO SEGUNDO:</strong> Déjese establecido que el trabajador se regirá por el procedimiento establecido en el “Manual de Procedimientos de Denuncia, Prevención y Sanación del Maltrato, Acoso Laboral y/o Sexual y Discriminación, conforme resolución vigente en el Servicio de Salud Tarapacá.
      </p>

      <p class="justify">
        <strong>DECIMO TERCERO:</strong> Déjese establecido que el trabajador tendrá derecho a presentar licencias médicas, la cual sólo justificará los días de inasistencia, no procediendo el pago de éstos y siendo responsabilidad del prestador del servicio, la tramitación de la licencia médica ante el organismo que corresponda; además deberá dejar copia de licencia médica en la Subdirección de Gestión y Desarrollo de las Personas. Las ausencias por esta causa serán descontadas de la cuota mensual.<br><br>
        @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
            Las mujeres podrán solicitar permiso post-natal parental, los cuales sólo justificará los días de inasistencia, no procediendo el pago por los días mientras dure el permiso; el beneficio es sólo para la persona definida en el convenio e intransferible
        @endif
      </p>

      @if($ServiceRequest->additional_benefits != null)
        <p class="justify">
          <strong>DECIMO CUARTO:</strong> El prestador (a) individualizado (a) en la presente resolución tendrá los siguientes beneficios adicionales:<br><br>
          {!! nl2br($ServiceRequest->additional_benefits) !!}
        </p>
      @endif

      @if($ServiceRequest->signature_page_break)
        <div class="page-break"></div>
      @endif

      Para constancia firman: <br><br> {{$ServiceRequest->employee->fullName}} <br>

      <p class="">
        <strong>2.</strong> El convenio que por este acto se aprueban, se entiende que forman parte integrante de la presente Resolución.
      </p>

      <p class="">
        @if($ServiceRequest->programm_name == "CONTINGENCIA RESPIRATORIA")
          <strong>3.</strong> IMPÚTESE el gasto correspondiente al ítem 21-03-001-001-02 Honorario Suma Alzada Personal No Médico, del presupuesto del Hospital “Dr. Ernesto Torres Galdames” de Iquique, Requerimiento Contingencia Respiratoria Unidad demandante COVID-19.
        @else
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
            @elseif($ServiceRequest->programm_name == "OTROS PROGRAMAS HETG" or $ServiceRequest->programm_name == "LEQ Fonasa")
              @if($ServiceRequest->profession->category == "A")
                21-03-001-001-03 Honorarios a Suma Alzada del presupuesto del Hospital “Dr. Ernesto Torres Galdames” de Iquique. )
              @else
                21-03-001-001-02 Honorarios a Suma Alzada del presupuesto del Hospital “Dr. Ernesto Torres Galdames” de Iquique. )
              @endif
            @elseif($ServiceRequest->programm_name == "33 MIL HORAS")
              21-03-001-001-06 Honorarios Suma Alzada “Programa Cierres de Brechas 33.000 horas” dispuestos por el Ministerio de Salud, Subtítulo 21.
            @endif

            Honorario Suma Alzada.
          @endif
        @endif
      </p>

      <br>

      <p class="center">
        <strong>
          @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
            ANÓTESE, REGÍSTRESE Y COMUNÍQUESE
          @else
            ANÓTESE, COMUNIQUESE Y REMÍTASE ESTA RESOLUCIÓN CON LOS ANTECEDENTES QUE CORRESPONDAN A LA CONTRALORÍA REGIONAL DE TARAPACÁ PARA SU REGISTRO Y CONTROL POSTERIOR.
          @endif
        </strong>
      </p>

      <div id="firmas">
        <div class="center" style="width: 100%;">
          @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
                <strong>
                    <span class="uppercase">
                        {{App\Models\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->user->fullNameUpper}}
                    </span><br>
                    <span style="text-transform:uppercase">{{App\Models\Rrhh\Authority::getAuthorityFromDate(84,now(),['manager'])->position}}</span><br>
                    HOSPITAL DR ERNESTO TORRES GALDAMES<br>
                </strong>
            @elseif($ServiceRequest->responsabilityCenter->establishment_id == 38)
                <strong>
                    <span class="uppercase">
                        {{App\Models\Rrhh\Authority::getAuthorityFromDate(1,now(),['manager'])->user->fullNameUpper}}
                    </span><br>
                    <span style="text-transform:uppercase">{{App\Models\Rrhh\Authority::getAuthorityFromDate(1,now(),['manager'])->position}}</span><br>
                    SERVICIO DE SALUD TARAPACÁ<br>
                </strong>
            @elseif($ServiceRequest->responsabilityCenter->establishment_id == 41)
                <strong>
                    <span class="uppercase">
                        {{App\Models\Rrhh\Authority::getAuthorityFromDate(246,now(),['manager'])->user->fullNameUpper}}
                    </span><br>
                    <span style="text-transform:uppercase">{{App\Models\Rrhh\Authority::getAuthorityFromDate(246,now(),['manager'])->position}}</span><br>
                    HOSPITAL DE ALTO HOSPICIO<br>
                </strong>
            @endif
            <br style="padding-bottom: 4px;">
            Lo que me permito transcribe a usted para su conocimiento y fines consiguientes.
            <br><br>
            MINISTRO DE FE
        </div>
      </div>

      <br>

      @if($ServiceRequest->responsabilityCenter->establishment_id == 1)
        <div class="siete" style="padding-top: 2px;">
          <strong><u>DISTRIBUCIÓN:</u></strong><br>
          Honorarios Suma Alzada<br>
          Oficina de Partes<br>
        </div>
      @endif

    </div>
  </main>
</body>

</html>

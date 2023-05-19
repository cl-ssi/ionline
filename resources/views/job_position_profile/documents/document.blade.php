@extends('layouts.report')

@section('title', "Perfil de Cargo N° $jobPositionProfile->id ")

@section('content')

{{--
<div style="width: 49%; display: inline-block;">
    <div class="siete">
        
    </div>
</div>

<div class="right" style="width: 50%; display: inline-block;">
    <b>RESOLUCION EXENTA N°</b>: {{ $allowance->folio_sirh }} <br>
    Iquique, {{ $allowance->created_at->format('d-m-Y H:i') }}
</div>
--}}

<div style="clear: both; padding-bottom: 5px">&nbsp;</div>

<div class="center"><b>{{ $jobPositionProfile->name }}</b></div>
<div class="center"><b>{{ $jobPositionProfile->organizationalUnit->name }}</b></div>
<div class="center"><b>{{ $jobPositionProfile->jobPositionProfileSigns->where('event_type', 'subdir o depto')->first()->organizationalUnit->name }}</b></div>
<br>

<table class="siete">
    <tbody>
        <tr>
            <th align="left" colspan="4" style="background-color: #2f5496; color: white">I. IDENTIFICACIÓN DEL CARGO</th>
        </tr>    
        <tr>
            <th align="left" style="background-color: #b4c6e7" width="25%">NOMBRE DEL CARGO</th>
            <td colspan="3">{{ $jobPositionProfile->name }}</td>
        </tr>
        <tr>
            <th align="left" style="background-color: #b4c6e7">CANTIDAD DE CARGOS</th>
            <td colspan="3">{{ $jobPositionProfile->charges_number }}</td>
        </tr>
        <tr>
            <th align="left" style="background-color: #b4c6e7" width="25%">ESTAMENTO</th>
            <td width="25%">{{ $jobPositionProfile->estament->name }}</td>
            <th align="left" style="background-color: #b4c6e7" width="25%">AREA</th>
            <td width="25%">{{ $jobPositionProfile->area->name }}</td>
        </tr>
        <tr>
            <th align="left" style="background-color: #b4c6e7" width="25%">ESTABLECIMIENTO</th>
            <td>{{ $jobPositionProfile->organizationalUnit->establishment->name }}</td>
            <th align="left" style="background-color: #b4c6e7" width="25%">UNIDAD ORGANIZACIONAL</th>
            <td>{{ $jobPositionProfile->organizationalUnit->name }}</td>
        </tr>
        <tr>
            <th align="left" style="background-color: #b4c6e7" width="25%">SUBORDINADOS</th>
            <td colspan="3">
                {{ $jobPositionProfile->SubordinatesValue }}
            </td>
        </tr>
        <tr>
            <th align="left" style="background-color: #b4c6e7" width="25%">CALIDAD JURIDICA DE CONTRATO</th>
            <td>
                {{ $jobPositionProfile->contractualCondition->name }}
            </td>
            @if($jobPositionProfile->contractualCondition->name == 'Contrata' || $jobPositionProfile->contractualCondition->name == 'Titular')
            <th align="left" style="background-color: #b4c6e7">GRADO</th>
            <td>{{ $jobPositionProfile->degree }}</td>
            @endif
            @if($jobPositionProfile->contractualCondition->name == 'Honorarios')
            <th align="left" style="background-color: #b4c6e7">RENTA</th>
            <td>{{ $jobPositionProfile->salary }}</td>
            @endif
        </tr>
        <tr>
            <th align="left" style="background-color: #b4c6e7" width="25%">LEY</th>
            <td width="25%">{{ $jobPositionProfile->LawValue }}</td>
            <th align="left" style="background-color: #b4c6e7" width="25%">MARCO NORMATIVO</th>
            <td width="25%">
                @if($jobPositionProfile->dfl3)
                    {{ $jobPositionProfile->Dfl3Value }}
                @endif
                @if($jobPositionProfile->dfl29)
                    <br>{{ $jobPositionProfile->Dfl29Value }}
                @endif
                @if($jobPositionProfile->other_legal_framework)
                    <br>{{ $jobPositionProfile->Dfl29Value }}
                @endif
            </td>
        </tr>
        <tr>
            <th align="left" style="background-color: #b4c6e7" width="25%">HORARIO DE TRABAJO</th>
            <td colspan="3">
                {{ $jobPositionProfile->working_day }} hrs.
            </td>
        </tr>
    </tbody>
</table>

<br>

<table class="siete">
    <tbody>
        <tr>
            <th align="left" colspan="2" style="background-color: #2f5496; color: white">II. REQUISITOS FORMALES</th>
        </tr>   
        <tr>
            <th align="left" style="background-color: #b4c6e7" width="25%">REQUISITO GENERAL ({{ $jobPositionProfile->staffDecreeByEstament->StaffDecree->name }}/{{ $jobPositionProfile->staffDecreeByEstament->StaffDecree->year->format('Y') }})</th>
            <td>{{ $jobPositionProfile->staffDecreeByEstament->description }}</td>
        </tr>
        <tr>
            <th align="left" style="background-color: #b4c6e7" width="25%">REQUISITO ESPECÍFICO</th>
            <td>{{ $jobPositionProfile->specific_requirement }}</td>
        </tr>
        <tr>
            <th align="left" style="background-color: #b4c6e7" width="25%">CAPACITACIÓN PERTINENTE</th>
            <td>{{ $jobPositionProfile->training }}</td>
        </tr>
        <tr>
            <th align="left" style="background-color: #b4c6e7" width="25%">EXPERIENCIA CALIFICADA</th>
            <td>{{ $jobPositionProfile->experience }}</td>
        </tr>
        <tr>
            <th align="left" style="background-color: #b4c6e7" width="25%">COMPETENCIAS TÉCNICAS</th>
            <td>{{ $jobPositionProfile->technical_competence }}</td>
        </tr>
    </tbody>
</table>

<br>

<table class="siete">
    <tbody>
        <tr>
            <th colspan="2" align="left" style="background-color: #2f5496; color: white">III. PROPÓSITOS DEL CARGO</th>
        </tr> 
        <tr>
            <th colspan="2" align="left" style="background-color: #b4c6e7">Objetivo</th>
        </tr>
        <tr>
            <td colspan="2">{{ $jobPositionProfile->objective }}</td>
        </tr>
        <tr>
            <th colspan="2" align="left" style="background-color: #b4c6e7">Listado de Funciones</th>
        </tr>
        @foreach($jobPositionProfile->roles as $role)
        <tr>
            <td align="left" style="background-color: #b4c6e7" width="3%">{{ $loop->iteration }}</td>
            <td>{{ $role->description }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>

<table class="siete">
    <tbody>
        <tr>
            <th align="left" style="background-color: #2f5496; color: white">IV. ORGANIZACIÓN Y CONTEXTO DEL CARGO</th>
        </tr> 
        <tr>
            <th align="left" style="background-color: #b4c6e7">EQUIPO DE TRABAJO</th>
        </tr>
        <tr>
            <td>{{ $jobPositionProfile->working_team }}</td>
        </tr>
        <tr>
            <th align="left" style="background-color: #b4c6e7">Organigrama</th>
        </tr>
        <tr>
            <td><img id="chartImg" /></td>
        </tr>
    </tbody>
</table>

{{-- <div id="chart_div"></div> --}}

@endsection

@section('custom_js')

    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <!--
    <script type="text/javascript">
        
        google.charts.load('current', {packages:["orgchart"]});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Name');
            data.addColumn('string', 'Manager');
            data.addColumn('string', 'ToolTip');

            // For each orgchart box, provide the name, manager, and tooltip to show.
            data.addRows({!! $tree !!});

            // Create the chart.
            var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
            // Draw the chart, setting the allowHtml option to true for the tooltips.
            chart.draw(data, {'allowHtml':true});

            google.visualization.events.addListener(chart, 'ready', function () {
                var imgUri = chart.getImageURI();
                // do something with the image URI, like:
                document.getElementById('chartImg').src = imgUri;
            });
        }
    </script>
    -->
    <script type="text/javascript">
        function init(){
            google.load('visualization', 1.1, {
                packages: 'corechart',
                callback: 'drawVisualizationDaily'
            });
        }

        function drawVisualizationDaily() {
            // Create and populate the data table.
            var data = google.visualization.arrayToDataTable([
                ['Daily', 'Sales'],
                ['Mon', 4],
                ['Tue', 6],
                ['Wed', 6],
                ['Thu', 5],
                ['Fri', 3],
                ['Sat', 7],
                ['Sun', 7]
            ]);
            
            // Create and draw the visualization.
            var chart = new google.visualization.ColumnChart(document.getElementById('visualization'));
            google.visualization.events.addListener(chart, 'ready', function () {
                var imgUri = chart.getImageURI();
                // do something with the image URI, like:
                document.getElementById('chartImg').src = imgUri;
            });
            chart.draw(data, {
                title:"Daily Sales",
                width:500,
                height:400,
                hAxis: {title: "Daily"}
            });
        }  
        google.load('visualization', '1', {packages:['corechart'], callback: drawVisualizationDaily});
    </script>

@endsection
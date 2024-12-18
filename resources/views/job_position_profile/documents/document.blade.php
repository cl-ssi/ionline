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
<div class="center"><b>{{ ($jobPositionProfile->organizationalUnit) ? $jobPositionProfile->organizationalUnit->name : '' }}</b></div>
<div class="center"><b>
    {{  ($jobPositionProfile->jobPositionProfileSigns->where('event_type', 'subdir o depto')->first()) ?
        $jobPositionProfile->jobPositionProfileSigns->where('event_type', 'subdir o depto')->first()->organizationalUnit->name :
        ''
    }}</b></div>
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
            <th align="left" style="background-color: #b4c6e7" width="25%">FAMILIA DEL CARGO</th>
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
                {{ $jobPositionProfile->working_day == 'shift' ? 'Turno' : $jobPositionProfile->working_day.' hrs.' }}
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
            <th align="left" style="background-color: #b4c6e7" width="25%">REQUISITO GENERAL</th>
            <td>
                {{--
                <p style="white-space: pre-wrap;"> $jobPositionProfile->staffDecreeByEstament->description
                    {{ ($jobPositionProfile->staffDecreeByEstament) ? $jobPositionProfile->staffDecreeByEstament->description : '' }}
                </p>
                --}}

                @if($jobPositionProfile->staff_decree_by_estament_id)
                    <p style="white-space: pre-wrap;">{{ $jobPositionProfile->staffDecreeByEstament->description }}</p>
                @elseif($jobPositionProfile->general_requirement)
                    <p style="white-space: pre-wrap;">{!! $jobPositionProfile->general_requirement !!}</p>
                @else
                    <p style="white-space: pre-wrap;">{{-- $generalRequirements->description --}}</p>
                @endif
            </td>
        </tr>
        <tr>
            <th align="left" style="background-color: #b4c6e7" width="25%">PERTINENCIA DE FORMACIÓN</th>
            <td><p style="white-space: pre-wrap;">{{ $jobPositionProfile->specific_requirement }}</p></td>
        </tr>
        <tr>
            <th align="left" style="background-color: #b4c6e7" width="25%">CAPACITACIÓN PERTINENTE</p></th>
            <td><p style="white-space: pre-wrap;">{{ $jobPositionProfile->training }}</p></td>
        </tr>
        <tr>
            <th align="left" style="background-color: #b4c6e7" width="25%">EXPERIENCIA CALIFICADA</th>
            <td><p style="white-space: pre-wrap;">{{ $jobPositionProfile->experience }}</p></td>
        </tr>
        <tr>
            <th align="left" style="background-color: #b4c6e7" width="25%">COMPETENCIAS TÉCNICAS</th>
            <td><p style="white-space: pre-wrap;">{{ $jobPositionProfile->technical_competence }}</p></td>
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
            <td>
                <ul>
                    @foreach($jobPositionProfile->organizationalUnit->getTreeDocPdf() as $treeDocPdf)
                        @if($treeDocPdf['level'] == 1)
                            <br>
                            <li>
                                {{ $treeDocPdf['name'] }}
                                @if($treeDocPdf['level'] == $jobPositionProfile->organizationalUnit->level)
                                    <br><strong>(Funcionario)</strong>
                                    <br><br>
                                    <ul>
                                        @foreach($jobPositionProfile->organizationalUnit->childs as $child)
                                            <li>
                                                {{ $child->name }}
                                            </li>
                                        @endforeach
                                    </ul>    
                                @endif
                            </li>
                        @endif
                        @if($treeDocPdf['level'] == 2)
                            <br>
                            <ul>
                                <li>
                                    {{ $treeDocPdf['name'] }}
                                    @if($treeDocPdf['level'] == $jobPositionProfile->organizationalUnit->level)
                                        <br><strong>(Funcionario)</strong>
                                        <br><br>
                                        <ul>
                                            @foreach($jobPositionProfile->organizationalUnit->childs as $child)
                                                <li>
                                                    {{ $child->name }}
                                                </li>
                                            @endforeach
                                        </ul>    
                                    @endif
                                </li>
                            </ul>
                        @endif
                        @if($treeDocPdf['level'] == 3)
                            <br>
                            <ul>
                                <ul>
                                    <li>
                                        {{ $treeDocPdf['name'] }}
                                        @if($treeDocPdf['level'] == $jobPositionProfile->organizationalUnit->level)
                                            <br><strong>(Funcionario)</strong>
                                            <br><br>
                                            <ul>
                                                @foreach($jobPositionProfile->organizationalUnit->childs as $child)
                                                <li>
                                                    {{ $child->name }}
                                                </li>
                                                @endforeach
                                            </ul>    
                                        @endif
                                    </li>
                                </ul>
                            </ul>
                        @endif
                        @if($treeDocPdf['level'] == 4)  
                            <br>
                            <ul>
                                <ul>
                                    <ul>
                                        <li>
                                            {{ $treeDocPdf['name'] }}
                                            @if($treeDocPdf['level'] == $jobPositionProfile->organizationalUnit->level)
                                                <br><strong>(Funcionario)</strong>
                                                <br><br>
                                                <ul>
                                                    @foreach($jobPositionProfile->organizationalUnit->childs as $child)
                                                    <li>
                                                        {{ $child->name }}
                                                    </li>
                                                    @endforeach
                                                </ul>    
                                            @endif
                                        </li>
                                    </ul>
                                </ul>
                            </ul>
                        @endif
                        @if($treeDocPdf['level'] == 5)  
                            <br>
                            <ul>
                                <ul>
                                    <ul>
                                        <ul>
                                            <li>
                                                {{ $treeDocPdf['name'] }}
                                                @if($treeDocPdf['level'] == $jobPositionProfile->organizationalUnit->level)
                                                    <br><strong>(Funcionario)</strong>
                                                    <br><br>
                                                    <ul>
                                                        @foreach($jobPositionProfile->organizationalUnit->childs as $child)
                                                        <li>
                                                            {{ $child->name }}
                                                        </li>
                                                        @endforeach
                                                    </ul>    
                                                @endif
                                            </li>
                                        </ul>
                                    </ul>
                                </ul>
                            </ul>
                        @endif
                    @endforeach
                </ul>
            </td>
        </tr>
    </tbody>
</table>

<br>

<table class="siete">
    <tbody>
        <tr>
            <th align="left" style="background-color: #2f5496; color: white" colspan="3">V. RESPONSABILIDAD DEL CARGO</th>
        </tr>
        <tr>
            <th width="30%" style="background-color: #b4c6e7">Categorías de Responsabilidades</th>
            <th style="background-color: #b4c6e7">Descripción</th>
            <th style="background-color: #b4c6e7">Si/No</th>
        </tr>
        @foreach($jobPositionProfile->jppLiabilities as $Jppliability)
            <tr>
                <td style="background-color: #b4c6e7" width="30%">
                    {{ $Jppliability->liability->name }}
                </td>
                <td style="background-color: #b4c6e7" width="50%">
                    {{ $Jppliability->liability->description }}
                </td>
                <td align="center" width="20%">
                    {{ $Jppliability->YesNoValue }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<br>

<table class="siete">
    <tbody>
        <tr>
            <th align="left" style="background-color: #2f5496; color: white" colspan="2">
                VI. DICCIONARIO DE COMPETENCIAS DEL SERVICIO DE SALUD TARAPACÁ
            </th>
        </tr>
    </tbody>
</table>

<br>

<table class="siete">
    <tbody>
        <tr>
            <th align="left" style="background-color: #2f5496; color: white" colspan="2">
                Competencias Institucionales
            </th>
        </tr>
        <tr>
            <td width="30%" style="background-color: #b4c6e7">Orientación a la excelencia</td>
            <td align="justify">
                Habilidad para realizar un trabajo de calidad y excelencia, orientado a los objetivos actuales y futuros, 
                monitoreando permanentemente sus resultados y detectando y corrigiendo errores según corresponda
            </td>
        </tr>
        <tr>
            <td width="30%" style="background-color: #b4c6e7">Vocación de servicio público</td>
            <td align="justify">
                    Actuar teniendo como guía el compromiso con la sociedad y el bien común, actuando y decidiendo de manera ética y 
                    responsable (accountability), guiado por los valores y principios de probidad y transparencia que rigen al 
                    Servicio de Salud Tarapacá.
            </td>
        </tr>
        <tr>
            <td width="30%" style="background-color: #b4c6e7">Reflexión crítica y pensamiento sistémico</td>
            <td align="ustify">
                    Habilidad para analizar críticamente problemas, desafíos o decisiones, comprendiendo los hechos que componen un fenómeno 
                    y su relación, siendo capaz de escuchar y aceptar diversas visiones, y desarrollando ideas y modelos de relaciones sistémicas.
            </td>
        </tr>
        <tr>
            <td width="30%" style="background-color: #b4c6e7">Colaboración y trabajo en equipo</td>
            <td align="justify">
                    Habilidad para colaborar transversalmente, apoyar e integrar a equipos de trabajo inter e intra-áreas, 
                    con interdisciplinariedad y transdisciplinariedad, superando los silos organizacionales y facilitando 
                    el cumplimiento de los objetivos colectivos.
            </td>
        </tr>
        <tr>
            <td width="30%" style="background-color: #b4c6e7">Respeto y empatía</td>
            <td align="justify">
                    Habilidad para relacionarse de manera amable, cordial y respetuosa con los demás y realizar acciones 
                    para fomentar un ambiente de trabajo positivo basado en el respeto, la inclusividad, la valoración y 
                    la solidaridad con el otro, dando a conocer que entiende y comprende su problemática y entregando 
                    respuestas oportunas, equitativas, inclusivas, con igualdad de género y no discriminatoria, promoviendo 
                    la valoración de la diversidad.
            </td>
        </tr>
    </tbody>
</table>

<br>
<div style="page-break-before:always;">
    <table class="siete">
        <tbody>
            <tr>
                <th align="left" style="background-color: #2f5496; color: white" colspan="6">
                    Competencias Distintivas del Estamento
                </th>
            </tr>
            <tr style="background-color: #b4c6e7">
                <th rowspan="2" width="30%">Nombre</th>
                <th rowspan="2" width="50%">Descripción</th>
                <th colspan="4">Nivel requerido <br> (según corresponda)</th>
            </tr>
            <tr style="background-color: #b4c6e7">
                <th width="5%">
                    4
                    Desarrollo Bajo
                </th>
                <th width="5%">
                    3
                    Desarrollo Regular
                </th>
                <th width="5%">
                    2
                    Desarrollo Avanzado
                </th>
                <th width="5%">
                    1
                    Desarrollo Óptimo
                </th>
            </tr>
            @foreach($jobPositionProfile->jppExpertises as $jppExpertise)
                <tr>
                    <td style="background-color: #b4c6e7">{{ $jppExpertise->expertise->name }}</td>
                    <td align="justify">{{ $jppExpertise->expertise->description }}</td>
                    <td align="center">
                        @if($jppExpertise->value == 4)
                            X
                        @endif
                    </td>
                    <td align="center">
                        @if($jppExpertise->value == 3)
                            X
                        @endif
                    </td>
                    <td align="center">
                        @if($jppExpertise->value == 2)
                            X
                        @endif
                    </td>
                    <td align="center">
                        @if($jppExpertise->value == 1)
                            X
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if($jobPositionProfile->jobPositionProfileSigns)
<br>

<div style="text-align: left;">
    <table class="siete">
        <tbody>
            <tr>
                <th align="left" style="background-color: #2f5496; color: white" colspan="{{ $jobPositionProfile->jobPositionProfileSigns->count() }}">
                    Aprobaciones
                </th>
            </tr>
            <tr align="center">
                @foreach($jobPositionProfile->jobPositionProfileSigns as $sign)
                <td>
                    <b>{{ $sign->organizationalUnit->name }}</b> <br>
                    {{ ($sign->user) ? $sign->user->fullName : 'sin firmar' }} <br>
                    {{ ($sign->date_sign) ? $sign->date_sign->format('d-m-Y H:i:s') : 'pendiente' }}
                </td>
                @endforeach
            </tr>
        </tbody>
    </table>
</div>
@endif

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
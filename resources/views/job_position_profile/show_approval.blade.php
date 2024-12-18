<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" data-mutate-approach="sync"></script>

<h5><i class="fas fa-id-badge"></i> Perfil de Cargo</h5>
<h6>ID: {{ $jobPositionProfile->id }} 
@switch($jobPositionProfile->status)
    @case('saved')
        <span class="badge badge-primary">{{ $jobPositionProfile->StatusValue }}</span>
        @break

    @case('sent')
        <span class="badge badge-secondary">{{ $jobPositionProfile->StatusValue }}</span>
        @break

    @case('review')
        <span class="badge badge-info">{{ $jobPositionProfile->StatusValue }}</span>
        @break
                                
    @case('pending')
        <span class="badge badge-warning">{{ $jobPositionProfile->StatusValue }}</span>
        @break
                                
    @case('rejected')
        <span class="badge badge-danger">{{ $jobPositionProfile->StatusValue }}</span>
        @break

    @case('complete')
        <span class="badge badge-success">{{ $jobPositionProfile->StatusValue }}</span>
        @break
    @endswitch
<hr>

<h6><i class="fas fa-info-circle"></i> I. Identificación de Cargo</h6>
<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <tbody>
            <tr>
                <th class="table-active" width="25%">NOMBRE DEL CARGO</th>
                <td colspan="3">{{ $jobPositionProfile->name }}</td>
            </tr>
            <tr>
                <th class="table-active">CANTIDAD DE CARGOS</th>
                <td colspan="3">{{ $jobPositionProfile->charges_number }}</td>
            </tr>
            <tr>
                <th class="table-active" width="25%">ESTAMENTO</th>
                <td width="25%">{{ $jobPositionProfile->estament->name }}</td>
                <th class="table-active" width="25%">FAMILIA DEL CARGO</th>
                <td width="25%">{{ $jobPositionProfile->area->name }}</td>
            </tr>
            <tr>
                <th class="table-active" width="25%">ESTABLECIMIENTO</th>
                <td>{{ $jobPositionProfile->organizationalUnit->establishment->name }}</td>
                <th class="table-active" width="25%">UNIDAD ORGANIZACIONAL</th>
                <td>{{ $jobPositionProfile->organizationalUnit->name }}</td>
            </tr>
            <tr>
                <th class="table-active" width="25%">SUBORDINADOS</th>
                <td colspan="3">

                    {{ $jobPositionProfile->SubordinatesValue }}
                </td>
            </tr>
            <tr>
                <th class="table-active" width="25%">CALIDAD JURIDICA DE CONTRATO</th>
                <td>
                    {{ $jobPositionProfile->contractualCondition->name }}
                </td>
                @if($jobPositionProfile->contractualCondition->name == 'Contrata' || $jobPositionProfile->contractualCondition->name == 'Titular')
                    <th class="table-active">GRADO</th>
                    <td>{{ $jobPositionProfile->degree }}</td>
                @endif
                @if($jobPositionProfile->contractualCondition->name == 'Honorarios')
                    <th class="table-active">RENTA</th>
                    <td>{{ $jobPositionProfile->salary }}</td>
                @endif
            </tr>
            <tr>
                <th class="table-active" width="25%">LEY</th>
                <td width="25%">{{ $jobPositionProfile->LawValue }}</td>
                <th class="table-active" width="25%">MARCO NORMATIVO</th>
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
                <th class="table-active" width="25%">HORARIO DE TRABAJO</th>
                <td colspan="3">
                    {{ $jobPositionProfile->working_day == 'shift' ? 'Turno' : $jobPositionProfile->working_day.' hrs.' }}
                </td>
            </tr>
        </tbody>
    </table>
</div>

<br>

<h6><i class="fas fa-info-circle"></i> II. Requisitos Formales</h6>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <tbody>
            <tr>
                <th class="table-active" width="25%">REQUISITO GENERAL</th>
                <td>
                    {{--
                    <p style="white-space: pre-wrap;">
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
                <th class="table-active" width="25%">PERTINENCIA DE FORMACIÓN</th>
                <td><p style="white-space: pre-wrap;">{{ $jobPositionProfile->specific_requirement }}</p></td>
            </tr>
            <tr>
                <th class="table-active" width="25%">CAPACITACIÓN PERTINENTE</th>
                <td><p style="white-space: pre-wrap;">{{ $jobPositionProfile->training }}</p></td>
            </tr>
            <tr>
                <th class="table-active" width="25%">EXPERIENCIA CALIFICADA</th>
                <td><p style="white-space: pre-wrap;">{{ $jobPositionProfile->experience }}</p></td>
            </tr>
            <tr>
                <th class="table-active" width="25%">COMPETENCIAS TÉCNICAS</th>
                <td><p style="white-space: pre-wrap;">{{ $jobPositionProfile->technical_competence }}</p></td>
            </tr>
        </tbody>
    </table>
</div>

<br>

<h6><i class="fas fa-info-circle"></i> III. Propósitos del Cargo</h6>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <tbody>
            <tr>
                <th class="table-active" width="25%">Objetivo</th>
                <td>{{ $jobPositionProfile->objective }}</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <thead>
            <tr>
                <th class="table-active" colspan="2">Listado de Funciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobPositionProfile->roles as $role)
            <tr>
                <td class="text-center table-active" width="25%">{{ $loop->iteration }}</td>
                <td>{{ $role->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<h6><i class="fas fa-info-circle"></i> IV. Organización y Contexto del Cargo</h6>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <tbody>
            <tr>
                <th class="table-active" width="25%">EQUIPO DE TRABAJO</th>
                <td>{{ $jobPositionProfile->working_team }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="card">
    <div class="card-body">
        <div id="chart_div"></div>
    </div>
</div>

<br>

<h6><i class="fas fa-info-circle"></i> V. Responsabilidad del Cargo</h6>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <thead class="table-active text-center">
                <th width="30%">Categorías de Responsabilidades</th>
                <th width="50%">Descripción</th>
                <th width="20%">Si/No</th>
        </thead>
        <tbody>
            @foreach($jobPositionProfile->jppLiabilities as $Jppliability)
            <tr>
                <td width="30%">{{ $Jppliability->liability->name }}</td>
                <td width="50%">{{ $Jppliability->liability->description }}</td>
                <td class="text-center" width="20%">{{ $Jppliability->YesNoValue }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<br>

<h6><i class="fas fa-info-circle"></i> VI. Diccionario de Competencias del Servicio de Salud Tarapacá</h6>

<br>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <thead class="table-active">
                <tr>
                    <th colspan="2">Competencias Institucionales</th>
                </tr>
        </thead>
        <tbody>
            <tr>
                <td width="30%">Orientación a la excelencia</td>
                <td class="text-justify">
                    Habilidad para realizar un trabajo de calidad y excelencia, orientado a los objetivos actuales y futuros, 
                    monitoreando permanentemente sus resultados y detectando y corrigiendo errores según corresponda
                </td>
            </tr>
            <tr>
                <td width="30%">Vocación de servicio público</td>
                <td class="text-justify">
                    Actuar teniendo como guía el compromiso con la sociedad y el bien común, actuando y decidiendo de manera ética y 
                    responsable (accountability), guiado por los valores y principios de probidad y transparencia que rigen al 
                    Servicio de Salud Tarapacá.
                </td>
            </tr>
            <tr>
                <td width="30%">Reflexión crítica y pensamiento sistémico</td>
                <td class="text-justify">
                    Habilidad para analizar críticamente problemas, desafíos o decisiones, comprendiendo los hechos que componen un fenómeno 
                    y su relación, siendo capaz de escuchar y aceptar diversas visiones, y desarrollando ideas y modelos de relaciones sistémicas.
                </td>
            </tr>
            <tr>
                <td width="30%">Colaboración y trabajo en equipo</td>
                <td class="text-justify">
                    Habilidad para colaborar transversalmente, apoyar e integrar a equipos de trabajo inter e intra-áreas, 
                    con interdisciplinariedad y transdisciplinariedad, superando los silos organizacionales y facilitando 
                    el cumplimiento de los objetivos colectivos.
                </td>
            </tr>
            <tr>
                <td width="30%">Respeto y empatía</td>
                <td class="text-justify">
                    Habilidad para relacionarse de manera amable, cordial y respetuosa con los demás y realizar acciones 
                    para fomentar un ambiente de trabajo positivo basado en el respeto, la inclusividad, la valoración y 
                    la solidaridad con el otro, dando a conocer que entiende y comprende su problemática y entregando 
                    respuestas oportunas, equitativas, inclusivas, con igualdad de género y no discriminatoria, promoviendo 
                    la valoración de la diversidad.
                </td>
            </tr>
        </tbody>
    </table>
</div>

<h6 class="small"><b>Competencias Distintivas del Estamento</b></h6>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <thead class="table-active">
            <tr class="text-center">
                <th rowspan="2" width="30%">Nombre</th>
                <th rowspan="2" width="50%">Descripción</th>
                <th colspan="4">Nivel requerido <br> (según corresponda)</th>
            </tr>
            <tr class="text-center">
                <th width="5%">
                    4 <br>
                    Desarrollo Bajo
                </th>
                <th width="5%">
                    3 <br>
                    Desarrollo Regular
                </th>
                <th width="5%">
                    2 <br>
                    Desarrollo Avanzado
                </th>
                <th width="5%">
                    1 <br>
                    Desarrollo Óptimo
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($jobPositionProfile->jppExpertises as $jppExpertise)
            <tr>
                <td>{{ $jppExpertise->expertise->name }}</td>
                <td>{{ $jppExpertise->expertise->description }}</td>
                <td class="text-center align-middle">
                    @if($jppExpertise->value == 4)
                        <i class="far fa-check-square fa-2x"></i>
                    @endif
                </td>
                <td class="text-center align-middle">
                    @if($jppExpertise->value == 3)
                        <i class="far fa-check-square fa-2x"></i>
                    @endif
                </td>
                <td class="text-center align-middle">
                    @if($jppExpertise->value == 2)
                        <i class="far fa-check-square fa-2x"></i>
                    @endif
                </td>
                <td class="text-center align-middle">
                    @if($jppExpertise->value == 1)
                        <i class="far fa-check-square fa-2x"></i>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<br>

<h6><i class="fas fa-signature"></i> Proceso de aprobación.</h6>

@if(!$jobPositionProfile->approvals->isEmpty())

<div class="table-responsive">
    <table class="table table-bordered table-sm small">
        <thead>
            <tr class="text-center">
                @foreach($jobPositionProfile->approvals as $approval)
                <th width="" class="table-secondary">{{ $approval->sentToOu->name }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr class="text-center">
                @foreach($jobPositionProfile->approvals as $approval)
                <td>
                    @switch($approval->StatusInWords)
                        @case('Pendiente')
                            <i class="fas fa-clock"></i> {{ $approval->StatusInWords }}
                            @break
                        @case('Aprobado')
                            <span class="d-inline-block" style="color: green;">
                                <i class="fas fa-check-circle"></i> {{ $approval->StatusInWords }}
                            </span>
                            @break
                        @case('Rechazado')
                            <span class="d-inline-block" style="color: tomato;">
                                <i class="fas fa-check-circle"></i> {{ $approval->StatusInWords }}
                            </span>
                            @break
                    @endswitch
                    <br>
                    @if($approval->StatusInWords == 'Aprobado' || $approval->StatusInWords == 'Rechazado')
                        <i class="fas fa-user"></i> {{ ($approval->approver) ? $approval->approver->fullName : '' }} <br>
                        <i class="fas fa-calendar-alt"></i> {{ ($approval->approver_at) ? $approval->approver_at->format('d-m-Y H:i:s') : '' }}
                    @endif
                </td>           
                @endforeach
            </tr>
        <tbody>
    </table>
</div>
@else
<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <tbody>
            <tr>
                @foreach($jobPositionProfile->jobPositionProfileSigns as $sign)
                <td class="table-active text-center">
                    <strong>{{ $sign->organizationalUnit->name }}</strong><br>
                </td>
                @endforeach
            </tr>
            <tr>
                @foreach($jobPositionProfile->jobPositionProfileSigns as $sign)
                <td align="center">
                    @if($sign->status == 'pending' || $sign->status == NULL)
                        Estado: <i class="fas fa-clock"></i> {{ $sign->StatusValue }} <br><br>
                    @endif

                    @if($sign->status == 'accepted')
                        <span style="color: green;">
                            <i class="fas fa-check-circle"></i> {{ $sign->StatusValue }}
                        </span> 
                        <br>
                        <i class="fas fa-user"></i> {{ $sign->user->fullName }}<br>
                        <i class="fas fa-calendar-alt"></i> {{ $sign->date_sign->format('d-m-Y H:i:s') }}<br>
                    @endif

                    @if($sign->status == 'rejected')
                        <span style="color: Tomato;">
                            <i class="fas fa-times-circle fa-2x"></i> {{ $sign->StatusValue }}
                        </span> 
                        <br>
                        <i class="fas fa-user"></i> {{ $sign->user->fullName }}<br>
                        <i class="fas fa-calendar-alt"></i> {{ $sign->date_sign->format('d-m-Y H:i:s') }}<br>
                    @endif
                </td>
                @endforeach
            </tr>
        </tbody>
    </table>
</div>
@endif

<hr />
<br>

<div class="row">
    <div class="col-md-3">
        <h5><i class="fas fa-comment mt-2"></i> Canal de Comunicación</h5>
    </div>
    <div class="col-md-9">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
            <i class="fas fa-plus"></i> Agregar Mensaje
        </button>
    </div>
</div>

@include('job_position_profile.modals.message')

<br>

@livewire('job-position-profile.show-messages', [
    'jobPositionProfile'    => $jobPositionProfile
])

@can(['Job Position Profile: audit'])
<hr/>
<div style="height: 300px; overflow-y: scroll;">
    @include('partials.audit', ['audits' => $jobPositionProfile->audits()] )
</div>
@endcan

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {packages:["orgchart"]});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
            
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        data.addColumn('string', 'ToolTip');

        // For each orgchart box, provide the name, manager, and tooltip to show.
        data.addRows({!! $jobPositionProfile->organizationalUnit->treeWithChilds->toJson() !!});

        // Create the chart.
        var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
        // Draw the chart, setting the allowHtml option to true for the tooltips.
        chart.draw(data, {'allowHtml':true});
    }
</script>
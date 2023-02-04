@extends('layouts.app')

@section('title', 'Nuevo Staff')

@section('content')

@include('job_position_profile.partials.nav')

<h5><i class="fas fa-id-badge"></i> Perfil de Cargo N° {{ $jobPositionProfile->id }}</h5>
<h6>{{ $jobPositionProfile->name }}</h6>

<br>

<h6>Progreso</h5>

<div class="table-responsive">
    <table class="table table-sm small text-center">
        <thead class="table-info">
            <tr>
                <th>I. IDENTIFICACIÓN DEL CARGO</th>
                <th>II. REQUISITOS FORMALES</th>
                <th>III. PROPÓSITOS DEL CARGO</th>
                <th>IV. ORGANIZACIÓN Y CONTEXTO DEL CARGO</th>
                <th>V. RESPONSABILIDAD DEL CARGO</th>
                <th>VI. MAPA DE COMPETENCIAS DEL S.S.I</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <span style="color: green;">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </span>
                    <a class="btn btn-link mb-2" href="{{ route('job_position_profile.edit', $jobPositionProfile) }}">Ir</a>
                </td>
                <td>
                    @if($jobPositionProfile->staff_decree_by_estament_id)
                        <span style="color: green;">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </span>
                        <a class="btn btn-link mb-2" href="{{ route('job_position_profile.edit_formal_requirements', $jobPositionProfile) }}">Ir</a>
                    @else
                        <i class="fas fa-clock fa-2x"></i>
                    @endif
                </td>
                <td>
                    @if($jobPositionProfile->roles->count() > 0 && $jobPositionProfile->objective)
                        <span style="color: green;">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </span>
                        <a class="btn btn-link mb-2" href="{{ route('job_position_profile.edit_objectives', $jobPositionProfile) }}">Ir</a>
                    @else
                        <i class="fas fa-clock fa-2x"></i>
                    @endif
                </td>
                <td>
                    @if($jobPositionProfile->working_team)
                        <span style="color: green;">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </span>
                        <a class="btn btn-link mb-2" href="{{ route('job_position_profile.edit_organization', $jobPositionProfile) }}">Ir</a>
                    @else
                        <i class="fas fa-clock fa-2x"></i>
                    @endif
                </td>
                <td>
                    @if($jobPositionProfile->jppLiabilities->count() > 0)
                        <span style="color: green;">
                                <i class="fas fa-check-circle fa-2x"></i>
                        </span>
                        <a class="btn btn-link mb-2" href="{{ route('job_position_profile.edit_liabilities', $jobPositionProfile) }}">Ir</a>
                    @else 
                        <i class="fas fa-clock fa-2x"></i>
                    @endif
                </td>
                <td>
                    @if($jobPositionProfile->jppExpertises->count() > 0)
                        <span style="color: green;">
                                <i class="fas fa-check-circle fa-2x"></i>
                        </span>
                        <a class="btn btn-link mb-2" href="{{ route('job_position_profile.edit_expertise_map', $jobPositionProfile) }}">Ir</a>
                    @else
                        <i class="fas fa-clock fa-2x"></i>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>

<hr>

<form method="POST" class="form-horizontal" action="{{ route('job_position_profile.update_organization', $jobPositionProfile) }}" enctype="multipart/form-data"/>
    @csrf
    @method('PUT')
    <h6 class="small"><b>IV. ORGANIZACIÓN Y CONTEXTO DEL CARGO.</b></h6> 
    <br>

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-12">  
            <label for="for_working_team">Equipo de Trabajo</label>
            <textarea class="form-control" id="for_working_team" name="working_team" rows="3" required>{{ $jobPositionProfile->working_team }}</textarea>
        </filedset>
    </div>

    <br>

    <h6 class="small"><b>Organigrama.</b></h6> 

    <div id="chart_div"></div>

    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>
</form>

<br/><br />

<hr />

<div class="row">
    <div class="col">
        <a class="btn btn-info float-left" href="{{ route('job_position_profile.edit_objectives', $jobPositionProfile) }}">
            <i class="fas fa-chevron-left"></i> III. Propósitos del Cargo
        </a>
        <a class="btn btn-info float-right" href="{{ route('job_position_profile.edit_liabilities', $jobPositionProfile) }}">
            <i class="fas fa-chevron-right"></i> V. Responsabilidad del Cargo
        </a>
    </div>
</div>

{{-- dd($tree) --}}

<hr/>
<div style="height: 300px; overflow-y: scroll;">
    @include('partials.audit', ['audits' => $jobPositionProfile->audits()] )
</div>

@endsection

@section('custom_js')

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
            data.addRows({!! $tree !!});

            // Create the chart.
            var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
            // Draw the chart, setting the allowHtml option to true for the tooltips.
            chart.draw(data, {'allowHtml':true});
        }
    </script>

@endsection

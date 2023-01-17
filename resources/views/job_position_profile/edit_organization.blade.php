@extends('layouts.app')

@section('title', 'Nuevo Staff')

@section('content')

@include('job_position_profile.partials.nav')

<h5><i class="fas fa-id-badge"></i> Perfil de Cargo N° {{ $jobPositionProfile->id }}</h5>
<h6>{{ $jobPositionProfile->name }}</h6>

<br>

<h6>Progreso</h5>



<hr>

<form method="POST" class="form-horizontal" action="{{-- route('job_position_profile.update_objectives', $jobPositionProfile) --}}" enctype="multipart/form-data"/>
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
        <a class="btn btn-info float-right" href="{{-- route('job_position_profile.edit_organization', $jobPositionProfile) --}}">
            <i class="fas fa-chevron-right"></i> 
        </a>
    </div>
</div>

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
            data.addRows([
            [{'v':'Mike', 'f':'Mike<div style="color:red; font-style:italic">President</div>'},'', 'The President'],
            [{'v':'Jim', 'f':'Jim<div style="color:red; font-style:italic">Vice President</div>'}, 'Mike', 'VP'],
            ['Alice', 'Mike', ''],
            ['Bob', 'Jim', 'Bob Sponge'],
            ['Carol', 'Bob', '']
            ]);

            // Create the chart.
            var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));
            // Draw the chart, setting the allowHtml option to true for the tooltips.
            chart.draw(data, {'allowHtml':true});
        }
    </script>

@endsection

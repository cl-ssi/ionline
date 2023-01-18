@extends('layouts.app')

@section('title', 'Nuevo Staff')

@section('content')

@include('job_position_profile.partials.nav')

<h5><i class="fas fa-id-badge"></i> Perfil de Cargo N° {{ $jobPositionProfile->id }}</h5>
<h6>{{ $jobPositionProfile->name }}</h6>

<br>

<h6>Progreso</h5>

<table class="table table-sm small text-center">
    <thead class="table-info">
        <tr>
            <th>I. IDENTIFICACIÓN DEL CARGO</th>
            <th>II. REQUISITOS FORMALES</th>
            <th>III. PROPÓSITOS DEL CARGO</th>
            <th>IV. ORGANIZACIÓN Y CONTEXTO DEL CARGO</th>
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
                @if($jobPositionProfile->roles->count() > 0)
                    <span style="color: green;">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </span>
                    <a class="btn btn-link mb-2" href="{{ route('job_position_profile.edit_objectives', $jobPositionProfile) }}">Ir</a>
                @else
                    <i class="fas fa-clock fa-2x"></i>
                @endif
            </td>
            <td>
                
            </td>
        </tr>
    </tbody>
</table>

<hr>

<form method="POST" class="form-horizontal" action="{{ route('job_position_profile.update_objectives', $jobPositionProfile) }}" enctype="multipart/form-data"/>
    @csrf
    @method('PUT')
    <h6 class="small"><b>III. PROPÓSITOS DEL CARGO</b></h6> 
    <br>

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-12">  
            <label for="for_objective">Objetivo</label>
            <textarea class="form-control" id="for_objective" name="objective" rows="3" required>{{ $jobPositionProfile->objective }}</textarea>
        </filedset>
    </div>

    <br>

    @livewire('job-position-profile.roles', [
        'jobPositionProfile' => $jobPositionProfile
    ])

    <br>

    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>
</form>

<br/><br />

<hr />

<div class="row">
    <div class="col">
        <a class="btn btn-info float-left" href="{{ route('job_position_profile.edit_formal_requirements', $jobPositionProfile) }}">
            <i class="fas fa-chevron-left"></i> II. Requisitos Formales
        </a>
        <a class="btn btn-info float-right" href="{{ route('job_position_profile.edit_organization', $jobPositionProfile) }}">
            <i class="fas fa-chevron-right"></i> IV. Organización y Contexto del Cargo
        </a>
    </div>
</div>

<hr/>
<div style="height: 300px; overflow-y: scroll;">
    @include('partials.audit', ['audits' => $jobPositionProfile->audits()] )
</div>



@endsection

@section('custom_js')

@endsection

@extends('layouts.bt4.app')

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
                <th>VI. DICCIONARIO DE COMPETENCIAS DEL S.S.T</th>
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
                    @if($jobPositionProfile->contractual_condition_id != 2 && ($jobPositionProfile->staff_decree_by_estament_id || $jobPositionProfile->general_requirement))
                        <span style="color: green;">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </span>
                        <a class="btn btn-link mb-2" href="{{ route('job_position_profile.edit_formal_requirements', $jobPositionProfile) }}">Ir</a>
                    @elseif($jobPositionProfile->contractual_condition_id == 2)
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

<form method="POST" class="form-horizontal" action="{{ route('job_position_profile.update_formal_requirements', 
      ['jobPositionProfile' => $jobPositionProfile, 'generalRequirements' => $generalRequirements]) }}" enctype="multipart/form-data"/>
    @csrf
    @method('PUT')
    <h6 class="small"><b>II. REQUISITOS FORMALES </b></h6> 
    <br>
    
    Requisito General
    <br><br>
    <div class="alert alert-secondary text-justify" role="alert">
        @if($jobPositionProfile->staff_decree_by_estament_id)
            <p style="white-space: pre-wrap;">{{ $jobPositionProfile->staffDecreeByEstament->description }}</p>
        @elseif($jobPositionProfile->general_requirement)
            <p style="white-space: pre-wrap;">{!! $jobPositionProfile->general_requirement !!}</p>
        @else
            <p style="white-space: pre-wrap;">{!! $generalRequirements->description !!}</p>
        @endif
    </div>

    @if($jobPositionProfile->law == '19664')
    <div class="form-row" hidden>
        <fieldset class="form-group col-12 col-md-12">  
            <label for="for_specific_requirement">Requisito General</label>
            <textarea class="form-control" id="for_general_requirement" name="general_requirement" rows="3">{{ $generalRequirements->description }}</textarea>
        </filedset>
    </div>
    @endif

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-12">  
            <label for="for_specific_requirement">Pertinencia de Formación</label>
            <textarea class="form-control" id="for_specific_requirement" name="specific_requirement" rows="3" required>{{ $jobPositionProfile->specific_requirement }}</textarea>
        </filedset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-12">  
            <label for="for_training">Capacitación Pertinente</label>
            <textarea class="form-control" id="for_training" name="training" rows="3" required>{{ $jobPositionProfile->training }}</textarea>
        </filedset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-12">  
            <label for="experience">Experiencia Calificada</label>
            <textarea class="form-control" id="for_experience" name="experience" rows="3" required>{{ $jobPositionProfile->experience }}</textarea>
        </filedset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-12 col-md-12">  
            <label for="for_technical_competence">Competencias Técnicas</label>
            <textarea class="form-control" id="for_technical_competence" name="technical_competence" rows="3" required>{{ $jobPositionProfile->technical_competence }}</textarea>
        </filedset>
    </div>

    <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>
</form>

<br/><br />

<hr />

<div class="row">
    <div class="col">
        <a class="btn btn-info float-left" href="{{ route('job_position_profile.edit', $jobPositionProfile) }}">
            <i class="fas fa-chevron-left"></i> I. Identificación del Cargo
        </a>
        <a class="btn btn-info float-right" href="{{ route('job_position_profile.edit_objectives', $jobPositionProfile) }}">
            <i class="fas fa-chevron-right"></i> III. Propósitos del Cargo
        </a>
    </div>
</div>

<hr/>
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

@endsection

@section('custom_js')

@endsection

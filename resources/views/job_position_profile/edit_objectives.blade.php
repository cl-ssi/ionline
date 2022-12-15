@extends('layouts.app')

@section('title', 'Nuevo Staff')

@section('content')

@include('job_position_profile.partials.nav')

<h5><i class="fas fa-id-badge"></i> Perfil de Cargo N° {{ $jobPositionProfile->id }}</h5>
<h6>{{ $jobPositionProfile->name }}</h6>

<br>

<h6>Progreso</h5>



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
    @include('partials.audit', ['audits' => $jobPositionProfile->audits] )
</div>



@endsection

@section('custom_js')

@endsection

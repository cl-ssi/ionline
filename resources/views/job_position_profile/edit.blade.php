@extends('layouts.app')

@section('title', 'Nuevo Staff')

@section('content')

@include('job_position_profile.partials.nav')

<h5><i class="fas fa-id-badge"></i> Perfil de Cargo N°</h5>

<br>

<h6>Progreso</h5>

<table class="table table-sm small text-center">
    <thead class="table-info">
        <tr>
            <th>I.Identificación del Cargo</th>
            <th>II. REQUISITOS FORMALES</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <span style="color: green;">
                    <i class="fas fa-check-circle fa-2x"></i>
                </span>
            </td>
            <td>
                @if($jobPositionProfile->staff_decree_by_estament_id)
                <span style="color: green;">
                    <i class="fas fa-check-circle fa-2x"></i>
                </span>
                @else
                    <i class="fas fa-clock fa-2x"></i>
                @endif
            </td>
        </tr>
    </tbody>
</table>

<hr>

@livewire('job-position-profile.create-job-position-profiles', [
    'action'                => 'update',
    'jobPositionProfile'    => $jobPositionProfile
])

<br/><br />

<hr />

<div class="row">
    <div class="col">
        <a class="btn btn-info float-right" href="{{ route('job_position_profile.edit_formal_requirements', $jobPositionProfile) }}">
            <i class="fas fa-chevron-right"></i> II. Requisitos Formales
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

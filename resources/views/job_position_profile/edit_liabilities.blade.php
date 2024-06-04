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
<br>

<h6 class="small"><b>V. RESPONSABILIDAD DEL CARGO</b></h6> 

<br>

@if($jppLiabilities->count() > 0)

    <form method="POST" class="form-horizontal" action="{{ route('job_position_profile.update_liabilities', $jobPositionProfile) }}" enctype="multipart/form-data"/>
        @csrf
        @method('PUT')
        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered">
                <thead>
                    <tr class="text-center">
                        <th width="30%">Categorías de responsabilidades</th>
                        <th width="50%">Descripción</th>
                        <th width="20%">SI/NO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jppLiabilities as $jppLiability)
                    <tr>
                        <td>{{ $jppLiability->liability->name }}</td>
                        <td>{{ $jppLiability->liability->description }}</td>
                        <td>
                            <div class="text-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="values[{{ $loop->iteration }}]" id="for_value_{{ $loop->iteration }}" value="1" 
                                        {{ ($jppLiability->value == 1)?'checked':'' }} required>
                                    <label class="form-check-label" for="for_subordinates">Si</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="values[{{ $loop->iteration }}]" id="for_value_{{ $loop->iteration }}" value="0" 
                                        {{ ($jppLiability->value == 0)?'checked':'' }} required>
                                    <label class="form-check-label" for="for_subordinates">No</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <br>

        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </form>

@else

    <form method="POST" class="form-horizontal" action="{{ route('job_position_profile.store_liabilities', $jobPositionProfile) }}" enctype="multipart/form-data"/>
        @csrf
        @method('POST')
        <div class="table-responsive">
            <table class="table table-sm table-striped table-bordered">
                <thead>
                    <tr class="text-center">
                        <th width="30%">Categorías de responsabilidades</th>
                        <th width="50%">Descripción</th>
                        <th width="20%">SI/NO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($liabilities as $liability)
                    <tr>
                        <td>{{ $liability->name }}</td>
                        <td>{{ $liability->description }}</td>
                        <td>
                            <div class="text-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="values[{{ $loop->iteration }}]" id="for_value_{{ $loop->iteration }}" value="1" 
                                        {{-- ($jobPositionProfile && $jobPositionProfile->subordinates == 1)?'checked':'' --}} required>
                                    <label class="form-check-label" for="for_subordinates">Si</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="values[{{ $loop->iteration }}]" id="for_value_{{ $loop->iteration }}" value="0" 
                                        {{-- ($jobPositionProfile && $jobPositionProfile->subordinates == 0)?'checked':'' --}} required>
                                    <label class="form-check-label" for="for_subordinates">No</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <br>

        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </form>

@endif

<hr />

<div class="row">
    <div class="col">
        <a class="btn btn-info float-left" href="{{ route('job_position_profile.edit_organization', $jobPositionProfile) }}">
            <i class="fas fa-chevron-left"></i> IV. Organización y Contexto del Cargo
        </a>
        <a class="btn btn-info float-right" href="{{ route('job_position_profile.edit_expertise_map', $jobPositionProfile) }}">
            <i class="fas fa-chevron-right"></i> VI. Diccionario de Competencias del S.S.I.
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

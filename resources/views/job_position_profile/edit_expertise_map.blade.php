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

@if(($jobPositionProfile->staff_decree_by_estament_id == NULL && $jobPositionProfile->general_requirement == NULL) ||
    ($jobPositionProfile->roles->count() <= 0 && $jobPositionProfile->objective == NULL) ||
    $jobPositionProfile->working_team == NULL ||
    $jobPositionProfile->jppLiabilities->count() <= 0 ||
    $jobPositionProfile->jppExpertises->count() <= 0)
    <div class="alert alert-danger alert-dismissible fade show">
        Estimado Usuario: Favor completar la siguiente información: <br><br>
        @if($jobPositionProfile->staff_decree_by_estament_id == NULL && $jobPositionProfile->general_requirement == NULL)
            <b>II. REQUISITOS FORMALES</b><br>
        @endif
        @if($jobPositionProfile->roles->count() <= 0 && $jobPositionProfile->objective == NULL)
            <b>III. PROPÓSITOS DEL CARGO</b><br>
        @endif
        @if($jobPositionProfile->working_team == NULL)
            <b>IV. ORGANIZACIÓN Y CONTEXTO DEL CARGO</b><br>
        @endif
        @if($jobPositionProfile->jppLiabilities->count() <= 0)
            <b>V. RESPONSABILIDAD DEL CARGO</b><br>
        @endif
        @if($jobPositionProfile->jppExpertises->count() <= 0)
            <b>VI. DICCIONARIO DE COMPETENCIAS DEL S.S.I</b><br>
        @endif
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<h6 class="small"><b>VI. DICCIONARIO DE COMPETENCIAS DEL SERVICIO DE SALUD TARAPACÁ</b></h6> 

<br>

<h6 class="small"><b>Competencias Distintivas del Estamento</b></h6>

<div class="alert alert-info" role="alert">
  El diccionario de competencias se presenta de acuerdo al estamento <b>{{ $jobPositionProfile->estament->name }}</b> y área <b>{{ $jobPositionProfile->area->name }}</b>
</div>

{{-- dd($jobPositionProfile->jppExpertises->first()->expertise->name) --}}

@if($jobPositionProfile->jppExpertises->count() > 0)
    <form method="POST" class="form-horizontal" action="{{ route('job_position_profile.update_expertises', $jobPositionProfile) }}" enctype="multipart/form-data"/>
        @csrf
        @method('PUT')
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm small">
                <thead class="table-active">
                    <tr class="text-center">
                        <th rowspan="2" width="30%">Nombre</th>
                        <th rowspan="2" width="50%">Descripción</th>
                        <th colspan="4">Nivel requerido (según corresponda)</th>
                    </tr>
                    <tr class="text-center">
                        <th colspan="4">Valor <i class="fas fa-info-circle" type="button" data-toggle="modal" data-target="#valueExpertiseGuideModal"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobPositionProfile->jppExpertises as $jppExpertise)
                    <tr>
                        <td>{{ $jppExpertise->expertise->name }}</td>
                        <td>{{ $jppExpertise->expertise->description }}</td>
                        <td>
                            <div class="text-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="values[{{ $jppExpertise->expertise_id }}]" id="for_value_{{ $jppExpertise->expertise_id }}" value="4" 
                                    {{ ($jppExpertise->value == 4)?'checked':'' }} required>
                                    <label class="form-check-label" for="for_value">4</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="values[{{ $jppExpertise->expertise_id }}]" id="for_value_{{ $jppExpertise->expertise_id }}" value="3" 
                                    {{ ($jppExpertise->value == 3)?'checked':'' }} required>                                    
                                    <label class="form-check-label" for="for_value">3</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="values[{{ $jppExpertise->expertise_id }}]" id="for_value_{{ $jppExpertise->expertise_id }}" value="2" 
                                    {{ ($jppExpertise->value == 2)?'checked':'' }} required>                                    
                                    <label class="form-check-label" for="for_value">2</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="values[{{ $jppExpertise->expertise_id }}]" id="for_value_{{ $jppExpertise->expertise_id }}" value="1" 
                                    {{ ($jppExpertise->value == 1)?'checked':'' }} required>                                    
                                    <label class="form-check-label" for="for_value">1</label>
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
    <form method="POST" class="form-horizontal" action="{{ route('job_position_profile.store_expertises', $jobPositionProfile) }}" enctype="multipart/form-data"/>
        @csrf
        @method('POST')
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm small">
                <thead class="table-active">
                    <tr class="text-center">
                        <th rowspan="2" width="30%">Nombre</th>
                        <th rowspan="2" width="50%">Descripción</th>
                        <th colspan="4">Nivel requerido (según corresponda)</th>
                    </tr>
                    <tr class="text-center">
                        <th colspan="4">Valor <i class="fas fa-info-circle" type="button" data-toggle="modal" data-target="#valueExpertiseGuideModal"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expertises as $expertise)
                    <tr>
                        <td>{{ $expertise->name }}</td>
                        <td>{{ $expertise->description }}</td>
                        <td>
                            <div class="text-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="values[{{ $expertise->id }}]" id="for_value_{{ $loop->iteration }}" value="4" required>
                                    <label class="form-check-label" for="for_value">4</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="values[{{ $expertise->id }}]" id="for_value_{{ $loop->iteration }}" value="3" required>                                    
                                    <label class="form-check-label" for="for_value">3</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="values[{{ $expertise->id }}]" id="for_value_{{ $loop->iteration }}" value="2" required>                                    
                                    <label class="form-check-label" for="for_value">2</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="values[{{ $expertise->id }}]" id="for_value_{{ $loop->iteration }}" value="1" required>                                    
                                    <label class="form-check-label" for="for_value">1</label>
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

<!-- Modal Guía -->
@include('job_position_profile.modals.value_expertise_guide')

<br>

@if(count($jobPositionProfile->approvals) == 0)
<div class="row">
    <div class="col">
        <form method="POST" class="form-horizontal" action="{{ route('job_position_profile.sign.store', $jobPositionProfile) }}" enctype="multipart/form-data"/>
            @csrf
            @method('POST')
            <button class="btn btn-success float-right" type="submit">
                <i class="fas fa-share"></i> Enviar Formulario
            </button>
        </form>
    </div>
</div>
@endif

<hr />

<div class="row">
    <div class="col">
        <a class="btn btn-info float-left" href="{{ route('job_position_profile.edit_liabilities', $jobPositionProfile) }}">
            <i class="fas fa-chevron-left"></i> V. Responsabilidad del Cargo
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

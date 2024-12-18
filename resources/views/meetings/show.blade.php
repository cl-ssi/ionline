@extends('layouts.bt5.app')

@section('title', 'Reuniones')

@section('content')

@include('meetings.partials.nav')

<h5>
    <i class="fas fa-users fa-fw"></i> Mi Reunión ID: {{ $meeting->id }}
</h5>

<h6>
    @switch($meeting->StatusValue)
        @case('Guardado')
            <span class="badge text-bg-primary">{{ $meeting->StatusValue }}</span>
            @break

        @case('Derivado SGR')
            <span class="badge text-bg-primary">{{ $meeting->StatusValue }} <i class="fas fa-rocket"></i></span>
            @break
    @endswitch
</h6>

<h6 class="mt-4"><b>1- Descripción reunión</b></h6>

<div class="table-responsive">
    <table class="table table-bordered table-sm small">
        <tbody>
            <tr>
                <th class="table-secondary" width="25%">Fecha Reunión</th>
                <td colspan="3">{{ $meeting->date }}</td>
            </tr>
            <tr>
                <th class="table-secondary" width="25%">Tipo</th>
                <td colspan="3">{{ $meeting->TypeValue }}</td>
            </tr>
            <tr>
                <th class="table-secondary" width="25%">Asunto</th>
                <td colspan="3">{{ $meeting->subject }}</td>
            </tr>
            <tr>
                <th class="table-secondary" width="25%">Medio</th>
                <td colspan="3">{{ $meeting->MechanismValue }}</td>
            </tr>
            <tr>
                <th class="table-secondary" width="25%">Hora Inicio</th>
                <td width="25%">{{ $meeting->start_at }}</td>
                <th class="table-secondary" width="25%">Hora Termino</th>
                <td width="25%">{{ $meeting->end_at }}</td>
            </tr>
            <tr>
                <th class="table-secondary" width="25%">Usuario Creador / Fecha Creación</th>
                <td colspan="3">{{ $meeting->userCreator->fullName }} / {{ $meeting->created_at->format('d-m-Y H:i:s') }}</td>
            </tr>
        </tbody>
    </table>
</div>

<h6 class="mt-4"><b>2- Asociaciones de Funcionarios / Federaciones Regionales / Reunión Mesas y Comités de Trabajos</b></h6>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm small">
        <thead class="table-info">
            <tr class="text-center" >
                <th width="10%">#</th>
                <th width="40%">Tipo</th>
                <th width="35%">Nombre</th>
            </tr>
        </thead>
        <tbody>
            @foreach($meeting->groupings as $grouping)
                <tr>
                    <th class="text-center">{{ $loop->iteration }}</th>
                    <td class="text-center">
                        @switch($grouping->type)
                            @case('asociaciones funcionarios')
                                Asociaciones de Funcionarios                              
                                @break
                                
                            @case('federaciones regionales')
                                Federaciones Regionales
                                @break

                            @case('mesas comites de trabajo')
                                Reunión Mesas y Comités de Trabajos
                                @break
                        @endswitch
                    </td>
                    <td>{{ $grouping->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<h6 class="mt-4"><b>3- Compromisos</b></h6>

<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm small">
        <thead class="table-info">
            <tr class="text-center">
                <th width="3%">#</th>
                <th width="40%">Descripción</th>
                <th width="25%">Usuario / Unidad Organizacional</th>
                <th width="7%">Fecha límite</th>
                <th width="10%">Estado <i class="fas fa-rocket"></i> SGR</th>
            </tr>
        </thead>
        <tbody>
            @foreach($meeting->commitments as $commitment)
                <tr>        
                    <th class="text-center">{{ $loop->iteration }}</th>
                    <td style="text-align: justify;">{{ $commitment->description }}</td>
                    <td class="text-center">{{ ($commitment->commitment_user_id) ?  $commitment->commitmentUser->tinyName : $commitment->commitmentOrganizationalUnit->name }}</td>
                    <td class="text-center">
                        {{ ($commitment['closing_date']) ? $commitment['closing_date'] : 'Sin fecha límite' }} <br>
                        @switch($commitment->priority)
                            @case('normal')
                                <span class="badge text-bg-success">{{ $commitment->priority }}</span>
                                @break
                            @case('urgente')
                                <span class="badge text-bg-danger">{{ $commitment->priority }}</span>
                                @break
                        @endswitch
                    </td>
                    <td class="text-center">
                        @switch($commitment->requirement->status)
                            @case('creado')
                                <span class="badge text-bg-light">{{ $commitment->requirement->status }}</span>
                                @break
                            @case('respondido') 
                                <span class="badge text-bg-warning">{{ $commitment->requirement->status }}</span>
                                @break
                            @case('cerrado') 
                                <span class="badge text-bg-success">{{ $commitment->requirement->status }}</span>
                                @break
                            @case('derivado') 
                                <span class="badge text-bg-primary">{{ $commitment->requirement->status }}</span>
                                @break
                            @case('reabierto')
                                <span class="badge text-bg-light">{{ $commitment->requirement->status }}</span>
                                @break
                        @endswitch
                        <br>
                        <a class="btn btn-primary btn-sm" href="{{ route('requirements.show', $commitment->requirement->id) }}" target="_blank">
                            <i class="fas fa-rocket"></i> SGR
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('custom_js')

@endsection
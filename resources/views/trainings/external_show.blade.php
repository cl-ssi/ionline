@extends('layouts.bt4.external')

@section('title', 'Nuevo Staff')

@section('content')

<div class="row">
    <div class="col-sm-5">
        <h5 class="mt-2 mb-3">Formulario Solicitud de Capacitación ID: {{ $training->id }}
            @switch($training->StatusValue)
                @case('Guardado')
                    <span class="badge badge-primary">{{ $training->StatusValue }}</span>
                    
                    @break
                                
                @case('Enviado')
                    <span class="badge badge-warning">{{ $training->StatusValue }}</span>
                    @break

                @case('Pendiente')
                    <span class="badge badge-warning">{{ $training->StatusValue }}</span>
                    @break
            @endswitch
        </h5>
    </div>
</div>

<div class="table-responsive mt-3">
    <table class="table table-bordered table-sm small">
        <thead>
            <tr>
                <th colspan="6" class="table-secondary">I. Antecedentes del funcionario/a que asiste a la Capacitación.</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%" colspan="2" class="table-secondary">Nombre</th>
                <td width="25%" colspan="2">{{ ($training->userTraining) ? $training->userTraining->FullName : null }}</td>
                <th width="25%" class="table-secondary">RUN</th>
                <td width="25%">{{ $training->userTraining->id }}-{{ $training->userTraining->dv }}</td>
            </tr>
            <tr>
                <th width="12.5%" class="table-secondary">Estamento</th>
                <td width="12.5%">{{ $training->estament->name }}</td>
                <th width="12.5%" class="table-secondary">Grado</th>
                <td width="12.5%">{{ $training->degree }}</td>
                <th width="" class="table-secondary">Calidad Jurídica</th>
                <td width="">{{ $training->contractualCondition->name }}</td>
            </tr>
            <tr>
                <th width="25%" colspan="2" class="table-secondary">Servicio/Unidad</th>
                <td width="25%" colspan="2">{{ ($training->userTrainingOu) ? $training->userTrainingOu->name : null }}</td>
                <th width="25%" class="table-secondary">Establecimiento</th>
                <td width="25%">{{ ($training->userTrainingEstablishment) ? $training->userTrainingEstablishment->name : null }}</td>
            </tr>
            <tr>
                <th width="25%" colspan="2" class="table-secondary">Correo electrónico</th>
                <td width="25%" colspan="2">{{ $training->email }}</td>
                <th width="25%" class="table-secondary">Fono contacto</th>
                <td width="25%">{{ $training->telephone }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="table-responsive mt-3">
    <table class="table table-bordered table-sm small">
        <thead>
            <tr>
                <th colspan="6" class="table-secondary">II. Antecedentes de la Actividad.</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th width="25%" colspan="2" class="table-secondary">Eje estratégico asociados a la Actividad</th>
                <td colspan="4">{{ $training->StrategicAxes->name }}</td>
            </tr>
            <tr>
                <th width="25%" colspan="2" class="table-secondary">Objetivo</th>
                <td colspan="4">{{ $training->objective }}</td>
            </tr>
            <tr>
                <th width="25%" colspan="2" class="table-secondary">Nombre de la Actividad</th>
                <td colspan="4">{{ $training->activity_name }}</td>
            </tr>
            <tr>
                <th width="25%" colspan="2" class="table-secondary">Tipo de Actividad</th>
                <td width="25%" colspan="2">{{ $training->activity_type }}</td>
                <th width="25%" class="table-secondary">Otro</th>
                <td width="25%">{{ $training->other_activity_type }}</td>
            </tr>
            <tr>
                <th width="25%" colspan="2" class="table-secondary">Modalidad de aprendizaje</th>
                <td width="25%" colspan="2">{{ $training->mechanism }}</td>
                <th width="25%" class="table-secondary">Actividad</th>
                <td width="25%"> {{ $training->schuduled }}</td>
            </tr>
            <tr>
                <th width="12.5%" class="table-secondary">Inicio Actividad</th>
                <td width="12.5%">{{ $training->activity_date_start_at }}</td>
                <th width="12.5%" class="table-secondary">Fin Actividad</th>
                <td width="12.5%">{{ $training->activity_date_end_at }}</td>
                <th width="" class="table-secondary">Total horas cronológicas</th>
                <td width="">{{ $training->total_hours }}</td>
            </tr>
            <tr>
                <th width="12.5%" class="table-secondary">Permiso Desde</th>
                <td width="12.5%">{{ $training->permission_date_start_at }}</td>
                <th width="12.5%" class="table-secondary">Permiso Hasta</th>
                <td width="12.5%">{{ $training->permission_date_end_at }}</td>
                <th width="" class="table-secondary">Lugar</th>
                <td width="">{{ $training->place }}</td>
            </tr>
            <tr>
                <th width="25%" colspan="2" class="table-secondary">Jornada y Horarios</th>
                <td colspan="4">{{ $training->working_day }}</td>
            </tr>
            <tr>
                <th width="25%" colspan="2" class="table-secondary">Fundamento o Razones Técnicas para la asistencia del funcionario</th>
                <td colspan="4">{{ $training->technical_reasons }}</td>
            </tr>
        </tbody>
    </table>
</div>


<h6 class="mt-3"><i class="fas fa-check-circle"></i> Aprobaciones</h6>

<div class="table-responsive">
    <table class="table table-bordered table-sm small">
        <thead>
            <tr class="text-center">
                @foreach($training->approvals as $approval)
                    <th class="table-secondary">{{ $approval->sentToOu->name }}</th>
                @endforeach
            </tr>
        </thead>
        <thead>
            <tr class="text-center">
                @foreach($training->approvals as $approval)
                    <td>
                        {{ $approval->StatusInWords }} <br><br>
                        @if($approval->approver) <i class="fas fa-user"></i> @endif {{ ($approval->approver) ? $approval->approver->FullName : null }}<br> 
                        @if($approval->approver) <i class="fas fa-calendar"></i> @endif {{ ($approval->approver) ? $approval->approver_at : null }}
                        
                        @if($approval->approver_observation != null) 
                            <hr>
                            {{ $approval->approver_observation }} 
                        @endif
                    </td>
                @endforeach
            </tr>
        </thead>
    </table>
</div>

@endsection

@section('custom_js')

@endsection
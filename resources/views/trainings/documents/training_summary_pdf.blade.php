@extends('layouts.document')

@section('title', 'Resumen Solicitud Permiso Capacitación '.$training->id)

@section('content')
    <style>
        .tabla th,
        .tabla td {
            padding: 3px;
            /* Ajusta este valor a tus necesidades */
        }

        .totales {
            margin-left: auto;
            margin-right: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .nowrap {
            white-space: nowrap;
        }
        
        .signature-container {
            height: 160px;
        }
        
    </style>

    <div style="clear: both; padding-bottom: 120px"></div>

    <div class="center diez">
        <strong style="text-transform: uppercase;">
            FORMULARIO SOLICITUD DE CAPACITACION
        </strong>
    </div>

    <div style="clear: both; padding-bottom: 15px"></div>

    <h4><b>I. Antecedentes del funcionario/a que asiste a la Capacitación.</b></h4>

    <table class="tabla">
        <tbody>
            <tr>
                <th width="50%" colspan="2" style="background-color:#EEEEEE;">Nombre</th>
                <th width="50%" colspan="2" style="background-color:#EEEEEE;">RUN</th>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center">{{ ($training->userTraining) ? $training->userTraining->fullName : null }}</td>
                <td colspan="2" style="text-align: center">{{ $training->userTraining->id }}-{{ $training->userTraining->dv }}</td>
            </tr>
            <tr>
                <th width="25%" style="background-color:#EEEEEE;">Estamento</th>
                <th width="25%" style="background-color:#EEEEEE;">Calidad Contractual</th>
                <th width="25%" style="background-color:#EEEEEE;">Ley</th>
                <th width="25%" style="background-color:#EEEEEE;">
                    @if($training->law == 18834)
                        Grado
                    @else
                        Horas de Desempeño
                    @endif
                </th>
            </tr>
            <tr>
                <td style="text-align: center">{{ $training->estament->name }}</td>
                <td style="text-align: center">{{ $training->contractualCondition->name }}</td>
                <td style="text-align: center">N° {{ number_format($training->law, 0, ",", ".") }}</td>
                <td style="text-align: center">
                    @if($training->law == 18834)
                        {{ $training->degree }}
                    @else
                        {{ $training->work_hours }}
                    @endif
                </td>
            </tr>
            <tr>
                <th colspan="2" style="background-color:#EEEEEE;">Servicio/Unidad</th>
                <th colspan="2" style="background-color:#EEEEEE;">Establecimiento</th>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center">{{ ($training->userTrainingOu) ? $training->userTrainingOu->name : null }}</td>
                <td colspan="2" style="text-align: center">{{ ($training->userTrainingEstablishment) ? $training->userTrainingEstablishment->name : null }}</td>
            </tr>
            <tr>
                <th colspan="2" style="background-color:#EEEEEE;">Correo electrónico</th>
                <th colspan="2" style="background-color:#EEEEEE;">Fono contacto</th>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center">{{ $training->email }}</td>
                <td colspan="2" style="text-align: center">{{ $training->telephone }}</td>
            </tr>
        </tbody>
    </table>

    <h4 class="mt-3"><b>II. Antecedentes de la Actividad.</b></h4>

    <table class="tabla">
        <tbody>
            <tr>
                <th colspan="4" style="background-color:#EEEEEE;">Eje estratégico asociados a la Actividad</th>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center">{{ $training->StrategicAxes->name }}</td>
            </tr>
            <tr>
                <th colspan="4" style="background-color:#EEEEEE;">Objetivo</th>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center">{{ $training->objective }}</td>
            </tr>
            <tr>
                <th colspan="2" width="50%" style="background-color:#EEEEEE;">Nombre de la Actividad</th>
                <th width="25%" style="background-color:#EEEEEE;">Tipo de Actividad</th>
                <th width="25%" style="background-color:#EEEEEE;">Nombre de la Actividad</th>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center">{{ $training->activity_name }}</td|>
                <td style="text-align: center">{{ $training->ActivityTypeValue }}</td>
                <td style="text-align: center">{{ $training->other_activity_type }}</td>
            </tr>
            <tr>
                <th colspan="2" width="50%" style="background-color:#EEEEEE;">Nacional / Internacional</th>
                <th width="25%" style="background-color:#EEEEEE;">Comuna</th>
                <th width="25%" style="background-color:#EEEEEE;">Viático</th>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center">{{ $training->ActivityInValue }}</td>
                <td style="text-align: center">{{ ($training->ClCommune) ? $training->ClCommune->name : null }}</td>
                <td style="text-align: center">{{ $training->AllowanceValue }}</td>
            </tr>
            <tr>
                <th colspan="2" width="50%" style="background-color:#EEEEEE;">Modalidad de aprendizaje</th>
                <th width="25%" style="background-color:#EEEEEE;">Modalidad Online</th>
                <th width="25%" style="background-color:#EEEEEE;">Actividad Programada</th>
            </tr>
            <tr>
                <td colspan="2" width="50%" style="text-align: center">{{ $training->MechanismValue }}</td>
                <td width="25%" style="text-align: center">{{ $training->OnlineTypeValue }}</td>
                <td width="25%" style="text-align: center">{{ $training->SchuduledValue }}</td>
            </tr>
            <tr>
                <th colspan="2" width="50%" style="background-color:#EEEEEE;">Fecha Inicio de Actividad</th>
                <th width="25%" style="background-color:#EEEEEE;">Fecha Termino de Actividad</th>
                <th width="25%" style="background-color:#EEEEEE;">Total Horas Pedagógicas</th>
            </tr>
            <tr>
                <td colspan="2" width="50%" style="text-align: center">{{ $training->activity_date_start_at->format('d-m-Y') }}</td>
                <td width="25%" style="text-align: center">{{ $training->activity_date_end_at->format('d-m-Y') }}</td>
                <td width="25%" style="text-align: center">{{ $training->total_hours }}</td>
            </tr>
            <tr>
                <th colspan="2" width="50%" style="background-color:#EEEEEE;">Solicita Permiso Desde</th>
                <th width="25%" style="background-color:#EEEEEE;">Solicita Permiso Hasta</th>
                <th width="25%" style="background-color:#EEEEEE;">Lugar</th>
            </tr>
            <tr>
                <td colspan="2" width="50%" style="text-align: center">{{ $training->permission_date_start_at->format('d-m-Y') }}</td>
                <td width="25%" style="text-align: center">{{ $training->permission_date_end_at->format('d-m-Y') }}</td>
                <td width="25%" style="text-align: center">{{ $training->place }}</td>
            </tr>
            <tr>
                <th colspan="2" width="50%" style="background-color:#EEEEEE;">Jornada</th>
                <th colspan="2" width="50%" style="background-color:#EEEEEE;">Fundamento o Razones Técnicas para la asistencia del funcionario</th>
            </tr>
            <tr>
                <td colspan="2" width="50%" style="text-align: center">{{ $training->WorkingDayValue }}</td>
                <td colspan="2" width="50%" style="text-align: center">{{ $training->technical_reasons }}</td>
            </tr>
        </tbody>
    </table>

    <h4 class="mt-3"><b>III. Aprobaciones.</b></h4>
    @php
        $width = 100 / $training->approvals->count();
    @endphp
    <table class="tabla">
            <thead>
                <tr>
                    @foreach($training->approvals as $approval)
                        <th style="background-color:#EEEEEE;" width="{{ $width }}">{{ $approval->sentToOu->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <thead>
                <tr>
                    @foreach($training->approvals as $approval)
                        <td style="text-align: center">
                            <p style="color: green">{{ $approval->StatusInWords }}</p> <br><br>
                            {{ $approval->approver->fullName }}<br> 
                            {{ $approval->approver_at }}
                            
                            @if($approval->approver_observation != null) 
                                <hr>
                                {{ $approval->approver_observation }} 
                            @endif
                        </td>
                    @endforeach
                </tr>
            </thead>
        </table>
@endsection

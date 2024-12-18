<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" data-mutate-approach="sync"></script>

<div class="row">
    <div class="col-12 col-md-12">
        <h5 class="mt-2 mb-3">Formulario Solicitud DE Capacitación ID: {{ $training->id }}
            @switch($training->StatusValue)
                @case('Guardado')
                    <span class="badge text-bg-primary">{{ $training->StatusValue }}</span>
                    @break
                                
                @case('Enviado')
                    <span class="badge text-bg-warning">{{ $training->StatusValue }}</span>
                    @break
                
                @case('Certificado Pendiente')
                    <span class="badge text-bg-warning">{{ $training->StatusValue }}</span>
                    @break

                @case('Rechazado')
                    <span class="badge text-bg-danger">{{ $training->StatusValue }}</span>
                    @break
                
                @case('Finalizado')
                    <span class="badge text-bg-success">{{ $training->StatusValue }}</span>
                    @break
            @endswitch
        </h5>
    </div>
</div>

<h6 class="mt-3"><b>I. Antecedentes del funcionario/a que asiste a la Capacitación.</b></h6>

<div class="table-responsive mt-3">
    <table class="table table-bordered table-sm small text-center">
        <tbody>
            <tr>
                <th width="45%" colspan="2" class="table-secondary">Nombre</th>
                <th width="45%" colspan="2" class="table-secondary">RUN</th>
            </tr>
            <tr>
                <td colspan="2">{{ ($training->userTraining) ? $training->userTraining->fullName : null }}</td>
                <td colspan="2">{{ $training->userTraining->id }}-{{ $training->userTraining->dv }}</td>
            </tr>
            <tr>
                <th width="22.5%" class="table-secondary">Estamento</th>
                <th width="22.5%" class="table-secondary">Calidad Contractual</th>
                <th width="22.5%" class="table-secondary">Ley</th>
                <th width="22.5%" width="15%" class="table-secondary">
                    @if($training->law == 18834)
                        Grado
                    @else
                        Horas de Desempeño
                    @endif
                </th>
            </tr>
            <tr>
                <td>{{ $training->estament->name }}</td>
                <td>{{ $training->contractualCondition->name }}</td>
                <td>N° {{ number_format($training->law, 0, ",", ".") }}</td>
                <td>
                    @if($training->law == 18834)
                        {{ $training->degree }}
                    @else
                        {{ $training->work_hours }}
                    @endif
                </td>
            </tr>
            <tr>
                <th colspan="2" class="table-secondary">Servicio/Unidad</th>
                <th colspan="2" class="table-secondary">Establecimiento</th>
            </tr>
            <tr>
                <td colspan="2">{{ ($training->userTrainingOu) ? $training->userTrainingOu->name : null }}</td>
                <td colspan="2">{{ ($training->userTrainingEstablishment) ? $training->userTrainingEstablishment->name : null }}</td>
            </tr>
            <tr>
                <th colspan="2" class="table-secondary">Correo electrónico</th>
                <th colspan="2" class="table-secondary">Fono contacto</th>
            </tr>
            <tr>
                <td colspan="2">{{ $training->email }}</td>
                <td colspan="2" >{{ $training->telephone }}</td>
            </tr>
        </tbody>
    </table>
</div>

<h6 class="mt-3"><b>II. Antecedentes de la Actividad.</b></h6>

<div class="table-responsive mt-3">
    <table class="table table-bordered table-sm small text-center">
        <tbody>
            <tr>
                <th colspan="4" class="table-secondary">Eje estratégico asociados a la Actividad</th>
            </tr>
            <tr>
                <td colspan="4">{{ $training->StrategicAxes->name }}</td>
            </tr>
            <tr>
                <th colspan="4" class="table-secondary">Objetivo</th>
            </tr>
            <tr>
                <td colspan="4">{{ $training->objective }}</td>
            </tr>
            <tr>
                <th colspan="2" width="50%" class="table-secondary">Nombre de la Actividad</th>
                <th width="25%" class="table-secondary">Tipo de Actividad</th>
                <th width="25%" class="table-secondary">Nombre de Otro Tipo Actividad</th>
            </tr>
            <tr>
                <td colspan="2">{{ $training->activity_name }}</td|>
                <td>{{ $training->ActivityTypeValue }}</td>
                <td>{{ $training->other_activity_type }}</td>
            </tr>
            <tr>
                <th colspan="2" width="50%" class="table-secondary">Nacional / Internacional</th>
                <th width="25%" class="table-secondary">Comuna</th>
                <th width="25%" class="table-secondary">Viático</th>
            </tr>
            <tr>
                <td colspan="2">{{ $training->ActivityInValue }}</td>
                <td>{{ ($training->ClCommune) ? $training->ClCommune->name : null }}</td>
                <td>{{ $training->AllowanceValue }}</td>
            </tr>
            <tr>
                <th colspan="2" width="50%" class="table-secondary">Modalidad de aprendizaje</th>
                <th width="25%" class="table-secondary">Modalidad Online</th>
                <th width="25%" class="table-secondary">Actividad Programada</th>
            </tr>
            <tr>
                <td colspan="2" width="50%">{{ $training->MechanismValue }}</td>
                <td width="25%">{{ $training->OnlineTypeValue }}</td>
                <td width="25%">{{ $training->SchuduledValue }}</td>
            </tr>
            <tr>
                <th colspan="2" width="50%" class="table-secondary">Fecha Inicio de Actividad</th>
                <th width="25%" class="table-secondary">Fecha Termino de Actividad</th>
                <th width="25%" class="table-secondary">Total Horas Pedagógicas</th>
            </tr>
            <tr>
                <td colspan="2" width="50%">{{ $training->activity_date_start_at }}</td>
                <td width="25%">{{ $training->activity_date_end_at }}</td>
                <td width="25%">{{ $training->total_hours }}</td>
            </tr>
            <tr>
                <th colspan="2" width="50%" class="table-secondary">Solicita Permiso Desde</th>
                <th width="25%" class="table-secondary">Solicita Permiso Hasta</th>
                <th width="25%" class="table-secondary">Lugar</th>
            </tr>
            <tr>
                <td colspan="2" width="50%">{{ $training->permission_date_start_at }}</td>
                <td width="25%">{{ $training->permission_date_end_at }}</td>
                <td width="25%">{{ $training->place }}</td>
            </tr>
            <tr>
                <th colspan="2" width="50%" class="table-secondary">Jornada</th>
                <th colspan="2" width="50%" class="table-secondary">Fundamento o Razones Técnicas para la asistencia del funcionario</th>
            </tr>
            <tr>
                <td colspan="2" width="50%">{{ $training->WorkingDayValue }}</td>
                <td colspan="2" width="50%">{{ $training->technical_reasons }}</td>
            </tr>
        </tbody>
    </table>
</div>

<h6 class="mt-3"><i class="fas fa-paperclip"></i> Adjuntos</h6>

<div class="table-responsive">
    <table class="table table-bordered table-sm small">
        <thead>
            <tr class="text-center table-secondary">
                <th width="10%">#</th>
                <th width="45%">Nombre Archivo</th>
                <th width="45%"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($training->files as $file)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @switch($file->type)
                            @case('permission_file')
                                Permiso
                                @break

                            @case('rejoinder_file')
                                Contrato Replica
                                @break
                        
                            @case('program_file')
                                Programa
                                @break
                        
                            @case('certificate_file')
                                Certificado
                                @break
                        @endswitch
                    </td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('trainings.show_file', ['training' => $training, 'type' => $file->type]) }}" target="_blank">
                            <i class="fas fa-paperclip fa-fw"></i> Ver adjunto
                        </a>
                    </td>
                </tr>
            @endforeach
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
                        <p class="text-{{ $approval->Color }}">{{ $approval->StatusInWords }}</p>

                        @if($approval->approver) <i class="fas fa-user"></i> @endif {{ ($approval->approver) ? $approval->approver->fullName : null }}<br> 
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


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" data-mutate-approach="sync"></script>

<div class="row">
    <div class="col">
        <h4 class="mb-3">Gestión de Solicitudes para aprobación
    </div>
</div>

@if($requestReplacementStaff->form_type == 'replacement' || $requestReplacementStaff->form_type == NULL)
    @if($requestReplacementStaff->requestFather)
        <div class="row">
            <div class="col">
                <div class="alert alert-primary" role="alert">
                    Este formulario corresponde a una extensión del formulario Nº {{ $requestReplacementStaff->requestFather->id }} - {{ $requestReplacementStaff->requestFather->name }}
                </div>
            </div>
        </div>
        <br>
    @endif
@endif

@if($requestReplacementStaff->form_type == 'replacement' || $requestReplacementStaff->form_type == NULL)
    <h6><i class="fas fa-file"></i> Formulario de Reemplazos</h6>
    <div class="table-responsive">
        <table class="table table-sm table-bordered small">
            <thead>
                <tr class="table-active">
                    <th colspan="4">Formulario Contratación de Personal - Solicitud Nº {{ $requestReplacementStaff->id }}
                        @switch($requestReplacementStaff->request_status)
                            @case('pending')
                                <span class="badge bg-warning">{{ $requestReplacementStaff->StatusValue }}</span>
                                @break

                            @case('complete')
                                <span class="badge bg-success">{{ $requestReplacementStaff->StatusValue }}</span>
                                @break

                            @case('rejected')
                                <span class="badge bg-danger">{{ $requestReplacementStaff->StatusValue }}</span>
                                @break
                            
                            @case('to assign')
                                <span class="badge badge-warning">{{ $requestReplacementStaff->StatusValue }}</span>
                                @break

                            @case('finance sign')
                                <span class="badge badge-warning">{{ $requestReplacementStaff->StatusValue }}</span>
                                @break

                            @default
                                Default case...
                        @endswitch
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="table-active">Solicitante</th>
                    <td style="width: 33%">{{ $requestReplacementStaff->user->fullName }}</td>
                    <td style="width: 33%">{{ $requestReplacementStaff->organizationalUnit->name }}</td>
                </tr>
                <tr>
                    <th class="table-active">Nombre de Formulario / Nº de Cargos</th>
                    <td style="width: 33%">{{ $requestReplacementStaff->name }}</td>
                    <td style="width: 33%">{{ $requestReplacementStaff->charges_number }}</td>
                </tr>
                <tr>
                    <th class="table-active">Estamento / Ley / Grado</th>
                    <td style="width: 33%">{{ $requestReplacementStaff->profile_manage->name }}</td>
                    <td style="width: 33%">
                        {{ ($requestReplacementStaff->law) ? 'Ley N° '.number_format($requestReplacementStaff->law, 0, ",", ".").' -' : '' }} {{ ($requestReplacementStaff->degree) ? $requestReplacementStaff->degree : 'Sin especificar grado' }}
                        @if(auth()->id() == App\Models\Rrhh\Authority::getTodayAuthorityManagerFromDate(App\Models\Parameters\Parameter::get('ou','SubRRHH'))->user_id && $requestReplacementStaff->degree)
                            <a class="btn btn-link btn-sm small"
                                href="{{ route('replacement_staff.request.technical_evaluation.show', $requestReplacementStaff) }}"
                                target="_blank">
                                Editar grado
                            </a>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="table-active">Periodo</th>
                    <td style="width: 33%">{{ $requestReplacementStaff->start_date->format('d-m-Y') }}</td>
                    <td style="width: 33%">{{ $requestReplacementStaff->end_date->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <th class="table-active">Calidad Jurídica / $ Honorarios</th>
                    <td style="width: 33%">{{ $requestReplacementStaff->legalQualityManage->NameValue }}</td>
                    <td style="width: 33%">
                        @if($requestReplacementStaff->LegalQualityValue == 'Honorarios')
                            ${{ number_format($requestReplacementStaff->salary,0,",",".") }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="table-active">
                        Fundamento de la Contratación / Detalle de Fundamento
                    </th>
                    <td style="width: 33%">
                        {{ $requestReplacementStaff->fundamentManage->NameValue }}
                    </td>
                    <td style="width: 33%">
                        {{ ($requestReplacementStaff->fundamentDetailManage) ? $requestReplacementStaff->fundamentDetailManage->NameValue : '' }}
                    </td>
                </tr>
                <tr>
                    <th class="table-active">Funcionario a Reemplazar</th>
                    <td style="width: 33%">
                        @if($requestReplacementStaff->run)
                            {{$requestReplacementStaff->run}}-{{$requestReplacementStaff->dv}}
                        @endif
                    </td>
                    <td style="width: 33%">{{$requestReplacementStaff->name_to_replace}}</td>
                </tr>
                <tr>
                    <th class="table-active">Otro Fundamento (especifique)</th>
                    <td colspan="2">{{ $requestReplacementStaff->other_fundament }}</td>
                </tr>
                <tr>
                    <th class="table-active">La Persona cumplirá labores en Jornada</th>
                    <td style="width: 33%">{{ $requestReplacementStaff->WorkDayValue }}</td>
                    <td style="width: 33%">{{ $requestReplacementStaff->other_work_day }}</td>
                </tr>
                <tr>
                    <th class="table-active">Archivos</th>
                    <td style="width: 33%">Perfil de Cargo
                        @if($requestReplacementStaff->job_profile_file)
                            <a href="{{ route('replacement_staff.request.show_file', $requestReplacementStaff) }}" target="_blank"> <i class="fas fa-paperclip"></i></a>
                        @endif
                    </td>
                    <td style="width: 33%">Correo (Verificación Solicitud) <a href="{{ route('replacement_staff.request.show_verification_file', $requestReplacementStaff) }}" target="_blank"> <i class="fas fa-paperclip"></i></a></td>
                </tr>
                <tr>
                    <th class="table-active">Lugar de Desempeño</th>
                    <td>{{ $requestReplacementStaff->ouPerformance->name }}</td>
                    <td>{{ ($requestReplacementStaff->establishment) ? $requestReplacementStaff->establishment->name : '' }}</td>
                </tr>
                <tr>
                    <th class="table-active">Staff Sugerido</th>
                    <td colspan="2">
                        @if($requestReplacementStaff->replacementStaff)
                            {{ $requestReplacementStaff->replacementStaff->fullName }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="table-active">Ítem Presupuestario</th>
                    <td colspan="2">
                        @if($requestReplacementStaff->budgetItem)
                            {{ $requestReplacementStaff->budgetItem->code }} <br>
                            {{ $requestReplacementStaff->budgetItem->name }}
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@else
    <h5><i class="fas fa-file"></i> Formulario de Convocatorias</h5>

    <div class="table-responsive">
        <table class="table table-sm table-bordered small">
            <thead>
                <tr class="table-active">
                    <th colspan="4">
                        Formulario Contratación de Personal - Solicitud Nº {{ $requestReplacementStaff->id }}
                        @switch($requestReplacementStaff->request_status)
                            @case('pending')
                                <span class="badge bg-warning">{{ $requestReplacementStaff->StatusValue }}</span>
                                @break

                            @case('complete')
                                <span class="badge bg-success">{{ $requestReplacementStaff->StatusValue }}</span>
                                @break

                            @case('rejected')
                                <span class="badge bg-danger">{{ $requestReplacementStaff->StatusValue }}</span>
                                @break

                            @default
                                Default case...
                        @endswitch
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="table-active">Creador / Solicitante</th>
                    <td style="width: 33%">
                        {{ $requestReplacementStaff->user->fullName }} <br>
                        {{ $requestReplacementStaff->organizationalUnit->name }}
                    </td>
                    <td style="width: 33%">
                        {{($requestReplacementStaff->requesterUser) ?  $requestReplacementStaff->requesterUser->tinyName : '' }}
                    </td>
                </tr>
                <tr>
                    <th class="table-active">Nombre de Solicitud</th>
                    <td colspan="2">{{ $requestReplacementStaff->name }}</td>
                </tr>
                <tr>
                    <th class="table-active">Archivos</th>
                    <td colspan="2">Correo (Verificación Solicitud) <a href="{{ route('replacement_staff.request.show_verification_file', $requestReplacementStaff) }}" target="_blank"> <i class="fas fa-paperclip"></i></a></td>
                </tr>
                <tr>
                    <th class="table-active">Lugar de Desempeño</th>
                    <td>{{ $requestReplacementStaff->ouPerformance->name }}</td>
                    <td>{{ ($requestReplacementStaff->establishment) ? $requestReplacementStaff->establishment->name : '' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    </br>

    <h6><i class="fas fa-list-ol"></i> Listado de cargos</h6>

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered">
            <thead class="text-center small table-active">
                <tr>
                    <th>N° de cargos</th>
                    <th>Estamento</th>
                    <th>Grado / Renta</th>
                    <th>Calidad Jurídica</th>
                    <th>Fundamento</th>
                    <th>Jornada</th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-center small">
                @foreach($requestReplacementStaff->positions as $position)
                <tr>
                    <td>{{ $position->charges_number }}</td>
                    <td>{{ $position->profile_manage->name ?? '' }}</td>
                    <td>{{ $position->degree ?? number_format($position->salary, 0, ",", ".") }}</td>
                    <td>
                        {{ $position->legalQualityManage->NameValue ?? '' }} <br><br>
                        <b>Ley</b>: {{ ($position->law) ? number_format($position->law, 0, ",", ".") : 'Sin especificar' }}    
                    </td>
                    <td>
                        {{ $position->fundamentManage->NameValue ?? '' }}<br>
                        @if($position->other_fundament)
                            <hr>
                            {{ $position->other_fundament }}
                        @endif
                        {{ $position->fundamentDetailManage->NameValue ?? '' }}</td>
                    <td>{{ $position->WorkDayValue ?? '' }}</td>
                    <td>
                        @if($position->job_profile_file)
                            <a class="btn btn-outline-secondary"
                                href="{{ route('replacement_staff.request.show_file_position', $position) }}"
                                target="_blank"> Adjunto
                            </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <br>
@endif

<h6 class="small mt-4"><i class="fas fa-signature"></i> El proceso debe contener las aprobaciones de las personas que dan autorización para que la Unidad Selección inicie el proceso de Llamado de presentación de antecedentes.</h6>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <thead style="font-size: 12px;">
            <tr>
            <!-- APPROVALS -->
            @if(count($requestReplacementStaff->approvals) > 0)
                @foreach($requestReplacementStaff->approvals as $approval)
                    @if($approval->subject == "Solicitud de Aprobación Jefatura Depto. o Unidad")
                    <th class="table-active text-center">
                        {{ $approval->sentToOu->name }}
                    </th>
                    @endif
                    
                    @if($approval->subject == "Solicitud de Aprobación SDGP")
                        @php $flag = 1; @endphp
                    @else
                        @php $flag = 0; @endphp
                    @endif

                    @if($approval->subject == "Solicitud de Aprobación Finanzas")
                        @php $flagFinance = 1; @endphp
                    @else
                        @php $flagFinance = 0; @endphp
                    @endif

                @endforeach

                <!-- APROBACION DE PERSONAL -->
                @if($requestReplacementStaff->form_type == 'replacement')
                    @if(count($requestReplacementStaff->requestSign) > 0)
                        @foreach($requestReplacementStaff->requestSign as $sign)
                            <th class="table-active text-center">
                                {{ $sign->organizationalUnit->name }}
                            </th>
                        @endforeach

                    @else
                        <th class="table-active text-center">
                            {{ App\Models\Parameters\Parameter::get('ou', 'NombreUnidadPersonal', $requestReplacementStaff->establishment_id) }}
                        </th>
                    @endif
                @endif
            
                @if($flag == 0)
                    <th class="table-active text-center">
                        {{ App\Models\Parameters\Parameter::get('ou', 'NombrePlanificacionRRHH', $requestReplacementStaff->establishment_id) }}
                    </th>
                    <th class="table-active text-center">
                        {{ App\Models\Parameters\Parameter::get('ou', 'NombreSubRRHH', $requestReplacementStaff->establishment_id) }}
                    </th>
                @endif
            
                @if($flag == 1)
                    @foreach($requestReplacementStaff->approvals as $approval)
                        @if($approval->subject != "Solicitud de Aprobación Jefatura Depto. o Unidad")
                        <th class="table-active text-center">
                            {{ $approval->sentToOu->name }}
                        </th>
                        @endif
                    @endforeach
                @endif

                @if($flagFinance == 0 && $requestReplacementStaff->form_type == 'replacement')
                    <th class="table-active text-center">
                        {{ App\Models\Parameters\Parameter::get('ou', 'NombreUnidadFinanzas', $requestReplacementStaff->establishment_id) }}
                    </th>
                @endif
            @else
                <!-- ANTIGUO SISTEMA DE APROBACIONES -->
                @foreach($requestReplacementStaff->RequestSign as $sign)
                    <th class="table-active text-center">
                        {{ $sign->organizationalUnit->name }}
                    </th>
                @endforeach
            @endif    
            </tr>
        </thead>
        <tbody class="small">
            <tr class="text-center">
            <!-- APPROVALS -->
            @if(count($requestReplacementStaff->approvals) > 0)
                <!-- APPROVALS JEFATURAS DIRECTAS -->
                @foreach($requestReplacementStaff->approvals as $approval)
                    @if($approval->subject == "Solicitud de Aprobación Jefatura Depto. o Unidad")
                        <td>
                            @if($approval->StatusInWords == "Pendiente")
                                <span>
                                    <i class="fas fa-check-circle"></i> {{ $approval->StatusInWords }}
                                </span> <br>
                            @endif
                            @if($approval->StatusInWords == "Aprobado")
                                <span style="color: green;">
                                    <i class="fas fa-check-circle"></i> {{ $approval->StatusInWords }}
                                </span> <br>
                                <i class="fas fa-user"></i> {{ $approval->approver->fullName }}<br>
                                <i class="fas fa-calendar-alt"></i> {{ $approval->approver_at->format('d-m-Y H:i:s') }}<br>
                            @endif
                            @if($approval->StatusInWords == "Rechazado")
                                <span style="color: tomato;">
                                    <i class="fas fa-check-circle"></i> {{ $approval->StatusInWords }}
                                </span> <br>
                                <i class="fas fa-user"></i> {{ $approval->approver->fullName }}<br>
                                <i class="fas fa-calendar-alt"></i> {{ $approval->approver_at->format('d-m-Y H:i:s') }}
                                <hr>
                                {{ $approval->approver_observation }}
                            @endif
                        </td>
                    @endif
                    
                @endforeach
                <!-- APROBACION INTERNA PERSONAL -->
                @if($requestReplacementStaff->form_type == 'replacement')
                    @if(count($requestReplacementStaff->requestSign) > 0)
                        @foreach($requestReplacementStaff->requestSign as $sign)
                            <td>
                                @if($sign->request_status == 'accepted')
                                    <span style="color: green;">
                                        <i class="fas fa-check-circle"></i> {{ $sign->StatusValue }} 
                                    </span><br>
                                    <i class="fas fa-user"></i> {{ $sign->user->tinyName }}<br>
                                    <i class="fas fa-calendar-alt"></i> {{ ($sign->date_sign) ? $sign->date_sign->format('d-m-Y H:i:s') : '' }}<br>
                                @endif
                                @if($sign->request_status == 'rejected')
                                    <span style="color: Tomato;">
                                        <i class="fas fa-times-circle"></i> {{ $sign->StatusValue }} 
                                    </span><br>
                                    <i class="fas fa-user"></i> {{ $sign->user->fullName }}<br>
                                    <i class="fas fa-calendar-alt"></i> {{ $sign->date_sign->format('d-m-Y H:i:s') }}<br>
                                    <hr>
                                    {{ $sign->observation }}<br>
                                @endif
                                @if($sign->request_status == 'pending' || $sign->request_status == NULL)
                                    <i class="fas fa-clock"></i> Pendiente<br>
                                @endif
                            </td>
                        @endforeach

                    @else
                        <td>
                            <i class="fas fa-clock"></i> Pendiente<br>
                        </td>
                    @endif
                @endif   

                @if($flag == 0)
                    <td>
                        <i class="fas fa-check-circle"></i> Pendiente
                    </td>
                    <td>
                        <i class="fas fa-check-circle"></i> Pendiente
                    </td> 
                @endif
                @if($flag ==  1)
                    @foreach($requestReplacementStaff->approvals as $approval)
                        @if($approval->subject != "Solicitud de Aprobación Jefatura Depto. o Unidad")
                            <td>
                                @if($approval->StatusInWords == "Pendiente")
                                    <span>
                                        <i class="fas fa-check-circle"></i> {{ $approval->StatusInWords }}
                                    </span> <br>
                                @endif
                                @if($approval->StatusInWords == "Aprobado")
                                    <span style="color: green;">
                                        <i class="fas fa-check-circle"></i> {{ $approval->StatusInWords }}
                                    </span> <br>
                                    <i class="fas fa-user"></i> {{ $approval->approver->fullName }}<br>
                                    <i class="fas fa-calendar-alt"></i> {{ $approval->approver_at->format('d-m-Y H:i:s') }}<br>
                                @endif
                                @if($approval->StatusInWords == "Rechazado")
                                    <span style="color: tomato;">
                                        <i class="fas fa-check-circle"></i> {{ $approval->StatusInWords }}
                                    </span> <br>
                                    <i class="fas fa-user"></i> {{ $approval->approver->fullName }}<br>
                                    <i class="fas fa-calendar-alt"></i> {{ $approval->approver_at->format('d-m-Y H:i:s') }}
                                    <hr>
                                    {{ $approval->approver_observation }}
                                @endif
                            </td>
                        @endif
                        
                    @endforeach
                @endif

                @if($flagFinance == 0 && $requestReplacementStaff->form_type == 'replacement')
                    <td>
                        <i class="fas fa-check-circle"></i> Pendiente
                    </td>
                @endif

            @else
                <!-- ANTIGUO SISTEMA DE APROBACIONES -->
                @foreach($requestReplacementStaff->RequestSign as $sign)
                    <td class="text-center">
                    @if($sign->request_status == 'accepted')
                        <span style="color: green;">
                            <i class="fas fa-check-circle"></i> {{ $sign->StatusValue }} 
                        </span><br>
                        <i class="fas fa-user"></i> {{ $sign->user->tinyName }}<br>
                        <i class="fas fa-calendar-alt"></i> {{ ($sign->date_sign) ? $sign->date_sign->format('d-m-Y H:i:s') : '' }}<br>
                    @endif
                    @if($sign->request_status == 'rejected')
                        <span style="color: Tomato;">
                            <i class="fas fa-times-circle"></i> {{ $sign->StatusValue }} 
                        </span><br>
                        <i class="fas fa-user"></i> {{ $sign->user->fullName }}<br>
                        <i class="fas fa-calendar-alt"></i> {{ $sign->date_sign->format('d-m-Y H:i:s') }}<br>
                        <hr>
                        {{ $sign->observation }}<br>
                    @endif
                    @if($sign->request_status == 'pending' || $sign->request_status == NULL)
                        <i class="fas fa-clock"></i> Pendiente<br>
                    @endif
                    @if($sign->request_status == 'not valid')
                        @if($requestReplacementStaff->signaturesFile)
                            @foreach($requestReplacementStaff->signaturesFile->signaturesFlows as $flow)
                                @if($flow->status == 1)
                                    <span style="color: green;">
                                        <i class="fas fa-signature"></i> Aceptada
                                    </span><br>
                                    <i class="fas fa-user"></i> {{ $flow->signerName }}<br>
                                    <i class="fas fa-calendar-alt"></i> {{ $flow->signature_date->format('d-m-Y H:i:s') }}
                                @elseif($flow->status === 0)
                                    <span style="color: Tomato;">
                                        <i class="fas fa-times-circle"></i> Rechazada
                                    </span><br>
                                    <i class="fas fa-user"></i> {{ $flow->signerName }}<br>
                                    <i class="fas fa-calendar-alt"></i> {{ $flow->signature->rejected_at->format('d-m-Y H:i:s') }}<br>
                                    <hr>
                                    {{ $flow->observation }}<br>
                                @else
                                    <i class="fas fa-clock"></i> Pendiente<br>
                                @endif
                            @endforeach
                        @else
                            <i class="fas fa-clock"></i> Pendiente<br>
                        @endif
                    @endif
                    </td>
                @endforeach
            @endif
            <tr>
        </tbody>
    </table>
</div>
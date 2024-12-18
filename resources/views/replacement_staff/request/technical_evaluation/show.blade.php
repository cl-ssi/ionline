@extends('layouts.bt4.app')

@section('title', 'Selección')

@section('content')

@include('replacement_staff.nav')

@if($requestReplacementStaff->requestFather)
<div class="row">
    <div class="col">
      <div class="alert alert-primary" role="alert">
          Este formulario corresponde a una extensión del formulario Nº
          <a target="_blank" href="{{ route('replacement_staff.request.technical_evaluation.show', $requestReplacementStaff->requestFather) }}">
            {{ $requestReplacementStaff->requestFather->id }} - {{ $requestReplacementStaff->requestFather->name }}
          </a>
      </div>
    </div>
</div>

<br />
@endif

@if($requestReplacementStaff->form_type == 'replacement' || $requestReplacementStaff->form_type == NULL)
<h5><i class="fas fa-file"></i> Formulario de Reemplazos</h5>

<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <thead class="small">
            <tr class="table-active">
                <th colspan="3">Formulario Contratación de Personal - Solicitud Nº {{ $requestReplacementStaff->id }}
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
        <tbody class="small">
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
                            data-toggle="modal"
                            title="Cambio Grado"
                            data-target="#changeDegreeModal-{{ $requestReplacementStaff->id }}">
                            Editar grado
                        </a>
                    @endif

                    @include('replacement_staff.modals.modal_to_change_degree')
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
                  {{ ($requestReplacementStaff->fundamentDetailManage) ? $requestReplacementStaff->fundamentDetailManage->NameValue : ''}}
                </td>
            </tr>
            <tr>
                <th class="table-active">Otro Fundamento (especifique)</th>
                <td colspan="2">{{ $requestReplacementStaff->other_fundament }}</td>
            </tr>
            <tr>
                <th class="table-active">Funcionario a Reemplazar
                </th>
                <td style="width: 33%">
                  @if($requestReplacementStaff->run)
                      {{ $requestReplacementStaff->run}}-{{$requestReplacementStaff->dv }}
                  @endif
                </td>
                <td style="width: 33%">{{ $requestReplacementStaff->name_to_replace }}</td>
            </tr>
            <tr>
                <th class="table-active">La Persona cumplirá labores en / Jornada</th>
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

<h6><i class="fas fa-list-ol"></i> Listado de cargos </h6>

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
                <td>{{ $position->legalQualityManage->NameValue ?? '' }}</td>
                <td>
                    {{ $position->fundamentManage->NameValue ?? '' }}<br>
                    @if($position->other_fundament)
                        <hr>
                        {{ $position->other_fundament }}
                    @endif
                    {{ $position->fundamentDetailManage->NameValue ?? '' }}</td>
                <td>{{ $position->WorkDayValue ?? '' }}</td>
                <td>
                    <a class="btn btn-outline-secondary"
                        href="{{ route('replacement_staff.request.show_file_position', $position) }}"
                        target="_blank"> <i class="fas fa-paperclip"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<h6 class="mt-3"><i class="fas fa-user"></i> Selección de RR.HH.</h6>
@if($requestReplacementStaff->technicalEvaluation && ($requestReplacementStaff->technicalEvaluation->technical_evaluation_status == 'complete' || $requestReplacementStaff->technicalEvaluation->technical_evaluation_status == 'rejected'))
    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered">
            <thead class="text-center small">
                <tr>
                    <th width="3%">#</th>
                    <th width="20%">Detalle Convocatoria</th>
                    <th width="10%">Fecha Ingreso</th>
                    <th colspan="2" width="40%">Datos del Seleccionado</th>
                    <th width="3%"></th>
                <tr>
            </thead>
            <tbody class="small">
                @php
                    $contador = 0;
                @endphp
                @foreach($requestReplacementStaff->positions as $position)
                    @foreach($position->selectedPositions as $key => $selectedPosition)
                    <tr>
                        <th class="text-center">
                            {{ $contador + 1 }}
                        </th>
                        <td class="text-left">
                            <b>Estamento</b>: {{ $position->profile_manage->name ?? '' }}<br>

                            @if($position->degree)
                                <b>Grado</b>: {{ $position->degree }}
                            @else
                                <b>Renta</b>: ${{ number_format($position->salary, 0, ",", ".") }}
                            @endif
                            <br>
                            <b>Calidad Contractual</b>: {{ $position->legalQualityManage->NameValue ?? '' }} <br>
                            <b>Fundamento</b>: {{ $position->fundamentManage->NameValue ?? '' }} <br>
                            <b>Detalle</b>: {{ $position->fundamentDetailManage->NameValue ?? '' }} <br>
                            <b>Jornada</b>: {{ $position->WorkDayValue ?? '' }}
                        </td>
                        <td class="text-center">
                            {{ $selectedPosition->start_date ? $selectedPosition->start_date->format('d-m-Y') : '' }}
                            @if($selectedPosition->start_date != NULL)
                                <span class="badge badge-warning mt-3">3 meses: {{ $selectedPosition->start_date ? $selectedPosition->start_date->addMonths(3)->format('d-m-Y') : '' }}</span> 
                                <span class="badge badge-danger">6 meses: {{ $selectedPosition->start_date ? $selectedPosition->start_date->addMonths(6)->format('d-m-Y') : '' }}</span> 
                            @endif
                        </td>
                        @if($selectedPosition->run != null)
                        <td width="20%" class="text-center">
                            {{ $selectedPosition->run }}-{{ $selectedPosition->dv }}
                        </td>
                        <td class="text-center">
                            {{ $selectedPosition->name }}
                        </td>
                        @else
                        <td colspan="2" class="text-center">
                            <span class="badge badge-warning">No seleccionado</span>
                        </td>
                        @endif
                        <td>
                        </td>
                    </tr>
                    @php
                        $contador++;
                    @endphp
                    @endforeach
                @endforeach

            </tbody>
        </table>
    </div>
@endif
<br>
@endif

@if($requestReplacementStaff->request_status == "complete" && $requestReplacementStaff->form_type == 'replacement')
<div class="row">
    <div class="col-12">
        <a href="{{ route('replacement_staff.request.technical_evaluation.create_document', $requestReplacementStaff) }}"
            class="btn btn-info btn-sm float-right" 
            title="Selección" 
            target="_blank">
            <i class="fas fa-file"></i> Exportar Resumen 
        </a>        
    </div>
</div>
<br>
@endif

{{-- dd($requestReplacementStaff->signaturesFile->signed) --}}

@if($requestReplacementStaff->signaturesFile && $requestReplacementStaff->signaturesFile->signed_file)
<div class="row">
    <div class="col-12">
        <a class="btn btn-info btn-sm float-right" 
            title="" href="{{ route('replacement_staff.request.show_budget_availability_certificate_signed', $requestReplacementStaff) }}" 
            target="_blank" 
            title="Certificado">
            <i class="fas fa-file-contract"></i> Certificado de Disponibilidad Presupuestaria
        </a>
    </div>
</div>
<br />
@endif

<h6 class="small"><i class="fas fa-signature"></i> El proceso debe contener las aprobaciones de las personas que dan autorización para que la Unidad Selección inicie el proceso de Llamado de presentación de antecedentes.</h6>

<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <thead style="font-size: 12px;">
            <tr>
                @if(count($requestReplacementStaff->approvals) > 0)
                    <!-- APPROVALS -->
                    @foreach($requestReplacementStaff->approvals as $approval)
                        <!-- APPROVALS DE JEFATURA DIRECTA -->
                        @if($approval->subject == "Solicitud de Aprobación Jefatura Depto. o Unidad")
                            <th class="table-active text-center">
                                {{ $approval->sentToOu->name }}
                            </th>     
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

                    <!-- APPROVALS DE PLANIFICACION - SDGP -->
                    @php $flagPostPersonal = array(); @endphp
                    @foreach($requestReplacementStaff->approvals as $approval)
                        @if($approval->subject == 'Solicitud de Aprobación Planificación' || 
                            $approval->subject == 'Solicitud de Aprobación SDGP')
                            <th class="table-active text-center">
                                {{ $approval->sentToOu->name }}
                            </th>
                            @php $flagPostPersonal[] = 1 @endphp
                        @else
                            @php $flagPostPersonal[] = 0; @endphp
                        @endif
                    @endforeach
                
                    @if(!in_array(1, $flagPostPersonal))
                        <th class="table-active text-center">
                            {{ App\Models\Parameters\Parameter::get('ou','NombrePlanificaciónRRHH', $requestReplacementStaff->establishment_id) }}
                        </th>
                        <th class="table-active text-center">
                            {{ App\Models\Parameters\Parameter::get('ou','NombreSubRRHH', $requestReplacementStaff->establishment_id) }}
                        </th>
                    @endif

                    <!-- APPROVALS DE FINANZAS FIRMA ELECTRÓNICA -->
                    @php $flagPostRrhh = array(); @endphp
                    @if($requestReplacementStaff->form_type == 'replacement')
                        @foreach($requestReplacementStaff->approvals as $approval)
                            @if(str_contains($approval->subject, 'Certificado de disponibilidad presupuestaria'))
                                <th class="table-active text-center">
                                    {{ $approval->sentToOu->name }}
                                </th>
                                @php $flagPostRrhh[] = 1 @endphp
                            @else
                                @php $flagPostRrhh[] = 0; @endphp
                            @endif
                        @endforeach
                    @endif

                    @if(!in_array(1, $flagPostRrhh) && $requestReplacementStaff->form_type == 'replacement')
                        <th class="table-active text-center">
                            {{ App\Models\Parameters\Parameter::get('ou','NombreUnidadFinanzas', $requestReplacementStaff->establishment_id) }}
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
                @if(count($requestReplacementStaff->approvals) > 0)
                    <!-- APPROVALS -->
                    @foreach($requestReplacementStaff->approvals as $approval)
                        <!-- APPROVALS DE JEFATURA DIRECTA -->
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


                    <!-- APROBACION DE PERSONAL -->
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

                    <!-- APPROVALS DE PLANIFICACION - SDGP -->
                    @php $flagPostPersonal = array(); @endphp
                    @foreach($requestReplacementStaff->approvals as $approval)
                        @if($approval->subject == 'Solicitud de Aprobación Planificación' || 
                            $approval->subject == 'Solicitud de Aprobación SDGP')
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
                            @php $flagPostPersonal[] = 1 @endphp
                        @else
                            @php $flagPostPersonal[] = 0; @endphp
                        @endif
                    @endforeach
                
                    @if(!in_array(1, $flagPostPersonal))
                        <td>
                            <i class="fas fa-clock"></i> Pendiente<br>
                        </td>
                        <td>
                            <i class="fas fa-clock"></i> Pendiente<br>
                        </td> 
                    @endif

                    <!-- APPROVALS DE FINANZAS FIRMA ELECTRÓNICA -->
                    @php $flagPostRrhh = array(); @endphp
                    @if($requestReplacementStaff->form_type == 'replacement')
                        @foreach($requestReplacementStaff->approvals as $approval)
                            @if(str_contains($approval->subject, 'Certificado de disponibilidad presupuestaria'))
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
                                @php $flagPostRrhh[] = 1 @endphp
                            @else
                                @php $flagPostRrhh[] = 0; @endphp
                            @endif
                        @endforeach
                    @endif

                    @if(!in_array(1, $flagPostRrhh) && $requestReplacementStaff->form_type == 'replacement')
                        <td>
                            <i class="fas fa-clock"></i> Pendiente<br>
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

<br>

@if($requestReplacementStaff->technicalEvaluation)
  @if($requestReplacementStaff->technicalEvaluation->technical_evaluation_status == 'complete' ||
    $requestReplacementStaff->technicalEvaluation->technical_evaluation_status == 'rejected')
    <div class="table-responsive">
        <table class="table table-sm table-bordered small">
            <tr>
                <th class="table-active" style="width: 33%">Estado de Solicitud</th>
                <td colspan="2">{{ $requestReplacementStaff->StatusValue }}</td>
            </tr>
            <tr>
                <th class="table-active">Fecha de Cierre</th>
                <td colspan="2">{{ $requestReplacementStaff->technicalEvaluation->date_end->format('d-m-Y H:i:s') }}</td>
            </tr>
        </table>
    </div>
  @endif
@endif

<div class="row">
    <div class="col">
        @if($requestReplacementStaff->technicalEvaluation && $requestReplacementStaff->request_id == NULL &&
            ($requestReplacementStaff->form_type == 'replacement' || $requestReplacementStaff->form_type == NULL) &&
            $requestReplacementStaff->end_date < now()->toDateString() &&
            $requestReplacementStaff->technicalEvaluation->date_end != null &&
            ($requestReplacementStaff->user_id == auth()->id() || 
            $requestReplacementStaff->organizational_unit_id == auth()->user()->organizationalUnit->id) &&
            (App\Models\ReplacementStaff\RequestReplacementStaff::getCurrentContinuity($requestReplacementStaff) == 'no current' || 
            App\Models\ReplacementStaff\RequestReplacementStaff::getCurrentContinuity($requestReplacementStaff) == 'no childs'))
            <a class="btn btn-success float-right btn-sm" href="{{ route('replacement_staff.request.create_extension', $requestReplacementStaff) }}">
                <i class="fas fa-plus"></i> Extender en Nueva Solicitud</a>
        @endif
    </div>
</div>

<br>

@if($requestReplacementStaff->technicalEvaluation &&
  $requestReplacementStaff->technicalEvaluation->commissions->count() > 0)
    <h6><i class="fas fa-users"></i> Integrantes Comisión</h6>

    <div class="table-responsive">
        <table class="table table-sm table-bordered">
            <thead class="text-center table-active small">
                <tr>
                    <th>Nombre</th>
                    <th>Unidad Organizacional</th>
                    <th>Cargo</th>
                </tr>
            </thead>
            <tbody class="small">
              @foreach($requestReplacementStaff->technicalEvaluation->commissions as $commission)
                <tr>
                    <td>{{ $commission->user->fullName }}</td>
                    <td>{{ $commission->user->organizationalUnit->name }}</td>
                    <td>{{ $commission->job_title }}</td>
                </tr>
              @endforeach
            </tbody>
        </table>
    </div>
    <br>
@endif

@if($requestReplacementStaff->technicalEvaluation &&
  $requestReplacementStaff->technicalEvaluation->reason != NULL)
    <div class="row">
        <div class="col">
            <div class="alert alert-danger" role="alert">
                <h6><i class="fas fa-exclamation-circle"></i> Proceso Selección Finalizado</h6>
                <ul>
                    <li><strong>Motivo:</strong> {{ $requestReplacementStaff->technicalEvaluation->ReasonValue }}</li>
                    <li><strong>Observación:</strong> {{ $requestReplacementStaff->technicalEvaluation->observation }}</li>
                    <li><strong>Fecha:</strong> {{ $requestReplacementStaff->technicalEvaluation->date_end->format('d-m-Y H:i:s') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <br>
@endif

@if($requestReplacementStaff->technicalEvaluation && $requestReplacementStaff->technicalEvaluation->applicants->count() > 0)
    @if (session('message-success-sirh-contract'))
      <div class="alert alert-success alert-dismissible fade show">
          {{ session('message-success-sirh-contract') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
      </div>
    @endif

    <h6><i class="fas fa-users"></i> Selección de RR.HH.</h6>

    <div class="table-responsive" id="applicant">
        <table class="table table-sm table-striped table-bordered">
            <thead class="text-center table-active small">
                <tr>
                    <th style="width: 15%">Nombre</th>
                    <th style="width: 18%">Calificación Evaluación Psicolaboral</th>
                    <th style="width: 18%">Calificación Evaluación Técnica y/o de Apreciación Global</th>
                    <th>Observaciones</th>
                    <th style="width: 8%">Ingreso Efectivo</th>
                    <th style="width: 8%">Fin</th>
                    <th style="width: 8%">Fecha Ingreso Contrato</th>
                </tr>
            </thead>
            <tbody class="small">
              @foreach($requestReplacementStaff->technicalEvaluation->applicants->sortByDesc('score') as $applicant)
                <tr class="{{ ($applicant->selected == 1 && $applicant->desist == NULL)?'table-success':''}}">
                    <td>
                        <a href="{{ route('replacement_staff.show_replacement_staff', $applicant->replacementStaff) }}"
                            target="_blank">{{ $applicant->replacementStaff->fullName }}
                        </a>
                        <br>
                        @if($applicant->selected == 1 && $applicant->desist == NULL)
                            <span class="badge bg-success">Seleccionado</span>
                        @endif
                        @if($applicant->desist == 1)
                            <span class="badge bg-danger">
                                @if($applicant->reason == 'renuncia a reemplazo')
                                    Renuncia a reemplazo (Posterior ingreso)
                                @endif
                                @if($applicant->reason == 'rechazo oferta laboral')
                                    Rechazo oferta laboral (Previo ingreso)
                                @endif
                                @if($applicant->reason == 'error digitacion')
                                    Error de Digitación
                                @endif
                            </span>
                        @endif
                    </td>
                    <td class="text-center">{{ $applicant->psycholabor_evaluation_score }} <br> {{ $applicant->PsyEvaScore }}</td>
                    <td class="text-center">{{ $applicant->technical_evaluation_score }} <br> {{ $applicant->TechEvaScore }}</td>
                    <td>{{ $applicant->observations }}</td>
                    <td class="text-center">{{ ($applicant->start_date) ? $applicant->start_date->format('d-m-Y') : '' }}</td>
                    <td class="text-center">{{ ($applicant->end_date) ? $applicant->end_date->format('d-m-Y') : '' }}</td>
                    <td class="text-center">
                        @if($applicant->sirh_contract)
                            {{ $applicant->sirh_contract->format('d-m-Y') }}
                        @else
                            @if((auth()->user()->hasPermissionTo('Replacement Staff: view requests') ||
                              auth()->user()->can('Replacement Staff: admin') ||
                              App\Models\Rrhh\Authority::getAuthorityFromDate(46, Carbon\Carbon::now(), 'manager')->user_id == auth()->id()) &&
                              $applicant->selected == 1 && $applicant->desist == NULL)
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal"
                                    data-target="#exampleModal-to-sirh-contract-{{ $applicant->id }}">
                                    <i class="fas fa-file-signature"></i>
                                </button>

                                @include('replacement_staff.modals.modal_to_sirh_contract')
                            @endif
                        @endif

                        @if($applicant->approval_id)
                            <a type="button" 
                                class="btn btn-primary btn-sm" 
                                href="{{ route('replacement_staff.request.technical_evaluation.applicant.download_budget_availavility_certificate_pdf', $applicant) }}"
                                target="_blank">
                                <i class="fas fa-file-pdf fa-fw"></i>
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

@if($requestReplacementStaff->technicalEvaluation && $requestReplacementStaff->technicalEvaluation->technicalEvaluationFiles->count() > 0)

    <h6>Adjuntos </h6>

    <div class="table-responsive">
        <table class="table table-sm table-striped table-bordered">
            <thead class="text-center">
                <tr>
                    <th>Nombre Archivo</th>
                    <th>Cargado por</th>
                    <th>Fecha</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
              @foreach($requestReplacementStaff->technicalEvaluation->technicalEvaluationFiles->sortByDesc('created_at') as $technicalEvaluationFiles)
                <tr>
                    <td>{{ $technicalEvaluationFiles->name }}</td>
                    <td>{{ $technicalEvaluationFiles->user->fullName }}</td>
                    <td>{{ $technicalEvaluationFiles->created_at->format('d-m-Y H:i:s') }}</td>
                    <td style="width: 4%">
                        <a href="{{ route('replacement_staff.request.technical_evaluation.file.show_file', $technicalEvaluationFiles) }}"
                            class="btn btn-outline-secondary btn-sm"
                            title="Ir"
                            target="_blank"> <i class="far fa-eye"></i>
                        </a>
                    </td>
                </tr>
              @endforeach
            </tbody>
        </table>
    </div>
@endif

@if($requestReplacementStaff->requestChilds->count() > 0)
<div class="row">
    <div class="col-sm">
        <h5><i class="fas fa-inbox"></i> Formularios de Continuidad</h5>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered">
        <thead class="text-center small">
            <tr>
                <th>#</th>
                <th style="width: 8%">Fecha</th>
                <th>Solicitud</th>
                <th>Grado</th>
                <th>Calidad Jurídica</th>
                <th colspan="2">Periodo</th>
                <th>Fundamento</th>
                <th>Jornada</th>
                <th>Solicitante</th>
                <th style="width: 2%"></th>
            </tr>
        </thead>
        <tbody class="small">
            @foreach($requestReplacementStaff->requestChilds as $requestChild)
            <tr>
                <td>
                    {{ $requestChild->id }} <br>
                    @switch($requestChild->request_status)
                        @case('pending')
                            <i class="fas fa-clock"></i>
                            @break

                        @case('complete')
                            <span style="color: green;">
                              <i class="fas fa-check-circle"></i>
                            </span>
                            @break

                        @case('rejected')
                            <span style="color: Tomato;">
                              <i class="fas fa-times-circle"></i>
                            </span>
                            @break

                        @default
                            Default case...
                    @endswitch
                </td>
                <td>{{ $requestChild->created_at->format('d-m-Y H:i:s') }}</td>
                <td>{{ $requestChild->name }}</td>
                <td class="text-center">{{ $requestChild->degree }}</td>
                <td>{{ $requestChild->legalQualityManage->NameValue }}</td>
                <td style="width: 8%">{{ $requestChild->start_date->format('d-m-Y') }} <br>
                    {{ $requestChild->end_date->format('d-m-Y') }}
                </td>
                <td class="text-center">{{ $requestChild->getNumberOfDays() }}
                    @if($requestChild->getNumberOfDays() > 1)
                        días
                    @else
                        dia
                    @endif
                </td>
                <td>
                    {{ $requestChild->fundamentManage->NameValue }}<br>
                    {{ ($requestChild->fundamentDetailManage) ? $requestChild->fundamentDetailManage->NameValue : '' }}
                </td>
                <td>
                    {{ $requestChild->WorkDayValue }}
                </td>
                <td>{{ $requestChild->user->fullName }}<br>
                    {{ $requestChild->organizationalUnit->name }}
                </td>
                <td>
                  @if($requestChild->technicalEvaluation)
                    <a href="{{ route('replacement_staff.request.technical_evaluation.show', $requestChild)}}"
                                class="btn btn-outline-secondary btn-sm" title="Evaluación Técnica"><i class="fas fa-eye"></i></a>
                  @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

@endsection

@section('custom_js')

@endsection

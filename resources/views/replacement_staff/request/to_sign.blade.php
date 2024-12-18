@extends('layouts.bt4.app')

@section('title', 'Listado de STAFF')

@section('content')

@include('replacement_staff.nav')

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
                    <th colspan="4">Formulario Contratación de Personal - Solicitud Nº {{ $requestReplacementStaff->id }}</th>
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
                    <td style="width: 33%">{{ ($requestReplacementStaff->law) ? 'Ley N° '.number_format($requestReplacementStaff->law, 0, ",", ".").' -' : '' }} {{ ($requestReplacementStaff->degree) ? $requestReplacementStaff->degree : 'Sin especificar grado' }}</td>
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
                    <td colspan="2">{{ $requestReplacementStaff->ouPerformance->name }}</td>
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
    <br />
@else
    <h6><i class="fas fa-file"></i> Formulario de Convocatorias</h6>
    <div class="table-responsive">
        <table class="table table-sm table-bordered">
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
            </tbody>
        </table>
    </div>

    </br>

    <h6><i class="fas fa-list-ol"></i> Listado de cargos</h6>

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered">
            <thead class="text-center">
                <tr>
                    <th>N° de cargos</th>
                    <th>Estamento</th>
                    <th>Grado / Renta</th>
                    <th>Calidad Jurídica</th>
                    <th>Fundamento</th>
                    <th>Jornada</th>
                    <th>Perfil de Cargo</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach($requestReplacementStaff->positions as $position)
                <tr>
                    <td>{{ $position->charges_number }}</td>
                    <td>{{ $position->profile_manage->name ?? '' }}</td>
                    <td>{{ $position->degree ?? number_format($position->salary, 0, ",", ".") }}</td>
                    <td>{{ $position->legalQualityManage->NameValue ?? '' }}</td>
                    <td>{{ $position->fundamentManage->NameValue ?? '' }}<br>
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
    <br>
@endif

<h6><i class="fas fa-signature"></i> El proceso debe contener las aprobaciones de las personas que dan autorización para que la Unidad Selección inicie el proceso de Llamado de presentación de antecedentes.</h6>
<div class="table-responsive">
    <table class="table table-sm table-bordered small">
        <tbody>
            <tr>
                @foreach($requestReplacementStaff->RequestSign as $sign)
                    <td class="table-active text-center">
                        <strong>{{ $sign->organizationalUnit->name }}</strong><br>
                    </td>
                @endforeach
            </tr>
            <tr>
                @foreach($requestReplacementStaff->RequestSign as $requestSign)
                    <td align="center">
                        @if($requestSign->request_status == 'pending' && (in_array($requestSign->organizational_unit_id, $iam_authorities_in) || auth()->user()->hasPermissionTo('Replacement Staff: personal sign')))
                            Estado: {{ $requestSign->StatusValue }} <br><br>
                            <div class="row">
                                <div class="col-md-12">
                                    <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.sign.update', [$requestSign, 'status' => 'accepted']) }}">
                                        @csrf
                                        @method('PUT')
                
                                        @if($requestSign->ou_alias == 'uni_per' 
                                            && (auth()->user()->can('Replacement Staff: personal sign') || auth()->id() == App\Models\Rrhh\Authority::getTodayAuthorityManagerFromDate(auth()->user()->organizational_unit_id)->user_id)
                                            && ($requestReplacementStaff->legalQualityManage && ($requestReplacementStaff->legalQualityManage->NameValue == 'Contrata' ||
                                            $requestReplacementStaff->legalQualityManage->NameValue == 'Titular')))
                                            <fieldset class="form-group">
                                                <label for="for_gender" >Subtítulo</label>
                                                <select name="budget_item_id" id="for_budget_item_id" class="form-control" required small>
                                                    <option value="">Seleccione...</option>
                                                        @foreach($budgetItems as $budgetItem)
                                                            <option value="{{ $budgetItem->id }}">
                                                                {{ $budgetItem->code }} -
                                                                @if($budgetItem->code == '210300500102')
                                                                    Reemplazos del personal no médico
                                                                @endif
                                                                @if($budgetItem->code == '210300500101')
                                                                    Reemplazos del personal médico
                                                                @endif
                                                                @if($budgetItem->code == '210100100102')
                                                                    Personal de Planta Ley 18.834
                                                                @endif
                                                                @if($budgetItem->code == '210100100103')
                                                                    Personal de Planta Ley 19.664
                                                                @endif
                                                                @if($budgetItem->code == '210200100102')
                                                                    Personal a Contrata Ley 18.834
                                                                @endif
                                                                @if($budgetItem->code == '210200100103')
                                                                    Personal a Contrata Ley 19.664
                                                                @endif
                                                            </option>
                                                        @endforeach
                                                </select>
                                            </fieldset>
                                        @endif
                                </div>
                                <div class="col-md-12">
                                    <p>
                                    <button type="submit" class="btn btn-success btn-sm"
                                        onclick="return confirm('¿Está seguro que desea Aceptar la solicitud?')"
                                        title="Aceptar"
                                        @if($requestReplacementStaff->form_type == "replacement" && $requestSign->ou_alias == 'finance') disabled @endif>
                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Aceptar">
                                            <i class="fas fa-check-circle"></i></a>
                                        </span>
                                    </button>

                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Rechazar">
                                        <a class="btn btn-danger btn-sm" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                            <i class="fas fa-times-circle"></i>
                                        </a>
                                    </span>
                                    </p>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm">
                                     <div class="collapse" id="collapseExample">
                                        <div class="card card-body">
                                            <form method="POST" class="form-horizontal" action="{{ route('replacement_staff.request.sign.update', [$requestSign, 'status' => 'rejected', $requestReplacementStaff]) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="form-group">
                                                    <label class="float-left" for="for_observation">Motivo Rechazo</label>
                                                    <textarea class="form-control" id="for_observation" name="observation" rows="2"></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-danger btn-sm float-right"
                                                    onclick="return confirm('¿Está seguro que desea Rechazar la solicitud?')"
                                                    title="Rechazar">
                                                        <i class="fas fa-times-circle"></i> Rechazar</a>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif($requestSign->request_status == 'accepted')
                            <span style="color: green;">
                                <i class="fas fa-check-circle"></i> {{ $requestSign->StatusValue }}
                            </span> <br>
                            <i class="fas fa-user"></i> {{ $requestSign->user->fullName }}<br>
                            <i class="fas fa-calendar-alt"></i> {{ $requestSign->date_sign->format('d-m-Y H:i:s') }}<br>
                        @else
                            @if($requestSign->request_status == NULL)
                                <i class="fas fa-ban"></i> No disponible para Aprobación.<br>
                            @else
                                <i class="fas fa-clock"></i> {{ $requestSign->StatusValue }}<br>
                            @endif
                        @endif
                    </td>
                @endforeach
            </tr>
        </tbody>
    </table>
</div>

{{--

@if($requestReplacementStaff->budget_item_id != NULL)
    <object type="application/pdf" data="{{ route('replacement_staff.request.create_budget_availability_certificate_view', [ $requestReplacementStaff ]) }}" width="100%" height="100%" style="height: 193vh;"><a href="" target="_blank">
        <i class="fas fa-file"></i> Ver documento</a>
    </object>
@endif

@if($requestReplacementStaff->requestSign->where('ou_alias', 'sub_rrhh')->first()->request_status == 'accepted' &&
$requestReplacementStaff->requestSign->where('ou_alias', 'finance')->first()->request_status == 'pending' &&
    $requestReplacementStaff->budget_item_id)
    @php 
        $idModelModal = $requestReplacementStaff->id;
        $routePdfSignModal = "/replacement_staff/request/create_budget_availability_certificate_document/$idModelModal/";
        $routeCallbackSignModal = 'replacement_staff.request.callbackSign';
    @endphp

    @include('documents.signatures.partials.sign_file')

    <button type="button" data-toggle="modal" class="btn btn-primary float-right"
        title="Firma Digital"
        data-target="#signPdfModal{{$idModelModal}}" title="Firmar">
            Firmar <i class="fas fa-signature"></i>
    </button> 

    <br><br>
@endif

--}}

@endsection

@section('custom_js')

@endsection
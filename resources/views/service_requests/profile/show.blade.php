@extends('layouts.app')

@section('title', 'Perfil de Honorario')

@section('content')

    <h3 class="mb-3">Perfil del Funcionario</h3>

    <!-- Datos Personales -->
    <div class="card mb-3">
        <div class="card-body">
            <h4 class="card-title">Datos Personales</h4>
            <div class="form-row mb-3">
                <div class="col-md-2">
                    <label for="validationDefault02">Run.</label>
                    <input type="text" class="form-control" id="validationDefault02" value="{{ $user->runFormat() }}">
                </div>
                <div class="col-md-3">
                    <label for="validationDefault01">Nombres</label>
                    <input type="text" class="form-control" id="validationDefault01" value="{{ $user->name }}">
                </div>
                <div class="col-md-2">
                    <label for="validationDefault02">Apellido P.</label>
                    <input type="text" class="form-control" id="validationDefault02" value="{{ $user->fathers_family }}">
                </div>
                <div class="col-md-2">
                    <label for="validationDefault02">Apellido M.</label>
                    <input type="text" class="form-control" id="validationDefault02" value="{{ $user->mothers_family }}">
                </div>
                <div class="col-md-1">
                    <label for="validationDefault02">Sexo</label>
                    <select name="" id="" class="form-control">
                        <option value=""></option>
                        <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Masculino</option>
                        <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Femenino</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="validationDefault02">F. Nac.</label>
                    <input type="date" class="form-control" id="validationDefault02" value="{{ $user->birthday }}">
                </div>
            </div>
            <div class="form-row mb-3">
                <div class="col-md-4">
                    <label for="validationDefault02">Dirección</label>
                    <input type="text" class="form-control" id="validationDefault02" value="{{ $user->address }}">
                </div>
                <div class="col-md-2">
                    <label for="validationDefault02">Comuna</label>
                    <select name="" id="" class="form-control">
                        <option value="">Iquique</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="validationDefault02">Telefono</label>
                    <input type="text" class="form-control" id="validationDefault02" value="{{ $user->phone_number }}">
                </div>
                <div class="col-md-4">
                    <label for="validationDefault02">Email</label>
                    <input type="text" class="form-control" id="validationDefault02" value="{{ $user->email }}">
                </div>
            </div>

        </div>
    </div>

    <ul class="nav justify-content-end">
        <li class="nav-item">
            <b class="nav-link">Año</b>
        </li>
        @foreach ($yearsRange as $yearName => $hasContracts)
            <li class="nav-item">
                @if ($hasContracts)
                    <a class="nav-link @if ($yearName == $year) font-weight-bold @endif"
                        href="{{ route('rrhh.service-request.show', ['run' => $user->id, 'year' => $yearName]) }}">
                        {{ $yearName }}
                    </a>
                @else
                    <span class="nav-link">{{ $yearName }}</span>
                @endif
            </li>
        @endforeach
    </ul>

    @if ($year)
        <h5>Contratos</h5>
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    @foreach ($working_day_types as $wdtype => $hasContracts)
                        <li class="nav-item">
                            @if ($hasContracts)
                                <a class="nav-link small @if ($wdtype == $type) active @endif"
                                    href="{{ route('rrhh.service-request.show', ['run' => $user->id, 'year' => $year, 'type' => $wdtype]) }}">
                                    {{ ucfirst(mb_strtolower($wdtype, 'UTF-8')) }}</a>
                            @else
                                <span class="nav-link small">
                                    {{ ucfirst(mb_strtolower($wdtype, 'UTF-8')) }}
                                </span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="card-body">
                @if ($type)
                    <ul class="nav mb-3">
                        @php
                            $previousEndDate = null;
                        @endphp
                        @foreach ($serviceRequests as $serviceRequest)
                            @php
                                $hasNotContinuity = $previousEndDate && $previousEndDate->addDay() != $serviceRequest->start_date;
                                $previousEndDate = $serviceRequest->end_date;
                                $isCurrentContract = $serviceRequest->start_date <= now() && now() <= $serviceRequest->end_date;
                            @endphp
                            @if ($hasNotContinuity)
                                <li>
                                    |<br>
                                    |<br>
                                    |<br>
                                    |
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link @if ($serviceRequest->id == $id) font-weight-bold @endif"
                                    href="{{ route('rrhh.service-request.show', ['run' => $user->id, 'year' => $year, 'type' => $type, 'id' => $serviceRequest->id]) }}">
                                    <span style="font-size: 19px;"><i>id: {{ $serviceRequest->id }}</i></span><br>
                                    {{ $serviceRequest->start_date->format('Y-m-d') }} <br>
                                    {{ $serviceRequest->end_date->format('Y-m-d') }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if ($serviceRequestId)
                    <h5 class="card-title">Contrato id: {{ $serviceRequestId->id }}</h5>

                    <div class="form-row mb-3">
                        <div class="col-md-3">
                            <label for="validationDefault02">Programa</label>
                            <select name="" id="" class="form-control" disabled>
                                <option value="">{{ $serviceRequestId->programm_name }}</option>

                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="validationDefault01">Fuente de financiamiento</label>
                            <select name="" id="" class="form-control" disabled>
                                <option value="">{{ $serviceRequestId->type }}</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="validationDefault02">Responsable</label>
                            @if ($serviceRequestId->SignatureFlows->isNotEmpty())
                                <input type="text" disabled class="form-control" id="validationDefault02"
                                    value="{{ optional(optional($serviceRequestId->SignatureFlows->where('sign_position', 1)->first())->user)->getFullNameAttribute() }}">
                            @endif
                        </div>
                        <div class="col-md-3">
                            <label for="validationDefault02">Supervisor</label>
                            <input type="text" disabled class="form-control" id="validationDefault02"
                                value="{{ optional(optional($serviceRequestId->SignatureFlows->where('sign_position', 2)->first())->user)->getFullNameAttribute() }}">
                        </div>
                    </div>


                    <div class="form-row mb-3">
                        <div class="col-md-2">
                            <label for="validationDefault02">Establecimiento</label>
                            <select name="" id="" class="form-control" disabled>
                                <option value="">{{ $serviceRequestId->establishment->name }}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="validationDefault02">Unidad Organizacional</label>
                            <select name="" id="" class="form-control" disabled>
                                <option value="">{{ $serviceRequestId->responsabilityCenter->name }}</option>

                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="validationDefault02">Estamento</label>
                            <select name="" id="" class="form-control" disabled>
                                <option value="">
                                    {{ $serviceRequestId->profession ? $serviceRequestId->profession->estamento : $serviceRequestId->estate }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="validationDefault02">Profesión</label>
                            <select name="" id="" class="form-control" disabled>
                                <option value="">{{ $serviceRequestId->profession->name }}</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="validationDefault02">Jornada</label>
                            <input type="text" class="form-control" disabled id="validationDefault02"
                                value="{{ $serviceRequestId->working_day_type }}">
                        </div>
                    </div>
                @endif


                @if ($serviceRequestId)
                    @livewire('service-request.approval-workflow', ['serviceRequest' => $serviceRequestId])
                @endif

                @if ($serviceRequestId)
                    @livewire('service-request.info-rrhh', ['serviceRequest' => $serviceRequestId])
                @endif


                {{-- @if ($serviceRequestId->program_contract_type == 'Mensual')
                    @include('service_requests.requests.fulfillments.edit_monthly', [
                        'serviceRequest' => $serviceRequestId,
                    ])
                @else
                    @if ($serviceRequestId->programm_name == 'Covid 2022')
                        @if ($serviceRequestId->working_day_type == 'HORA MÉDICA')
                            @include('service_requests.requests.fulfillments.edit_hours_medics', [
                                'serviceRequest' => $serviceRequestId,
                            ])
                        @else
                            @include('service_requests.requests.fulfillments.edit_hours_others', [
                                'serviceRequest' => $serviceRequestId,
                            ])
                        @endif
                    @else
                        @if ($serviceRequestId->working_day_type == 'HORA MÉDICA' or $serviceRequestId->working_day_type == 'TURNO DE REEMPLAZO')
                            @include('service_requests.requests.fulfillments.edit_hours_medics', [
                                'serviceRequest' => $serviceRequestId,
                            ])
                        @else
                            @include('service_requests.requests.fulfillments.edit_hours_others', [
                                'serviceRequest' => $serviceRequestId,
                            ])
                        @endif
                    @endif
                @endif --}}



            </div>
        </div>
    @endif

    <br>
    @if(isset($id))
    <h5>Periodos</h5>

    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs mx-auto" id="periods-card">
                @foreach($meses as $numero => $mes)
                <li class="nav-item">
                    <a class="nav-link @disabled(!$periods[$numero]) @if($period == $numero) active @endif" 
                        href="{{ route('rrhh.service-request.show', ['run' => $user->id, 'year' => $year, 'type' => $type, 'id' => $id, 'period' => $numero]) }}#periods-card">
                        {{ $mes }}
                        @if($periods[$numero]) 
                        <span class="badge badge-pill badge-success">$</span>
                        @else
                        <span class="badge badge-pill badge-secondary">&nbsp;</span>
                        @endif
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="card-body">

            @if(isset($period))
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 18%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Contrato</div>
                    <div class="progress-bar bg-success" role="progressbar" style="width: 18%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Responsable</div>
                    <div class="progress-bar bg-success" role="progressbar" style="width: 18%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Recursos Humanos</div>
                    <div class="progress-bar bg-secondary" role="progressbar" style="width: 18%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Boleta</div>
                    <div class="progress-bar bg-secondary" role="progressbar" style="width: 18%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Finanzas</div>
                    <div class="progress-bar bg-secondary" role="progressbar" style="width: 10%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Pagado</div>
                </div>

                {{ $fulfillment->id }}

                <!-- Incluire los 4 livewires  -->
            @endif
        </div>
    </div>
    @endif

@endsection

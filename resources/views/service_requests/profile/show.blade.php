@extends('layouts.app')

@section('title', 'Maqueta Honorario')

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

        <ul class="nav justify-content-end nav-tabs card-header-tabs">
            <li class="nav-item">
                <b class="nav-link">Año</b>
            </li>
            @foreach (range(2020, now()->format('Y')) as $ano)
                <li class="nav-item">
                    <a class="nav-link @if ($year == $ano) active @endif"
                        href="{{ route('rrhh.service-request.show', ['run' => $user->id, 'year' => $ano]) }}">{{ $ano }}</a>
                </li>
            @endforeach
        </ul>
    </div>

    @if ($year)
        <h5>Contratos</h5>
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    @foreach ($workingDayTypes as $workingDayType)
                        <li class="nav-item">
                            <a class="nav-link @if ($type == $workingDayType) active @endif"
                                href="{{ route('rrhh.service-request.show', ['run' => $user->id, 'year' => $year, 'type' => $workingDayType]) }}">{{ $workingDayType }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="card-body">
                @if ($type)
                    <ul class="nav mb-3">
                        @foreach ($serviceRequests as $serviceRequest)
                            <li class="nav-item">
                                <a class="nav-link"
                                    href="{{ route('rrhh.service-request.show', ['run' => $user->id, 'year' => $year, 'type' => $workingDayType, 'id' => $serviceRequest->id]) }}">
                                    <h5><i>id: {{ $serviceRequest->id }}</i></h5>
                                    {{ $serviceRequest->start_date->format('Y-m-d') }} <br>
                                    {{ $serviceRequest->end_date->format('Y-m-d') }} <br>
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
                            @if($serviceRequestId->SignatureFlows->isNotEmpty())
                            <input type="text" disabled class="form-control" id="validationDefault02"
                                value="{{ optional(optional($serviceRequestId->SignatureFlows->where('sign_position',1)->first())->user)->getFullNameAttribute() }}">
                            @endif
                        </div>
                        <div class="col-md-3">
                            <label for="validationDefault02">Supervisor</label>
                            <input type="text" disabled class="form-control" id="validationDefault02"
                                value="{{ optional(optional($serviceRequestId->SignatureFlows->where('sign_position',2)->first())->user)->getFullNameAttribute() }}">
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
                                <option value="">{{ ($serviceRequestId->profession) ? $serviceRequestId->profession->estamento : $serviceRequestId->estate }}</option>
                                <option value="">F</option>
                                <option value="">O</option>
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
            </div>
        </div>
    @endif
    </div>


@endsection

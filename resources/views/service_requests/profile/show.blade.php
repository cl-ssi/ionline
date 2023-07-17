@extends('layouts.app')

@section('title', 'Perfil de Honorario')

@section('content')

    <h3 class="mb-3">Perfil del Funcionario</h3>

    <div class="form-row mb-3">
        <div class="col">
            @livewire('search-select-user')
        </div>
        <div class="col-1">
            <button class="btn btn-secondary"> <i class="fas fa-search"></i> </button>
        </div>
        <div class="col-2"></div>

        <div class="col-2">
            <input type="text" class="form-control" placeholder="id de solicitud">
        </div>
        <div class="col-1">
            <button class="btn btn-secondary"> <i class="fas fa-search"></i> </button>
        </div>
    </div>

    <hr>

    @if($user)
        <!-- Mostrar los datos de perfil del Usuario -->
        @livewire('service-request.user-data', ['user' => $user])

        <!-- Mostrar el listado de años con contratos del Usuario -->
        @livewire('service-request.years-with-contracts', [
            'user_id' => $user->id, 
            'year' => $year
        ])

        @if ($year)
            <h5>Contratos</h5>
            <div class="card">
                <div class="card-header">
                    <!-- Mostrar listado de working_day_types -->
                    @livewire('service-request.working-day-types', [
                        'user_id' => $user->id, 
                        'year' => $year,
                        'type' => $type
                    ])
                </div>
                <div class="card-body">
                    @if ($type)
                        <!-- Mostrar todos los contratos por working_day_type seleccionado -->
                        @livewire('service-request.contracts-by-working-day-type', [
                            'user_id' => $user->id, 
                            'year' => $year,
                            'type' => $type,
                            'service_request_id' => $serviceRequest->id ?? null
                        ])
                    @endif

                    @if ($serviceRequest)
                        <!-- Mostrar los datos del Service Request -->
                        @livewire('service-request.show-compact', [
                            'serviceRequest' => $serviceRequest
                        ])

                        <!-- Mostrar el flujo de firmas -->
                        @livewire('service-request.approval-workflow', ['serviceRequest' => $serviceRequest])

                        <!-- Mostrar Información Adicional de RRHH -->
                        @livewire('service-request.info-rrhh', ['serviceRequest' => $serviceRequest])
                    @endif


                </div>
            </div>
        @endif
    
    @endif

    <br>

    @if($serviceRequest)

    <h5>Periodos</h5>

    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs mx-auto" id="periods-card">
                @foreach($meses as $numero => $mes)
                <li class="nav-item">
                    <a class="nav-link @disabled(!$periods[$numero]) @if($period == $numero) active @endif" 
                        href="{{ route('rrhh.service-request.show', ['user' => $user->id, 'year' => $year, 'type' => $type, 'serviceRequest' => $serviceRequest, 'period' => $numero]) }}#periods-card">
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


                <!-- Livewire de Responsable -->
                <!-- Livewire de rrhh -->
                <!-- Livewire de Boleta -->
                <!-- Livewire de Finanzas -->
            @endif
        </div>
    </div>
    @endif
    

@endsection

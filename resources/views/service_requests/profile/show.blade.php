@extends('layouts.bt4.app')

@section('title', 'Perfil de Honorario')

@section('content')

    <h3 class="mb-3">Perfil del Funcionario</h3>

    <!-- Búsqueda -->
    <div class="form-row mb-3">
        <div class="col">
            <form method="POST" action="{{ route('rrhh.service-request.show.post') }}">
            @csrf
            @livewire('search-select-user')
        </div>
        <div class="col-1">
            <button type="submit" class="btn btn-secondary"> <i class="fas fa-search"></i> </button>
            </form>
        </div>
        <div class="col-2"></div>

        <div class="col-2">
            <form method="POST" action="{{ route('rrhh.service-request.show.post') }}">
            @csrf
                <input type="text" class="form-control" name="id" placeholder="id de solicitud">
            </div>
            <div class="col-1">
                <button type="submit" class="btn btn-secondary"> <i class="fas fa-search"></i> </button>
            </form>
        </div>
    </div>

    <hr>

    @if($user)
        <!-- Mostrar los datos de perfil del Usuario -->
        @livewire('service-request.user-data', ['user' => $user])
        <h5 class="mt-2">Contratos</h5>
        <div class="row">
            <div class="col">
                <!-- Mostrar el listado de años en los que tenga contratos -->
                @livewire('service-request.years-with-contracts', [
                    'user_id' => $user->id, 
                    'year' => $year
                ])
            </div>
            <div class="col">
                @if ($year)
                    <!-- Mostrar listado de program_contract_types -->
                    @livewire('service-request.program-contract-types', [
                        'user_id' => $user->id, 
                        'year' => $year,
                        'type' => $type
                    ])
                @endif
            </div>
        </div>


        @if ($year)

            @if ($type)
                <!-- Mostrar todos los contratos por program_contract_type seleccionado -->
                @livewire('service-request.contracts-by-program-contract-type', [
                    'user_id' => $user->id, 
                    'year' => $year,
                    'type' => $type,
                    'service_request_id' => $serviceRequest->id ?? null
                ])
            @endif

            @if ($serviceRequest)
                <div class="card">
                    <div class="card-body">
                        <!-- Mostrar los datos del Service Request -->
                        @livewire('service-request.show-compact', [
                            'serviceRequest' => $serviceRequest
                        ])

                        <!-- Mostrar el flujo de firmas -->
                        @livewire('service-request.approval-workflow', ['serviceRequest' => $serviceRequest])

                        <!-- Mostrar Información Adicional de RRHH -->
                        @livewire('service-request.info-rrhh', ['serviceRequest' => $serviceRequest])

                        <div class="form-row">
                            <div class="col-md-6">
                                <!-- Subir la resolución -->
                                @livewire('service-request.upload-resolution', ['serviceRequest' => $serviceRequest])
                            </div>
                            <div class="col-md-4">
                                <!-- Pasar a livewire -->
                                <label>Firma funcionario</label>
                                <button class="btn btn-warning form-control" wire:click="">
                                    <i class="fas fa-paper-plane"></i>
                                        Previsualizar y enviar para firma
                                    <i class="fas fa-signature"></i>
                                </button>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
            @endif
        @endif

        <br>

        @if($serviceRequest)

            <h5 id="periods-card">Periodos</h5>

            <div class="card">
                <div class="card-header">
                    <!-- Muestra la barra de periodos -->
                    @livewire('service-request.periods-bar',[
                        'user_id' => $user->id, 
                        'year' => $year,
                        'type' => $type,
                        'serviceRequest' => $serviceRequest,
                        'period' => $period
                    ])
                </div>

                <div class="card-body">

                    @if($period)
                        <div class="progress mb-3">
                            <div class="progress-bar {{ $serviceRequest->has_resolution_file ? 'bg-success' : 'bg-secondary' }}" role="progressbar" style="width: 20%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Contrato</div>
                            <div class="progress-bar {{ $fulfillment->signatures_file_id ? 'bg-success' : 'bg-secondary' }}" role="progressbar" style="width: 20%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Responsable</div>
                            <div class="progress-bar {{ $fulfillment->total_to_pay ? 'bg-success' : 'bg-secondary' }}" role="progressbar" style="width: 20%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Recursos Humanos</div>
                            <div class="progress-bar {{ $fulfillment->has_invoice_file ? 'bg-success' : 'bg-secondary' }}" role="progressbar" style="width: 20%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Boleta</div>
                            <div class="progress-bar {{ $fulfillment->payment_date ? 'bg-success' : 'bg-secondary' }}" role="progressbar" style="width: 20%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">Finanzas</div>
                        </div>

                        <!-- Información del periodo, incio, término, obs, tipo -->
                        @livewire('service-request.period-data',['fulfillment' => $fulfillment])

                        <!-- Livewire de Responsable, el código del card que esté dentro del componente -->
                        <div class="card border-success mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Responsable </h5>

                                <!-- Ejemplo para entender mejor el código -->
                                @switch($serviceRequest->program_contract_type)
                                    @case("Mensual")
                                        @livewire('service-request.responsable.monthly',['fulfillment' => $fulfillment])
                                        @break

                                    @case("Horas")
                                        @switch($serviceRequest->working_day_type)
                                            @case('HORA MÉDICA')
                                            @case('TURNO DE REEMPLAZO')
                                                @livewire('service-request.responsable.medic-hours',['fulfillment' => $fulfillment])
                                                @break
                                            @case('TERCER TURNO')
                                            @case('CUARTO TURNO')
                                            @case('HORA EXTRA')
                                            @case('DIURNO')
                                            @case('TURNO EXTRA')
                                            @case('CUARTO TURNO - MODIFICADO')
                                            @case('DIURNO PASADO A TURNO')
                                            @case('OTRO')
                                            @case('TERCER TURNO - MODIFICADO')
                                            @case('VESPERTINO')
                                            @case('DIARIO')
                                                @livewire('service-request.responsable.other-hours',['serviceRequest' => $serviceRequest])
                                                @break
                                        @endswitch
                                        @break

                                @endswitch
                            </div>
                        </div>


                        <!-- Livewire de rrhh -->
                        @livewire('service-request.period-rrhh', [
                            'fulfillment' => $fulfillment
                        ])
                            
                        <!-- Livewire de Boleta -->
                        <div class="card mb-3 border-warning">
                            <div class="card-body">
                                <h5 class="card-title">Boleta</h5>
                                <div class="form-row mb-3">
                                    <div class="col">
                                        @if($fulfillment->total_to_pay)
                                            @livewire('service-request.upload-invoice', ['fulfillment' => $fulfillment ])
                                        @else
                                            No se ha ingresado el "Total a pagar" en Recuros Humanos.
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Livewire de Finanzas -->
                        @livewire('service-request.period-finance', [
                            'fulfillment' => $fulfillment
                        ])

                        <div class="text-right text-muted small">
                            id cumplimiento: {{ $fulfillment->id }} -
                            <!-- Opcion para borrar un cumplimiento --> 
                            @can('Service Request: delete fulfillments')
                                <a class="text-link text-danger" title="borrar el cumplimiento" href="{{ route('rrhh.service-request.fulfillment.destroy',$fulfillment) }}" onclick="return confirm('¿Está seguro que desea eliminar el período?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            @endcan
                        </div>

                        @can('Service Request: audit')
                            @include('partials.audit', ['audits' => $fulfillment->audits()])
                        @endcan
                    @endif
                </div>
            </div>
        @endif

    @endif

@endsection

@section('custom_js')

@endsection
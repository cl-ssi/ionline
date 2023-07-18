@extends('layouts.app')

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

        <!-- Mostrar el listado de años en los que tenga contratos -->
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

                        <div class="form-row">
                            <div class="col-md-6">
                                <!-- Subir la resolución -->
                                @livewire('service-request.upload-resolution', ['serviceRequest' => $serviceRequest])
                            </div>
                            <div class="col-md-4">
                                <!-- Pasar a livewire -->
                                <label>Firma funcionario</label>
                                <button class="btn btn-warning form-control">
                                    <i class="fas fa-paper-plane"></i>
                                    Pervisualizar y enviar para firma
                                    <i class="fas fa-signature"></i>
                                </button>
                            </div>
                        </div>
                    @endif


                </div>
            </div>
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

                    <!-- Información del incio y término del periodo -->
                    <!-- Quién puede modificar esta información? -->
                    <!-- Pasar a livewire -->
                    <div class="form-row">
                        <fieldset class="form-group col-12 col-md-2">
                            <label for="for_type">Período</label>
                            <select name="type" class="form-control" required="">
                                <option value=""></option>
                                <option value="Mensual" selected="">Mensual</option>
                                <option value="Parcial">Parcial</option>
                            </select>
                        </fieldset>
                        <fieldset class="form-group col-6 col-md-2">
                            <label for="for_start_date">Inicio</label>
                            <input type="date" class="form-control" name="start_date" value="2021-10-01" required="">
                        </fieldset>
                        <fieldset class="form-group col-6 col-md-2">
                            <label for="for_end_date">Término</label>
                            <input type="date" class="form-control" name="end_date" value="2021-10-31" required="">
                        </fieldset>
                        <fieldset class="form-group col-12 col-md-5">
                            <label for="for_observation">Observación</label>
                            <input type="text" class="form-control" name="observation" value="">
                        </fieldset>
                        
                        <fieldset class="form-group col-1">
                            <label for="for_submit"><br></label>
                            <button type="submit" class="btn btn-primary form-control">
                                <i class="fas fa-save"></i>
                            </button>
                        </fieldset>
                    </div>


                    <!-- Livewire de Responsable -->
                    <div class="card border-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Responsable </h5>

                            @if($serviceRequest->program_contract_type == "Mensual")
                                {{-- 
                                @include('service_requests.requests.fulfillments.edit_monthly',['serviceRequest' => $serviceRequest])
                                --}}
                            @else
                                {{-- 
                                @if($serviceRequest->working_day_type == "HORA MÉDICA" or $serviceRequest->working_day_type == "TURNO DE REEMPLAZO")
                                    @include('service_requests.requests.fulfillments.edit_hours_medics',['serviceRequest' => $serviceRequest])
                                @else
                                    @include('service_requests.requests.fulfillments.edit_hours_others',['serviceRequest' => $serviceRequest])
                                @endif
                                --}}
                            @endif
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

                    <div class="text-right text-muted small">id cumplimiento: {{ $fulfillment->id }}</div>

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
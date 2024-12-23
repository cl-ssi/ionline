@extends('layouts.bt4.app')

@section('title', 'Viático')

@section('content')

@include('allowances.partials.nav')

<h5>
    <i class="fas fa-file"></i> Viatico ID: {{ ($allowance->correlative) ? $allowance->correlative : $allowance->id }}
    @switch($allowance->status)
        @case('pending')
            <span class="badge badge-warning">Pendiente</span>
            @break
    
        @case('rejected')
            <span class="badge badge-danger">Rechazado</span>
            @break
        
        @case('complete')
            <span class="badge badge-success">Finalizado</span>
            @break
        
        @case('manual')
            <span class="badge badge-info">Manual</span>
            @break
    @endswitch
</h5>

<br />

<div class="row">
    <div class="col-md-9">
        <h6><i class="fas fa-info-circle"></i> Funcionario</h6>
        <div class="table-responsive">
            <table class="table table-sm table-bordered text-center small">
                <tbody>
                    <tr class="table-active">
                        <th width="37%">Nombre funcionario</th>
                        <th width="13%">RUT</th>
                        <th>Calidad</th>
                        <th>Ley</th>
                    </tr>
                    <tr>
                        <td>{{ $allowance->userAllowance->fullName }}</td>
                        <td>{{ $allowance->userAllowance->id }}-{{ $allowance->userAllowance->dv }}</td>
                        <td>{{ $allowance->contractualCondition->name }}</td>
                        <td>{{ $allowance->LawValue }}</td>
                    </tr>
                    <tr class="table-active">
                        <th colspan="2">Cargo / Función</th>
                        <th colspan="2">Grado E.U.S.</th>
                    </tr>
                    <tr class="text-center">
                        <td colspan="2">{{ $allowance->position }}</td>
                        <td>{{ $allowance->allowanceValue->name }}</td>
                        <td>{{ $allowance->grade }}</td>
                    </tr>
                    <tr class="table-active">
                        <th colspan="2">Establecimiento</th>
                        <th colspan="2">Unidad o Sección</th>
                    </tr>
                    <tr>
                        <td colspan="2">{{ $allowance->organizationalUnitAllowance->establishment->name }}</td>
                        <td colspan="2">{{ $allowance->organizationalUnitAllowance->name }}</td>
                    </tr>
                    <tr class="table-active">
                        <th colspan="4">Motivo</th>
                    </tr>
                    <tr>
                        <td colspan="4">{{ $allowance->reason }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <br>
        <h6><i class="fas fa-info-circle"></i> Origen / Destino(s)</h6>
        <div class="table-responsive">
            <table class="table table-sm table-bordered text-center small">
                <tbody>
                    <tr class="table-active">
                        <th>Origen</th>
                    </tr>
                    <tr>
                        <td>{{ $allowance->originCommune->name }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-bordered text-center small">
                <tbody>
                    <tr class="table-active">
                        <th colspan="3">Destino</th>
                    </tr>
                    <tr class="table-active">
                        <th width="33%">Comuna</th>
                        <th width="33%">Localidad</th>
                        <th width="33%">Descripción</th>
                    </tr>
                    @foreach($allowance->destinations as $destination)
                    <tr>
                        <td>{{ $destination->commune->name }}</td>
                        <td>{{ ($destination->locality) ? $destination->locality->name : '' }}</td>
                        <td>{{ $destination->description }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <br>

        <h6><i class="fas fa-info-circle"></i> Información de Itinerario</h6>
        <div class="table-responsive">
            <table class="table table-sm table-bordered text-center small">
                <tbody>
                    <tr class="table-active">
                        <th>Medio de transporte</th>
                        <th>Itinerario</th>
                        <th>Derecho de pasaje</th>
                    </tr>
                    <tr>
                        <td>{{ $allowance->MeansOfTransportValue }}</td>
                        <td>{{ $allowance->RoundTripValue }}</td>
                        <td>{{ $allowance->PassageValue }}</td>
                    </tr>
                    <tr class="table-active">
                        <th>Pernocta fuera del lugar de residencia</th>
                        <th>Alojamiento *</th>
                        <th>Alimentación *</th>
                    </tr>
                    <tr>
                        <td>{{ $allowance->OvernightValue }}</td>
                        <td>{{ $allowance->AccommodationValue }}</td>
                        <td>{{ $allowance->FoodValue }}</td>
                    </tr>
                    <tr class="table-active">
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th>Sólo medios días</th>
                    </tr>
                    <tr>
                        <td>{{ $allowance->FromFormat }}</td>
                        <td>{{ $allowance->ToFormat }}</td>
                        <td>{{ $allowance->HalfDaysOnlyValue }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row mt-0">
            <div class="col">
                <p class="small">* Incluído en cometido o actividad</p>
            </div>
        </div>

        @if($allowance->allowanceSignature && $allowance->allowanceSignature->status == "completed")
            <a href="{{ route('documents.signatures.showPdf',[$allowance->allowanceSignature->signaturesFileDocument->id, time()])}}"
                class="btn btn-primary float-right" target="_blank"
                title="Ver documento">
                <span class="fas fa-file-pdf" aria-hidden="true"></span> Viático Firmado
            </a>
        @endif
    </div>
    
    <div class="col-md-3">
        <h6><i class="fas fa-paperclip"></i> Archivos Adjuntos</h6>

        @if($allowance->status == 'manual')
            <div class="alert alert-info" role="alert">
                <b>Estimado Usuario</b>: Archivo adjunto no disponible para este Viático
            </div>
        @endif
        
        <div class="list-group">
            @foreach($allowance->files as $allowanceFile)
            <a href="{{ route('allowances.files.show', $allowanceFile) }}" class="list-group-item list-group-item-action py-2 small" target="_blank">
                <i class="fas fa-file"></i> {{ $allowanceFile->name }} <br>
                <i class="fas fa-calendar-day"></i> {{ $allowanceFile->created_at->format('d-m-Y H:i') }}</a>
            @endforeach
        </div>

        <!-- PDF -->
        @if(count($allowance->approvals) > 0 && $allowance->approvals->last()->status == 1)
        <div class="list-group mt-3">
            <a href="{{ route('allowances.download_resol_pdf', $allowance) }}" class="list-group-item list-group-item-action py-2 active small" target="_blank">
                <i class="fas fa-file-pdf"></i> Viático Firmado <br>
            </a>
        </div>
        @endif
    </div>
</div>

<br>

@livewire('allowances.show-summary',[
    'allowance' => $allowance
])

<br><br>

<h6><i class="fas fa-check-circle"></i> Gestión de aprobaciones</h6>

@if($allowance->status == 'manual')
    <div class="alert alert-info" role="alert">
        <b>Estimado Usuario</b>: Gestión de aprobaciones no disponible para este Viático
    </div>
@else
    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-sm table-bordered small">
                    <tbody>
                        <tr>
                            @foreach($allowance->AllowanceSigns as $sign)
                                <td class="table-active text-center">
                                    <strong>{{ $sign->organizationalUnit->name }}</strong><br>
                                </td>
                            @endforeach
                            @if(count($allowance->approvals) > 0)
                                @foreach($allowance->approvals as $approval)
                                    <td class="table-active text-center">
                                        <strong>{{ ($approval->sentToOu) ? $approval->sentToOu->name : $approval->sentToUser->fullName }}</strong><br>
                                    </td>
                                @endforeach
                            @endif
                        </tr>
                        <tr>
                            @foreach($allowance->AllowanceSigns as $allowanceSign)
                            <td class="text-center">
                                {{--
                                @if($subrogants && $allowanceSign->status == 'pending')
                                    <div class="alert alert-info" role="alert">
                                        <b>Estimado Usuario</b>: Según el calendario de autoridades <b>{{ $allowance->userAllowance->tinyName }}</b> es director(a) {{ $allowance->userAllowance->organizationalUnit->establishment->name }}
                                    </div>
                                @endif
                                
                                @if($allowanceSign->status == 'pending' &&
                                    $allowanceSign->event_type == 'sirh' &&
                                    auth()->user()->can('Allowances: sirh'))
                                    <form method="POST" class="form-horizontal" action="{{ route('allowances.sign.update', [$allowanceSign, 'status' => 'accepted']) }}">
                                        @csrf
                                        @method('PUT')

                                        <!-- CAMPO PARA ELEGIR SUBRROGANTE DE DIRECCION -->
                                        @if($subrogants)
                                            <fieldset class="form-group">
                                                <label for="for_gender" >Quien aprueba viátido de director?</label>
                                                <select name="approver" id="for_approver" class="form-control" required>
                                                    <option value="">Seleccione...</option>                                           
                                                    @foreach($subrogants as $subrogant)
                                                        <option value="{{ $subrogant->subrogant_id}}">{{ $subrogant->subrogant->fullName }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        @endif
                                        
                                        <button type="submit" class="btn btn-success btn-sm ml-2 mt-2"
                                            onclick="return confirm('¿Está seguro que desea Aceptar la solicitud?')"
                                            title="Aceptar">
                                            <i class="fas fa-check-circle"></i> Aceptar
                                        </button>

                                        <a class="btn btn-danger btn-sm mt-2" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                            <i class="fas fa-times-circle"></i> Rechazar
                                        </a>
                                    </form>    

                                    <div class="row">
                                        <div class="col-md">
                                            <div class="collapse" id="collapseExample">
                                                <form method="POST" class="form-horizontal" action="{{ route('allowances.sign.update', [$allowanceSign, 'status' => 'rejected', $allowance]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label class="float-left" for="for_observation">Motivo Rechazo</label>
                                                        <textarea class="form-control" id="for_observation" name="observation" rows="2"></textarea>
                                                    </div>
                                                        
                                                    <button type="submit" class="btn btn-danger btn-sm float-right"
                                                        onclick="return confirm('¿Está seguro que desea Rechazar la solicitud?')"
                                                        title="Rechazar">
                                                        <i class="fas fa-times-circle"></i> Guardar</a>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                --}}

                                {{-- dd(auth()->user()->organizationalUnit->establishment_id, App\Models\Parameters\Parameter::get('establishment', 'SSTarapaca')) --}}

                                @if($allowanceSign->status == 'pending' &&
                                    $allowanceSign->event_type == 'sirh' &&
                                    auth()->user()->can('Allowances: sirh') && 
                                    $allowanceSign->allowance->establishment_id == App\Models\Parameters\Parameter::get('establishment', 'SSTarapaca')  &&
                                    auth()->user()->organizationalUnit->establishment_id == App\Models\Parameters\Parameter::get('establishment', 'SSTarapaca'))
                                    @if($subrogants && $allowanceSign->status == 'pending')
                                        <div class="alert alert-info" role="alert">
                                            <b>Estimado Usuario</b>: Según el calendario de autoridades <b>{{ $allowance->userAllowance->tinyName }}</b> es director(a) {{ $allowance->userAllowance->organizationalUnit->establishment->name }}
                                        </div>
                                    @endif
                                    
                                    <form method="POST" class="form-horizontal" action="{{ route('allowances.sign.update', [$allowanceSign, 'status' => 'accepted']) }}">
                                        @csrf
                                        @method('PUT')

                                        <!-- CAMPO PARA ELEGIR SUBRROGANTE DE DIRECCION -->
                                        @if($subrogants)
                                            <fieldset class="form-group">
                                                <label for="for_gender" >Quien aprueba viátido de director?</label>
                                                <select name="approver" id="for_approver" class="form-control" required>
                                                    <option value="">Seleccione...</option>                                           
                                                    @foreach($subrogants as $subrogant)
                                                        <option value="{{ $subrogant->subrogant_id}}">{{ $subrogant->subrogant->fullName }}</option>
                                                    @endforeach
                                                </select>
                                            </fieldset>
                                        @endif
                                        
                                        <button type="submit" class="btn btn-success btn-sm ml-2 mt-2"
                                            onclick="return confirm('¿Está seguro que desea Aceptar la solicitud?')"
                                            title="Aceptar">
                                            <i class="fas fa-check-circle"></i> Aceptar
                                        </button>

                                        <a class="btn btn-danger btn-sm mt-2" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                            <i class="fas fa-times-circle"></i> Rechazar
                                        </a>
                                    </form>    

                                    <div class="row">
                                        <div class="col-md">
                                            <div class="collapse" id="collapseExample">
                                                <form method="POST" class="form-horizontal" action="{{ route('allowances.sign.update', [$allowanceSign, 'status' => 'rejected', $allowance]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label class="float-left" for="for_observation">Motivo Rechazo</label>
                                                        <textarea class="form-control" id="for_observation" name="observation" rows="2"></textarea>
                                                    </div>
                                                        
                                                    <button type="submit" class="btn btn-danger btn-sm float-right"
                                                        onclick="return confirm('¿Está seguro que desea Rechazar la solicitud?')"
                                                        title="Rechazar">
                                                        <i class="fas fa-times-circle"></i> Guardar</a>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <!-- SIRH HAH -->
                                @if($allowanceSign->status == 'pending' &&
                                    $allowanceSign->event_type == 'sirh' &&
                                    auth()->user()->can('Allowances: sirh') && 
                                    $allowanceSign->allowance->establishment_id == App\Models\Parameters\Parameter::get('establishment', 'HospitalAltoHospicio')  &&
                                    auth()->user()->organizationalUnit->establishment_id == App\Models\Parameters\Parameter::get('establishment', 'HospitalAltoHospicio')) 
                                    <form method="POST" class="form-horizontal" action="{{ route('allowances.sign.update', [$allowanceSign, 'status' => 'accepted']) }}">
                                        @csrf
                                        @method('PUT')
                                        
                                        <button type="submit" class="btn btn-success btn-sm ml-2 mt-2"
                                            onclick="return confirm('¿Está seguro que desea Aceptar la solicitud?')"
                                            title="Aceptar">
                                            <i class="fas fa-check-circle"></i> Aceptar
                                        </button>

                                        <a class="btn btn-danger btn-sm mt-2" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                            <i class="fas fa-times-circle"></i> Rechazar
                                        </a>
                                    </form>    

                                    <div class="row">
                                        <div class="col-md">
                                            <div class="collapse" id="collapseExample">
                                                <form method="POST" class="form-horizontal" action="{{ route('allowances.sign.update', [$allowanceSign, 'status' => 'rejected', $allowance]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label class="float-left" for="for_observation">Motivo Rechazo</label>
                                                        <textarea class="form-control" id="for_observation" name="observation" rows="2"></textarea>
                                                    </div>
                                                        
                                                    <button type="submit" class="btn btn-danger btn-sm float-right"
                                                        onclick="return confirm('¿Está seguro que desea Rechazar la solicitud?')"
                                                        title="Rechazar">
                                                        <i class="fas fa-times-circle"></i> Guardar</a>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                @endif

                                <!-- CONTABILIDAD HAH -->
                                @if($allowanceSign->status == 'pending' &&
                                    $allowanceSign->event_type == 'contabilidad' &&
                                    auth()->user()->can('Allowances: contabilidad') && 
                                    $allowanceSign->allowance->establishment_id == App\Models\Parameters\Parameter::get('establishment', 'HospitalAltoHospicio')  &&
                                    auth()->user()->organizationalUnit->establishment_id == App\Models\Parameters\Parameter::get('establishment', 'HospitalAltoHospicio')) 
                                    <form method="POST" class="form-horizontal" action="{{ route('allowances.sign.update', [$allowanceSign, 'status' => 'accepted']) }}">
                                        @csrf
                                        @method('PUT')
                                        
                                        <button type="submit" class="btn btn-success btn-sm ml-2 mt-2"
                                            onclick="return confirm('¿Está seguro que desea Aceptar la solicitud?')"
                                            title="Aceptar">
                                            <i class="fas fa-check-circle"></i> Aceptar
                                        </button>

                                        <a class="btn btn-danger btn-sm mt-2" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                            <i class="fas fa-times-circle"></i> Rechazar
                                        </a>
                                    </form>   

                                    <div class="row">
                                        <div class="col-md">
                                            <div class="collapse" id="collapseExample">
                                                <form method="POST" class="form-horizontal" action="{{ route('allowances.sign.update', [$allowanceSign, 'status' => 'rejected', $allowance]) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group">
                                                        <label class="float-left" for="for_observation">Motivo Rechazo</label>
                                                        <textarea class="form-control" id="for_observation" name="observation" rows="2"></textarea>
                                                    </div>
                                                        
                                                    <button type="submit" class="btn btn-danger btn-sm float-right"
                                                        onclick="return confirm('¿Está seguro que desea Rechazar la solicitud?')"
                                                        title="Rechazar">
                                                        <i class="fas fa-times-circle"></i> Guardar</a>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- INFO DE ESTADOS -->
                                @if($allowanceSign->status == 'pending')
                                    <i class="fas fa-clock"></i> Pendiente de Aprobación.<br>
                                @endif
                                @if($allowanceSign->status == 'accepted')
                                    <span style="color: green;">
                                        <i class="fas fa-check-circle"></i> {{ $allowanceSign->StatusValue }}
                                    </span> <br>
                                    <i class="fas fa-user"></i> {{ $allowanceSign->user->fullName }}<br>
                                    <i class="fas fa-calendar-alt"></i> {{ $allowanceSign->date_sign->format('d-m-Y H:i:s') }}<br>
                                @endif
                                @if($allowanceSign->status == 'rejected')
                                    <span style="color: Tomato;">
                                        <i class="fas fa-times-circle"></i> {{ $allowanceSign->StatusValue }} 
                                    </span><br>
                                    <i class="fas fa-user"></i> {{ $allowanceSign->user->fullName }}<br>
                                    <i class="fas fa-calendar-alt"></i> {{ $allowanceSign->date_sign->format('d-m-Y H:i:s') }}<br>
                                    <hr>
                                    {{ $allowanceSign->observation }}<br>
                                @endif
                                @if($allowanceSign->status == NULL)
                                    <i class="fas fa-ban"></i> No disponible para Aprobación.<br>
                                @endif
                            </td>
                            @endforeach

                            @if(count($allowance->approvals) > 0)
                                @foreach($allowance->approvals as $approval)
                                    <td class="text-center">
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
                                @endforeach
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

@endsection

@section('custom_js')

@endsection
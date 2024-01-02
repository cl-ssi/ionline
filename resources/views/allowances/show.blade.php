@extends('layouts.bt4.app')

@section('title', 'Viático')

@section('content')

@include('allowances.partials.nav')

<h5>
    <i class="fas fa-file"></i> Viatico ID: {{ $allowance->id }} <br>
</h5>
<h6>
    Folio sirh: @if($allowance->folio_sirh) {{ $allowance->folio_sirh }} @else No disponible @endif
</h6>

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
                        <td>{{ $allowance->userAllowance->FullName }}</td>
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
        <div class="list-group">
            @foreach($allowance->files as $allowanceFile)
            <a href="{{ route('allowances.files.show', $allowanceFile) }}" class="list-group-item list-group-item-action py-2 small" target="_blank">
                <i class="fas fa-file"></i> {{ $allowanceFile->name }} <br>
                <i class="fas fa-calendar-day"></i> {{ $allowanceFile->created_at->format('d-m-Y H:i') }}</a>
            @endforeach
        </div>
    </div>
</div>

<br>

<h6><i class="fas fa-dollar-sign"></i> Resumen</h6>
<div class="table-responsive">
    <table class="table table-sm table-bordered table-striped table-hover">
        <tbody>
            <tr class="text-center">
                <th>Viático</th>
                <th>%</th>
                <th>Valor</th>
                <th>N° Días</th>
                <th>Valor Total</th>
            </tr>
            <tr>
                <td><b>1. DIARIO</b></td>
                <td class="text-center">100%</td>
                <td class="text-right">
                    ${{ number_format($allowance->allowanceValue->value, 0, ",", ".") }}
                </td>
                <td class="text-center"> 
                    {{ ($allowance->total_days) ? intval($allowance->total_days) : 0 }}
                </td>
                <td class="text-right">
                    ${{ ($allowance->total_days >= 1) ? number_format(($allowance->day_value * intval($allowance->total_days)), 0, ",", ".") : '0' }}
                </td>
            </tr>
            <tr>
                <td><b>2. PARCIAL</b></td>
                <td class="text-center">40%</td>
                <td class="text-right">
                    ${{ ($allowance->half_day_value) ? number_format($allowance->half_day_value, 0, ",", ".") : '0' }}
                </td>
                <td class="text-center">
                    {{ ($allowance->total_half_days) ? intval($allowance->total_half_days) : 0 }}

                    @if($allowance->total_half_days && $allowance->total_half_days > 1)
                        medios días
                    @elseif($allowance->total_half_days && $allowance->total_half_days == 1)
                        medio día
                    @else

                    @endif
                </td>
                <td class="text-right">
                    ${{ ($allowance->half_day_value) ? number_format($allowance->half_day_value * $allowance->total_half_days, 0, ",", ".") : '' }}
                </td>
            </tr>
            <tr>
                <td><b>3. PARCIAL</b></td>
                <td class="text-center">50%</td>
                <td class="text-right">
                    ${{ ($allowance->fifty_percent_day_value) ? number_format($allowance->fifty_percent_day_value, 0, ",", ".") : '0' }}
                </td>
                <td class="text-center">
                    {{ ($allowance->fifty_percent_total_days) ? intval($allowance->fifty_percent_total_days) : 0 }}
                </td>
                <td class="text-right">
                    ${{ ($allowance->fifty_percent_day_value) ? number_format($allowance->fifty_percent_day_value * $allowance->fifty_percent_total_days, 0, ",", ".") : '' }}
                </td>
            </tr>
            <tr>
                <td colspan="3"></td>                    
                <td class="text-center"><b>Total</b></td>
                <td class="text-right">
                    ${{ number_format($allowance->total_value, 0, ",", ".") }}
                </td>
            </tr>
        </tbody>
    </table>
</div>

<br>

{{--
@if($allowance->allowanceSigns->first()->status == 'pending')
    <i class="fas fa-check-circle"></i> Gestión de víatico.
    <div class="table-responsive">
        <table class="table table-sm table-bordered small">
            <tbody>
                    @php 
                        $signsCount = $allowance->AllowanceSigns->whereNotIn('status', ['not valid'])->count();
                        $width = 100 / $signsCount;
                    @endphp
                <tr>
                    @foreach($allowance->AllowanceSigns->whereNotIn('status', ['not valid']) as $sign)
                    <td class="table-active text-center" width="{{ $width }}">
                        <strong>{{ $sign->organizationalUnit->name }}</strong><br>
                        @if($sign->event_type == "sirh")
                            SIRH
                        @endif
                    </td>
                    @endforeach
                </tr>
                <tr>
                    @foreach($allowance->AllowanceSigns->whereNotIn('status', ['not valid']) as $allowanceSign)
                    <td class="text-center" width="{{ $width }}">
                        @if($allowanceSign->status == 'pending')
                            @if($allowanceSign->event_type == 'sirh' && Auth::user()->can('Allowances: sirh'))
                                <form method="POST" class="form-horizontal" action="{{ route('allowances.sign.update', [$allowanceSign, 'status' => 'accepted', $allowance]) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-row">
                                        <fieldset class="form-group col-12 col-md-12">
                                            <label for="for_folio_sirh" class="float-left">Folio sirh</label>
                                            <input class="form-control" type="number" autocomplete="off" name="folio_sirh" required>
                                        </fieldset>
                                    </div>

                                    <button type="submit" class="btn btn-success btn-sm float-right ml-2"
                                        onclick="return confirm('¿Está seguro que desea Aceptar la solicitud?')"
                                        title="Aceptar">
                                        <i class="fas fa-check-circle"></i> Aceptar
                                    </button>

                                    <a class="btn btn-danger btn-sm float-right" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <i class="fas fa-times-circle"></i> Rechazar
                                    </a>
                                </form>    
                                
                                <br><br>

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
                            
                            @elseif($allowanceSign->event_type != 'chief financial officer' && 
                                $allowanceSign->event_type != 'sirh')
                                
                                @foreach(App\Rrhh\Authority::getAmIAuthorityFromOu(Carbon\Carbon::now(), 'manager', auth()->user()->id) as $authority)
                                    @if($authority->organizational_unit_id == $allowanceSign->organizational_unit_id)
                                        <form method="POST" class="form-horizontal" action="{{ route('allowances.sign.update', [$allowanceSign, 'status' => 'accepted', $allowance]) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm"
                                                onclick="return confirm('¿Está seguro que desea Aceptar la solicitud?')"
                                                title="Aceptar">
                                                <i class="fas fa-check-circle"></i> Aceptar
                                            </button>

                                            <a class="btn btn-danger btn-sm" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                <i class="fas fa-times-circle"></i> Rechazar
                                            </a>
                                        </form>

                                        <div class="row">
                                            <div class="col-md">
                                                <div class="collapse" id="collapseExample">
                                                    <br>
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
                                @endforeach
                            @else
                                @if($allowanceSign->event_type == 'chief financial officer')
                                    @foreach(App\Rrhh\Authority::getAmIAuthorityFromOu(Carbon\Carbon::now(), 'manager', auth()->user()->id) as $authority)
                                        @if($authority->organizational_unit_id == $allowanceSign->organizational_unit_id)
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModal">
                                                <i class="fas fa-check-circle"></i> Aceptar
                                            </button>
                                            @include('allowances.partials.document_sign')
                                            
                                            <a class="btn btn-danger btn-sm" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                <i class="fas fa-times-circle"></i> Rechazar
                                            </a>
                                            <div class="row">
                                                <div class="col-md">
                                                    <div class="collapse" id="collapseExample">
                                                        <br>
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
                                    @endforeach
                                @endif
                            @endif
                            <i class="fas fa-clock"></i> Pendiente de Aprobación
                        @endif
                        @if($allowanceSign->status == 'accepted')
                            <span style="color: green;">
                                <i class="fas fa-check-circle"></i> {{ $allowanceSign->StatusValue }}
                            </span> <br>
                            <i class="fas fa-user"></i> {{ $allowanceSign->user->FullName }}<br>
                            <i class="fas fa-calendar-alt"></i> {{ $allowanceSign->date_sign->format('d-m-Y H:i:s') }}<br>
                        @endif
                        @if($allowanceSign->status == 'rejected')
                            <span style="color: Tomato;">
                                <i class="fas fa-times-circle"></i> {{ $allowanceSign->StatusValue }} 
                            </span><br>
                            <i class="fas fa-user"></i> {{ $allowanceSign->user->FullName }}<br>
                            <i class="fas fa-calendar-alt"></i> {{ $allowanceSign->date_sign->format('d-m-Y H:i:s') }}<br>
                            <hr>
                            {{ $allowanceSign->observation }}<br>
                        @endif
                        @if($allowanceSign->status == NULL)
                            <i class="fas fa-ban"></i> No disponible para Aprobación.<br>
                        @endif
                    </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
@else
    <i class="fas fa-check-circle"></i> Gestión / Firma Electrónica de Documento.
    <div class="table-responsive">
        <table class="table table-sm table-bordered small">
            <thead>
                <tr class="text-center">
                    @php 
                        $signsCount = $allowance->AllowanceSigns->whereNotIn('status', ['not valid'])->count();
                        $width = 100 / $signsCount;
                    @endphp
                    @foreach($allowance->AllowanceSigns as $sign)
                    <th class="table-active" width="{{ $width }}">
                        {{ $sign->organizationalUnit->name }}<br>
                        @if($sign->event_type == "sirh")
                            SIRH
                        @endif
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                    <td>
                        @if($allowance->allowanceSigns->first()->status == 'accepted')
                            <span style="color: green;">
                                <i class="fas fa-check-circle"></i> Folio Ingresado N°: {{ $allowance->folio_sirh }}
                            </span> <br>
                            <i class="fas fa-user"></i> {{ $allowance->allowanceSigns->first()->user->FullName }}<br>
                            <i class="fas fa-calendar-alt"></i> {{ $allowance->allowanceSigns->first()->date_sign->format('d-m-Y H:i') }}<br>
                        @endif
                        @if($allowance->allowanceSigns->first()->status == 'rejected')
                            <span style="color: Tomato;">
                                <i class="fas fa-times-circle"></i> {{ $allowance->allowanceSigns->first()->StatusValue }} 
                            </span><br>
                            <i class="fas fa-user"></i> {{ $allowance->allowanceSigns->first()->user->FullName }}<br>
                            <i class="fas fa-calendar-alt"></i> {{ $allowance->allowanceSigns->first()->date_sign->format('d-m-Y H:i:s') }}<br>
                            <hr>
                            <b>Motivo: </b>{{ $allowance->allowanceSigns->first()->observation }}<br>
                        @endif
                    </td>
                    @if($allowance->allowanceSigns->first()->status == 'accepted')
                    @foreach($allowance->allowanceSignature->signaturesFlows as $flow)
                    <td>
                        @if($flow->status === null)
                            <span>
                                <i class="fas fa-clock"></i> Pendiente 
                            </span><br>
                        @endif
                        @if($flow->status === 1)
                            <span style="color: green;">
                                <i class="fas fa-check-circle"></i> Aceptada
                            </span> <br>
                            <i class="fas fa-user"></i> {{ $flow->userSigner->FullName }}<br>
                            <i class="fas fa-calendar-alt"></i> {{ $flow->signature_date->format('d-m-Y H:i') }}<br>
                        @endif
                        @if($flow->status === 0)
                            <span style="color: tomato;">
                                <i class="fas fa-check-circle"></i> Rechazada
                            </span> <br>
                            <i class="fas fa-user"></i> {{ $flow->userSigner->FullName }}<br>
                            
                            <hr>
                            <b>Motivo: </b>{{ $flow->observation }}<br>
                        @endif
                    </td>
                    @endforeach
                    @endif
                    @if($allowance->allowanceSigns->first()->status == 'rejected')
                    @foreach($allowance->AllowanceSigns->whereNotIn('event_type', ['sirh']) as $sign)
                    <td>
                            
                    </td>
                    @endforeach
                    @endif
                </tr>
            </tbody>
        </table>
    </div>
@endif
--}}


@endsection

@section('custom_js')

@endsection
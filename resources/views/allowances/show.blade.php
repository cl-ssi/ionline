@extends('layouts.app')

@section('title', 'Viático')

@section('content')

@include('allowances.partials.nav')

<h5>
    <i class="fas fa-file"></i> Viatico ID: {{ $allowance->id }} - Folio sirh: @if($allowance->folio_sirh) {{ $allowance->folio_sirh }} @else No disponible @endif
</h5>

<br />

<div class="row">
    <div class="col-md-9">
        <h6><i class="fas fa-info-circle"></i> Descripción de Viático</h6>
        <div class="table-responsive">
            <table class="table table-sm table-bordered text-center small">
                <tbody>
                    <tr class="table-active">
                        <th colspan="2" width="50%">Nombre completo</th>
                        <th>RUT</th>
                        <th>Calidad</th>
                    </tr>
                    <tr>
                        <td colspan="2">{{ $allowance->userAllowance->FullName }}</td>
                        <td>{{ $allowance->userAllowance->id }}-{{ $allowance->userAllowance->dv }}</td>
                        <td>{{ $allowance->ContractualConditionValue }}</td>
                    </tr>
                    <tr class="table-active">
                        <th colspan="2">Cargo / Función</th>
                        <th colspan="2">Gr. Cat. horas</th>
                    </tr>
                    <tr class="text-center">
                        <td colspan="2">{{ $allowance->position }}</td>
                        <td colspan="2">{{ $allowance->allowanceValue->name }}</td>
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
                        <th width="25%">Origen</th>
                        <th width="25%">Destino</th>
                        <th width="25%">Lugar</th>
                        <th width="25%">Motivo</th>
                    </tr>
                    <tr>
                        <td>{{ $allowance->originCommune->name }}</td>
                        <td>{{ $allowance->destinationCommune->name }}</td>
                        <td>{{ $allowance->place }}</td>
                        <td>{{ $allowance->reason }}</td>
                    </tr>
                    <tr class="table-active">
                        <th>Medio de transporte</th>
                        <th>Itinerario</th>
                        <th>Derecho de pasaje</th>
                        <th>Pernocta fuera del lugar de residencia</th>
                    </tr>
                    <tr>
                        <td>{{ $allowance->MeansOfTransportValue }}</td>
                        <td>{{ $allowance->RoundTripValue }}</td>
                        <td>{{ $allowance->PassageValue }}</td>
                        <td>{{ $allowance->OvernightValue }}</td>
                    </tr>
                    <tr class="table-active">
                        <th>Desde</th>
                        <th>Hasta</th>
                    </tr>
                    <tr>
                        <td>{{ $allowance->from->format('d-m-Y') }}</td>
                        <td>{{ $allowance->to->format('d-m-Y') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if($allowance->signatures_file_id)
            <a class="btn btn-primary float-right" title="Ver viático firmado" 
                href="{{ route('allowances.show_file', $allowance) }}" target="_blank">
                <i class="fas fa-file-pdf"></i> Viático Firmado
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
                <th>Valor</th>
                <th>N° Días</th>
                <th>Valor Total</th>
            </tr>
            <tr>
                <td><b>1. DIARIO</b></td>
                <td class="text-right">
                    ${{ $allowance->day_value ? number_format($allowance->day_value, 0, ",", ".") : number_format($allowance->allowanceValue->value, 0, ",", ".") }}
                </td>
                <td class="text-center">{{ intval($allowance->total_days) }}</td>
                <td class="text-right">
                    ${{ ($allowance->total_days >= 1) ? number_format(($allowance->day_value * intval($allowance->total_days)), 0, ",", ".") : '0' }}
                </td>
            </tr>
            <tr>
                <td><b>2. PARCIAL</b></td>
                <td class="text-right">
                    ${{ number_format($allowance->half_day_value, 0, ",", ".") }}
                </td>
                <td class="text-center">0,5</td>
                <td class="text-right">${{ number_format($allowance->half_day_value, 0, ",", ".") }}</td>
            </tr>
            <tr>
                <td colspan="2"></td>                    
                <td class="text-center"><b>Total</b></td>
                <td class="text-right">${{ number_format($allowance->total_value, 0, ",", ".") }}</td>
            </tr>
        </tbody>
    </table>
</div>

<br>

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



@endsection

@section('custom_js')

@endsection
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

<h5>
    <i class="fas fa-file"></i> Viatico ID: {{ $allowance->id }} <br>
    Folio sirh: @if($allowance->folio_sirh) {{ $allowance->folio_sirh }} @else No disponible @endif
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
                <td><b>4. PARCIAL</b></td>
                <td class="text-center">60%</td>
                <td class="text-right">
                    ${{ ($allowance->sixty_percent_day_value) ? number_format($allowance->sixty_percent_day_value, 0, ",", ".") : '0' }}
                </td>
                <td class="text-center">
                    {{ ($allowance->sixty_percent_total_days) ? intval($allowance->sixty_percent_total_days) : 0 }}
                </td>
                <td class="text-right">
                    ${{ ($allowance->sixty_percent_day_value) ? number_format($allowance->sixty_percent_day_value * $allowance->sixty_percent_total_days, 0, ",", ".") : '' }}
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

@if($allowance->approvals)
    <i class="fas fa-check-circle"></i> Gestión de víatico. 
    <div class="table-responsive">
        <table class="table table-sm table-bordered small">
            <tbody>
                <tr>
                    @foreach($allowance->approvals as $approval)
                    <td class="table-active text-center">
                        <strong>{{ $approval->sentToOu->name }}</strong><br>
                    </td>
                    @endforeach
                </tr>
                <tr>
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
                            <i class="fas fa-user"></i> {{ $approval->approver->FullName }}<br>
                            <i class="fas fa-calendar-alt"></i> {{ $approval->approver_at->format('d-m-Y H:i:s') }}<br>
                        @endif
                        @if($approval->StatusInWords == "Rechazado")
                            <span style="color: tomato;">
                                <i class="fas fa-check-circle"></i> {{ $approval->StatusInWords }}
                            </span> <br>
                            <i class="fas fa-user"></i> {{ $approval->approver->FullName }}<br>
                            <i class="fas fa-calendar-alt"></i> {{ $approval->approver_at->format('d-m-Y H:i:s') }}<br>
                        @endif
                    </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
@endif

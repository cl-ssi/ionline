<tr>
    <td colspan="8">
    <table class="table table-bordered table-sm mb-0" style="table-layout: fixed; width: 100%;">
            <!-- Colgroup para igualar anchos -->
            <colgroup>
                <col style="width: 5%;">
                <col style="width: 15%;">
                <col style="width: 20%;">
                <col style="width: 25%;">
                <col style="width: 10%;">
                <col style="width: 15%;">
                <col style="width: 25%;">
                <col style="width: 15%;">
            </colgroup>
            <tbody>
            <tr>
                <td>{{ $request->id }}</td>
                <td>{{ $request->created_at->format('Y-m-d') }}</td>
                <td>
                    {{ $request->applicant->shortName }}
                    <br><small>{{ $request->applicant->runFormat }}</small>
                </td>
                <td>
                    @if ($request->subsidy->benefit)
                        {{ $request->subsidy->benefit->name }} - {{ $request->subsidy->name }}
                    @endif
                    <br>Monto solicitado: <b>${{ money($request->requested_amount) }}</b>
                    @if ($request->status != 'En revisión')
                        <div class="input-group mt-2">
                            <span class="input-group-text" style="align-self: flex-start; height: auto;">Observación</span>
                            <textarea class="form-control" wire:model="observation" style="height: 100px;"></textarea>
                            <div wire:loading wire:target="saveObservation, cancel">
                                <i class="fas fa-spinner fa-spin"></i> Espere...
                            </div>
                            <div wire:loading.remove wire:target="saveObservation, cancel">
                                <button wire:click="saveObservation" class="btn btn-primary btn-sm mt-2">
                                    <i class="bi bi-floppy"></i> Guardar
                                </button>
                                <!-- <button wire:click="cancel" class="btn btn-secondary btn-sm mt-2">
                                    <i class="bi bi-x-circle"></i> Cancelar
                                </button> -->
                            </div>
                        </div>
                    @endif
                </td>
                <td>
                    @foreach ($request->files as $file)
                        <a href="{{ route('welfare.download', $file->id) }}" target="_blank">
                            <i class="fas fa-paperclip"></i>
                        </a>
                    @endforeach
                </td>
                <td>
                    @if ($request->status == 'En revisión')
                        <div wire:loading wire:target="accept, reject">
                            <i class="fas fa-spinner fa-spin text-primary"></i> Procesando...
                        </div>
                        <div wire:loading.remove wire:target="accept, reject">
                            <button wire:click="accept" class="btn btn-outline-success btn-sm" type="button" wire:loading.attr="disabled">
                                <i class="fa fa-check"></i> Aceptar
                            </button>
                            <button wire:click="reject" class="btn btn-outline-danger btn-sm" type="button" wire:loading.attr="disabled">
                                <i class="fa fa-times"></i> Rechazar
                            </button>
                        </div>
                    @elseif ($request->status == 'Aceptado')
                        <div wire:loading wire:target="reject">
                            <i class="fas fa-spinner fa-spin text-primary"></i> Procesando...
                        </div>
                        <div wire:loading.remove wire:target="reject">
                            <button class="btn btn-success btn-sm" disabled>
                                <i class="fa fa-check"></i> Aceptado
                            </button>
                            <button wire:click="reject" class="btn btn-outline-danger btn-sm" type="button" wire:loading.attr="disabled">
                                <i class="fa fa-times"></i> Rechazar
                            </button>
                        </div>
                    @elseif ($request->status == 'Rechazado')
                        <div wire:loading wire:target="accept">
                            <i class="fas fa-spinner fa-spin text-primary"></i> Procesando...
                        </div>
                        <div wire:loading.remove wire:target="accept">
                            <button wire:click="accept" class="btn btn-outline-success btn-sm" type="button" wire:loading.attr="disabled">
                                <i class="fa fa-check"></i> Aceptar
                            </button>
                            <button class="btn btn-danger btn-sm" disabled>
                                <i class="fa fa-times"></i> Rechazado
                            </button>
                        </div>
                    @elseif ($request->status == 'Pagado')
                        <button class="btn btn-info btn-sm" disabled>
                            <i class="bi bi-cash-coin"></i> Pagado
                        </button>
                    @endif

                    @if($showTextarea == 1)
                        <div class="mt-2">
                            <textarea class="form-control" wire:model="observation" placeholder="Ingrese la observación"></textarea>
                            <div wire:loading wire:target="saveCancelObservation">
                                <i class="fas fa-spinner fa-spin"></i> Espere...
                            </div>
                            <div wire:loading.remove wire:target="saveCancelObservation">
                                <div class="mt-2">
                                    <button class="btn btn-primary" wire:click="saveCancelObservation" wire:loading.attr="disabled">
                                        <i class="bi bi-save"></i> Guardar
                                    </button>
                                    <button class="btn btn-secondary" wire:click="cancel">
                                        <i class="bi bi-x-circle"></i> Cancelar
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </td>

                
                
                <td>
                    <div class="input-group mb-2">
                        <span class="input-group-text">$</span>
                        <input type="number" wire:model="acceptedAmount" class="form-control" @disabled($request->status != 'Aceptado')>
                        <div wire:loading wire:target="saveAcceptedAmount">
                            <i class="fas fa-spinner fa-spin"></i> Espere...
                        </div>
                        <div wire:loading.remove wire:target="saveAcceptedAmount">
                            <button wire:click="saveAcceptedAmount" class="btn btn-primary btn-sm" @disabled($request->status != 'Aceptado')>
                                <i class="bi bi-floppy"></i>
                            </button>
                        </div>
                    </div>
                    <div class="input-group mb-2">
                        <span class="input-group-text">Folio</span>
                        <input type="text" wire:model="folioNumber" class="form-control" @disabled($request->status != 'Aceptado')>
                        <div wire:loading wire:target="saveFolio">
                            <i class="fas fa-spinner fa-spin"></i> Espere...
                        </div>
                        <div wire:loading.remove wire:target="saveFolio">
                            <button wire:click="saveFolio" class="btn btn-primary btn-sm" @disabled($request->status != 'Aceptado')>
                                <i class="bi bi-floppy"></i>
                            </button>
                        </div>
                    </div>
                    @if ($request->accepted_amount && $request->subsidy->payment_in_installments)
                        <div class="input-group">
                            <span class="input-group-text">N°Cuotas</span>
                            <input type="number" wire:model="installmentsNumber" class="form-control" @disabled($request->status != 'Aceptado')>
                            <div wire:loading wire:target="saveInstallmentsNumber">
                                <i class="fas fa-spinner fa-spin"></i> Espere...
                            </div>
                            <div wire:loading.remove wire:target="saveInstallmentsNumber">
                                <button wire:click="saveInstallmentsNumber" class="btn btn-primary btn-sm" @disabled($request->status != 'Aceptado')>
                                    <i class="bi bi-floppy"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                </td>
                <td>
                    @if ($request->payed_date)
                        {{ $request->payed_date->format('Y-m-d') }} - <b>${{ money($request->payed_amount) }}</b>
                    @elseif ($request->status == 'Aceptado')
                        <div wire:loading wire:target="saveTransfer">
                            <i class="fas fa-spinner fa-spin"></i> Espere...
                        </div>
                        <div wire:loading.remove wire:target="saveTransfer">
                            <button wire:click="saveTransfer" class="btn btn-success btn-sm">
                                <i class="bi bi-cash"></i> Transferencia
                            </button>
                        </div>
                    @endif
                </td>
            </tr>
            <!-- Fila 2: Revisor -->
            <tr>
                <td colspan="8">
                    @if ($request->responsable)
                        <small>Revisor: <b>{{ $request->responsable->shortName }}</b></small>
                    @else
                        <small>No asignado</small>
                    @endif
                </td>
            </tr>
            <!-- Fila 3: Mensajes -->
            <tr>
                <td colspan="8">
                    @if (session()->has('message'))
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> {{ session('message') }}
                        </div>
                    @endif
                </td>
            </tr>
            </tbody>
        </table>
    </td>
</tr>
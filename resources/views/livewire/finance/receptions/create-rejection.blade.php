<div>
    <h3 class="mb-3">Crear un rechazo</h3>

    <!-- MENU -->
    @include('finance.receptions.partials.nav')

    <!-- Orden de Compra -->
    <div class="row mb-3 g-2">
        <div class="col-md-3">
            <label for="reception-date">Orden de compra</label>
            <div class="input-group">
                <input type="text"
                    class="form-control"
                    placeholder="Orden de compra"
                    aria-label="Orden de compra"
                    aria-describedby="purchase-order"
                    wire:model="purchaseOrderCode">
                <button class="btn btn-primary"
                    wire:click="getPurchaseOrder"
                    wire:loading.attr="disabled">
                    <i class="fa fa-spinner fa-spin"
                        wire:loading></i>
                    <i class="bi bi-search"
                        wire:loading.class="d-none"></i>
                </button>
            </div>
        </div>
        @if ($purchaseOrder)
            <div class="col-md-2 text-center">
                <b>Form. Requerimiento</b><br>
                @if ($purchaseOrder->requestForm)
                    <a href="{{ route('request_forms.show', $purchaseOrder->requestForm->id) }}"
                        target="_blank">
                        {{ $purchaseOrder->requestForm->folio }}
                    </a>
                @else
                    <span class="text-danger">
                        No existe ningún proceso de compra para la OC ingresada. Contácte a abastecimiento.
                        <button class="btn btn-sm btn-danger">
                            <i class="fas fa-biohazard"></i> Notificar a Abastecimiento
                        </button>
                    </span>
                @endif
            </div>
            <div class="col-md-2 text-center">
                <b>Orden de Compra</b><br>
                <a target="_blank"
                    href="{{ route('finance.purchase-orders.show', $purchaseOrder) }}">
                    {{ $purchaseOrder->code }}
                </a>
                <br>
                {{ $purchaseOrder->json->Listado[0]->Estado }}
                <div class="form-check form-switch form-check-inline">
                    <input class="form-check-input"
                        type="checkbox"
                        role="switch"
                        wire:click="togglePoCenabast()"
                        id="for-cenabast"
                        {{ $purchaseOrder->cenabast ? 'checked' : '' }}>
                    <label class="form-check-label"
                        for="flexSwitchCheckDefault">Cenabast</label>
                </div>
            </div>

            <div class="col-md-3 text-center">
                <b>Actas creadas para esta OC</b><br>
                <ul>
                    @foreach ($purchaseOrder->receptions as $otherReception)
                        <li>
                            <a href="#">
                                Nº: {{ $otherReception->number }}
                                Fecha: {{ $otherReception->date?->format('Y-m-d') }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-2">
                <b>Documento Tributario*</b><br>
                <ul>
                    @foreach ($purchaseOrder->dtes as $dte)
                        <li>
                            <div class="form-check">
                                <input class="form-check-input @error('selectedDteId') is-invalid @enderror"
                                    type="radio"
                                    wire:model.live="selectedDteId"
                                    name="selectedDte"
                                    value="{{ $dte->id }}"
                                    {{ $dte->rejectedReception ? 'disabled' : '' }}
                                    >
                                <label @if ($dte->rejectedReception) class="text-danger" @endif>
                                    {{ $dte->tipoDocumentoIniciales }}
                                    {{ $dte->folio }}
                                    @if ($dte->rejectedReception)
                                        <span class="text-danger">(Rechazo)</span>
                                    @endif
                                </label>
                            </div>
                        </li>
                    @endforeach
                    <li>
                        <div class="form-check">
                            <input class="form-check-input @error('selectedDteId') is-invalid @enderror"
                                type="radio"
                                wire:model.live="selectedDteId"
                                name="selectedDte"
                                value="0">
                            <label>
                                Otro
                            </label>
                        </div>
                    </li>
                </ul>
                @error('selectedDteId')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        @elseif(is_null($purchaseOrder))
            <div class="col-md-3 text-center">
                <br>
                <span class="text-danger">No se encontró la orden de compra</span>
            </div>
        @endif

    </div>

    @if ($purchaseOrder)
        <div class="row mb-3 g-2">
            <div class="col-6">
                <br>
                <h5>Documento Tributario Asociado</h5>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="reception-date">Tipo de documento*</label>
                    <select id="document_type"
                        class="form-select @error('reception.dte_type') is-invalid @enderror"
                        wire:model.live="reception.dte_type">
                        <option></option>
                        <option value ="guias_despacho">Guía de despacho</option>
                        <option value ="factura_electronica">Factura Electronica Afecta</option>
                        <option value ="factura_exenta">Factura Electronica Exenta</option>
                        <option value ="boleta_honorarios">Boleta Honorarios</option>
                    </select>
                    @error('reception.dte_type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="reception-date">Número de documento</label>
                    <input type="text"
                        class="form-control"
                        wire:model="reception.dte_number">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="reception-date">Fecha de documento</label>
                    <input type="date"
                        class="form-control"
                        wire:model.live="reception.dte_date">
                </div>
            </div>
        </div>

        <h4>Recepción</h4>

        <div class="row mb-3 g-2">
            <div class="form-group col-md-2">
                <div class="form-group">
                    <label for="number">Número de acta</label>
                    <input type="text"
                        class="form-control"
                        disabled
                        placeholder="Automático">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="reception-date">Fecha acta*</label>
                    <input type="date"
                        class="form-control @error('reception.date') is-invalid @enderror"
                        wire:model.live="reception.date">
                    @error('reception.date')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group col-md-2">
                <label for="form-reception-type">Tipo de acta*</label>
                <select class="form-select @error('reception.reception_type_id') is-invalid @enderror"
                    wire:model.live="reception.reception_type_id">
                    <option value=""></option>
                    @foreach ($types as $id => $type)
                        <option value="{{ $id }}">{{ $type }}</option>
                    @endforeach
                </select>
                @error('reception.reception_type_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="internal_number">Número interno acta</label>
                    <input type="text"
                        class="form-control"
                        placeholder="opcional"
                        wire:model.live="reception.internal_number">
                    <div class="form-text">En caso que la unidad tenga su propio correlativo</div>
                </div>
            </div>


        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <div class="form-group">
                    <Label>Motivo de rechazo</Label>
                    <textarea name=""
                        id="for-rejected_notes"
                        rows="6"
                        class="form-control"
                        wire:model="reception.rejected_notes"></textarea>
                    @error('reception.rejected_notes')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <div>
                        @livewire(
                            'text-templates.controls-text-template',
                            [
                                'module' => 'Receptions',
                                'input' => 'reception.rejected_notes',
                            ],
                            key('rejected_notes')
                        )
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-danger" wire:click="save">
                    Rechazar
                </button>
            </div>
        </div>


    @endif
</div>

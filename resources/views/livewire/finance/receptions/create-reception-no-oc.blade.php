<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <h3 class="mb-3">Crear un acta de recepción conforme sin OC</h3>

    <!-- MENU -->
    @include('finance.receptions.partials.nav')


    <form wire:submit.prevent="save">
    <h5>Documento Tributario Asociado</h5>
    <!-- Archivo Digitalizado de DTE -->
    <div class="row mb-3 g-2">
        <div class="col-md-4">
            <!-- Etiqueta y campo de carga de archivo -->
            <label for="digital-invoice-file">Archivo Digitalizado DTE</label>
            <div class="input-group">
                <input type="file"
                class="form-control"
                placeholder="Archivo Digitalizado DTE"
                aria-label="Archivo Digitalizado DTE"
                aria-describedby="digital-invoice"
                wire:model.defer="digitalInvoiceFile">
                
            </div>
        </div>


        <div class="col-md-2">
            <div class="form-group">
                <label for="reception-date">Tipo de documento*</label>
                <select id="document_type"
                    class="form-select @error('reception.dte_type') is-invalid @enderror"
                    wire:model.defer="reception.dte_type">
                    <option></option>
                    <option value ="factura_electronica">Factura Electronica Afecta</option>
                    <option value ="factura_exenta">Factura Electronica Exenta</option>
                    <option value ="boleta_honorarios">Boleta Honorarios</option>
                </select>
                @error('reception.dte_type')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group col-2">
            <label for="emisor">RUT</label>
            <input type="text" class="form-control" id="emisor" wire:model.defer="emisor"
                placeholder="ej: 76.278.474-2" autocomplete="off">
            @error('emisor')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group col-4">
            <label for="razonSocial">Razón Social</label>
            <input type="text" class="form-control" id="razonSocial" wire:model.defer="razonSocial"
                autocomplete="off">
            @error('razonSocial')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>


        <div class="row mb-3 g-2">
            <div class="form-group col-2">
                <label for="folio">Número</label>
                <input type="number" class="form-control" id="folio" wire:model.defer="folio" autocomplete="off"
                    min="1">
                @error('folio')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-2">
                <label for="montoTotal">Monto Total</label>
                <input type="number" class="form-control" id="montoTotal" wire:model.defer="montoTotal"
                    autocomplete="off" min="1000">
                @error('montoTotal')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
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
                            wire:model.defer="reception.date">
                        @error('reception.date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label for="form-reception-type">Tipo de acta*</label>
                    <select class="form-select @error('reception.reception_type_id') is-invalid @enderror"
                        wire:model.defer="reception.reception_type_id">
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
                            wire:model.defer="reception.internal_number">
                        <div class="form-text">En caso que la unidad tenga su propio correlativo</div>
                    </div>
                </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <div class="form-group">
                    <Label>Encabezado</Label>
                    <textarea name=""
                        id="for-header_notes"
                        rows="6"
                        class="form-control"
                        wire:model.defer="reception.header_notes"></textarea>

                    <div>
                        @livewire(
                            'text-templates.controls-text-template',
                            [
                                'module' => 'Receptions',
                                'input' => 'reception.header_notes',
                            ],
                            key('head_notes')
                        )
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-6 text-primary">
                <button class="btn btn-primary" type="submit">
                    Crear
                </button>

            </div>
        </div>
    </form>
    


</div>

<div>
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
                    wire:model.defer="reception.dte_type"
                    wire:loading.attr="disabled"
                    >
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
                placeholder="ej: 76.278.474-2" autocomplete="off"
                wire:loading.attr="disabled"
                >
            @error('emisor')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group col-4">
            <label for="razonSocial">Razón Social</label>
            <input type="text" class="form-control" id="razonSocial" wire:model.defer="razonSocial"
                autocomplete="off" wire:loading.attr="disabled">
            @error('razonSocial')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>


        <div class="row mb-3 g-2">

            <div class="col-md-2">
                <div class="form-group">
                    <label for="reception-date">Fecha de documento</label>
                    <input type="date"
                        class="form-control"
                        wire:model="reception.dte_date" 
                        wire:loading.attr="disabled">
                </div>
            </div>



            <div class="form-group col-2">
                <label for="folio">Número</label>
                <input type="number" class="form-control" id="folio" wire:model.defer="folio" autocomplete="off"
                    min="1" 
                    wire:loading.attr="disabled">
                @error('folio')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-2">
                <label for="montoTotal">Monto Total</label>
                <input type="number" class="form-control" id="montoTotal" wire:model.defer="montoTotal"
                    autocomplete="off" min="1000" wire:loading.attr="disabled">
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
                            placeholder="Automático"
                            >
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="reception-date">Fecha acta*</label>
                        <input type="date"
                            class="form-control @error('reception.date') is-invalid @enderror"
                            wire:model.defer="reception.date" wire:loading.attr="disabled">
                        @error('reception.date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <label for="form-reception-type">Tipo de acta*</label>
                    <select class="form-select @error('reception.reception_type_id') is-invalid @enderror"
                        wire:model.defer="reception.reception_type_id" wire:loading.attr="disabled">
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
                            wire:model.defer="reception.internal_number" wire:loading.attr="disabled">
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



        <!-- Firmantes -->
        <h4 class="mb-2">Firmantes</h4>
        <div class="row mb-3">
            <div class="col-7">
                <label for="forOrganizationalUnit">Establecimiento / Unidad Organizacional</label>
                @livewire('select-organizational-unit', [
                    'emitToListener' => 'ouSelected',
                    'establishment_id' => auth()->user()->organizationalUnit->establishment_id,
                ])
                <b>Autoridad: </b>
                @if (is_null($authority))
                    <span class="text-danger">La unidad organizacional no tiene una autoridad definida</span>
                @else
                    {{ $authority }}
                @endif
            </div>
            <div class="col-1 text-center">
                <br>
                O
            </div>
            <div class="col">
                <label for="forUsers">Usuario</label>
                @livewire('search-select-user', [], key('firma'))
            </div>
        </div>

        <div class="row text-center">
            <div class="col">
                <b>Columna Izquierda</b>
                <div class="row mt-1 mb-2 g-2">
                    <div class="col">
                        <button class="btn btn-primary form-control"
                            wire:click="addApproval('left')"
                            @disabled(is_null($signer_id) and is_null($signer_ou_id))>
                            <i class="bi bi-plus"></i>
                            Agregar firmante
                        </button>
                    </div>
                    <div class="col">
                        <button class="btn btn-success form-control"
                            wire:click="addApproval('left',{{ auth()->id() }})">
                            <i class="bi bi-plus"></i>
                            Agregarme a mi
                        </button>
                    </div>
                </div>

                @error('approvals')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <div style="height: 40px">
                    @if (array_key_exists('left', $this->approvals))
                        {{ $this->approvals['left']['signerShortName'] }}
                        @if (array_key_exists('sent_to_ou_id', $approvals['left']))
                            <i class="fas fa-chess-king"></i>
                        @else
                            <i class="fas fa-chess-pawn"></i>
                        @endif
                        <button class="btn btn-sm btn-danger"
                            wire:click="removeApproval('left')">
                            <i class="bi bi-trash"></i>
                        </button>
                    @endif
                </div>

            </div>

            <div class="col">
                <b>Columna Central</b>
                <div class="row mt-1 mb-2 g-2">
                    <div class="col">
                        <button class="btn btn-primary form-control"
                            wire:click="addApproval('center')"
                            @disabled(is_null($signer_id) and is_null($signer_ou_id))>
                            <i class="bi bi-plus"></i>
                            Agregar firmante
                        </button>
                    </div>
                    <div class="col">
                        <button class="btn btn-success form-control"
                            wire:click="addApproval('center',{{ auth()->id() }})">
                            <i class="bi bi-plus"></i>
                            Agregarme a mi
                        </button>
                    </div>
                </div>

                @error('approvals')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <div style="height: 40px">
                    @if (array_key_exists('center', $this->approvals))
                        {{ $this->approvals['center']['signerShortName'] }}
                        @if (array_key_exists('sent_to_ou_id', $approvals['center']))
                            <i class="fas fa-chess-king"></i>
                        @else
                            <i class="fas fa-chess-pawn"></i>
                        @endif
                        <button class="btn btn-sm btn-danger"
                            wire:click="removeApproval('center')">
                            <i class="bi bi-trash"></i>
                        </button>
                    @endif
                </div>
            </div>

            <div class="col">
                <b>Columna Derecha</b>
                <div class="row mt-1 mb-2 g-2">
                    <div class="col">
                        <button class="btn btn-primary form-control"
                            wire:click="addApproval('right')"
                            @disabled(is_null($signer_id) and is_null($signer_ou_id))>
                            <i class="bi bi-plus"></i>
                            Agregar firmante
                        </button>
                    </div>
                    <div class="col">
                        <button class="btn btn-success form-control"
                            wire:click="addApproval('right',{{ auth()->id() }})">
                            <i class="bi bi-plus"></i>
                            Agregarme a mi
                        </button>
                    </div>
                </div>

                @error('approvals')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                <div style="height: 40px">
                    @if (array_key_exists('right', $this->approvals))
                        {{ $this->approvals['right']['signerShortName'] }}
                        @if (array_key_exists('sent_to_ou_id', $approvals['right']))
                            <i class="fas fa-chess-king"></i>
                        @else
                            <i class="fas fa-chess-pawn"></i>
                        @endif
                        <button class="btn btn-sm btn-danger"
                            wire:click="removeApproval('right')">
                            <i class="bi bi-trash"></i>
                        </button>
                    @endif
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

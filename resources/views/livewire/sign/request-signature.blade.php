<div>
    @section('title', 'Solicitud de firma y distribución')

    <h3>Nueva solicitud de firmas y distribución</h3>

    <h5>
        Solicitud
    </h5>

    @include('layouts.bt4.partials.flash_message')

    <div class="form-row">
        <fieldset class="form-group col-2">
            <label for="document-number">Fecha Documento*</label>
            <input
                type="date"
                class="form-control @error('document_number') is-invalid @enderror"
                id="document-number"
                wire:model.live="document_number"
            >
            @error('document_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-3">
            <label for="document-type">Tipo de Documento*</label>
            <select
                class="form-control @error('type_id') is-invalid @enderror"
                id="document-type"
                required
                wire:model.live='type_id'
            >
                <option value="">Seleccion un tipo</option>
                @foreach($documentTypes as $id => $type)
                    <option value="{{ $id }}">{{ $type }}</option>
                @endforeach
            </select>
            @error('type_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-7 col-md-7">
            <label for="subject">Materia o tema del documento*</label>
            <input
                type="text"
                class="form-control @error('subject') is-invalid @enderror"
                id="subject"
                wire:model.live.debounce.1500ms="subject"
                required
            >
            @error('subject')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-4">
            <label for="document-{{ $iterationDocument }}">Documento a Firmar</label>
            <br>
            @if($document)
                <a href="{{ route('documents.show.document', $document) }}" target="_blank">
                    <i class="fas fa-paperclip"></i> Documento
                </a>
            @else
                <input
                    type="file"
                    class="form-control @error('document_to_sign') is-invalid @enderror"
                    id="document-{{ $iterationDocument }}"
                    wire:model="document_to_sign"
                >
                @error('document_to_sign')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            @endif
        </fieldset>

        <fieldset class="form-group col-8">
            <label for="description">Descripción del documento</label>
            <input
                type="text"
                class="form-control @error('description') is-invalid @enderror"
                id="description"
                wire:model.live.debounce.1500ms="description"
                required
            >
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>
    </div>

    <h5>
        Anexos
    </h5>

    <div class="form-row">
        <fieldset class="form-group col-12">
            <label for="file{{ $iterationAnnex }}">Archivo anexo</label>
            <input
                type="file"
                class="form-control @error('annex_file') is-invalid @enderror"
                id="file-{{ $iterationAnnex }}"
                wire:model.live.debounce.900ms="annex_file"
                accept=".pdf,.xls,.xlsx,.doc,.docx"
                multiple
            >
            @error('annex_file')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="link">Enlace anexo</label>
            <input
                type="text"
                class="form-control @error('annex_link') is-invalid @enderror"
                id="link"
                placeholder="Ingrese un enlace"
                wire:model.live.debounce.1500ms="annex_link"
            >
            @error('annex_link')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-2">
            <label>&nbsp;</label>
            <br>
            <button
                class="btn btn-primary"
                wire:loading.attr="disabled"
                wire:click="uploadAnnexed"
            >
                Cargar Enlace
            </button>
        </fieldset>

        <fieldset class="form-group col-6">
            <label for="type-annexed">Enlaces</label>
            <ul class="list-group mb-3">
                @forelse($annexes as $indexAnnex => $itemAnnex)
                    <li class="list-group-item d-flex justify-content-between align-items-center pt-2">
                        <a href="{{ $itemAnnex['source'] }}">{{ $itemAnnex['source'] }}</a>

                        <button
                            class="btn btn-sm btn-danger"
                            wire:click="deleteAnnexes({{ $indexAnnex }})"
                            title="Eliminar"
                        >
                            <i class="fas fa-trash"></i>
                        </button>
                    </li>
                @empty
                    <li class="list-group-item p-2">
                        No hay enlaces
                    </li>
                @endforelse
            </ul>
        </fieldset>
    </div>



    <h5>
        Distribución
    </h5>

    <div class="form-row mt-4">
        <fieldset class="form-group col-6">
            <label for="distribution">Distribución del documento</label>

            @livewire('sign.add-emails', [
                'eventName' => 'setEmailDistributions'
            ])

            <input type="hidden" name="distribution" class="@error('distribution') is-invalid @enderror">
            @error('distribution')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <ul class="list-group mt-2">
                @foreach($distribution as $i => $itemDistribution)
                    <li class="list-group-item">
                        @if($itemDistribution['type'] == 'email')
                            <a href="mailto:{{ $itemDistribution['destination'] }}">{{ $itemDistribution['destination'] }}</a>
                        @else
                            {{ $itemDistribution['destination'] }}
                        @endif
                    </li>
                @endforeach
            </ul>
        </fieldset>

        <fieldset class="form-group col-6">
            <label for="recipients">Destinatarios del documento</label>

            @livewire('sign.add-emails', [
                'eventName' => 'setEmailRecipients'
            ])

            <input type="hidden" name="recipients" class="@error('recipients') is-invalid @enderror">
            @error('recipients')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <ul class="list-group mt-2">
                @foreach($recipients as $j => $itemRecipient)
                    <li class="list-group-item">
                        @if($itemRecipient['type'] == 'email')
                            <a href="mailto:{{ $itemRecipient['destination'] }}">{{ $itemRecipient['destination'] }}</a>
                        @else
                            {{ $itemRecipient['destination'] }}
                        @endif
                    </li>
                @endforeach
            </ul>
        </fieldset>
    </div>

    <div class="row">
        <div class="col">
            <h5>
                Firmantes
            </h5>
            <input type="hidden" name="signers" class="@error('signers') is-invalid @enderror">
            @error('signers')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="form-row mt-4">
        <fieldset class="form-group col-4">
            <label for="left-signatures">1. Firmantes Columna Izquierda</label>

            @livewire('sign.add-signer', [
                'eventName' => 'addLeftSignature',
            ], key(1))

            <input type="hidden" name="left_signatures" class="@error('left_signatures') is-invalid @enderror">
            @error('left_signatures')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            @if($namesSignaturesLeft->count() > 0)
                <div class="input-group input-group-sm my-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="left-endorse">
                            Firma
                        </label>
                    </div>
                    <select
                        class="custom-select custom-select-sm @error('column_left_endorse') is-invalid @enderror"
                        id="left-endorse"
                        wire:model.live.debounce.1000ms="column_left_endorse"
                    >
                        <option value="">Selecione Tipo Firma</option>
                        <option value="Opcional">Opcional</option>
                        <option value="Obligatorio sin Cadena de Responsabilidad">Obligatorio sin Cadena de Responsabilidad</option>
                        <option value="Obligatorio en Cadena de Responsabilidad">Obligatorio en Cadena de Responsabilidad</option>
                    </select>
                    @error('column_left_endorse')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            @endif

            <label>Firmantes Agregados</label>

            <ul class="list-group mt-1">
                @forelse($namesSignaturesLeft as $indexLeft => $itemLeftSignature)
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        1.{{ $indexLeft + 1 }} {{ $itemLeftSignature }}
                        <button
                            class="btn btn-sm btn-danger"
                            wire:click="deleteSigner({{ $indexLeft }}, 'left')"
                            wire:target="deleteSigner"
                            wire:loading.attr="disabled"
                        >
                            <i class="fa fa-trash"></i>
                        </button>
                    </li>
                @empty
                    <li class="list-group-item">No hay usuarios</li>
                @endforelse
            </ul>

            <div class="form-check form-check-inline my-1">
                <input
                    class="form-check-input"
                    type="checkbox"
                    wire:model.live="column_left_visator"
                    id="left-visator"
                >
                <label class="form-check-label" for="left-visator">
                    Visadores
                </label>
            </div>
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="center-signatures">2. Firmantes Columna Central</label>

            @livewire('sign.add-signer', [
                'eventName' => 'addCenterSignature',
            ], key(2))

            <input type="hidden" name="center_signatures" class="@error('center_signatures') is-invalid @enderror">
            @error('center_signatures')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            @if($namesSignaturesCenter->count() > 0)
                <div class="input-group input-group-sm my-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="center-endorse">
                            Firma
                        </label>
                    </div>
                    <select
                        class="custom-select custom-select-sm @error('column_center_endorse') is-invalid @enderror"
                        id="center-endorse"
                        wire:model.live.debounce.1000ms="column_center_endorse"
                    >
                        <option value="">Selecione Tipo Firma</option>
                        <option value="Opcional">Opcional</option>
                        <option value="Obligatorio sin Cadena de Responsabilidad">Obligatorio sin Cadena de Responsabilidad</option>
                        <option value="Obligatorio en Cadena de Responsabilidad">Obligatorio en Cadena de Responsabilidad</option>
                    </select>
                    @error('column_center_endorse')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            @endif

            <label>Firmantes Agregados</label>

            <ul class="list-group mt-1">
                @forelse($namesSignaturesCenter as $indexCenter => $itemCenterSignature)
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        2.{{ $indexCenter + 1 }} {{ $itemCenterSignature }}
                        <button
                            class="btn btn-sm btn-danger"
                            wire:click="deleteSigner({{ $indexCenter }}, 'center')"
                            wire:target="deleteSigner"
                            wire:loading.attr="disabled"
                        >
                            <i class="fa fa-trash"></i>
                        </button>
                    </li>
                @empty
                    <li class="list-group-item">No hay usuarios</li>
                @endforelse
            </ul>

            <div class="form-check form-check-inline my-1">
                <input
                    class="form-check-input"
                    type="checkbox"
                    wire:model.live="column_center_visator"
                    id="center-visator"
                    disabled
                >
                <label class="form-check-label" for="center-visator">
                    Visadores
                </label>
            </div>
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="center-signatures">3. Firmantes Columna Derecha</label>

            @livewire('sign.add-signer', [
                'eventName' => 'addRightSignature',
            ], key(3))

            <input type="hidden" name="right_signatures" class="@error('right_signatures') is-invalid @enderror">
            @error('right_signatures')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            @if($namesSignaturesRight->count() > 0)
                <div class="input-group input-group-sm my-1">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="right-endorse">
                            Firma
                        </label>
                    </div>
                    <select
                        class="custom-select custom-select-sm @error('column_right_endorse') is-invalid @enderror"
                        id="right-endorse"
                        wire:model.live.debounce.1000ms="column_right_endorse"
                    >
                        <option value="">Selecione Tipo Firma</option>
                        <option value="Opcional">Opcional</option>
                        <option value="Obligatorio sin Cadena de Responsabilidad">Obligatorio sin Cadena de Responsabilidad</option>
                        <option value="Obligatorio en Cadena de Responsabilidad">Obligatorio en Cadena de Responsabilidad</option>
                    </select>
                    @error('column_right_endorse')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            @endif

            <label>Firmantes Agregados</label>

            <ul class="list-group mt-1">
                @forelse($namesSignaturesRight as $indexRight => $itemRightSignature)
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        3.{{ $indexRight + 1 }} {{ $itemRightSignature }}
                        <button
                            class="btn btn-sm btn-danger"
                            wire:click="deleteSigner({{ $indexRight }}, 'right')"
                            wire:target="deleteSigner"
                            wire:loading.attr="disabled"
                        >
                            <i class="fa fa-trash"></i>
                        </button>
                    </li>
                @empty
                    <li class="list-group-item">No hay usuarios</li>
                @endforelse
            </ul>

            <div class="form-check form-check-inline my-1">
                <input
                    class="form-check-input"
                    type="checkbox"
                    wire:model.live="column_right_visator"
                    id="right-visator"
                    disabled
                >
                <label class="form-check-label" for="right-visator">
                    Visadores
                </label>
            </div>
        </fieldset>
    </div>

    <div class="row mt-4">
        <div class="col">
            <button
                type="submit"
                id="submitBtn"
                class="btn btn-primary"
                wire:click="save"
                wire:loading.attr="disabled"
                wire:target='save'
            >
                <span
                    wire:loading.remove
                    wire:target="save"
                >
                    <i class="fas fa-file"></i>
                </span>

                <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                    wire:loading
                    wire:target="save"
                    aria-hidden="true"
                >
                </span>

                Crear Solicitud
            </button>
        </div>

        <div class="col-4">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Ubicación de Firmas</span>
                </div>
                <select
                    class="form-control"
                    name="page"
                    required
                    wire:model.live='page'
                    required
                >
                    <option value="last">Última Pagina</option>
                    <option value="first">Primera Pagina</option>
                </select>
                @error('page')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>

</div>

<div>
    @section('title', 'Solicitud de firma y distribución')

    <h3>Nueva solicitud de firmas y distribución</h3>

    <h5>
        Solicitud
    </h5>

    <div class="form-row">
        <fieldset class="form-group col-2">
            <label for="document-number">Fecha Documento*</label>
            <input
                type="date"
                class="form-control @error('document_number') is-invalid @enderror"
                id="document-number"
                wire:model="document_number"
            >
            @error('document_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-3">
            @livewire('signatures.document-types', ['type_id' => $signature->type_id ?? null])
            <input type="hidden" name="type_id" class="@error('type_id') is-invalid @enderror">
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
                wire:model.debounce.1500ms="subject"
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
        <fieldset class="form-group col-5">
            <label for="description">Descripción del documento</label>
            <input
                type="text"
                class="form-control @error('description') is-invalid @enderror"
                id="description"
                wire:model.debounce.1500ms="description"
                required
            >
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-2">
            <label for="page">Página</label>
            <select
                class="form-control"
                name="page"
                required
                wire:model='page'
                required
            >
                <option value="last">Última</option>
                <option value="first">Primera</option>
            </select>
            @error('page')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-5">
            <label for="document-signed">Documento a Firmar</label>
            <input
                type="file"
                class="form-control @error('document_to_sign') is-invalid @enderror"
                id="document-signed"
                wire:model="document_to_sign"
            >
            @error('document_to_sign')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-6">
            <label for="annex">Anexos</label>
            <input
                type="file"
                class="form-control @error('annex') is-invalid @enderror"
                id="annex"
                wire:model="annex"
                multiple
            >
            @error('annex')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-6">
            <label for="url">Link o URL asociado</label>
            <input
                type="url"
                class="form-control @error('url') is-invalid @enderror"
                id="url"
                wire:model.debounce.1500ms="url"
            >
            @error('url')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
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

            <p class="mt-1">
                <small>
                    @foreach($distribution as $i => $emailDistribution)
                        <a href="mailto:{{ $emailDistribution }}">{{ $emailDistribution }}</a>@if($i < count($distribution) - 1),@else.@endif
                    @endforeach
                </small>
            </p>
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

            <p class="mt-1">
                <small>
                    @foreach($recipients as $j => $emailRecipient)
                        <a href="mailto:{{ $emailRecipient }}">{{ $emailRecipient }}</a>@if($j < count($recipients) - 1),@else.@endif
                    @endforeach
                </small>
            </p>
        </fieldset>
    </div>

    <h5>
        Firmantes
    </h5>

    <div class="form-row mt-4">
        <fieldset class="form-group col-4">
            <label for="left-signatures">1. Firmantes Columna Izquierda</label>
            @livewire('users.search-user', [
                'placeholder' => 'Ingrese un nombre',
                'eventName' => 'addLeftSignature',
                'tagId' => 'left-signatures',
            ])

            <input type="hidden" name="left_signatures" class="@error('left_signatures') is-invalid @enderror">
            @error('left_signatures')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <hr>

            <div class="input-group input-group-sm mt-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="left-endorse">
                        Firma
                    </label>
                </div>
                <select
                    class="custom-select custom-select-sm @error('column_left_endorse') is-invalid @enderror"
                    id="left-endorse"
                    wire:model.debounce.1500ms="column_left_endorse"
                >
                    <option selected>Selecione Tipo Visación</option>
                    <option value="Opcional">Opcional</option>
                    <option value="Obligatorio">Obligatorio</option>
                    <option value="En Cadena de Responsabilidad">En Cadena de Responsabilidad</option>
                </select>
                @error('column_left_endorse')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-check form-check-inline my-1">
                <input
                    class="form-check-input"
                    type="checkbox"
                    wire:model="column_left_visator"
                    id="left-visator"
                >
                <label class="form-check-label" for="left-visator">
                    Visadores
                </label>
            </div>

            <br>

            <ul class="list-group">
                @forelse($namesSignaturesLeft as $indexLeft => $itemLeftSignature)
                    <li class="list-group-item">1.{{ $indexLeft + 1 }} {{ $itemLeftSignature }} </li>
                @empty
                    <li class="list-group-item">No hay usuarios</li>
                @endforelse
            </ul>
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="center-signatures">2. Firmantes Columna Central</label>
            @livewire('users.search-user', [
                'placeholder' => 'Ingrese un nombre',
                'eventName' => 'addCenterSignature',
                'tagId' => 'center-signatures',
            ])

            <input type="hidden" name="center_signatures" class="@error('center_signatures') is-invalid @enderror">
            @error('center_signatures')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <hr>

            <div class="input-group input-group-sm mt-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="center-endorse">
                        Visación Central
                    </label>
                </div>
                <select
                    class="custom-select custom-select-sm @error('column_center_endorse') is-invalid @enderror"
                    id="center-endorse"
                    wire:model.debounce.1500ms="column_center_endorse"
                >
                    <option selected>Selecione Tipo Visación</option>
                    <option value="Opcional">Opcional</option>
                    <option value="Obligatorio">Obligatorio</option>
                    <option value="En Cadena de Responsabilidad">En Cadena de Responsabilidad</option>
                </select>
                @error('column_center_endorse')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-check form-check-inline my-1">
                <input
                    class="form-check-input"
                    type="checkbox"
                    wire:model="column_center_visator"
                    id="left-visator"
                    disabled
                >
                <label class="form-check-label" for="left-visator">
                    Visadores
                </label>
            </div>

            <br>

            <ul class="list-group">
                @forelse($namesSignaturesCenter as $indexCenter => $itemCenterSignature)
                    <li class="list-group-item">2.{{ $indexCenter + 1 }} {{ $itemCenterSignature }} </li>
                @empty
                    <li class="list-group-item">No hay usuarios</li>
                @endforelse
            </ul>
        </fieldset>

        <fieldset class="form-group col-4">
            <label for="center-signatures">3. Firmantes Columna Derecha</label>
            @livewire('users.search-user', [
                'placeholder' => 'Ingrese un nombre',
                'eventName' => 'addRightSignature',
                'tagId' => 'center-signatures',
            ])

            <input type="hidden" name="right_signatures" class="@error('right_signatures') is-invalid @enderror">
            @error('right_signatures')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

            <hr>

            <div class="input-group input-group-sm mt-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="right-endorse">
                        Visación Derecha
                    </label>
                </div>
                <select
                    class="custom-select custom-select-sm @error('column_right_endorse') is-invalid @enderror"
                    id="right-endorse"
                    wire:model.debounce.1500ms="column_right_endorse"
                >
                    <option selected>Selecione Tipo Visación</option>
                    <option value="Opcional">Opcional</option>
                    <option value="Obligatorio">Obligatorio</option>
                    <option value="En Cadena de Responsabilidad">En Cadena de Responsabilidad</option>
                </select>
                @error('column_right_endorse')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-check form-check-inline my-1">
                <input
                    class="form-check-input"
                    type="checkbox"
                    wire:model="column_right_visator"
                    id="left-visator"
                    disabled
                >
                <label class="form-check-label" for="left-visator">
                    Visadores
                </label>
            </div>
            <br>

            <ul class="list-group">
                @forelse($namesSignaturesRight as $indexRight => $itemRightSignature)
                    <li class="list-group-item">3.{{ $indexRight + 1 }} {{ $itemRightSignature }} </li>
                @empty
                    <li class="list-group-item">No hay usuarios</li>
                @endforelse
            </ul>
        </fieldset>
    </div>

    <button
        type="submit"
        id="submitBtn"
        class="btn btn-primary mt-2"
        wire:click="save"
    >
        <i class="fa fa-file"></i> Crear Solicitud
    </button>

</div>

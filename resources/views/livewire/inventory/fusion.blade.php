<div>
    <h3>Fusión </h3>

    <div class="row row-cols-lg-auto g-2 mb-3 align-items-center">
        <div class="col-12">
            <label class="visually-hidden"
                for="for-origin">Origen</label>

            <input type="text"
                wire:model.defer="input_origin"
                class="form-control @error('input_origin') is-invalid @enderror"
                id="for-origin"
                placeholder="id Origen">
        </div>

        <div class="col-12">
            <button type="button"
                wire:click="search"
                class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left-right"></i>
            </button>
        </div>

        <div class="col-12">
            <label class="visually-hidden"
                for="for-target">Destino</label>

            <input type="text"
                wire:model.defer="input_target"
                class="form-control @error('input_target') is-invalid @enderror"
                id="for-target"
                placeholder="id Destino">
        </div>

        <div class="col-12">
            <button type="button"
                wire:click="search"
                class="btn btn-primary">Buscar</button>
        </div>


    </div>

    @if ($origin and $target)
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th></th>
                    <th scope="col"
                        width="40%">Item A</th>
                    <th scope="col"
                        width="40%">Item B</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Preservar</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-id"
                                id="for-id"
                                value="A">
                            <label class="form-check-label"
                                for="for-id">{{ $origin->id }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-id"
                                id="for-id"
                                value="B">
                            <label class="form-check-label"
                                for="for-id">{{ $target->id }}</label>
                        </div>
                    </td>
                </tr>


                <tr>
                    <th>Nro. Inventario</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-number"
                                id="for-number"
                                value="A">
                            <label class="form-check-label"
                                for="for-number">{{ $origin->number }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-number"
                                id="for-number"
                                value="B">
                            <label class="form-check-label"
                                for="for-number">{{ $target->number }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $origin->unspsc_product_id == $target->unspsc_product_id,
                ])>
                    <th>Código</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-code"
                                id="for-code"
                                value="A">
                            <label class="form-check-label"
                                for="for-code">{{ $origin->unspscProduct->code }} -
                                {{ $origin->unspscProduct->name }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-code"
                                id="for-code"
                                value="B">
                            <label class="form-check-label"
                                for="for-code">{{ $target->unspscProduct->code }} -
                                {{ $target->unspscProduct->name }}</label>
                        </div>
                    </td>
                </tr>

                <tr>
                    <th>Descripción <small><br>(especificación técnica)</small></th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-description"
                                id="for-description"
                                value="A">
                            <label class="form-check-label"
                                for="for-description">{{ $origin->product ? $origin->product->name : $origin->description }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-description"
                                id="for-description"
                                value="B">
                            <label class="form-check-label"
                                for="for-description">{{ $target->product ? $target->product->name : $target->description }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $origin->unspsc_product_id == $target->unspsc_product_id,
                ])>
                    <th>Nro. Inventario Antiguo</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-old_number"
                                id="for-old_number"
                                value="A">
                            <label class="form-check-label"
                                for="for-old_number">{{ $origin->old_number }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-old_number"
                                id="for-old_number"
                                value="B">
                            <label class="form-check-label"
                                for="for-old_number">{{ $target->old_number }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' =>
                        $origin->internal_description == $target->internal_description,
                ])>
                    <th>Descripción Interna</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-internal_description"
                                id="for-internal_description"
                                value="A">
                            <label class="form-check-label"
                                for="for-internal_description">{{ $origin->internal_description }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-internal_description"
                                id="for-internal_description"
                                value="B">
                            <label class="form-check-label"
                                for="for-internal_description">{{ $target->internal_description }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $origin->brand == $target->brand,
                ])>
                    <th>Marca</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-brand"
                                id="for-brand"
                                value="A">
                            <label class="form-check-label"
                                for="for-brand">{{ $origin->brand }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-brand"
                                id="for-brand"
                                value="B">
                            <label class="form-check-label"
                                for="for-brand">{{ $target->brand }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $origin->model == $target->model,
                ])>
                    <th>Modelo</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-model"
                                id="for-model"
                                value="A">
                            <label class="form-check-label"
                                for="for-model">{{ $origin->model }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-model"
                                id="for-model"
                                value="B">
                            <label class="form-check-label"
                                for="for-model">{{ $target->model }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $origin->serial_number == $target->serial_number,
                ])>
                    <th>Número de Serie</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-serial_number"
                                id="for-serial_number"
                                value="A">
                            <label class="form-check-label"
                                for="for-serial_number">{{ $origin->serial_number }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-serial_number"
                                id="for-serial_number"
                                value="B">
                            <label class="form-check-label"
                                for="for-serial_number">{{ $target->serial_number }}</label>
                        </div>
                    </td>
                </tr>


                <tr @class([
                    'table-success' =>
                        $origin->accounting_code_id == $target->accounting_code_id,
                ])>
                    <th>Cuenta contable</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-accounting_code_id"
                                id="for-accounting_code_id"
                                value="A">
                            <label class="form-check-label"
                                for="for-accounting_code_id">{{ $origin->accountingCode?->name }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-accounting_code_id"
                                id="for-accounting_code_id"
                                value="B">
                            <label class="form-check-label"
                                for="for-accounting_code_id">{{ $target->accountingCode?->name }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $origin->status == $target->status,
                ])>
                    <th>Estado</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-status"
                                id="for-status"
                                value="A">
                            <label class="form-check-label"
                                for="for-status">{{ $origin->status }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-status"
                                id="for-status"
                                value="B">
                            <label class="form-check-label"
                                for="for-status">{{ $target->status }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $origin->useful_life == $target->useful_life,
                ])>
                    <th>Vida útil</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-useful_life"
                                id="for-useful_life"
                                value="A">
                            <label class="form-check-label"
                                for="for-useful_life">{{ $origin->useful_life }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-useful_life"
                                id="for-useful_life"
                                value="B">
                            <label class="form-check-label"
                                for="for-useful_life">{{ $target->useful_life }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $origin->depreciation == $target->depreciation,
                ])>
                    <th>Depreciación</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-depreciation"
                                id="for-depreciation"
                                value="A">
                            <label class="form-check-label"
                                for="for-depreciation">{{ $origin->depreciation }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-depreciation"
                                id="for-depreciation"
                                value="B">
                            <label class="form-check-label"
                                for="for-depreciation">{{ $target->depreciation }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $origin->classification_id == $target->classification_id,
                ])>
                    <th>Clasificación</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-classification_id"
                                id="for-classification_id"
                                value="A">
                            <label class="form-check-label"
                                for="for-classification_id">{{ $origin->classification->name }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-classification_id"
                                id="for-classification_id"
                                value="B">
                            <label class="form-check-label"
                                for="for-classification_id">{{ $target->classification->name }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $origin->request_form_id == $target->request_form_id,
                ])>
                    <th>Formulario de req.</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-request_form_id"
                                id="for-request_form_id"
                                value="A">
                            <label class="form-check-label"
                                for="for-request_form_id">{{ $origin->requestForm?->folio }}
                                {{ $origin->requestForm?->associateProgram?->name }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-request_form_id"
                                id="for-request_form_id"
                                value="B">
                            <label class="form-check-label"
                                for="for-request_form_id">{{ $target->requestForm?->folio }}
                                {{ $target->requestForm?->associateProgram?->name }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $origin->po_code == $target->po_code,
                ])>
                    <th>Orden de Compra</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-po_code"
                                id="for-po_code"
                                value="A">
                            <label class="form-check-label"
                                for="for-po_code">{{ $origin->po_code }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-po_code"
                                id="for-po_code"
                                value="B">
                            <label class="form-check-label"
                                for="for-po_code">{{ $target->po_code }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $origin->po_date == $target->po_date,
                ])>
                    <th>Fecha OC</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-po_date"
                                id="for-po_date"
                                value="A">
                            <label class="form-check-label"
                                for="for-po_date">{{ $origin->po_date }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-po_date"
                                id="for-po_date"
                                value="B">
                            <label class="form-check-label"
                                for="for-po_date">{{ $target->po_date }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $origin->po_price == $target->po_price,
                ])>
                    <th>Valor OC</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-po_price"
                                id="for-po_price"
                                value="A">
                            <label class="form-check-label"
                                for="for-po_price">{{ $origin->po_price }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-po_price"
                                id="for-po_price"
                                value="B">
                            <label class="form-check-label"
                                for="for-po_price">{{ $target->po_price }}</label>
                        </div>
                    </td>
                </tr>

                <tr>
                    <th>Nº Factura</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-dte_number"
                                id="for-dte_number"
                                value="A">
                            <label class="form-check-label"
                                for="for-dte_number">{{ $origin->dte_number }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-dte_number"
                                id="for-dte_number"
                                value="B">
                            <label class="form-check-label"
                                for="for-dte_number">{{ $target->dte_number }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $origin->observations == $target->observations,
                ])>
                    <th>Observaciones</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-observations"
                                id="for-observations"
                                value="A">
                            <label class="form-check-label"
                                for="for-observations">{{ $origin->observations }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-observations"
                                id="for-observations"
                                value="B">
                            <label class="form-check-label"
                                for="for-observations">{{ $target->observations }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $origin->observations == $target->observations,
                ])>
                    <th>Movimientos</th>
                    <td>
                        @foreach ($origin->movements as $movement)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    name="for-observations"
                                    id="for-observations"
                                    value="A">
                                <label class="form-check-label"
                                    for="for-observations">
                                    {{ $movement->id }}<br>
                                    <b>Fecha:</b> {{ $movement->reception_date }}<br>
                                    <b>Responsable:</b> {{ $movement->responsibleUser->shortName }}<br>
                                    <b>Usuario:</b> {{ $movement->usingUser->shortName }}<br>
                                    <b>Lugar:</b> {{ $movement->place->name }}
                                </label>
                            </div>
                        @endforeach

                    </td>
                    <td>
                        @foreach ($target->movements as $movement)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="radio"
                                    name="for-observations"
                                    id="for-observations"
                                    value="A">
                                <label class="form-check-label"
                                    for="for-observations">
                                    {{ $movement->id }}<br>
                                    <b>Fecha:</b> {{ $movement->reception_date }}<br>
                                    <b>Responsable:</b> {{ $movement->responsibleUser->shortName }}<br>
                                    <b>Usuario:</b> {{ $movement->usingUser->shortName }}<br>
                                    <b>Lugar:</b> {{ $movement->place->name }}
                                </label>
                            </div>
                        @endforeach
                    </td>
                </tr>


            </tbody>
        </table>

        <button type="button"
            class="btn btn-primary">
            <i class="bi bi-fusion"></i>
            Fusionar
        </button>
    @endif

    @include('layouts.bt5.partials.errors')
</div>

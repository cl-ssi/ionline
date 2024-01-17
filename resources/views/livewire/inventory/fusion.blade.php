<div>
    <h3>Fusión </h3>

    <div class="row row-cols-lg-auto g-2 mb-3 align-items-center">
        <div class="col-12">
            <label class="visually-hidden"
                for="for-input_item_a">Item A</label>

            <input type="text"
                wire:model.defer="input_item_a"
                class="form-control @error('input_item_a') is-invalid @enderror"
                id="for-input_item_a"
                placeholder="id ítem A">
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
                for="for-input_item_b">Item B</label>

            <input type="text"
                wire:model.defer="input_item_b"
                class="form-control @error('input_item_b') is-invalid @enderror"
                id="for-input_item_b"
                placeholder="id ítem B">
        </div>

        <div class="col-12">
            <button type="button"
                wire:click="search"
                class="btn btn-primary">Buscar</button>
        </div>


    </div>

    @if ($item_a and $item_b)
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
                                wire:model="fusion.id"
                                value="A{{ $item_a->id }}"
                                required>
                            <label class="form-check-label"
                                for="for-id">{{ $item_a->number }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-id"
                                id="for-id"
                                wire:model="fusion.id"
                                value="B{{ $item_b->id }}">
                            <label class="form-check-label"
                                for="for-id">{{ $item_b->number }}</label>
                        </div>
                    </td>
                </tr>



                <tr @class([
                    'table-success' => $item_a->old_number == $item_b->old_number,
                ])>
                    <th>Nro. Inventario Antiguo</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('fusion.old_number') is-invalid @enderror"
                                type="radio"
                                name="for-old_number"
                                id="for-old_number"
                                @if($item_a->old_number == $item_b->old_number) {{$input_item_a_checked}} @endif
                                value="{{ $item_a->old_number }}">
                            <label class="form-check-label"
                                for="for-old_number">{{ $item_a->old_number }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('fusion.old_number') is-invalid @enderror"
                                type="radio"
                                name="for-old_number"
                                @if($item_a->old_number == $item_b->old_number) {{$input_item_b_checked}} @endif
                                value="{{ $item_b->old_number }}">
                            <label class="form-check-label"
                                for="for-old_number">{{ $item_b->old_number }}</label>
                        </div>
                    </td>
                </tr>



                <tr @class([
                    'table-success' => $item_a->unspsc_product_id == $item_b->unspsc_product_id,
                ])>
                    <th>Código</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-code"
                                id="for-code"
                                @if($item_a->unspsc_product_id == $item_b->unspsc_product_id) {{$input_item_a_checked}} @endif
                                value="A"
                                required>
                            <label class="form-check-label"
                                for="for-code">{{ $item_a->unspscProduct->code }} -
                                {{ $item_a->unspscProduct->name }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-code"
                                id="for-code"
                                @if($item_a->unspsc_product_id == $item_b->unspsc_product_id) {{$input_item_b_checked}} @endif
                                value="B">
                            <label class="form-check-label"
                                for="for-code">{{ $item_b->unspscProduct->code }} -
                                {{ $item_b->unspscProduct->name }}</label>
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
                                @if($item_a->description == $item_b->description) {{$input_item_a_checked}} @endif
                                value="A"
                                required>
                            <label class="form-check-label"
                                for="for-description">{{ $item_a->product ? $item_a->product->name : $item_a->description }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-description"
                                id="for-description"
                                @if($item_a->description == $item_b->description) {{$input_item_b_checked}} @endif
                                value="B">
                            <label class="form-check-label"
                                for="for-description">{{ $item_b->product ? $item_b->product->name : $item_b->description }}</label>
                        </div>
                    </td>
                </tr>



                <tr @class([
                    'table-success' =>
                        $item_a->internal_description == $item_b->internal_description,
                ])>
                    <th>Descripción Interna</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-internal_description"
                                id="for-internal_description"
                                @if($item_a->internal_description == $item_b->internal_description) {{$input_item_a_checked}} @endif
                                value="A">
                            <label class="form-check-label"
                                for="for-internal_description">{{ $item_a->internal_description }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-internal_description"
                                id="for-internal_description"
                                @if($item_a->internal_description == $item_b->internal_description) {{$input_item_b_checked}} @endif
                                value="B">
                            <label class="form-check-label"
                                for="for-internal_description">{{ $item_b->internal_description }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $item_a->brand == $item_b->brand,
                ])>
                    <th>Marca</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-brand"
                                id="for-brand"
                                @if($item_a->brand == $item_b->brand) {{$input_item_a_checked}} @endif
                                value="A">
                            <label class="form-check-label"
                                for="for-brand">{{ $item_a->brand }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-brand"
                                id="for-brand"
                                @if($item_a->brand == $item_b->brand) {{$input_item_b_checked}} @endif
                                value="B">
                            <label class="form-check-label"
                                for="for-brand">{{ $item_b->brand }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $item_a->model == $item_b->model,
                ])>
                    <th>Modelo</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-model"
                                id="for-model"
                                @if($item_a->model == $item_b->model) {{$input_item_a_checked}} @endif
                                value="A">
                            <label class="form-check-label"
                                for="for-model">{{ $item_a->model }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-model"
                                id="for-model"
                                @if($item_a->model == $item_b->model) {{$input_item_b_checked}} @endif
                                value="B">
                            <label class="form-check-label"
                                for="for-model">{{ $item_b->model }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $item_a->serial_number == $item_b->serial_number,
                ])>
                    <th>Número de Serie</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-serial_number"
                                id="for-serial_number"
                                @if($item_a->serial_number == $item_b->serial_number) {{$input_item_a_checked}} @endif
                                value="A">
                            <label class="form-check-label"
                                for="for-serial_number">{{ $item_a->serial_number }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-serial_number"
                                id="for-serial_number"
                                @if($item_a->serial_number == $item_b->serial_number) {{$input_item_b_checked}} @endif
                                value="B">
                            <label class="form-check-label"
                                for="for-serial_number">{{ $item_b->serial_number }}</label>
                        </div>
                    </td>
                </tr>


                <tr @class([
                    'table-success' =>
                        $item_a->accounting_code_id == $item_b->accounting_code_id,
                ])>
                    <th>Cuenta contable</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-accounting_code_id"
                                id="for-accounting_code_id"
                                @if($item_a->accounting_code_id == $item_b->accounting_code_id) {{$input_item_a_checked}} @endif
                                value="A">
                            <label class="form-check-label"
                                for="for-accounting_code_id">{{ $item_a->accountingCode?->name }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-accounting_code_id"
                                id="for-accounting_code_id"
                                @if($item_a->accounting_code_id == $item_b->accounting_code_id) {{$input_item_b_checked}} @endif
                                value="B">
                            <label class="form-check-label"
                                for="for-accounting_code_id">{{ $item_b->accountingCode?->name }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $item_a->status == $item_b->status,
                ])>
                    <th>Estado</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-status"
                                id="for-status"
                                @if($item_a->status == $item_b->status) {{$input_item_a_checked}} @endif
                                value="A">
                            <label class="form-check-label"
                                for="for-status">{{ $item_a->status }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-status"
                                id="for-status"
                                @if($item_a->status == $item_b->status) {{$input_item_b_checked}} @endif
                                value="B">
                            <label class="form-check-label"
                                for="for-status">{{ $item_b->status }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $item_a->useful_life == $item_b->useful_life,
                ])>
                    <th>Vida útil</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-useful_life"
                                id="for-useful_life"
                                @if($item_a->useful_life == $item_b->useful_life) {{$input_item_a_checked}} @endif
                                value="A">
                            <label class="form-check-label"
                                for="for-useful_life">{{ $item_a->useful_life }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-useful_life"
                                id="for-useful_life"
                                @if($item_a->useful_life == $item_b->useful_life) {{$input_item_b_checked}} @endif
                                value="B">
                            <label class="form-check-label"
                                for="for-useful_life">{{ $item_b->useful_life }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $item_a->depreciation == $item_b->depreciation,
                ])>
                    <th>Depreciación</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-depreciation"
                                id="for-depreciation"
                                @if($item_a->depreciation == $item_b->depreciation) {{$input_item_a_checked}} @endif
                                value="A">
                            <label class="form-check-label"
                                for="for-depreciation">{{ $item_a->depreciation }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-depreciation"
                                id="for-depreciation"
                                @if($item_a->depreciation == $item_b->depreciation) {{$input_item_b_checked}} @endif
                                value="B">
                            <label class="form-check-label"
                                for="for-depreciation">{{ $item_b->depreciation }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $item_a->store_id == $item_b->store_id,
                ])>
                    <th>Ingreso en Bodega</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-store_id"
                                id="for-store_id"
                                @if($item_a->store_id == $item_b->store_id) {{$input_item_a_checked}} @endif
                                value="A">
                            <label class="form-check-label"
                                for="for-store_id">
                                {{ $item_a->store?->name }} {{ $item_a->control?->date }}
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-store_id"
                                id="for-store_id"
                                @if($item_a->store_id == $item_b->store_id) {{$input_item_b_checked}} @endif
                                value="B">
                            <label class="form-check-label"
                                for="for-store_id">
                                {{ $item_b->store?->name }} {{ $item_b->control?->date }}
                            </label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $item_a->classification_id == $item_b->classification_id,
                ])>
                    <th>Clasificación</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-classification_id"
                                id="for-classification_id"
                                @if($item_a->classification_id == $item_b->classification_id) {{$input_item_a_checked}} @endif
                                value="A">
                            <label class="form-check-label"
                                for="for-classification_id">{{ $item_a->classification->name }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-classification_id"
                                id="for-classification_id"
                                @if($item_a->classification_id == $item_b->classification_id) {{$input_item_b_checked}} @endif
                                value="B">
                            <label class="form-check-label"
                                for="for-classification_id">{{ $item_b->classification->name }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $item_a->request_form_id == $item_b->request_form_id,
                ])>
                    <th>Formulario de req.</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-request_form_id"
                                id="for-request_form_id"
                                @if($item_a->request_form_id == $item_b->request_form_id) {{$input_item_a_checked}} @endif
                                value="A">
                            <label class="form-check-label"
                                for="for-request_form_id">{{ $item_a->requestForm?->folio }}
                                {{ $item_a->requestForm?->associateProgram?->name }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-request_form_id"
                                id="for-request_form_id"
                                @if($item_a->request_form_id == $item_b->request_form_id) {{$input_item_b_checked}} @endif
                                value="B">
                            <label class="form-check-label"
                                for="for-request_form_id">{{ $item_b->requestForm?->folio }}
                                {{ $item_b->requestForm?->associateProgram?->name }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $item_a->budget_item_id == $item_b->budget_item_id,
                ])>
                    <th>Formulario de req.</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-budget_item_id"
                                id="for-budget_item_id"
                                @if($item_a->budget_item_id == $item_b->budget_item_id) {{$input_item_a_checked}} @endif
                                value="A">
                            <label class="form-check-label"
                                for="for-budget_item_id">
                                {{ $item_a->budgetItem?->name }}
                            </label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-budget_item_id"
                                id="for-budget_item_id"
                                @if($item_a->budget_item_id == $item_b->budget_item_id) {{$input_item_b_checked}} @endif
                                value="B">
                            <label class="form-check-label"
                                for="for-budget_item_id">
                                {{ $item_b->budgetItem?->name }}
                            </label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $item_a->po_code == $item_b->po_code,
                ])>
                    <th>Orden de Compra</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-po_code"
                                id="for-po_code"
                                @if($item_a->po_code == $item_b->po_code) {{$input_item_a_checked}} @endif
                                value="A">
                            <label class="form-check-label"
                                for="for-po_code">{{ $item_a->po_code }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-po_code"
                                id="for-po_code"
                                @if($item_a->po_code == $item_b->po_code) {{$input_item_b_checked}} @endif
                                value="B">
                            <label class="form-check-label"
                                for="for-po_code">{{ $item_b->po_code }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $item_a->po_date == $item_b->po_date,
                ])>
                    <th>Fecha OC</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-po_date"
                                id="for-po_date"
                                @if($item_a->po_date == $item_b->po_date) {{$input_item_a_checked}} @endif
                                value="A">
                            <label class="form-check-label"
                                for="for-po_date">{{ $item_a->po_date }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-po_date"
                                id="for-po_date"
                                @if($item_a->po_date == $item_b->po_date) {{$input_item_b_checked}} @endif
                                value="B">
                            <label class="form-check-label"
                                for="for-po_date">{{ $item_b->po_date }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $item_a->po_price == $item_b->po_price,
                ])>
                    <th>Valor OC</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-po_price"
                                id="for-po_price"
                                @if($item_a->po_price == $item_b->po_price) {{$input_item_a_checked}} @endif
                                value="A">
                            <label class="form-check-label"
                                for="for-po_price">{{ $item_a->po_price }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-po_price"
                                id="for-po_price"
                                @if($item_a->po_price == $item_b->po_price) {{$input_item_b_checked}} @endif
                                value="B">
                            <label class="form-check-label"
                                for="for-po_price">{{ $item_b->po_price }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $item_a->dte_number == $item_b->dte_number,
                ])>
                    <th>Nº Factura</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-dte_number"
                                id="for-dte_number"
                                @if($item_a->dte_number == $item_b->dte_number) {{$input_item_a_checked}} @endif
                                value="A">
                            <label class="form-check-label"
                                for="for-dte_number">{{ $item_a->dte_number }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-dte_number"
                                id="for-dte_number"
                                @if($item_a->dte_number == $item_b->dte_number) {{$input_item_b_checked}} @endif
                                value="B">
                            <label class="form-check-label"
                                for="for-dte_number">{{ $item_b->dte_number }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $item_a->observations == $item_b->observations,
                ])>
                    <th>Observaciones</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-observations"
                                id="for-observations"
                                @if($item_a->observations == $item_b->observations) {{$input_item_a_checked}} @endif
                                value="A">
                            <label class="form-check-label"
                                for="for-observations">{{ $item_a->observations }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-observations"
                                id="for-observations"
                                @if($item_a->observations == $item_b->observations) {{$input_item_b_checked}} @endif
                                value="B">
                            <label class="form-check-label"
                                for="for-observations">{{ $item_b->observations }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $item_a->removed_user_id == $item_b->removed_user_id,
                ])>
                    <th>Usuario que lo eliminó</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-removed_user_id"
                                id="for-removed_user_id"
                                @if($item_a->removed_user_id == $item_b->removed_user_id) {{$input_item_a_checked}} @endif
                                value="A">
                            <label class="form-check-label"
                                for="for-removed_user_id">{{ $item_a->removed_user_id }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-removed_user_id"
                                id="for-removed_user_id"
                                @if($item_a->removed_user_id == $item_b->removed_user_id) {{$input_item_b_checked}} @endif
                                value="B">
                            <label class="form-check-label"
                                for="for-removed_user_id">{{ $item_b->removed_user_id }}</label>
                        </div>
                    </td>
                </tr>

                <tr @class([
                    'table-success' => $item_a->removed_at == $item_b->removed_at,
                ])>
                    <th>Fecha de eliminación</th>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-removed_at"
                                id="for-removed_at"
                                @if($item_a->removed_at == $item_b->removed_at) {{$input_item_a_checked}} @endif
                                value="A">
                            <label class="form-check-label"
                                for="for-removed_at">{{ $item_a->removed_at }}</label>
                        </div>
                    </td>
                    <td>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="radio"
                                name="for-removed_at"
                                id="for-removed_at"
                                @if($item_a->removed_at == $item_b->removed_at) {{$input_item_b_checked}} @endif
                                value="B">
                            <label class="form-check-label"
                                for="for-removed_at">{{ $item_b->removed_at }}</label>
                        </div>
                    </td>
                </tr>


                <tr>
                    <th>Movimientos</th>
                    <td>
                        @foreach ($item_a->movements as $movement)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="checkbox"
                                    name="for-observations"
                                    id="for-observations"
                                    @if($input_item_a_checked != null) {{$input_item_a_checked}} @endif
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
                        @foreach ($item_b->movements as $movement)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input"
                                    type="checkbox"
                                    name="for-observations"
                                    id="for-observations"
                                    @if($input_item_b_checked != null) {{$input_item_b_checked}} @endif
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

        <button type="submit"
            class="btn btn-primary"
            wire:click="fusion">
            <i class="bi bi-fusion"></i>
            Fusionar
        </button>
    @endif

    @include('layouts.bt5.partials.errors')
</div>

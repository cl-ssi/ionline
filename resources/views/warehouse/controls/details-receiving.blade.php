<div>
    <div class="form-row">
        <fieldset class="form-group col-md-4">
            <label for="type">Tipo de {{ $control->type_format }}</label>
            <input type="text" class="form-control form-control-sm"
                value="{{ optional($control->typeReception)->name }}" id="type" readonly>
        </fieldset>

        <fieldset class="form-group col-md-4">
            <label for="date">Fecha de {{ $control->type_format }}</label>
            <input type="text" class="form-control form-control-sm" value="{{ $control->date_format }}" id="date"
                readonly>
        </fieldset>
    </div>

    <div class="form-row">
        @switch($control->type_reception_id)
            @case(\App\Models\Warehouse\TypeReception::receiving())
                <fieldset class="form-group col-md-2">
                    <label for="origin-id">Origen</label>
                    <input type="text" class="form-control form-control-sm" value="{{ optional($control->origin)->name }}"
                        id="origin-id" readonly>
                </fieldset>
            @break

            @case(\App\Models\Warehouse\TypeReception::receiveFromStore())
                <fieldset class="form-group col-md-2">
                    <label for="store-origin-id">Bodega Origen</label>
                    <input type="text" class="form-control form-control-sm"
                        value="{{ optional($control->originStore)->name }}" id="store-origin-id" readonly>
                </fieldset>
            @break

            @case(\App\Models\Warehouse\TypeReception::return())
                <fieldset class="form-group col-md-2">
                    <label for="store-origin-id">Bodega Origen</label>
                    <input type="text" class="form-control" id="store-origin-id"
                        value="{{ optional($control->originStore)->name }}" readonly>
                </fieldset>
            @break

            @case(\App\Models\Warehouse\TypeReception::purchaseOrder())
                <fieldset class="form-group col-md-2">
                    <label for="purchase-order-code">Código OC</label>
                    <input type="text" class="form-control form-control-sm" value="{{ $control->po_code }}"
                        id="purchase-order-code" readonly>
                </fieldset>
            @break
        @endswitch

        @if ($control->isPurchaseOrder())
            <fieldset class="form-group col-md-2">
                <label for="po-date">Fecha OC</label>
                <input type="text" id="po-date" class="form-control form-control-sm"
                    value="{{ $control->po_date }}" readonly>
            </fieldset>
            <fieldset class="form-group col-md-8">
                <label for="supplier-name">Proveedor</label>
                <input type="text" id="supplier-name" class="form-control form-control-sm"
                    value="{{ optional($control->supplier)->name }}" readonly>
            </fieldset>
        @endif

        @if ($control->isReceptionNormal())
            <fieldset class="form-group col-md-3">
                <label for="program-id">Programa</label>
                <input type="text" class="form-control form-control-sm" value="{{ $control->program_name }}"
                    id="program-id" readonly>
            </fieldset>

            <fieldset class="form-group col-md-6">
                <label for="note">Nota</label>
                <input type="text" class="form-control form-control-sm" value="{{ $control->note }}" id="note"
                    readonly>
            </fieldset>
        @endif
    </div>

    @if ($control->isPurchaseOrder())
        <div class="form-row">
            <fieldset class="form-group col-md-2">
                <label for="document-type">Tipo Documento</label>
                <input type="text" id="document-type" class="form-control form-control-sm"
                    value="{{ $control->document_type_translate }}" readonly>
            </fieldset>

            <fieldset class="form-group col-md-2">
                <label for="document-date">Fecha Documento</label>
                <input type="date" id="document-date" class="form-control form-control-sm"
                    value="{{ $control->document_date }}" readonly>
            </fieldset>

            <fieldset class="form-group col-md-2">
                <label for="document-number">Nro. Documento</label>
                <input type="text" id="document-number" class="form-control form-control-sm"
                    value="{{ $control->document_number }}" readonly>
            </fieldset>

            <fieldset class="form-group col-md-2">
                <label for="program-id">Programa</label>
                <input type="text" class="form-control form-control-sm" value="{{ $control->program_name }}"
                    id="program-id" readonly>
            </fieldset>

            <fieldset class="form-group col-md-4">
                <label for="note">Nota</label>
                <input type="text" class="form-control form-control-sm" value="{{ $control->note }}" id="note"
                    readonly>
            </fieldset>
        </div>
    @endif

    <div class="form-row">
        <fieldset class="form-group col-md-4">
            <label for="signer-id">Visador Ingreso Bodega</label>
            <input type="text" class="form-control form-control-sm"
                value="{{ $control->receptionVisator->full_name ?? 'No posee Visador Ingreso Bodega' }}" id="signer-id"
                readonly>
        </fieldset>

        <fieldset class="form-group col-md-4">
            <label for="signer-id">Visador Recepción Técnica</label>
            <input type="text" class="form-control form-control-sm"
                value="{{ $control->technicalSigner->full_name ?? 'No posee Visador Recepción Técnica' }}"
                id="signer-id" readonly>
        </fieldset>


        <fieldset class="form-group col-md-4">
            <div class="form-group">
                <div class="form-row">
                    <label for="require-contract-manager-visation">Requiere Visación del Administrador de
                        Contrato</label>
                </div>
                <div class="form-check text-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                            {{ $control->require_contract_manager_visation ? 'checked' : '' }}
                            id="require-contract-manager-visation" disabled>
                    </div>
                </div>
            </div>
        </fieldset>

    </div>
</div>

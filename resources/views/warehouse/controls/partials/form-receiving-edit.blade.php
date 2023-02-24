<div class="form-row">
    <fieldset class="form-group col-md-4">
        <label for="type-dispatch">Tipo de Ingreso</label>
        <input
            type="text"
            class="form-control form-control-sm"
            value="{{ optional($control->typeReception)->name }}"
            id="type-dispatch"
            readonly
        >
    </fieldset>

    <fieldset class="form-group col-md-4">
        <label for="date">Fecha Ingreso</label>
        <input
            type="date"
            id="date"
            class="form-control form-control-sm @error('date') is-invalid @enderror"
            value="{{ old('date', optional($control)->date) }}"
            wire:model.debounce.1500ms="date"
            required
        >
        @error('date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>

<div class="form-row">
    @switch($control->type_reception_id)
        @case(\App\Models\Warehouse\TypeReception::receiving())
            <fieldset class="form-group col-md-3">
                <label for="origin-id">Origen</label>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    id="origin-id"
                    value="{{ optional($control->origin)->name }}"
                    readonly
                >
            </fieldset>
            @break
        @case(\App\Models\Warehouse\TypeReception::return())
            <fieldset class="form-group col-md-5">
                <label for="store-origin-id">Bodega Origen</label>
                <input
                    type="text"
                    class="form-control"
                    id="store-origin-id"
                    value="{{ optional($control->originStore)->name }}"
                    readonly
                >
            </fieldset>
            @break
        @case(\App\Models\Warehouse\TypeReception::receiveFromStore())
            <fieldset class="form-group col-md-5">
                <label for="store-origin-id">Bodega Origen</label>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    id="store-origin-id"
                    value="{{ optional($control->originStore)->name }}"
                    readonly
                >
            </fieldset>
            @break
        @case(\App\Models\Warehouse\TypeReception::purchaseOrder())
            <fieldset class="form-group col-md-5">
                <label for="purchase-order-code">Código OC</label>
                <input
                    type="text"
                    class="form-control form-control-sm"
                    value="{{ $control->po_code }}"
                    id="purchase-order-code"
                    readonly
                >
            </fieldset>
            @break
    @endswitch

    <fieldset class="form-group col-md-3">
        <label for="program-id">Programa</label>
        <input
            type="text"
            class="form-control form-control-sm"
            value="{{ $control->program_name }}"
            readonly
        >
    </fieldset>

    <fieldset class="form-group col-md-6">
        <label for="note">Nota</label>
        <input
            type="text"
            id="note"
            class="form-control form-control-sm @error('note') is-invalid @enderror"
            value="{{ optional($control)->name }}"
            wire:model.debounce.1500ms="note"
        >
        @error('note')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>

@if($control->isPurchaseOrder())
    <div class="form-row">
        <fieldset class="form-group col-md-4">
            <label for="po-date">Fecha OC</label>
            <input
                type="text"
                id="po-date"
                class="form-control form-control-sm"
                value="{{ $control->po_date }}"
                readonly
            >
        </fieldset>
        <fieldset class="form-group col-md-8">
            <label for="supplier-name">Proveedor</label>
            <input
                type="text"
                id="supplier-name"
                class="form-control form-control-sm"
                value="{{ optional($control->supplier)->name }}"
                readonly
            >
        </fieldset>
    </div>
@endif

<div class="form-row">
    <fieldset class="form-group col-md-4">
        <label for="reception-visator">Visador Ingreso Bodega</label>
        <input
            type="text"
            id="reception-visator"
            class="form-control form-control-sm"
            value="{{ $store->visator->full_name ?? 'No posee Visador Ingreso Bodega' }}"
            readonly
        >
    </fieldset>

    <fieldset class="form-group col-md-4">
        <label for="techinical-signer" class="form-label">Visador Recepción Técnica</label>
        <input
            type="text"
            id="techinical-signer"
            class="form-control form-control-sm"
            value="{{ $control->technicalSigner->full_name ?? 'No posee Visador Recepción Técnica' }}"
            readonly
        >
    </fieldset>
</div>

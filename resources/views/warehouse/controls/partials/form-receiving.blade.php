<div class="form-row">
    @if($mode == 'edit')
        <fieldset class="form-group col-md-4">
            <label for="type-dispatch">Tipo de Ingreso</label>
            <input
                type="text"
                class="form-control"
                value="{{ optional($control->typeReception)->name }}"
                id="type-dispatch"
                readonly
            >
        </fieldset>
    @endif
</div>

<div class="form-row">
    <fieldset class="form-group col-md-2">
        <label for="date">Fecha Ingreso</label>
        <input
            type="date"
            id="date"
            class="form-control @error('date') is-invalid @enderror"
            value="{{ old('date', optional($control)->date) }}"
            wire:model="date"
            required
        >
        @error('date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-5">
        <label for="program-id">Programa</label>
        @if($mode == 'edit')
            <input
                type="text"
                class="form-control"
                value="{{ $control->program_name }}"
                readonly
            >
        @else
            <select
                class="form-control @error('program_id') is-invalid @enderror"
                wire:model="program_id"
                id="program-id"
            >
                <option value="">Sin programa</option>
                @foreach($programs as $program)
                    <option
                        value="{{ $program->id }}"
                        {{ old('mobile_id', optional($control)->program_id) == $program->id ? 'selected' : '' }}
                    >
                        {{ $program->name }}
                    </option>
                @endforeach
            </select>
            @error('program_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        @endif
    </fieldset>

    @if($mode == 'create')
        <fieldset class="form-group col-md-5">
            <label for="origin-id">Origen</label>
            <select
                class="form-control @error('origin_id') is-invalid @enderror"
                wire:model="origin_id" id="origin-id"
            >
                <option value="">Selecciona un origen</option>
                @foreach($store->origins as $origin)
                    <option
                        value="{{ $origin->id }}"
                        {{ old('mobile_id', optional($control)->origin_id) == $origin->id ? 'selected' : '' }}
                    >
                        {{ $origin->name }}
                    </option>
                @endforeach
            </select>
            @error('origin_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>
    @endif

    @if($mode == 'edit')
        @switch($control->type_reception_id)
            @case(\App\Models\Warehouse\TypeReception::receiving())
                <fieldset class="form-group col-md-5">
                    <label for="origin-id">Origen</label>
                    <input
                        type="text"
                        class="form-control"
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
                        class="form-control"
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
                        class="form-control"
                        value="{{ $control->po_code }}"
                        id="purchase-order-code"
                        readonly
                    >
                </fieldset>
                @break
        @endswitch
    @endif
</div>

@if($mode == 'edit' && $control->isPurchaseOrder())
    <div class="form-row">
        <fieldset class="form-group col-md-4">
            <label for="po-date">Fecha OC</label>
            <input
                type="text"
                id="po-date"
                class="form-control"
                value="{{ $control->po_date }}"
                readonly
            >
        </fieldset>
        <fieldset class="form-group col-md-8">
            <label for="supplier-name">Proveedor</label>
            <input
                type="text"
                id="supplier-name"
                class="form-control"
                value="{{ optional($control->supplier)->name }}"
                readonly
            >
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-md-3">
            <label for="guide-date">Fecha Guía</label>
            <input
                type="date"
                id="guide-date"
                class="form-control @error('guide_date') is-invalid @enderror"
                wire:model="guide_date"
            >
            @error('guide_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-md-3">
            <label for="guide-number">Número Guía</label>
            <input
                type="text"
                id="guide-number"
                class="form-control @error('guide_number') is-invalid @enderror"
                wire:model="guide_number"
            >
            @error('guide_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-md-3">
            <label for="invoice-date">Fecha Factura</label>
            <input
                type="date"
                id="invoice-date"
                class="form-control @error('invoice_date') is-invalid @enderror"
                wire:model="invoice_date"
            >
            @error('invoice_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>

        <fieldset class="form-group col-md-3">
            <label for="invoice-number">Número Factura</label>
            <input
                type="text"
                id="invoice-number"
                class="form-control @error('invoice_number') is-invalid @enderror"
                wire:model="invoice_number"
            >
            @error('invoice_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </fieldset>
    </div>
@endif

<div class="form-row">
    <fieldset class="form-group col-md-12">
        <label for="note">Nota</label>
        <input
            type="text"
            id="note"
            class="form-control @error('note') is-invalid @enderror"
            value="{{ optional($control)->name }}"
            wire:model="note"
        >
        @error('note')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </fieldset>
</div>

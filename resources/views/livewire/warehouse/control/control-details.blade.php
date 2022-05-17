<div>
    <div class="form-row mt-2">
        <fieldset class="form-group col-md-4">
            <label for="type">Tipo de {{ $control->type_format }}</label>
            <input
                type="text"
                class="form-control"
                @if($control->isDispatch())
                value="{{ optional($control->typeDispatch)->name }}"
                @else
                value="{{ optional($control->typeReception)->name }}"
                @endif
                id="type"
                readonly
            >
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-md-4">
            <label for="date">Fecha</label>
            <input
                type="text"
                class="form-control"
                value="{{ $control->date_format }}"
                id="date"
                readonly
            >
        </fieldset>

        <fieldset class="form-group col-md-4">
            <label for="program-id">Programa</label>
            <input
                type="text"
                class="form-control"
                value="{{ $control->program_name }}"
                id="program-id"
                readonly
            >
        </fieldset>

        @switch($control->type_dispatch_id)
            @case(\App\Models\Warehouse\TypeDispatch::dispatch())
                <fieldset class="form-group col-md-4">
                    <label for="destination-id">Destino</label>
                    <input
                        type="text"
                        class="form-control"
                        value="{{ optional($control->destination)->name }}"
                        id="destination-id"
                        readonly
                    >
                </fieldset>
                @break
            @case(\App\Models\Warehouse\TypeDispatch::sendToStore())
                <fieldset class="form-group col-md-4">
                    <label for="store-destination-id">Bodega Destino</label>
                    <input
                        type="text"
                        class="form-control"
                        value="{{ optional($control->destinationStore)->name }}"
                        id="store-destination-id"
                        readonly
                    >
                </fieldset>
                @break
        @endswitch

        @switch($control->type_reception_id)
            @case(\App\Models\Warehouse\TypeReception::receiving())
                <fieldset class="form-group col-md-4">
                    <label for="origin-id">Origen</label>
                    <input
                        type="text"
                        class="form-control"
                        value="{{ optional($control->origin)->name }}"
                        id="origin-id"
                        readonly
                    >
                </fieldset>
                @break
            @case(\App\Models\Warehouse\TypeReception::receiveFromStore())
                <fieldset class="form-group col-md-4">
                    <label for="origin-id">Bodega Origen</label>
                    <input
                        type="text"
                        class="form-control"
                        value="{{ optional($control->originStore)->name }}"
                        id="store-origin-id"
                        readonly
                    >
                </fieldset>
                @break
        @endswitch
    </div>

    <div class="form-row">
        <fieldset class="form-group col-md-12">
            <label for="note">Nota</label>
            <input
                type="text"
                class="form-control"
                value="{{ $control->note }}"
                id="note"
                readonly>
        </fieldset>
    </div>
</div>

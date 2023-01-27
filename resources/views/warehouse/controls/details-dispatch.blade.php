<div>
    <div class="form-row mt-2">
        <fieldset class="form-group col-md-4">
            <label for="type">Tipo de {{ $control->type_format }}</label>
            <input
                type="text"
                class="form-control form-control-sm"
                value="{{ optional($control->typeDispatch)->name }}"
                id="type"
                readonly
            >
        </fieldset>
    </div>

    <div class="form-row">
        <fieldset class="form-group col-md-4">
            <label for="date">Fecha {{ $control->type_format }}</label>
            <input
                type="text"
                class="form-control form-control-sm"
                value="{{ $control->date_format }}"
                id="date"
                readonly
            >
        </fieldset>

        <fieldset class="form-group col-md-4">
            <label for="program-id">Programa</label>
            <input
                type="text"
                class="form-control form-control-sm"
                value="{{ $control->program_name }}"
                id="program-id"
                readonly
            >
        </fieldset>

        @switch($control->type_dispatch_id)
            @case(\App\Models\Warehouse\TypeDispatch::internal())
                <fieldset class="form-group col-md-5">
                    <label for="establishment-id">Establecimiento</label>
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        value="{{ optional($control->organizationalUnit)->establishment->name }}"
                        id="establishment-id"
                        readonly
                    >
                </fieldset>
                <fieldset class="form-group col-md-7">
                    <label for="organizational-unit-id">Unidad Organizacional</label>
                    <input
                        type="text"
                        class="form-control form-control-sm"
                        value="{{ optional($control->organizationalUnit)->name }}"
                        id="organizational-unit-id"
                        readonly
                    >
                </fieldset>
            @break
            @case(\App\Models\Warehouse\TypeDispatch::external())
                <fieldset class="form-group col-md-4">
                    <label for="destination-id">Destino</label>
                    <input
                        type="text"
                        class="form-control form-control-sm"
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
                        class="form-control form-control-sm"
                        value="{{ optional($control->destinationStore)->name }}"
                        id="store-destination-id"
                        readonly
                    >
                </fieldset>
                @break
        @endswitch

    </div>

    <div class="form-row">
        <fieldset class="form-group col-md-8">
            <label for="note">Nota</label>
            <input
                type="text"
                class="form-control form-control-sm"
                value="{{ $control->note }}"
                id="note"
                readonly
            >
        </fieldset>
    </div>
</div>

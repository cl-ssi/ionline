<div>
    <div class="row mb-2">
        <div class="col-4">
            <label for="date">Fecha</label>
            <input type="text" class="form-control" value="{{ $control->date_format }}" id="date" readonly>
        </div>

        <div class="col-4">
            <label for="program-id">Programa</label>
            <input type="text" class="form-control" value="{{ $control->program_name }}" id="program-id" readonly>
        </div>

        @if($control->type)
            <div class="col-4">
                <label for="origin-id">Origen</label>
                <input type="text" class="form-control" value="{{ optional($control->origin)->name }}" id="origin-id" readonly>
            </div>
        @else
            @if(!$control->isAdjustInventory())
                <div class="col-4">
                    <label for="destination-id">Destino</label>
                    <input type="text" class="form-control" value="{{ optional($control->destination)->name }}" id="destination-id" readonly>
                </div>
            @else
                <div class="col-4">
                    <label for="destination-id">Ajuste de Inventario</label>
                    <input type="text" class="form-control" value="{{ $control->adjust_inventory_format }}" id="destination-id" readonly>
                </div>
            @endif
        @endif
    </div>

    <div class="row">
        <div class="col-12">
            <label for="note">Nota</label>
            <input type="text" class="form-control" value="{{ $control->note }}" readonly>
        </div>
    </div>
</div>

<div>
    <h5>
        @if($type == 'receiving')
            Nuevo Ingreso
        @else
            Nuevo Egreso
        @endif
    </h5>

    @include('warehouse.controls.partials.form', [
        'control' => null,
        'store' => $store,
        'type' => $type,
        'disableProgram' => false,
        'showInputAdjustInventory' => true,
        'disabledAdjustInventory' => false,
    ])

    <button class="btn btn-primary" wire:click="createControl">
        Crear
    </button>
    <a
        class="btn btn-outline-primary"
        href="{{ route('warehouse.controls.index', ['store' => $store, 'type' => $type]) }}">
        Cancelar
    </a>
</div>

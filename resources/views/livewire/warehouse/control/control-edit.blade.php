<div>
    <h4>
        Editar {{ $control->type_format }} {{ $control->id }}
    </h4>

    @include('warehouse.controls.partials.form', [
        'store' => $store,
        'control' => $control,
        'type'  => $type,
        'disableProgram' => true,
        'showInputAdjustInventory' => false,
        'disabledAdjustInventory' => true,
    ])

    <button class="btn btn-primary" wire:click="controlUpdate">
        Actualizar
    </button>
    <a
        class="btn btn-outline-primary"
        href="{{ route('warehouse.controls.index', ['store' => $store, 'type' => $type]) }}">
        Cancelar
    </a>

</div>

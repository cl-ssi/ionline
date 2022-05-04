<div>
    <h4>
        Editar {{ $control->type_format }}
    </h4>

    @include('warehouse.controls.partials.form', [
        'store' => $store,
        'control' => $control,
        'type'  => $type
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

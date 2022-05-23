<div>
    <h5>
        Editar {{ $control->type_format }} {{ $control->id }}: {{ $store->name }}
    </h5>

    @if($type == 'receiving')
        @include('warehouse.controls.partials.form-receiving', [
            'control' => $control,
            'store' => $store,
            'type' => $type,
            'mode' => 'edit'
        ])
    @else
        @include('warehouse.controls.partials.form-dispatch', [
            'control' => $control,
            'store' => $store,
            'type' => $type,
            'mode' => 'edit',
        ])
    @endif

    <button class="btn btn-primary" wire:click="controlUpdate">
        Actualizar
    </button>
    <a
        class="btn btn-outline-primary"
        href="{{ route('warehouse.controls.index', ['store' => $store, 'type' => $type]) }}">
        Cancelar
    </a>
</div>

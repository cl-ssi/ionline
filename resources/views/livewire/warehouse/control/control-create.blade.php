<div>
    <h5>
        @if($type == 'receiving')
            Nuevo Ingreso:
        @else
            Nuevo Egreso:
        @endif
         {{ $store->name }}
    </h5>

    @if($type == 'receiving')
        @include('warehouse.controls.partials.form-receiving-create', [
            'control' => null,
            'store' => $store,
            'type' => $type,
            'mode' => 'create',
        ])
    @else
        @include('warehouse.controls.partials.form-dispatch', [
            'control' => null,
            'store' => $store,
            'type' => $type,
            'mode' => 'create',
        ])
    @endif

    <button class="btn btn-primary" wire:click="createControl">
        Crear
    </button>
    <a
        class="btn btn-outline-primary"
        href="{{ route('warehouse.controls.index', ['store' => $store, 'type' => $type, 'nav' => $nav]) }}"
    >
        Cancelar
    </a>
</div>

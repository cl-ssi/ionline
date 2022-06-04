<div>
    <div class="row">
        <div class="col">
            <h5>
                Editar {{ $control->type_format }} {{ $control->id }}: {{ $store->name }}
            </h5>
        </div>
        <div class="col text-right">
            @if($control->requestForm)
                <a
                    class="btn btn-sm btn-primary"
                    href="{{ route('request_forms.show', $control->requestForm) }}"
                    target="_blank"
                >
                    <i class="fas fa-file-alt"></i> Formulario de Requerimiento #{{ $control->requestForm->id }}
                </a>
            @endif
        </div>
    </div>

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

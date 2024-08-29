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
                    <i class="fas fa-file-alt"></i> FR Folio #{{ $control->requestForm->folio }}
                </a>
            @else
                <a
                    class="btn btn-sm btn-danger disabled"
                    href="#"
                    target="_blank"
                >
                    <i class="fas fa-exclamation-triangle"></i> No hay FR relacionada
                </a>
            @endif
        </div>
    </div>

    @if($type == 'receiving')
        @include('warehouse.controls.partials.form-receiving-edit', [
            'control' => $control,
            'store' => $store,
            'type' => $type,
            'mode' => 'edit',
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
        href="{{ route('warehouse.controls.index', ['store' => $store, 'type' => $type, 'nav' => $nav]) }}"
    >
        Cancelar
    </a>
</div>

@section('custom_js')
<script>
    document.addEventListener('livewire:init', function () {
        var organizational_unit_id = @this.organizational_unit_id;
        var establishment_id = @this.establishment_id;

        Livewire.emitTo('organizational-unit-search', 'addOrganizationalUnit', organizational_unit_id)
        Livewire.emitTo('establishment-search', 'addEstablishment', establishment_id)
    });
</script>
@endsection

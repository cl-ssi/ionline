<div>
    <div class="input-group @if($smallInput) input-group-sm @endif has-validation">
        <div class="input-group-prepend">
            <span
                class="input-group-text"
                wire:loading.remove
                wire:target="search"
            >
                @if($organizational_unit_id == null)
                    <i class="fas fa-times text-danger"></i>
                @else
                    <i class="fas fa-check text-success"></i>
                @endif
            </span>
            <span
                class="input-group-text"
                wire:loading
                wire:target="search"
            >
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true">
                </span>
            </span>
        </div>

        <input
            type="text"
            id="{{ $tagId }}"
            class="form-control @if($smallInput) form-control-sm @endif"
            wire:model.live.debounce.1500ms="search"
            placeholder="{{ $placeholder }}"
            @if($organizational_unit_id) disabled @endif
        >
        <div class="input-group-append">
            <button
                class="btn @if($smallInput) btn-sm @endif btn-secondary"
                type="button"
                wire:click="clear"
                title="Limpiar"
            >
                <i class="fas fa-eraser"></i>
            </button>
        </div>
    </div>

    <ul class="list-group col-12" style="z-index: 3; position: absolute;">
        @if($showResult)
            @forelse($organizationalUnits as $organizationalUnit)
                <a
                    wire:click.prevent="addOrganizationalUnit({{ $organizationalUnit }})"
                    class="list-group-item list-group-item-action py-1"
                >
                    <small>{{ $organizationalUnit->name }}</small>
                </a>
            @empty
                <div class="list-group-item list-group-item-danger py-1">
                    <small>No hay resultados</small>
                </div>
            @endforelse
        @endif
    </ul>
</div>

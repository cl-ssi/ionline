<div>
    <div class="input-group @if($smallInput) input-group-sm @endif has-validation">
        <div class="input-group">
            <span class="input-group-text" wire:loading.remove wire:target="search">
                @if($place_id == null)
                    <i class="fas fa-times text-danger"></i>
                @else
                    <i class="fas fa-check text-success"></i>
                @endif
            </span>
            <span class="input-group-text" wire:loading wire:target="search">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <span class="sr-only">...</span>
            </span>

        <input
            type="text"
            id="{{ $tagId }}"
            class="form-control @if($smallInput) form-control-sm @endif"
            wire:model.live.debounce.1500ms="search"
            placeholder="{{ $placeholder }}"
            autocomplete="off"
            @if($place_id) disabled @endif
        >
            <button
                class="btn @if($smallInput) btn-sm @endif btn-secondary"
                type="button"
                wire:click="clearSearch"
                title="Limpiar"
            >
                <i class="fas fa-eraser"></i>
            </button>
        </div>
    </div>

    <ul class="list-group" style="z-index: 3; position: absolute;">
        @if($showResult)
            @forelse($places as $place)
                <a
                    wire:click.prevent="addSearchPlace({{ $place }})"
                    class="list-group-item list-group-item-action py-1"
                >
                    <small>
                        {{ $place->location->name }}, {{ $place->name }} ({{ $place->architectural_design_code }})
                    </small>
                </a>
            @empty
                <div class="list-group-item list-group-item-danger py-1">
                    <small>No hay resultados</small>
                </div>
            @endforelse
        @endif
    </ul>
</div>

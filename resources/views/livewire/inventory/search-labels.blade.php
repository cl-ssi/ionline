<div>
    <div class="input-group @if($smallInput) input-group-sm @endif has-validation">
        <div class="input-group-prepend">
            <span class="input-group-text" wire:loading.remove wire:target="search">
                <i class="fas fa-search"></i>
            </span>
            <span class="input-group-text" wire:loading wire:target="search">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <span class="sr-only">...</span>
            </span>
        </div>

        <input
            type="text"
            id="{{ $tagId }}"
            class="form-control @if($smallInput) form-control-sm @endif"
            wire:model.live.debounce.1500ms="search"
            placeholder="{{ $placeholder }}"
        >
        <div class="input-group-append">
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

    <ul class="list-group col-12" style="z-index: 3; position: absolute;">
        @if($showResult)
            @forelse($foundLabels as $foundLabel)
                <a
                    wire:click.prevent="addSearchedLabel({{ $foundLabel }})"
                    class="list-group-item list-group-item-action py-1"
                >
                    <small>{{ $foundLabel->name }}</small>
                </a>
            @empty
                <div class="list-group-item list-group-item-danger py-1">
                    <small>No hay resultados</small>
                </div>
            @endforelse
        @endif
    </ul>

    <ul class="list-group my-2">
        @forelse($selectedLabels as $index => $selectedLabel)
            <li
                class="list-group-item d-flex justify-content-between align-items-center"
                style="padding: .4rem 0.5rem"
            >
                {{ $selectedLabel->name }}
                <button
                    class="btn btn-sm btn-outline-danger"
                    wire:click="deleteLabel({{ $index }})"
                >
                    <i class="fas fa-trash"></i>
                </button>
            </li>
        @empty
            <li class="list-group-item">
                <em>
                    No hay registros
                </em>
            </li>
        @endforelse
    </ul>
</div>

@section('custom_js')
<script>
    document.addEventListener('livewire:init', function () {
        var labelsId = @this.labelsId;
        var eventName = @this.eventName;

        Livewire.emit(eventName, labelsId)
    });
</script>
@endsection

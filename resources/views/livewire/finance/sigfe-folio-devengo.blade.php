<div>

    @if ($editing)
        <input class="form-control-sm" wire:model="nuevoFolioDevengo" type="text" placeholder="Ingrese el folio devengo sigfe">
        @if(!$onlyRead)
            <button class="btn btn-sm btn-primary" 
                wire:click="guardarFolioDevengo">
                <i class="fas fa-fw fa-save"></i>
            </button>
        @endif
    @else
        <div class="input-group mb-3">
            <input type="text" class="form-control-sm" value="{{ $nuevoFolioDevengo }}" disabled>
            @if(!$onlyRead)
                <div class="input-group-append">
                    <button wire:click="toggleEditing" 
                        class="btn btn-sm btn-outline-primary" 
                        type="button">
                        <i class="fas fa-fw fa-edit"></i>
                    </button>
                </div>
            @endif
        </div>
    @endif

    @if ($successMessage)
        <div class="text-success">{{ $successMessage }}</div>
    @endif
</div>

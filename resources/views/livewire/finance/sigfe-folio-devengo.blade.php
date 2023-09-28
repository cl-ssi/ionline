<div>

    @if ($editing)
        <input class="form-control form-control-sm" wire:model.defer="nuevoFolioDevengo" type="text" placeholder="Ingrese el folio devengo sigfe">
        <button class="btn btn-sm btn-primary" 
            wire:click="guardarFolioDevengo">
            <i class="fas fa-fw fa-save"></i>
        </button>
    @else
        <div class="input-group mb-3">
            <input type="text" class="form-control form-control-sm" value="{{ $nuevoFolioDevengo }}" disabled>
            <div class="input-group-append">
                <button wire:click="toggleEditing" 
                    class="btn btn-sm btn-outline-primary" 
                    type="button">
                    <i class="fas fa-fw fa-edit"></i>
                </button>
            </div>
        </div>
    @endif

    @if ($successMessage)
        <div class="text-success">{{ $successMessage }}</div>
    @endif
</div>

<div>
    @if ($editing)
            <input wire:model.defer="nuevoFolioCompromiso" 
                type="text" 
                placeholder="Ingrese el folio compromiso sigfe"
                class="form-control form-control-sm">
                <button class="btn btn-sm btn-primary" 
                    type="button" 
                    wire:click="guardarFolioCompromiso">
                    <i class="fas fa-fw fa-save"></i>
                </button>

    @else
        <div class="input-group mb-3">
            <input value="{{ $dte->folio_compromiso_sigfe }}" 
                type="text" 
                class="form-control form-control-sm" disabled>
            <div class="input-group-append">
                <button 
                    class="btn btn-sm btn-outline-primary" 
                    wire:click="toggleEditing">
                    <i class="fas fa-fw fa-edit"></i>
                </button>
            </div>
        </div>
    @endif

    @if ($successMessage)
        <div class="text-success">{{ $successMessage }}</div>
    @endif
</div>

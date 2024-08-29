<div>
    @if ($editing)
            <input wire:model="nuevoFolioCompromiso" 
                type="text" 
                placeholder="Ingrese el folio compromiso sigfe"
                class="form-control-sm">
                @if(!$onlyRead)
                    <button class="btn btn-sm btn-primary" 
                        type="button" 
                        wire:click="guardarFolioCompromiso">
                        <i class="fas fa-fw fa-save"></i>
                    </button>
                @endif

    @else
        <div class="input-group mb-3">
            <input value="{{ $dte->folio_compromiso_sigfe }}" 
                type="text" 
                class="form-control-sm" disabled>
            @if(!$onlyRead)
                <div class="input-group-append">
                    <button 
                        class="btn btn-sm btn-outline-primary" 
                        wire:click="toggleEditing">
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

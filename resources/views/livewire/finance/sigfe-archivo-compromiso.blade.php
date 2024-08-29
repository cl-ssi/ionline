<div>
    @if ($archivoCompromiso !== null)
        <div class="mb-2">
            <button wire:click="downloadFile('{{ $archivoCompromiso }}')" class="btn btn-sm btn-success">
                <i class="fas fa-download"></i> Descargar
            </button>
            @if(!$onlyRead)
                <button wire:click="deleteFile('{{ $archivoCompromiso }}')" class="btn btn-sm btn-danger">
                    <i class="fas fa-trash-alt"></i> Eliminar
                </button>
            @endif
        </div>
    @else
        <div class="input-group">
            <input class="form-control" type="file" wire:model.live="file" accept=".pdf">
            <button class="btn btn-outline-primary" wire:click="uploadFile">
                <i class="bi bi-upload"></i>
            </button>
        </div>
    @endif

    @if ($successMessage)
        <div class="text-success">{{ $successMessage }}</div>
    @endif
</div>

<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    @if ($archivoDevengo !== null)
        <div class="mb-2">
            <button wire:click="downloadFile('{{ $archivoDevengo }}')" class="btn btn-sm btn-success">
                <i class="fas fa-download"></i> Descargar
            </button>
            @if(!$onlyRead)
                <button wire:click="deleteFile('{{ $archivoDevengo }}')" class="btn btn-sm btn-danger">
                    <i class="fas fa-trash-alt"></i> Eliminar
                </button>
            @endif
        </div>
    @else
        <div class="input-group">
            <input class="form-control" type="file" wire:model.live="file" accept=".pdf" data-browse="Bestand kiezen">
            <button class="btn btn-outline-primary" wire:click="uploadFile">
                <i class="bi bi-upload"></i>
            </button>
        </div>
    @endif

    @if ($successMessage)
        <div class="text-success">{{ $successMessage }}</div>
    @endif
</div>

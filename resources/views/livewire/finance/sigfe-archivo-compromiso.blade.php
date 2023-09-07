<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    @if ($archivoCompromiso !== null)
        <div class="mb-2">
            <button wire:click="downloadFile('{{ $archivoCompromiso }}')" class="btn btn-sm btn-success">
                <i class="fas fa-download"></i> Descargar
            </button>
            <button wire:click="deleteFile('{{ $archivoCompromiso }}')" class="btn btn-sm btn-danger">
                <i class="fas fa-trash-alt"></i> Eliminar
            </button>
        </div>
    @else
        <input type="file" wire:model="file" accept=".pdf">
        <button wire:click="uploadFile">Subir Archivo</button>
    @endif

    @if ($successMessage)
        <div class="text-success">{{ $successMessage }}</div>
    @endif
</div>

<div>
    @if($has_resolution_file)
        <a href="{{route('rrhh.fulfillments.download.resolution', $fulfillment)}}"
           target="_blank" class="mr-4">Resolución cargada
        </a>
        <a class="btn btn-sm btn-outline-danger ml-4" wire:click="delete">
            <i class="fas fa-trash"></i>
        </a>
    @else
        <form wire:submit.prevent="upload">
            <input type="file" wire:model="resolutionFile" required>
            @error('resolutionFile') <span class="error">{{ $message }}</span> @enderror
            <div wire:loading wire:target="resolutionFile">Cargando...</div>
            <button type="submit" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-upload"></i>
            </button>
        </form>
    @endif
</div>
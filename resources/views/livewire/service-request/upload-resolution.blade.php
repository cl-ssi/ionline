<div>
    @if($has_resolution_file)
        <a href="{{route('rrhh.service-request.fulfillment.download_resolution', $serviceRequest)}}"
           target="_blank" class="btn btn-outline-primary"> <i class="fas fa-file-pdf"></i> Resolución
        </a>
        @can('Service Request: fulfillments rrhh')
        <a class="btn btn-outline-danger ml-4" wire:click="delete">
            <i class="fas fa-trash"></i>
        </a>
        @endcan
    @else
        @can('Service Request: fulfillments rrhh')
        <form wire:submit.prevent="save">
            <input type="file" wire:model="resolutionFile" required>
            @error('resolutionFile') <span class="error">{{ $message }}</span> @enderror
            <div wire:loading wire:target="resolutionFile"><strong>Cargando</strong></div>
            <button type="submit" class="btn btn-outline-primary">
                <i class="fas fa-save"></i>
            </button>
        </form>
        @endcan
    @endif
</div>

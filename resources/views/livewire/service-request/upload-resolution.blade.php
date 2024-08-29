<div class="form-row">
    @if($has_resolution_file)
        @can('Service Request: fulfillments rrhh')
        <div class="col-md-1">
            <label><br></label>
            <a class="btn btn-outline-danger" wire:click="delete">
                <i class="fas fa-trash"></i>
            </a>
        </div>
        @endcan
        <div class="col-md-1">
        </div>
        <div class="col-md-6">
            <label>Resolución</label>
            <a href="{{route('rrhh.service-request.fulfillment.download_resolution', $serviceRequest)}}"
                target="_blank" class="btn btn-outline-primary form-control"> <i class="fas fa-file-pdf"></i> Resolución
            </a>
        </div>
    @else
        @can('Service Request: fulfillments rrhh')
        <div class="col-md-7">
            <label>Resolución</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input @error('resolutionFile') is-invalid @enderror" wire:model.live="resolutionFile" required>
                <label class="custom-file-label" (for="customFileLangHTML" data-browse="Examinar">{{ optional($resolutionFile)->getClientOriginalName() }}</label>
                @error('resolutionFile') 
                <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
            </div>
        </div>
        <div class="col-md-1">
            <label><br></label>
            <div wire:loading wire:target="resolutionFile">
                <strong><i class="fas fa-circle-notch fa-spin fa-2x"></i></strong>
            </div>
        </div>
        <div class="col-md-1">
            <label><br></label>
            <button wire:click="save()" class="btn btn-outline-primary">
                <i class="fas fa-save"></i>
            </button>
        </div>
        @endcan
    @endif

</div>

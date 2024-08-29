<div>
    @if($remFile->filename)
        <a class="btn btn-sm btn-outline-secondary" wire:click="download" target="_blank">
            <i class="fas fa-fw fa-file-excel text-success"></i>
        </a>
    @endif

    @if(auth()->user()->can('Rem: admin'))
        <button type="button" wire:click="lock_unlock" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-fw {{ optional($remFile)->locked ? 'fa-lock' : 'fa-lock-open text-success' }}"></i>
        </button>
    @endif
    
    @if(!$remFile->locked)

        @if($remFile->filename)
            <button type="button" wire:click="deleteFile" class="btn btn-sm btn-danger" onclick="return confirm('¿está seguro que desea eliminar este Archivo?');">
                <i class="fas fa-fw fa-trash-alt"></i>
            </button>
        @else
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" wire:model.live="file" class="custom-file-input" id="for-file" required>
                    <label class="custom-file-label" for="for-file" data-browse="Examinar">
                        <div wire:loading wire:target="file"><strong>Cargando</strong></div>
                        {{ optional($file)->getClientOriginalName() ?? 'Archivo' }}
                    </label>
                </div>
                <div class="input-group-append">
                    <button type="button" wire:click="save" class="btn btn-sm btn-outline-primary" {{ !$file ? 'disabled':'' }}>
                        <i class="fas fa-save"></i>
                    </button>
                </div>
                @error('file') 
                    <span class="invalid-feedback" role="alert"> 
                        <strong>{{ $message }}</strong> 
                    </span> 
                @enderror 
            </div>
        @endif
    @endif

</div>
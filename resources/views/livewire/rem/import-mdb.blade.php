<div>
    <h3 class="mb-3">Import MDB</h3>

    <form wire:submit.prevent="save">
        <div class="row">
            <div class="col-md-6">
                <label for="formFile" class="form-label">Default file input example</label>
                <div class="input-group mb-3 @error('file') is-invalid @enderror">
                    <input class="form-control" type="file" id="formFile" wire:model="file">
                    <button wire:click="save" class="btn btn-primary" wire:loading.attr="disabled" @disabled(!$file)>
                        <i class="bi bi-upload" wire:loading.remove></i>
                        <div wire:loading class="spinner-border spinner-border-sm "></div>
                    </button>
                </div>
                @error('file')<span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6">

            </div>
        </div>
        
       
   </form>

    @if ($info)
        <pre>
                {{ print_r($info) }} uploaded successfully.
        </pre>
    @endif
</div>

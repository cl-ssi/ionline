<div class="form-row mb-3">
    <fieldset class="col-12 col-md-4">
        <label for="for-name">Nombre*</label>
        <input type="text" wire:model="classification.name" class="form-control">
        @error('classification.name') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>

    
</div>
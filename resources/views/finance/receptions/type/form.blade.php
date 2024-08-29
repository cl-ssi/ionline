<div class="form-row mb-3">
    <fieldset class="col-12 col-md-3">
        <label for="for-name">Nombre*</label>
        <input type="text" wire:model="type.name" class="form-control">
        @error('type.name') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>

    <fieldset class="col-12 col-md-5">
        <label for="for-name">Titulo*</label>
        <input type="text" wire:model="type.title" class="form-control">
        @error('type.title') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>
</div>
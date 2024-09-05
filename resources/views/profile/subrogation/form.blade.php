<div class="form-row mb-3">
    <fieldset class="col-12 col-md-4">
        <label for="for-name">Subrogante</label>
        @livewire('search-select-user')
        @error('subrogant_id') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>
</div>
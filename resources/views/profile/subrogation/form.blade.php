<div class="form-row mb-3">
    <fieldset class="col-md-6">
        <label for="for-name">Subrogante</label>
        @livewire('search-select-user')
        @error('subrogant_id') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>
</div>

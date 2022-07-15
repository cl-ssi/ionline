<div class="form-row mb-3">
    <fieldset class="col-md-6">
        <label for="for-name">Subrogante</label>
        @livewire('search-select-user')
        @error('subrogant_id') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>

    <fieldset class="col-md-2">
        <label for="for-date">Nivel</label>
        <select class="form-control" wire:model="level" required>
            <option value=""></option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
        </select>
        @error('level') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>
</div>
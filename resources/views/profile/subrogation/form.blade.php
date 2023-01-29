<div class="form-row mb-3">
    <fieldset class="col-md-6">
        <label for="for-name">Subrogante</label>
        @livewire('search-select-user')
        @error('subrogant_id') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>
    <fieldset class="col-md-6">
        <label for="for-name">Unidar Organizacional</label>
        @livewire('select-organizational-unit', [
        'establishment_id' => auth()->user()->organizationalUnit->establishment->id,
        'select_id' => 'organizationalunit'
        ])
    </fieldset>
</div>
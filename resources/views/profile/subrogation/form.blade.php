<div class="form-row mb-3">
    <fieldset class="col-12 col-md-4">
        <label for="for-name">Subrogante</label>
        @livewire('search-select-user')
        @error('subrogant_id') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>

    {{--
    @if(!$organizationalUnit)
    <fieldset class="col-12 col-md-8">
        <label for="for-name">Unidad Organizacional</label>
        @livewire('select-organizational-unit', [
            'establishment_id' => auth()->user()->organizationalUnit->establishment->id,
            'select_id' => 'organizational_unit_id',
            'emitToListener' => 'ouSelected',
        ])
        @error('organizational_unit_id') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>
    @endif
     --}}
</div>
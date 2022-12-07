<div class="form-row mb-3">
    <fieldset class="col-12 col-md-4">
        <label for="for-name">Nombre*</label>
        <input type="text" wire:model.defer="holiday.name" class="form-control">
        @error('holiday.name') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>

    <fieldset class="col-12 col-md-2">
        <label for="for-date">Fecha*</label>
        <input type="date" wire:model.defer="holiday.date" class="form-control">
        @error('holiday.date') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>

    <fieldset class="col-12 col-md-4">
        <label for="for-date">Región</label>
        <select class="form-control" wire:model.defer="holiday.region_id">
            <option value="">Todas</option>
            @foreach($regions->sort() as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
        @error('holiday.region') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>
</div>
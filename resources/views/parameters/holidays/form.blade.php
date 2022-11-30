<div class="form-row mb-3">
    <fieldset class="col-md-4">
        <label for="for-name">Nombre*</label>
        <input type="text" wire:model="holiday.name" class="form-control">
        @error('holiday.name') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>

    <fieldset class="col-md-2">
        <label for="for-date">Fecha*</label>
        <input type="date" wire:model.lazy="holiday.date" class="form-control">
        @error('holiday.date') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>

    <fieldset class="col-md-2">
        <label for="for-date">Región</label>
        <select class="form-control" wire:model.lazy="holiday.region">
            <option value="">Todas</option>
            <option>I</option>
            <option>II</option>
            <option>III</option>
            <option>IV</option>
            <option>V</option>
            <option>VI</option>
            <option>VII</option>
            <option>VIII</option>
            <option>IX</option>
            <option>X</option>
            <option>XI</option>
            <option>XII</option>
            <option>XIII</option>
            <option>XIV</option>
            <option>XV</option>
            <option>XVI</option>
        </select>
        @error('holiday.region') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>
</div>
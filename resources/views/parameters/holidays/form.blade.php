<div class="row g-2 mb-3">
    <fieldset class="col-12 col-md-4">
        <label for="for-name">Nombre*</label>
        <input type="text" wire:model="holidayName" class="form-control">
        @error('holidayName') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>

    <fieldset class="col-12 col-md-2">
        <label for="for-date">Fecha*</label>
        <input type="date" wire:model="holidayDate" class="form-control">
        @error('holidayDate') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>

    <fieldset class="col-12 col-md-4">
        <label for="for-date">Región</label>
        <select class="form-select" wire:model="holidayRegionId">
            <option value="">Todas</option>
            @foreach($regions->sort() as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
        @error('holidayRegionId') <span class="text-danger">{{ $message }}</span> @enderror
    </fieldset>
</div>
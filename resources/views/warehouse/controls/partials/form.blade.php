<div class="form-row mt-3">
    <fieldset class="form-group col-md-2">
        <label for="date">Fecha</label>
        <input type="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', optional($control)->date) }}" wire:model="date" required>
        @error('date')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </fieldset>

    @if($type == 'receiving')
        <fieldset class="form-group col-md-10">
            <label for="origin-id">Origen</label>
            <select class="form-control @error('origin_id') is-invalid @enderror" wire:model="origin_id" id="origin-id">
                <option value="">Selecciona un origen</option>
                @foreach($store->origins as $origin)
                    <option value="{{ $origin->id }}"  {{ old('mobile_id', optional($control)->origin_id) == $origin->id ? 'selected' : '' }}>{{ $origin->name }}</option>
                @endforeach
            </select>
            @error('origin_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </fieldset>
    @else
        <fieldset class="form-group col-md-10">
            <label for="destination-id">Destino</label>
            <select class="form-control @error('destination_id') is-invalid @enderror" wire:model="destination_id" id="destination-id">
                <option value="">Selecciona un destino</option>
                @foreach($store->destinations as $destination)
                    <option value="{{ $destination->id }}">{{ $destination->name }}</option>
                @endforeach
            </select>
            @error('destination_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </fieldset>
    @endif
</div>

<div class="form-row">
    <fieldset class="form-group col-md-12">
        <label for="note">Nota</label>
        <input type="text" id="note" class="form-control @error('note') is-invalid @enderror" value="{{ optional($control)->name }}" wire:model="note" required>
        @error('note')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </fieldset>
</div>

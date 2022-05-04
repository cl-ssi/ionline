<div class="form-row mt-3">
    <fieldset class="form-group col-md-3">
        <label for="name">Nombre</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" wire:model="name" placeholder="Ingresa el nombre" value="{{ old('name', optional($store)->name) }}" required>
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </fieldset>


    <fieldset class="form-group col-md-5">
        <label for="address">Dirección</label>
        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" wire:model="address" placeholder="Ingresa la dirección" value="{{ old('address', optional($store)->address) }}" required>
        @error('address')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-3">
        <label for="commune-id">Comuna</label>
        <select id="commune-id" class="form-control @error('commune_id') is-invalid @enderror" wire:model="commune_id" required>
            <option value="">Selecciona la comuna</option>
            @foreach($communes as $commune)
                <option value="{{ $commune->id }}" {{ optional($store)->commune_id == $commune->id ? 'selected' : '' }}>
                    {{ $commune->name }}
                </option>
            @endforeach
        </select>
        @error('commune_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </fieldset>
</div>

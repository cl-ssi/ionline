<div class="form-row mt-3">
    <fieldset class="form-group col-md-4">
        <label for="store-id">Bodega</label>
        <input type="text" id="store-id" class="form-control" value="{{ optional($store)->name }}" disabled>
    </fieldset>

    <fieldset class="form-group col-md-4">
        <label for="name">Nombre</label>
        <input type="text"
            class="form-control @error('name') is-invalid @enderror"
            id="name"
            wire:model="name"
            placeholder="Ingresa el nombre"
            value="{{ old('name', optional($product)->name) }}"
            required>
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-2">
        <label for="program-id">Programa</label>
        <select id="program-id" class="form-control @error('program_id') is-invalid @enderror" wire:model="program_id" required>
            <option value="">Selecciona el programa</option>
            @foreach($programs as $program)
                <option value="{{ $program->id }}" {{ optional($product)->program_id == $program->id ? 'selected' : '' }}>
                    {{ $program->name }}
                </option>
            @endforeach
        </select>
        @error('program_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </fieldset>

    <fieldset class="form-group col-md-2">
        <label for="category-id">Categoría</label>
        <select id="category-id" class="form-control @error('category_id') is-invalid @enderror" wire:model="category_id" required>
            <option value="">Selecciona la categoría</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ optional($product)->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </fieldset>
</div>

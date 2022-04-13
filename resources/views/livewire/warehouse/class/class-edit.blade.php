<div>
    <div class="form-row">
        <fieldset class="form-group col-md-2 col-4">
            <label for="codigo">Código</label>
            <input type="text" class="form-control" id="codigo" value="{{ $class->code }}" readonly>
        </fieldset>

        <fieldset class="form-group col-md-6 col-8">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" wire:model="name" id="name" placeholder="Aceites vegetales" required>
        </fieldset>
    </div>
    <button type="submit" class="btn btn-primary" wire:click="update">Actualizar</button>
</div>

<div>
    <div class="form-row">
        <fieldset class="form-group col-md-2">
            <label for="codigo">Código</label>
            <input type="text" class="form-control" id="codigo" value="{{ $segment->code }}" readonly>
        </fieldset>

        <fieldset class="form-group col-md-6">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" wire:model="name" id="name" placeholder="Aceites vegetales" required>
        </fieldset>

        <fieldset class="form-group col-md-4">
            <label for="name">Estatus</label>
            <div class="btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-{{ $segment->status_color }}">
                  <input type="checkbox" wire:click="changeExperiesAt()"> {{ $segment->status }}
                </label>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary" wire:click="update">Actualizar</button>
</div>

<div>

    <h3>Editar Segmento</h3>

    @include('unspsc.bread-crumbs', [
        'type' => 'segments.edit',
        'segment' => $segment
    ])

    <div class="form-row mt-3">
        <fieldset class="form-group col-md-2">
            <label for="codigo">Código</label>
            <input type="text" class="form-control" id="codigo" value="{{ $segment->code }}" readonly>
        </fieldset>

        <fieldset class="form-group col-md-6">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" wire:model.live.debounce.1500ms="name" id="name" placeholder="Aceites vegetales" required>
        </fieldset>

        <fieldset class="form-group col-md-4">
            <label for="name">Estatus</label>
            <div class="btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-{{ $segment->status_color }}">
                  <input type="checkbox" wire:click="changeExperiesAt()"> {{ $segment->status }}
                </label>
            </div>
        </fieldset>
    </div>

    <button class="btn btn-primary" wire:click="update">Actualizar</button>

</div>

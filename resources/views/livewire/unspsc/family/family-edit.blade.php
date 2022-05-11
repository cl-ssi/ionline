<div>
    @include('parameters.nav')

    <h5>Editar Familia</h5>

    @include('unspsc.bread-crumbs', [
        'type' => 'families.edit',
        'segment' => $segment,
        'family' => $family
    ])

    <div class="form-row mt-2">
        <fieldset class="form-group col-md-2 col-4">
            <label for="codigo">Código</label>
            <input type="text" class="form-control" id="codigo" value="{{ $family->code }}" readonly>
        </fieldset>

        <fieldset class="form-group col-md-6 col-8">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" wire:model="name" id="name" placeholder="Aceites vegetales" required>
        </fieldset>

        <fieldset class="form-group col-md-4">
            <label for="name">Estatus</label>
            <div class="btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-{{ $family->status_color }}">
                  <input type="checkbox" wire:click="changeExperiesAt()"> {{ $family->status }}
                </label>
            </div>
        </fieldset>
    </div>

    <button class="btn btn-primary" wire:click="update">Actualizar</button>

</div>

<div>

    <h3>Editar Producto</h3>

    @include('unspsc.bread-crumbs',[
        'type' => 'products.edit',
        'segment' => $segment,
        'family' => $family,
        'class' => $class
    ])

    <div class="form-row mt-2">
        <fieldset class="form-group col-md-2 col-4">
            <label for="codigo">Código</label>
            <input type="text" class="form-control" id="codigo" value="{{ $product->code }}" readonly>
        </fieldset>

        <fieldset class="form-group col-md-6 col-8">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" wire:model.live.debounce.1500ms="name" id="name" placeholder="Aceites vegetales" required>
        </fieldset>

        <fieldset class="form-group col-md-4">
            <label for="name">Estatus</label>
            <div class="btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-{{ $product->status_color }}">
                  <input type="checkbox" wire:click="changeExperiesAt()"> {{ $product->status }}
                </label>
            </div>
        </fieldset>
    </div>

    <button type="submit" class="btn btn-primary" wire:click="update">Actualizar</button>
</div>

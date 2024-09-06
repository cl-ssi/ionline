<div>
    @section('title', 'Lista de Clasificaciones de Inventario')

    @include('inventory.nav', [
        'establishment' => auth()->user()->organizationalUnit->establishment,
    ])

    @if ($form)
        <h3>{{ $classification->id ? 'Editar' : 'Crear' }} Clasificación</h3>

        @include('parameters.classifications.form')

        <div class="form-row">
            <div class="mt-3 col-12">
                <button type="button" class="btn btn-success" wire:click="save()">Guardar</button>
                <button type="button" class="btn btn-outline-secondary" wire:click="index()">Cancelar</button>
            </div>
        </div>
    @else
        <div class="form-row">
            <div class="col">
                <h3 class="mb-3">Listado de Clasificaciones para Inventario</h3>
            </div>
            <div class="col text-end">
                <button class="btn btn-success float-right" wire:click="formMethod()">
                    <i class="fas fa-plus"></i> Nueva Clasificación
                </button>
            </div>
        </div>

        @include('parameters.classifications.index')
    @endif
</div>

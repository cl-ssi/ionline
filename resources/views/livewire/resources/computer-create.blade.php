<div>
    @section('title', 'Crear Computador')

    <h4>
        Detalle Item Inventario
    </h4>

    @include('resources.computer.form', [
        'computer' => null
    ])

    <div class="form-row mb-3">
        <div class="col text-right">
            <button class="btn btn-primary" wire:click="create">
                <i class="fas fa-plus"></i> Crear
            </button>
        </div>
    </div>
</div>

<div>
    @if($computer->fusion_at)
        @section('title', 'Editar TIC')
    @else
        @section('title', 'Fusionar TIC')
    @endif

    <h4>
        Detalle Item Inventario
    </h4>

    @include('resources.computer.form', [
        'computer' => $computer
    ])

    <div class="form-row mb-3">
        <div class="col text-right">
            <button class="btn btn-primary" wire:click="update">
                @if($computer->fusion_at)
                    <i class="fas fa-edit"></i> Actualizar
                @else
                    <i class="fas fa-fire"></i> Fusionar
                @endif
            </button>
        </div>
    </div>
</div>

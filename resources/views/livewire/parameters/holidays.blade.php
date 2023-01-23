<div>

    @section('title', 'Lista de Feriados')

    @if ($form)
        <h3>{{ $holiday->id ? 'Editar' : 'Crear' }} Feriado</h3>
        
        @include('parameters.holidays.form')
        
        <div class="form-row">
            <div class="mt-3 col-12">
                <button type="button" class="btn btn-success" wire:click="save()">Guardar</button>
                <button type="button" class="btn btn-outline-secondary" wire:click="index()">Cancelar</button>
            </div>
        </div>
    @else
        <div class="form-row">
            <div class="col">
                <h3 class="mb-3">Listado de Feriados</h3>
            </div>
            <div class="col text-end">
                <button class="btn btn-success float-right" wire:click="form()">
                    <i class="fas fa-plus"></i> Nuevo Feriado
                </button>
            </div>
        </div>

        @include('parameters.holidays.index')

        {{ $holidays->links() }}
    @endif
    
</div>

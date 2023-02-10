<div>

    @section('title', 'Lista de reuniones')

    @if ($form)
        <h3>{{ $meeting->id ? 'Editar' : 'Crear' }} Acta de reunión</h3>
        
        @include('lobby.meeting.form')
        
        <div class="form-row">
            <div class="mt-3 col-12">
                <button type="button" class="btn btn-success" wire:click="save()">Guardar</button>
                <button type="button" class="btn btn-outline-secondary" wire:click="index()">Cancelar</button>
            </div>
        </div>
    @else
        <div class="form-row">
            <div class="col">
                <h3 class="mb-3">Listado de reuniones</h3>
            </div>
            <div class="col text-end">
                <button class="btn btn-success float-right" wire:click="form()">
                    <i class="fas fa-plus"></i> Nueva reunión
                </button>
            </div>
        </div>

        @include('lobby.meeting.index')

        {{ $meetings->links() }}
    @endif
    
</div>

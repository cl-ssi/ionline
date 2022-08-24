<div>
    @section('title', 'Mis subrogantes')

    @switch($view)

        @case('index')
            <h3 class="mb-3">
                <i class="fas fa-chess"></i> Subrogantes
                <button class="btn btn-success float-right"
                    wire:click="create"><i class="fas fa-plus"></i> Agregar nuevo</button>
            </h3>
            @include('profile.subrogation.index')
            @break

        @case('create')
            <h3>Crear nueva subrogancia</h3>
            @include('profile.subrogation.form')
            <button type="button" class="btn btn-primary"
                wire:click="store">Crear</button>
            <button type="button" class="btn btn-outline-secondary"
                wire:click="index">Cancelar</button>
            @break

        @case('edit')
            <h3>Editar subrogancia</h3>
            @include('profile.subrogation.form')
            <button type="button" class="btn btn-primary"
                wire:click="update({{$subrogation}})">Guardar</button>
            <button type="button" class="btn btn-outline-secondary"
                wire:click="index">Cancelar</button>
            @break

    @endswitch
</div>
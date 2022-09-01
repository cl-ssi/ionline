<div>

    @section('title', 'Lista de Feriados')

    @switch($view)

        @case('index')
            <h3 class="mb-3">
                <i class="fas fa-suitcase"></i> Listado de feriados
                <button class="btn btn-success float-right"
                    wire:click="create"><i class="fas fa-plus"></i> Crear nuevo</button>
            </h3>
            @include('parameters.holidays.index')
            @break

        @case('create')
            <h3>Crear nuevo feriado</h3>
            @include('parameters.holidays.form')
            <button type="button" class="btn btn-primary"
                wire:click="store">Crear</button>
            <button type="button" class="btn btn-outline-secondary"
                wire:click="index">Cancelar</button>
            @break

        @case('edit')
            <h3>Editar feriado</h3>
            @include('parameters.holidays.form')
            <button type="button" class="btn btn-primary"
                wire:click="update({{$holiday}})">Guardar</button>
            <button type="button" class="btn btn-outline-secondary"
                wire:click="index">Cancelar</button>
            @break

    @endswitch
</div>

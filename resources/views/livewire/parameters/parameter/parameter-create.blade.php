<div>
    @section('title', 'Crear Parámetro')

    @include('parameters.nav')

    <div class="row my-3">
        <div class="col">
            <h3>Parámetros</h3>
        </div>
    </div>

    @include('parameters.parameters.partials.form')

    <button class="btn btn-primary" wire:click="create">
        Crear
    </button>
    <a href="{{ route('parameters.index') }}" class="btn btn-outline-primary">
        Cancelar
    </a>
</div>

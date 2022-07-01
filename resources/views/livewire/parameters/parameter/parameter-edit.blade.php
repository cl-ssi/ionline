<div>
    @section('title', 'Editar Parámetro')

    @include('parameters.nav')

    <div class="row my-3">
        <div class="col">
            <h3>Editar Parámetro</h3>
        </div>
    </div>

    @include('parameters.parameters.partials.form', ['parameter' => $parameterEdit])

    <button class="btn btn-primary" wire:click="update">
        Actualizar
    </button>
    <a href="{{ route('parameters.index') }}" class="btn btn-outline-primary">
        Cancelar
    </a>
</div>

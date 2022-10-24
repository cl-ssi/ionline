<div>
    <h5>Crear Programa</h5>

    @include('parameters.programs.partials.form', [
        'program' => null,
    ])

    <button class="btn btn-primary" wire:click="createProgram">
        Crear
    </button>
    <a
        class="btn btn-outline-primary"
        href="{{ route('parameters.programs.index') }}"
    >
        Cancelar
    </a>
</div>

<div>
    <h5>Editar Programa</h5>

    @include('parameters.programs.partials.form', [
        'program' => $program,
    ])

    <button class="btn btn-primary" wire:click="updateProgram">
        Actualizar
    </button>
    <a
        class="btn btn-outline-primary"
        href="{{ route('parameters.programs.index') }}"
    >
        Cancelar
    </a>
</div>

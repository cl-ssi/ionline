<div>
    <h5>Editar Programa</h5>

    @include('cfg.programs.partials.form', [
        'program' => $program,
    ])

    <button class="btn btn-primary" wire:click="updateProgram">
        Actualizar
    </button>
    <a
        class="btn btn-outline-primary"
        href="{{ route('cfg.programs.index') }}">
        Cancelar
    </a>
</div>

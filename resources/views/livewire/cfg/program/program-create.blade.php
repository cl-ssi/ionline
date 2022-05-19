<div>
    <h5>Crear Programa</h5>

    @include('cfg.programs.partials.form', [
        'program' => null,
    ])

    <button class="btn btn-primary" wire:click="createProgram">
        Actualizar
    </button>
    <a
        class="btn btn-outline-primary"
        href="{{ route('cfg.programs.index') }}">
        Cancelar
    </a>
</div>

<div>
    <h3>
        Actualizar
    </h3>

    <br>

    @include('layouts.bt5.partials.flash_message')

    @livewire('file-mgr-list', [
        'model' => $receptionFinance,
        'emitToRefresh' => 'refreshFiles',
    ])

    <br>
    <br>

    <button
        class="btn btn-primary"
        wire:click="save()"
    >
        Guardar
    </button>
</div>

<div>
    <h3>
        Crear
    </h3>

    <br>

    @include('layouts.bt5.partials.flash_message')

    @livewire('file-mgr',
    [
        'multiple' => true,
        'valid_types' => ['pdf', 'jpg'],
        'max_file_size' => 2,
        'input_title' => 'Anexos',
        'storage_path' => 'test',
        'stored' => '',
    ])

    <br>
    <br>

    <button class="btn btn-primary" wire:click="save()">
        Guardar
    </button>
</div>

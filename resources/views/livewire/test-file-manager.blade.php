<div>
    @livewire('file-mgr',
    [
        'multiple' => true,
        'valid_types' => ['pdf', 'jpg'],
        'max_file_size' => 2,
        'input_title' => 'Anexos',
        'storage_path' => 'test',
        'stored' => '',
    ])


    <button class="btn btn-primary" wire:click="save()">Guardar</button>
</div>

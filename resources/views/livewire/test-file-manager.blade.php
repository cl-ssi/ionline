<div>
    @livewire('file-mgr',
    [ 
        'multiple' => true,
        'valid_types' => 'pdf', 
        'max_file_size' => 20,
    ])


    <button class="btn btn-primary" wire:click="save()">Guardar</button>
</div>

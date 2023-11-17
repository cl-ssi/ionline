<div>
    @foreach($myTextTemplates as $textTemplates)
        <a class="btn btn-info btn-sm float-start" 
            wire:click="emitControls({{ $textTemplates }})">
            <i class="fas fa-paste"></i> [ {{ $textTemplates->title }} ]
        </a>
    @endforeach
    
    <div class="col-md-12 col-12">
        <a class="btn btn-primary btn-sm float-end" 
            href="#" 
            role="button"
            data-bs-toggle="modal" 
            data-bs-target="#createTextTemplateModal-{{ $input }}">
            <i class="fas fa-plus-square"></i> Crear
        </a>

        {{ $module }}
        {{ $input }}

        @include('livewire.text-templates.modals.create', [
            'module'    => $module,
            'input'     => $input
            ]
        )
    </div>
</div>

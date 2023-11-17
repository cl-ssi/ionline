<div class="modal fade" id="createTextTemplateModal-{{ $input }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear Plantilla de Texto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @livewire('text-templates.create-text-template', [
                        'module'    => $module,
                        'input'     => $input
                    ]
                )
            </div>
        </div>
    </div>
</div>
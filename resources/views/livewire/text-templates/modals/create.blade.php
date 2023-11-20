<div class="modal fade" id="createTextTemplateModal-{{ $input }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Crear Plantilla de Texto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{--
                @livewire('text-templates.create-text-template', [
                        'module'    => $module,
                        'input'     => $input
                    ]
                )
                --}}
                
                <div class="row">
                    <div class="col">
                        <div class="row g-3 mb-3">
                            <fieldset class="form-group">
                                <label for="for_title">Título</label>
                                <input class="form-control" type="text" autocomplete="off" wire:model="title">
                            </fieldset>

                            <fieldset class="form-group">
                                <label for="for_template" class="form-label">Plantilla</label>
                                <textarea class="form-control" 
                                    id="for_template" 
                                    rows="3" 
                                    placeholder="Copia aquí tu plantilla"
                                    wire:model="template"></textarea>
                            </fieldset>    
                        </div>

                        <div class="col-md-12 col-12">
                            <a type="button" class="btn btn-primary float-end" wire:click="save()">
                                <i class="fas fa-save"></i> Guardar
                            </a>
                        </div>
                    </div>
                    <div class="col">
                        Mis Plantillas
                        
                        {{--
                        @foreach($myTextTemplates as $textTemplates)

                        @en
                        --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
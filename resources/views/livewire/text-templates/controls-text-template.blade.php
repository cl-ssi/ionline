<div>
    @foreach($myTextTemplates as $textTemplates)
        @if($textTemplates->module == $module && $textTemplates->input == $input)
            <a class="btn btn-info btn-sm float-start me-2" 
                wire:click="emitControls({{ $textTemplates }})">
                <i class="fas fa-paste"></i> [ {{ $textTemplates->title }} ]
            </a>
        @endif
    @endforeach
    
    <div class="col-md-12 col-12">
        <a class="btn btn-primary btn-sm float-end" 
            href="#" 
            role="button"
            data-bs-toggle="modal" 
            data-bs-target="#createTextTemplateModal-{{ $input }}">
            <i class="fas fa-plus-square"></i> Mis Plantillas
        </a>

        <div wire:ignore.self class="modal fade" id="createTextTemplateModal-{{ $input }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Crear Plantilla de Texto</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
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
                                <table class="table table-striped table-bordered table-sm small">
                                    <thead>
                                        <tr>
                                            <th colspan="3"><i class="fas fa-paste"></i> Mis Plantillas</th>
                                        </tr>
                                        <tr class="text-center">
                                            <th>Título</th>
                                            <th>Plantilla</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($myTextTemplates as $textTemplates)
                                        @if($textTemplates->module == $module && $textTemplates->input == $input)
                                        <tr>
                                            <td class="text-center">{{ $textTemplates->title }}</td>
                                            <td>{{ $textTemplates->template }}</td>
                                            <td class="text-center">
                                                <a class="btn btn-sm btn-outline-secondary" 
                                                    wire:click="set({{ $textTemplates }})">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

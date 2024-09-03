<div>
    <div class="col-md-12 col-12 mb-1">
        @foreach ($myTextTemplates as $textTemplates)
            <a class="btn btn-info btn-sm float-start me-2"
                wire:click="emitTemplates({{ $textTemplates }})">
                <i class="fas fa-paste"></i> {{ $textTemplates->title }}
            </a>
        @endforeach

        <a class="btn btn-primary btn-sm float-end"
            href="#"
            role="button"
            data-bs-toggle="modal"
            data-bs-target="#createTextTemplateModal-{{ str_replace('.', '_', $input) }}">
            <i class="bi bi-clipboard2-plus"></i> Mis Plantillas
        </a>
    </div>

    <div wire:ignore.self
        class="modal fade"
        id="createTextTemplateModal-{{ str_replace('.', '_', $input) }}"
        tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Plantilla de Texto</h5>
                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <table class="table table-striped table-bordered table-sm small">
                                <thead>
                                    <tr class="text-center">
                                        <th width="40"></th>
                                        <th><i class="fas fa-paste"></i> Mis Plantillas</th>
                                        <th width="40"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($myTextTemplates as $textTemplates)
                                        <tr>
                                            <td>
                                                <button class="btn btn-sm btn-outline-danger"
                                                    wire:click="delete({{ $textTemplates->id }})">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                            <td>{{ $textTemplates->title }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary"
                                                    wire:click="form({{ $textTemplates->id }})">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-8">
                            <div class="row g-3 mb-3">
                                <fieldset class="form-group col-4">
                                    <input class="form-control"
                                        type="text"
                                        autocomplete="off"
                                        placeholder="Titulo de tu plantilla"
                                        wire:model.live="textTemplateTitle"
                                        maxlength="25">
                                    @error('textTemplateTitle') <span class="text-danger">{{ $message }}</span> @enderror
                                </fieldset>

                                <fieldset class="form-group">
                                    <textarea class="form-control"
                                        id="for_template"
                                        rows="15"
                                        placeholder="Copia aquí contenido de tu plantilla"
                                        wire:model.live="textTemplateTemplate"></textarea>
                                    @error('textTemplateTemplate') <span class="text-danger">{{ $message }}</span> @enderror
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cerrar</button>
                    <button type="button"
                        class="btn btn-success"
                        wire:click="form()">
                        <i class="fas fa-plus"></i> Nuevo
                    </button>
                    <button type="button"
                        class="btn btn-primary"
                        wire:click="save()">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

<div>
    <style>
        .etiqueta {
            display: inline-block;
            /* Permite establecer un ancho fijo */
            width: 220px;
            /* Ancho fijo deseado */
            font-weight: bold;
        }

        .valor {
            /* Estilos para el contenido */
            display: inline-block;
            /* Permite establecer un ancho fijo */
        }
    </style>

    @include('documents.partials.nav')
    <h3 class="mb-3">Administrador de documentos</h3>

    @include('layouts.bt5.partials.errors')
    @include('layouts.bt5.partials.flash_message')

    <div class="row">

        <div class="col-md-3">

            <label for="search">Buscar</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" wire:model="document_id" placeholder="id de documento"
                    aria-label="id de documento">
                <button class="btn btn-outline-secondary" type="button" id="button-search" wire:click="search">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>

        @if ($document)
            <div class="col-md-3">
                <label for="number">Número</label> <br>
                @if ($document->number)
                    <button class="btn btn-outline-danger" wire:click="deleteNumber">
                        <i class="bi bi-trash"></i> {{ $document->number }}
                    </button>
                @endif

            </div>

            <div class="col-md-3">
                <div class="mb-3">
                    <label for="formFile" class="form-label">Archivo cargado</label> <br>
                    @if ($document->file)
                        @if ((int) $document->updated_at->diffInDays(now()) <= 14)
                            <button class="btn btn-outline-danger" wire:click="deleteUploadedFile">
                                <i class="bi bi-trash"></i>
                            </button>
                        @else
                            <span class="badge bg-warning text-dark">No se puede eliminar es mayor a 14 días</span>
                        @endif
                    @endif
                </div>
            </div>

            <div class="col-md-3">
                <div class="mb-3">
                    <label for="formFile" class="form-label">Eliminar Documento</label> <br>
                    @if (!$document->file)
                        @if ((int) $document->updated_at->diffInDays(now()) <= 14)
                            <button class="btn btn-danger" wire:click="deleteDocument">
                                <i class="bi bi-trash"></i>
                            </button>
                        @else
                            <span class="badge bg-warning text-dark">No se puede eliminar es mayor a 14 días</span>
                        @endif
                    @endif
                </div>
            </div>
        @endif

    </div>

    @if ($document)
        <span class="etiqueta">Creador:</span>
        <span class="valor">{{ $document->user?->shortName }}</span><br>
        <span class="etiqueta">Tipo:</span>
        <span class="valor">{{ $document->type?->name }}</span><br>
        <span class="etiqueta">Unidad Organizacional:</span>
        <span class="valor">{{ $document->organizationalUnit?->name }}</span><br>

        @if ($document->file)
            <a href="{{ route('documents.download', $document) }}" class="btn btn-outline-danger mt-3" target="_blank">
                <i class="bi bi-file-pdf"></i> Archivo cargado
            </a>
        @else
            <embed class="mt-3" src="{{ route('documents.show', $document->id) }}" width="100%" height="800">
        @endif
    @endif
</div>

<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $type_id ? 'Editar Tipo' : 'Crear Tipo' }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit="store">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="col-form-label">Nombre:</label>
                        <input type="text" class="form-control" id="name" wire:model.live="name">
                        @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">{{ $type_id ? 'Actualizar' : 'Guardar' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

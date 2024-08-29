<div class="{{ $external == 'no' ? 'text-start' : 'text-left' }}">
    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-12">
            <label for="forRejoinderFile" class="form-label">Certificado</label>
            <input class="form-control" type="file" wire:model="certificateFile" id="upload({{ $iterationFileClean }})">
            <div wire:loading wire:target="certificateFile">Cargando archivo...</div>
            @error('certificateFile') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>

    <div class="row g-3 mb-3">
        <fieldset class="form-group col-12 col-md-12">
            <div class="alert alert-info" role="alert">
                <b>Estimado usuario</b>: Si va a adjuntar documentos anexos, por favor consolídelos en un solo archivo PDF.
            </div>
            <label for="forRejoinderFile" class="form-label">Anexo</label>
            <input class="form-control" type="file" wire:model="attachedFile" id="upload({{ $iterationFileClean }})">
            <div wire:loading wire:target="attachedFile">Cargando archivo...</div>
            @error('attachedFile') <span class="text-danger error small">{{ $message }}</span> @enderror
        </fieldset>
    </div>

    <div class="row g-3 mb-3">
        <div class="col">
            <button wire:click="save" 
                wire:loading.attr="disabled" 
                wire:target="certificateFile, attachedFile" 
                class="btn btn-primary {{ ($external == 'no') ? 'float-end' : 'float-right' }}" 
                type="button"
                id="save-btn-{{ $training->id }}">
                <i class="fas fa-save"></i> Guardar
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', function () {
            // Capturar el evento emitido desde Livewire
            Livewire.on('closeModal', (bootstrapVersion, trainingId) => {
                if (bootstrapVersion === 'bootstrap5') {
                    var exampleModal = document.getElementById('exampleModal-' + trainingId);

                    if (exampleModal) {
                        var modalInstance = bootstrap.Modal.getInstance(exampleModal);
                        if (!modalInstance) {
                            modalInstance = new bootstrap.Modal(exampleModal);
                        }
                        modalInstance.hide();
                    }
                } else if (bootstrapVersion === 'bootstrap4') {
                    $('#exampleModal-' + trainingId).modal('hide');
                }
            });

            // Manejador para el evento de click del botón guardar
            document.querySelectorAll('[id^="save-btn"]').forEach(function(button) {
                button.addEventListener('click', function(event) {
                    // Desactiva el botón y muestra el spinner
                    this.disabled = true;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Guardando...';

                    // Ejecutar la función de guardado de Livewire
                    Livewire.emit('save');
                });
            });

            // Escuchar el evento de redirección desde Livewire
            Livewire.on('redirectTo', (url) => {
                window.location.href = url;
            });
        });
    </script>
</div>

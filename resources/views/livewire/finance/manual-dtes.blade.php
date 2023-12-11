<div>
    @if ($showSuccessMessage)
        <div class="alert alert-success mt-3">
            ¡El DTE manual se ha agregado exitosamente!
            <button type="button" class="close" wire:click="hideForm">&times;</button>
        </div>
    @endif

    <h3 class="mb-3">Agregar una DTE manualmente</h3>

    <form wire:submit.prevent="saveDte">
        <div class="row g-2">
            <div class="form-group col-2">
                <label for="tipoDocumento">Tipo de documento*</label>
                <select class="form-control" id="tipoDocumento" wire:model.defer="tipoDocumento" required>
                    <option value="">Seleccionar Tipo Documento</option>
                    @foreach ($this->getDistinctTipoDocumento() as $tipo)
                        <option value="{{ $tipo }}">{{ $tipo }}</option>
                    @endforeach
                    <option value="boleta_electronica">boleta_electronica</option>
                </select>
                @error('tipoDocumento')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-2">
                <label for="emisor">RUT</label>
                <input type="text" class="form-control" id="emisor" wire:model.defer="emisor"
                    placeholder="ej: 76.278.474-2" autocomplete="off">
                @error('emisor')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group col-4">
                <label for="razonSocial">Razón Social</label>
                <input type="text" class="form-control" id="razonSocial" wire:model.defer="razonSocial"
                    autocomplete="off">
                @error('razonSocial')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-4">
                <label for="cargarPdf" class="form-label">Cargar PDF Boleta</label>
                <input type="file" class="form-control" id="cargarPdf"
                    aria-describedby="Cargar PDF" wire:model.defer="archivoManual"
                    placeholder="Seleccionar Archivo" accept="application/pdf">
            </div>
        </div>

        <div class="row g-2 mb-3">
            <div class="form-group col-2">
                <label for="folio">Número</label>
                <input type="number" class="form-control" id="folio" wire:model.defer="folio" autocomplete="off"
                    min="1">
                @error('folio')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group col-2">
                <label for="montoTotal">Monto Total</label>
                <input type="number" class="form-control" id="montoTotal" wire:model.defer="montoTotal"
                    autocomplete="off" min="1000">
                @error('montoTotal')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group col-4">
                <label for="folioOC">Orden de Compra</label>
                <input type="text" class="form-control" id="folioOC" wire:model.defer="folioOC" autocomplete="off">
                @error('folioOC')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-4">
                <label for="barCode">7 Últimos dígitos código de barra <small>(Solo para BHE)</small></label>
                <div class="input-group">
                    <input type="text" class="form-control" id="barCode" wire:model.defer="barCode"
                        placeholder="ej: 6A86963" maxlength="7" autocomplete="off">
                    <a class="btn btn-outline-secondary" href="#" wire:click.prevent="verBoleta"
                        target="_blank">
                        <i class="fas fa-file-pdf" aria-hidden="true"></i> Ver boleta
                    </a>
                </div>
                @error('barCode')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="row g-2">
            <div class="col-12 text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Agregar</button>
            </div>
        </div>
    </form>
    <hr>

    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('mostrarUrlBoleta', function(boletaUrl) {
                // Mostrar la URL de la boleta en un cuadro de diálogo
                alert('URL de la boleta: ' + boletaUrl);
            });
        });
    </script>

    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('fileSelected', function () {
                var input = document.getElementById('inputGroupFile01');
                var label = input.nextElementSibling;
                var labelText = input.value.split('\\').pop();
                label.textContent = labelText || 'Seleccionar PDF';
            });
        });
    </script>


</div>

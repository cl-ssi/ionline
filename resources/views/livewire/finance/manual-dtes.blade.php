<div>
    @include('finance.payments.partials.nav')

    @if ($showSuccessMessage)
        <div class="alert alert-success mt-3">
            ¡El DTE manual se ha agregado exitosamente!
            <button type="button" class="close" wire:click="hideForm">&times;</button>
        </div>
    @endif

    <h3 class="mb-3">Agregar una DTE manualmente</h3>

    <div class="text-muted small">
        Solamente cargar Facturas u documentos que por algún otro motivo el proveedor de estos no sea la empresa acepta.com ejemplo: Boleta de Agua, etc
    </div>
    <br>

    <form wire:submit="saveDte">
        <div class="row g-2">
            <div class="form-group col-2">
                <label for="tipoDocumento">Tipo de documento*</label>
                <select class="form-select" id="tipoDocumento" wire:model="tipoDocumento" required>
                    <option value="">Seleccionar Tipo Documento</option>
                    @foreach ($this->getDistinctTipoDocumento() as $tipo)
                        <option value="{{ $tipo }}">{{ $tipo }}</option>
                    @endforeach
                </select>
                @error('tipoDocumento')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-2">
                <label for="emisor">RUT*</label>
                <input type="text" class="form-control" id="emisor" wire:model="emisor"
                    placeholder="ej: 76.278.474-2" autocomplete="off">
                @error('emisor')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group col-3">
                <label for="razonSocial">Razón Social*</label>
                <input type="text" class="form-control" id="razonSocial" wire:model="razonSocial"
                    autocomplete="off">
                @error('razonSocial')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-4">
                <label for="cargarPdf" class="form-label">Cargar PDF Boleta</label>
                <input type="file" class="form-control" id="cargarPdf"
                    aria-describedby="Cargar PDF" wire:model="archivoManual"
                    placeholder="Seleccionar Archivo" accept="application/pdf">
            </div>
        </div>

        <div class="row g-2 mb-3">
            <div class="form-group col-1">
                <label for="folio">folio*</label>
                <input type="number" class="form-control" id="folio" wire:model="folio" autocomplete="off"
                    min="1">
                @error('folio')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group col-2">
                <label for="montoTotal">Monto Total*</label>
                <input type="number" class="form-control" id="montoTotal" wire:model="montoTotal"
                    autocomplete="off" min="1000">
                @error('montoTotal')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-2">
                <label for="emision">Fecha*</label>
                <input type="date" class="form-control" id="emision" wire:model="emision" autocomplete="off">
                @error('emision')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-2">
                <label for="folioOC">Orden de Compra</label>
                <input type="text" class="form-control" id="folioOC" wire:model="folioOC" autocomplete="off">
                @error('folioOC')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-3">
                <label for="barCode">7 Últimos n° código barra <small>(Solo BHE)</small></label>
                <div class="input-group">
                    <input type="text" class="form-control" id="barCode" wire:model="barCode"
                        placeholder="ej: 6A86963" maxlength="7" autocomplete="off">
                    <a class="btn btn-outline-secondary" href="#" wire:click.prevent="verBoleta" target="_blank"
                        target="_blank">
                        <i class="fas fa-file-pdf" aria-hidden="true"></i> Ver boleta
                    </a>
                </div>
                @error('barCode')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group col-2 d-flex align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="pagoManual" wire:model="pagoManual">
                    <label class="form-check-label" for="pagoManual">
                        Pago Manual
                    </label>
                </div>
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
        document.addEventListener('livewire:init', function() {
            Livewire.on('mostrarUrlBoleta', function(boletaUrl) {
                // Mostrar la URL de la boleta en un cuadro de diálogo
                alert('URL de la boleta: ' + boletaUrl);
            });
        });
    </script>

    <script>
        document.addEventListener('livewire:init', function () {
            Livewire.on('fileSelected', function () {
                var input = document.getElementById('inputGroupFile01');
                var label = input.nextElementSibling;
                var labelText = input.value.split('\\').pop();
                label.textContent = labelText || 'Seleccionar PDF';
            });
        });
    </script>

    @section('custom_js')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="{{ asset('js/jquery.rut.chileno.js') }}"></script>
        <script type="text/javascript">
        $(document).ready(function() {
            $('#emisor').rut();
        });
        </script>
    @endsection


</div>

<div>
    <h3 class="mb-3">Subir una boleta de honorario electrónica</h3>

    <!-- Formulario para subir una boleta -->
    <form wire:submit.prevent="process">
        <div class="mb-3">
            <label for="formFile" class="form-label">Boleta de honorario electrónica</label>
            <input class="form-control" type="file" id="formFile" wire:model="bhe">
            @error('bhe') <span class="error">{{ $message }}</span> @enderror
        </div>
        <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">Procesar</button>
    </from>

    @if($bhe_to_text)
        <div class="row g-2">
            <div class="form-group col-2">
                <label for="tipo_documento">Tipo de documento</label>
                <input type="text" class="form-control" id="emisor" wire:model.defer="dte.tipo_documento" disabled>
            </div>

            <div class="form-group col-2">
                <label for="folio">Número (folio)</label>
                <input type="number" class="form-control" id="folio" wire:model.defer="dte.folio" min="1" 
                    autocomplete="off">
            </div>

            <div class="form-group col-2">
                <label for="emisor">RUT Emisor</label>
                <input type="text" class="form-control" id="emisor" wire:model.defer="dte.emisor"
                    autocomplete="off">
            </div>

            <div class="form-group col-4">
                <label for="razonSocial">Razón Social</label>
                <input type="text" class="form-control" id="razon_social_emisor" wire:model.defer="dte.razon_social_emisor"
                    autocomplete="off">
            </div>

            <div class="form-group col-2">
                <label for="emision">Fecha</label>
                <input type="date" class="form-control" id="emision" wire:model.defer="dte.emision" autocomplete="off">
            </div>
        </div>

        <div class="row g-2 mb-3">

            <div class="form-group col-2">
                <label for="monto_total">Monto Total</label>
                <input type="text" class="form-control" id="montoTotal" wire:model.defer="dte.monto_total"
                    autocomplete="off" min="1">
            </div>

            <div class="form-group col-2">
                <label for="receptor">Receptor</label>
                <input type="text" class="form-control" id="folioOC" wire:model.defer="dte.receptor" autocomplete="off">
            </div>

            <div class="form-group col-4">
                <label for="bar_code">Codigo de barras</label>
                <input type="text" class="form-control" id="bar_code" wire:model.defer="dte.bar_code" autocomplete="off">
            </div>

            <div class="form-group col-2">
                <label for="folio_oc">Orden de Compra</label>
                <input type="text" class="form-control" id="folioOC" wire:model.defer="dte.folio_oc" autocomplete="off">
            </div>

            <div class="form-group col-1">
                <label for="folio_oc">Documento</label>
                <a class="btn btn-outline-danger form-control" target="_blank" href="{{ $dte->uri }}">
                        <i class="bi bi-file-pdf"></i>
                </a>
            </div>

        </div>

        <button class="btn btn-primary" wire:click="save">Guardar</button>

        <pre>
{{ $bhe_to_text }}
        </pre>

    @endif
</div>

<div>
    <h3 class="mb-3">Subir una boleta de honorario electrónica</h3>

    <!-- Formulario para subir una boleta -->
    <div class="mb-3 col-md-6">
        <label for="formFile" class="form-label">Boleta de honorario electrónica</label>
        <div class="input-group">
            <input class="form-control" type="file" id="formFile" wire:model="bhe">
            <span class="input-group-text" id="bhe-file-loading">
                <i class="bi bi-upload" wire:loading.remove></i>
                <div wire:loading class="spinner-border spinner-border-sm"></div>
            </span>
        </div>
        @error('bhe') <span class="error">{{ $message }}</span> @enderror
    </div>

    @if($message)
        <div class="alert alert-success" role="alert">
            {{ $message }}
        </div>
    @endif

    @if($dte)
        <div class="row g-2 mb-3">
            <div class="form-group col-2">
                <label for="tipo_documento">Tipo de documento</label>
                <input type="text" class="form-control" id="emisor" wire:model.defer="dte.tipo_documento" disabled>
            </div>

            <div class="form-group col-2">
                <label for="folio">Número (folio)</label>
                <div class="input-group">
                    <input type="number" class="form-control" id="folio" wire:model.defer="dte.folio" min="1" 
                        autocomplete="off">
                    @error('dte.folio') <span class="text-danger">{{ $message }}</span> @enderror
                    @if(isset($dte->id))
                        <span class="input-group-text text-success" id="exist" title="Existe el registro en la BD">
                            <i class="bi bi-database-check"></i>
                        </span>
                    @else
                        <span class="input-group-text text-secondary" id="exist" title="No existe el registro en la BD">
                            <i class="bi bi-database-exclamation"></i>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group col-2">
                <label for="emisor">RUT Emisor</label>
                <input type="text" class="form-control" id="emisor" wire:model.defer="dte.emisor"
                    autocomplete="off">
                @error('dte.emisor') <span class="text-danger">{{ $message }}</span> @enderror
                <div id="emisor-helper" class="form-text">
                    @if($dte->isDirty('emisor'))
                        {{ $dte->getOriginal('emisor') }}
                    @endif
                </div>
            </div>

            <div class="form-group col-4">
                <label for="razonSocial">Razón Social</label>
                <input type="text" class="form-control" id="razon_social_emisor" wire:model.defer="dte.razon_social_emisor"
                    autocomplete="off">
                <div id="razon_social_emisor-helper" class="form-text">
                    @if($dte->isDirty('razon_social_emisor'))
                        {{ $dte->getOriginal('razon_social_emisor') }}
                    @endif
                </div>
            </div>

            <div class="form-group col-2">
                <label for="emision">Fecha</label>
                <input type="date" class="form-control" id="emision" wire:model.defer="dte.emision" autocomplete="off">
                <div id="emision-helper" class="form-text">
                    @if($dte->isDirty('emision'))
                        {{ $dte->getOriginal('emision') }}
                    @endif
                </div>
            </div>
        </div>

        <div class="row g-2 mb-3">
            <div class="form-group col-2">
                <label for="monto_total">Monto Total*</label>
                <input type="text" class="form-control" id="montoTotal" wire:model.defer="dte.monto_total"
                    autocomplete="off" min="1">
                @error('dte.monto_total') <span class="text-danger">{{ $message }}</span> @enderror
                <div id="monto_total-helper" class="form-text">
                    @if($dte->isDirty('monto_total'))
                        {{ $dte->getOriginal('monto_total') }}
                    @endif
                </div>
            </div>

            <div class="form-group col-2">
                <label for="receptor">Receptor</label>
                <input type="text" class="form-control" id="folioOC" wire:model.defer="dte.receptor" autocomplete="off">
                @error('dte.receptor') <span class="text-danger">{{ $message }}</span> @enderror
                <div id="receptor-helper" class="form-text">
                    @if($dte->isDirty('receptor'))
                        {{ $dte->getOriginal('receptor') }}
                    @endif
                </div>
            </div>

            <div class="form-group col-2">
                <label for="folio_oc">Orden de Compra*</label>
                <input type="text" class="form-control" id="folioOC" wire:model.defer="dte.folio_oc" autocomplete="off">
                @error('dte.folio_oc') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group col-1">
                <label for="folio_oc">Documento</label>
                <a class="btn btn-outline-danger form-control" target="_blank" href="{{ $dte->uri }}">
                        <i class="bi bi-file-pdf"></i>
                </a>
            </div>

            <div class="form-group offset-3 col-2">
                <label for="btn-save">&nbsp;</label>
                <button class="btn btn-primary form-control" wire:click="save">Guardar</button>
            </div>

        </div>
    @endif

    @if($bhe_to_text)
        <pre>{{ $bhe_to_text }}</pre>
    @endif
</div>

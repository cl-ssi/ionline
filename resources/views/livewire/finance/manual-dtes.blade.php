@if ($showSuccessMessage)
    <div class="alert alert-success mt-3">
        ¡El DTE manual se ha agregado exitosamente!
        <button type="button" class="close" wire:click="hideForm">&times;</button>
    </div>
@endif
<div>


    <h3 class="mb-3">Cargar DTE Manualmente</h3>
    <form wire:submit.prevent="saveDte">
        <div class="form-group">
            <label for="tipoDocumento">Tipo de documento</label>
            <input type="text" class="form-control" id="tipoDocumento" wire:model.defer="tipoDocumento"
                value="boleta_honorarios" disabled>
            @error('tipoDocumento')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="folio">Folio</label>
            <input type="number" class="form-control" id="folio" wire:model.defer="folio" autocomplete="off" min="1">
            @error('folio')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="emisor">Emisor</label>
            <input type="text" class="form-control" id="emisor" wire:model.defer="emisor"
                placeholder="ej: 76.278.474-2" autocomplete="off">
            @error('emisor')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="razonSocial">Razón Social</label>
            <input type="text" class="form-control" id="razonSocial" wire:model.defer="razonSocial"
                autocomplete="off">
            @error('razonSocial')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="montoTotal">Monto Total</label>
            <input type="number" class="form-control" id="montoTotal" wire:model.defer="montoTotal" autocomplete="off" min="1000">
            @error('montoTotal')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="folioOC">Folio OC</label>
            <input type="text" class="form-control" id="folioOC" wire:model.defer="folioOC" autocomplete="off">
            @error('folioOC')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="barCode">7 Últimos dígitos código de barra</label>
            <input type="text" class="form-control" id="barCode" wire:model.defer="barCode" placeholder="6A86963"
                required maxlength="7" autocomplete="off">
            @error('barCode')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
    <hr>
</div>

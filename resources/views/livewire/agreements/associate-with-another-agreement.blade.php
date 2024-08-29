<div class="row">
    <div class="mt-4 col-md-4">
        <label for="associate">Asociar a un convenio anterior (para prorrogas)</label>
        <div class="input-group">
            <input type="text" class="form-control" id="associateAgreement" wire:model.live="associateAgreement"
            placeholder="Ingrese el id del convenio anterior">
            <button class="btn btn-primary" wire:click="associate">Asociar</button>
        </div>
    </div>
</div>

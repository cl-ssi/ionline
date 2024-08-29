<div>
    <fieldset class="form-group col mt">
        <div class="mb-3">
            <label for="forFile" class="form-label"><br></label>
            <input class="form-control" type="file" wire:model="file" required>
            <!-- <div wire:loading wire:target="fileRequests">Cargando archivo(s)...</div> -->
        </div>
    </fieldset>

    <button wire:click="import"  class="btn btn-primary float-right" type="button" wire:loading.attr="disabled">
        <i class="fas fa-save"></i> Guardar
    </button>
</div>

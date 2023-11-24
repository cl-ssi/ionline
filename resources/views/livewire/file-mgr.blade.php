<div>
    <div class="mb-3">
    <label for="formFile" class="form-label">Default file input example</label>
    <input class="form-control" type="file" id="formFile" wire:model="file">
    </div>

    <button class="btn btn-primary" wire:click="emitFile()">Subir</button>
    <br><br>
</div>

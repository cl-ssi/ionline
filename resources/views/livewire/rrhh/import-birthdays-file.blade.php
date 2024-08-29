<div>

    <h3 class="mb-3">Importar información de cumpleaños</h3>

    <div class="form-row">
        <fieldset class="form-group col-6">
            <label>Archivo</label>
            <input type="file" class="form-control" wire:model.live="file">
        </fieldset>
    </div>

    @error('file') <span class="error">{{ $message }}</span> @enderror
    <div wire:loading wire:target="file"><strong>Cargando</strong></div>
    <button type="button" class="btn btn-primary mt-1 mb-4" wire:click="save()">Guardar</button>

    <br>
    @if($message2 != "")
        <div class="alert alert-success" role="alert">
            {{ $message2 }}
        </div>
    @endif
    
</div>

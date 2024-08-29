<div>
    @include('welfare.nav')

    <h3 class="mb-3">Importar usuarios de bienestar</h3>

    <div class="form-row">
        <fieldset class="form-group col-6">
            <label>Archivo Excel</label>
            <input type="file" class="form-control" wire:model.live="file">
        </fieldset>
    </div>
    @error('file') <span class="error">{{ $message }}</span> @enderror
    <div wire:loading wire:target="file"><strong>Cargando</strong></div>

    <div wire:loading.remove>
        <button type="button" class="btn btn-primary mt-1 mb-4" wire:click="import()">Guardar</button>
    </div>

    <div wire:loading.delay class="z-50 static flex fixed left-0 top-0 bottom-0 w-full bg-gray-400 bg-opacity-50">
        <img src="https://paladins-draft.com/img/circle_loading.gif" width="64" height="64" class="m-auto mt-1/4">
    </div>
    
</div>

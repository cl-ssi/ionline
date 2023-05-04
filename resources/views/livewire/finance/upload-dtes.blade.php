<form wire:submit.prevent="upload">
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <label for="users">Cargar archivo de Acepta con reporte de DTEs</label>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">Cargar Archivo</button>
        </div>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="dte_file" wire:model="dtes">
            <label class="custom-file-label" for="dte_file" data-browse="Examinar">Archivo xls máximo 20 mb</label>
        </div>
    </div>

    @error('dtes') <span class="error">{{ $message }}</span> @enderror

</form>
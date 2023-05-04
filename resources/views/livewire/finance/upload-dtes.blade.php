<form wire:submit.prevent="upload">
    <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
    <label for="users">Cargar archivo de Acepta con reporte de DTEs</label>
    <input type="file" class="form-control" style="padding: 3px;" wire:model="dtes">
 
    @error('dtes') <span class="error">{{ $message }}</span> @enderror
 
    <button class="btn btn-primary" type="submit" wire:loading.attr="disabled">Cargar Archivo</button>
</form>
<div class="form-group">
    <label for="for-files">Adjuntar archivos opcional (ej: norma)</label>
    <div class="custom-file">
    <form wire:submit.prevent="save">
        <input type="file" wire:model="file">
        @error('file') <span class="error">{{ $message }}</span> @enderror
        <button type="submit">Subir archivo</button>
    </form>
    </div>
</div>

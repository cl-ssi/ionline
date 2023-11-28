<div>
    <div class="mb-3">
        <label
            for="formFile"
            class="form-label"
        >
            {{ $input_title }}
        </label>
        <input
            class="form-control @error('file') is-invalid @enderror"
            type="file"
            id="formFile"
            accept="{{ $accept }}"
            wire:model="file"
            wire:loading.attr="disabled"
            wire:target="file"
        >
        <small
            id="formFile"
            class="form-text text-muted"
        >
            Solo se admite archivos: {{ $accept }} de hasta {{ $max_file_size }}MB.
        </small>
        @error('file')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <button
        class="btn btn-primary"
        wire:click="emitFile()"
        wire:loading.attr="disabled"
        wire:target="file"
    >
        Subir
    </button>

    <br><br>

</div>

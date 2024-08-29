<div>
    <label
        for="formFile"
        class="fw-bold"
    >
        {{ $input_title }}
    </label>
    <div class="input-group mb-3">
        <input
            class="form-control @error('file') is-invalid @enderror"
            type="file"
            id="formFile-{{ $countFile }}"
            accept="{{ $accept }}"
            wire:model.live="file"
            wire:loading.attr="disabled"
            wire:target="file, saveFile"


            @if(! $multiple && $countFile > 0)
                disabled
            @endif
        >
        <button
            class="btn btn-primary"
            type="button"
            wire:click="saveFile"
            wire:loading.attr="disabled"
            wire:target="file, saveFile"
            title="Subir"

            @if(! $multiple && $countFile > 0)
                disabled
            @endif
        >
            <span
                wire:loading.remove
                wire:target="file, saveFile"
            >
                <i class="fas fa-plus"></i>
            </span>

            <span
                class="spinner-border spinner-border-sm"
                role="status"
                wire:loading
                wire:target="file, saveFile"
                aria-hidden="true"
            >
            </span>
        </button>

        @error('file')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <small
        id="formFile"
        class="form-text text-muted"
    >
            Solo se admite archivos: {{ $accept }} de hasta {{ $max_file_size }}MB.
    </small>

    <hr>
    Archivos cargados
    <br>
    <br>

    @forelse($files as $index => $itemFileTemporary)
        <label
            for="file-{{ $index }}"
            class="fw-bold"
        >
            Archivo #{{ $index + 1 }}
        </label>
        <div class="input-group mb-3">
            <input
                type="text"
                class="form-control"
                id="file-{{ $index }}"
                value="{{ $itemFileTemporary['temporaryFilename'] }}"
                disabled
                readonly
            >
            <button
                class="btn btn-danger"
                type="button"
                wire:click="deleteFile({{ $index }})"
                wire:loading.attr="disabled"
                wire:target="deleteFile"
            >
                <span
                    wire:loading.remove
                    wire:target="deleteFile"
                >
                    <i class="fas fa-trash"></i>
                </span>

                <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                    wire:loading
                    wire:target="deleteFile"
                    aria-hidden="true"
                >
                </span>

            </button>
        </div>
    @empty
        <ul class="list-group">
            <li class="list-group-item">No hay archivos cargados</li>
        </ul>
    @endforelse

</div>

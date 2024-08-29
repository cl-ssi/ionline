<div>
    <hr>
    @foreach($fileLists as $itemFile)
        <label
            class="form-label fw-bold"
        >
            {{ $itemFile->input_title }}
        </label>
        <div class="input-group mb-3">
            @if($itemFile->stored)
                <input
                    type="text"
                    class="form-control"
                    value="{{ $itemFile->name }}"
                    readonly
                    disabled
                >
            @else
                <input
                    type="file"
                    class="form-control"
                    wire:model.live="file"
                >
            @endif

            @if($itemFile->stored)
                <button
                    class="btn btn-danger"
                    type="button"
                    wire:click="deleteFile({{ $itemFile }})"
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
            @else
                <button
                    class="btn btn-primary"
                    type="button"
                    wire:click="updateFile({{ $itemFile }})"
                    @if(!isset($file)) disabled @endif
                >
                    <span
                        wire:loading.remove
                        wire:target="file, updateFile"
                    >
                        <i class="fas fa-plus"></i>
                    </span>

                    <span
                        class="spinner-border spinner-border-sm"
                        role="status"
                        wire:loading
                        wire:target="file, updateFile"
                        aria-hidden="true"
                    >
                    </span>
                </button>
            @endif
        </div>
    @endforeach
</div>

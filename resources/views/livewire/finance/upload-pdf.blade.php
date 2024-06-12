<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if ($pdfPath)
        <div class="card" style="width: 18rem;">
            <div class="card-body text-center">
                <a href="{{ $pdfPath }}" target="_blank" class="btn btn-primary btn-sm">
                    <i class="fas fa-file-pdf"></i> Ver PDF
                </a>
                @if($pdfBackup->approval->status == 0)
                    <button wire:click="delete" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash-alt"></i> Borrar PDF
                    </button>
                @endif
            </div>
        </div>
    @else
        <form wire:submit.prevent="save">
            <input type="file" wire:model="pdf" accept="application/pdf">
            @error('pdf') <span class="error">{{ $message }}</span> @enderror

            <button type="submit" class="btn btn-primary btn-sm mt-2">Subir PDF</button>
        </form>
    @endif
</div>

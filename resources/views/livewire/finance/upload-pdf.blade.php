<div>
    @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif
    @if($small == false)
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
                <input type="file" wire:model="pdf" accept="application/pdf" wire:loading.attr="disabled">
                @error('pdf') <span class="error">{{ $message }}</span> @enderror

                <button type="submit" class="btn btn-primary btn-sm mt-2" wire:loading.attr="disabled">Subir PDF</button>
                
                <div wire:loading wire:target="pdf"><i class="fas fa-spinner fa-spin"></i> <b>Cargando...</b></div>
            </form>
        @endif
    @else
        @if ($pdfPaths)
            <div class="card" style="width: 18rem;">
                <div class="card-body text-center">
                    <a href="{{ $pdfPath }}" target="_blank" class="btn btn-primary btn-sm">
                        <i class="fas fa-file-pdf"></i> Ver PDF
                    </a>
                    <button wire:click="delete" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash-alt"></i> Borrar PDF
                    </button>
                </div>
            </div>
        @endif
        <form wire:submit.prevent="savePdfNoApproval">
            <div class="form-group form-inline">
                <input class="form-control d-none"
                    type="file"
                    accept="application/pdf"
                    wire:model="pdfNoApproval"
                    wire:loading.attr="disabled"
                    id="pdf_{{$this->id}}"
                />
                <label class="text-light bg-secondary px-2 py-1 rounded border-1"
                    for="pdf_{{$this->id}}"
                    style="cursor: pointer;" >
                    <i class="fas fa-file" wire:loading.class="d-none"></i>
                    <i class="fas fa-spinner fa-spin d-none" wire:loading.class.remove="d-none"></i>
                    <!-- <i class="fas fa-times d-none" wire:dirty.class.remove="d-none" wire:target="pdf"></i> -->
                </label>
                <button type="submit"
                    class="text-light bg-primary px-2 py-1 rounded border-1">
                    <i class="fas fa-save"></i>
                </button>
            </div>
        </form>
    @endif
</div>

<div>
    @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif
    @if($approval == true)
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
            <form wire:submit="save">
                <div class="input-group">
                    <input class="form-control" type="file" wire:model.live="pdf" accept="application/pdf" wire:loading.attr="disabled">
                    @error('pdf') <span class="error">{{ $message }}</span> @enderror
                    <button type="submit" class="btn btn-outline-primary" wire:loading.attr="disabled">
                        <i class="bi bi-upload"></i>
                    </button>
                    <div wire:loading wire:target="pdf"><i class="fas fa-spinner fa-spin"></i> <b>Cargando...</b></div>
                </div>
            </form>
        @endif
    @else
        @if($small)
        <form wire:submit="savePdfNoApproval">
            <div class="form-group form-inline text-center">
                <input class="form-control d-none"
                    type="file"
                    accept="application/pdf"
                    wire:model.live="pdfNoApproval"
                    wire:loading.attr="disabled"
                    id="pdf_{{$this->id}}"
                />
                <label class="text-light bg-secondary px-2 py-1 rounded border-1"
                    for="pdf_{{$this->id}}"
                    style="cursor: pointer;"
                    wire:loading.attr="disabled"
                    wire:loading.class="bg-dark"
                    wire:loading.remove.class="bg-secondary"
                    wire:target="pdfNoApproval">
                    <i class="fas fa-file" wire:loading.remove wire:target="pdfNoApproval"></i>
                    <i class="fas fa-spinner fa-pulse" wire:loading wire:target="pdfNoApproval"></i>
                </label>
                <button type="submit"
                    class="text-light bg-primary px-2 py-1 rounded border-1"
                    wire:loading.attr="disabled"
                    wire:loading.class="bg-danger"
                    wire:loading.remove.class="bg-primary"
                    wire:target="pdfNoApproval">
                    <i class="fas fa-save" wire:loading.remove wire:target="pdfNoApproval"></i>
                    <i class="fas fa-hourglass fa-spin" wire:loading wire:target="pdfNoApproval"></i>
                    <!-- <i class="fas fa-hourglass fa-spin"></i> -->
                </button>
            </div>
        </form>
        @else
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
                <form wire:submit="savePdfNoApproval">
                    <div class="input-group">
                        <input class="form-control" type="file" wire:model.live="pdf" accept="application/pdf" wire:loading.attr="disabled">
                        @error('pdf') <span class="error">{{ $message }}</span> @enderror
                        <button type="submit" class="btn btn-outline-primary" wire:loading.attr="disabled">
                            <i class="bi bi-upload"></i>
                        </button>
                        <div wire:loading wire:target="pdf"><i class="fas fa-spinner fa-spin"></i> <b>Cargando...</b></div>
                    </div>
                </form>
            @endif
        @endif
    @endif
</div>

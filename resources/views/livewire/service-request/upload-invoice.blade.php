<span>
    @if($has_invoice_file)
        <a href="{{route('rrhh.service-request.fulfillment.download_invoice', $fulfillment)}}"
           target="_blank" class="btn btn-outline-info"> <i class="fas fa-dollar-sign"></i> Boleta </a>
        </a>
        <a class="btn btn-sm btn-outline-danger ml-4" wire:click="delete">
            <i class="fas fa-trash"></i>
        </a>
    @else

        <strong>Boleta:</strong>
        <input type="file" wire:model="invoiceFile">
        @error('invoiceFile') <span class="error">{{ $message }}</span> @enderror
        <div wire:loading wire:target="invoiceFile"><strong>Cargando</strong></div>
        <button type="button" wire:click="save()" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-save"></i>
        </button>

    @endif
</span>

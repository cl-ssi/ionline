<div>
    {{-- The best athlete wants his opponent at his best. --}}

    @if ($nuevoFolioDevengo !== null)
        <span>{{ $nuevoFolioDevengo }}</span>
    @else
        <input wire:model.defer="nuevoFolioDevengo" type="text" placeholder="Ingrese el folio devengo sigfe">
        <button wire:click="guardarFolioDevengo">Guardar</button>
    @endif

    @if ($successMessage)
        <div class="text-success">{{ $successMessage }}</div>
    @endif
</div>
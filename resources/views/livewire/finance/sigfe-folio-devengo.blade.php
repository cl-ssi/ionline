<div>
    {{-- The best athlete wants his opponent at his best. --}}

    @if ($editing)
        <input wire:model.defer="nuevoFolioDevengo" type="text" placeholder="Ingrese el folio devengo sigfe">
        <button wire:click="guardarFolioDevengo">Guardar</button>
    @else
        <span>{{ $nuevoFolioDevengo }}</span>
        <button wire:click="toggleEditing"><i class="fas fa-pencil-alt"></i></button>
    @endif

    @if ($successMessage)
        <div class="text-success">{{ $successMessage }}</div>
    @endif
</div>

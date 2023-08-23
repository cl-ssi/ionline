<div>
    {{-- The Master doesn't talk, he acts. --}}
    @if ($editing)
        <input wire:model.defer="nuevoFolioCompromiso" type="text" placeholder="Ingrese el folio compromiso sigfe">
        <button wire:click="guardarFolioCompromiso">Guardar</button>
    @else
        <span>{{ $nuevoFolioCompromiso }}</span>
        <button wire:click="toggleEditing"><i class="fas fa-pencil-alt"></i></button>
    @endif

    @if ($successMessage)
        <div class="text-success">{{ $successMessage }}</div>
    @endif
</div>

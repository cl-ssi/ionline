<div>
    {{-- The Master doesn't talk, he acts. --}}
    @if ($nuevoFolioCompromiso !== null)
        <span>{{ $nuevoFolioCompromiso }}</span>
    @else
        <input wire:model.defer="nuevoFolioCompromiso" type="text" placeholder="Ingrese el folio compromiso sigfe">
        <button wire:click="guardarFolioCompromiso">Guardar</button>
    @endif

     @if ($successMessage)
        <div class="text-success">{{ $successMessage }}</div>
    @endif
</div>
